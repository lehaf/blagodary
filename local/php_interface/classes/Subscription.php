<?php

namespace WebCompany;

use WebCompany\BePaid;
use Bitrix\Main\Loader;
use Bitrix\Sale\Order;
use Bitrix\Sale\PaySystem;
use WebCompany\WReferralsTable;
use WebCompany\WUserSubscriptionTable;
use WebCompany\ReferralSystem;
use Bitrix\Main\Type\DateTime;

class Subscription
{
    private static int $paymentId = 2;
    private static int $referralCodeOrderPropertyId = 1;
    private static string $currency = 'BYN';
    private static int $oneDaySec = 86400;
    private static string $moduleName = 'webco.settings';

    private static function createOrder(int $userId, string $referralCode = '') : ?int
    {
        if (Loader::includeModule('sale')) {
            $basket = \Bitrix\Sale\Basket::create(SITE_ID);
            $item = $basket->createItem('catalog', SUBSCRIBE_GOOD_ID);
            if (!empty($referralCode)) {
                $item->setField('QUANTITY', 1);
            }
            $item->setField('QUANTITY', 1);
            $item->setField('CURRENCY', self::$currency);
            $item->setField('PRODUCT_PROVIDER_CLASS', '\Bitrix\Catalog\Product\CatalogProvider');
            $basket->refresh();
            $order = \Bitrix\Sale\Order::create(SITE_ID, $userId, self::$currency);

            $propertyCollection = $order->getPropertyCollection();
            $prop = $propertyCollection->getItemByOrderPropertyId(self::$referralCodeOrderPropertyId);
            $prop->setValue($referralCode);

            $order->setPersonTypeId(1);
            $order->setBasket($basket);
            $paymentCollection = $order->getPaymentCollection();
            $payment = $paymentCollection->createItem(
                \Bitrix\Sale\PaySystem\Manager::getObjectById(self::$paymentId) //ID платежной системы
            );
            $payment->setField("SUM", $order->getPrice());
            $payment->setField("CURRENCY", $order->getCurrency());
            $orderSaveRes = $order->save();

            if ($orderSaveRes->isSuccess()) {
                return $orderSaveRes->getId();
            }
        }

        // var_dump($orderSaveRes->getErrorMessages());
        return false;

    }

    public static function checkLastUserPayment(int $userId) : void
    {
        $userTokenLastPayment = self::getUserPaymentToken($userId);
        if (!empty($userTokenLastPayment)) {
            $paymentData = BePaid::getPaymentResult($userTokenLastPayment);

            if (!empty($paymentData['checkout'])) {

                if ($paymentData['checkout']['status'] === 'successful') {
                    self::setOrderPaid($paymentData['checkout']['order']['tracking_id']);

                } else {
                    self::cancelOrder($paymentData['checkout']['order']['tracking_id'], $paymentData['checkout']['message']);
                }

                self::setUserPaymentToken($userId, '');
            }
        }
    }

    public static function cancelOrder(int $orderId, string $message = '') : void
    {
        if (Loader::includeModule('sale') && !empty($orderId)) {
            $order = Order::load($orderId);
            if ($order) {
                $order->setField('STATUS_ID', 'C');
                $order->setField('CANCELED', 'Y');
                 if (!empty($message)) $order->setField('COMMENTS', $message);
                $order->save();
            }
        }
    }

    private static function setOrderPaid(int $orderId) : void
    {
        if (Loader::includeModule('sale') && !empty($orderId)) {
            $order = Order::load($orderId);
            if ($order) {
                $paymentCollection = $order->getPaymentCollection();
                $onePayment = $paymentCollection[0];

                $propertyCollection = $order->getPropertyCollection();
                $prop = $propertyCollection->getItemByOrderPropertyId(self::$referralCodeOrderPropertyId);
                $referralCode = $prop->getValue();

                if (!empty($referralCode)) {
                    self::addRefOwnerFreeSubscription($referralCode);
                    $refOwnerId = self::getUserByRefCode($referralCode);
                    if (!empty($refOwnerId))
                        self::addUserReferralPayment($order->getUserId(), $refOwnerId);
                }

                $onePayment->setPaid("Y"); // оплата
                $order->setField('STATUS_ID', 'F');
                $order->save();
            }
        }
    }

    public static function setUserPaymentToken(int $userId, string $paymentToken) : bool
    {
        if (!empty($userId)) {
            $user = new \CUser;
            $fields = array(
                "UF_PAYMENT_TOKEN" => $paymentToken
            );
            $user->Update($userId, $fields);
            return true;
        }

        return false;
    }

    public static function getUserPaymentToken(int $userId) : ?string
    {
        if (!empty($userId)) {
            return \Bitrix\Main\UserTable::getList(array(
                'select' => [
                    'UF_PAYMENT_TOKEN'
                ],
                'filter' => ['ID' => $userId],
                'limit' => 1
            ))->fetch()['UF_PAYMENT_TOKEN'];
        }

        return '';
    }

    public static function subscribeUser(string $userName, string $userEmail, int $sum, string $currency, string $referralCode = '') : array
    {
        $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
        $orderId = self::createOrder($userId, $referralCode);
        $response = BePaid::bindUserCard($userName, $userEmail, $sum, $orderId, $currency);
        if (!empty($response['checkout']['token'])) self::setUserPaymentToken($userId, $response['checkout']['token']);

        return $response;
    }

    public static function unsubscribeUser() : bool
    {
        $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
        if (!empty($userId)) {
            $user = new \CUser;
            $fields = array(
                "UF_SUBSCRIPTION" => false
            );
            $user->Update($userId, $fields);
            return true;
        }

        return false;
    }

    public static function checkUserSubscribeFirstPayment(array $result) : bool
    {
        if (!empty($result['status']) && $result['status'] == 'successful') {
            $userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
            self::setOrderPaid($result['tracking_id']);
            $userId = self::getUserIdByOrderId($result['tracking_id']);
            self::setUserSubscription($userId);
            if (!empty($result['credit_card']['token'])) self::setUserCardToken($userId, $result['credit_card']['token']);
            self::setUserPaymentToken($userId, '');
        }
        return true;
    }

    public static function setUserCardToken(int $userId, string $cardToken) : bool
    {
        if (!empty($userId)) {
            $user = new \CUser;
            $fields = array(
                "UF_TOKEN" => $cardToken
            );
            $user->Update($userId, $fields);

            return true;
        }

        return false;
    }

    private static function getUserIdByOrderId(int $orderId) : ?int
    {
        if (Loader::includeModule('sale') && !empty($orderId)) {
            $order = Order::load($orderId);
            if ($order) {
                return $order->getUserId();
            }
        }

        return NULL;
    }

    private static function getUserSubscriptionData(int $userId) : array
    {
        if (!empty($userId)) {
            return \Bitrix\Main\UserTable::getList(array(
                'select' => [
                    'UF_SUBSCRIPTION',
                    'UF_FREE_SUBSCRIPTION',
                    'UF_SUBSCRIPTION_DATE',
                    'UF_SUBSCRIPTION_FREE_DATE'
                ],
                'filter' => ['ID' => $userId],
                'limit' => 1
            ))->fetch();
        }

        return [];
    }

    private static function setUserSubscription(int $userId) : void
    {
        if (!empty($userId)) {
            $userSub = self::getUserSubscriptionData($userId);

            if (!empty($userSub) && Loader::includeModule(self::$moduleName)) {
                $WC = new ReferralSystem;
                $subscriptionDays = (int)$WC->getSettingValue('referralAccessCount');

                $user = new \CUser;
                $subscriptionDate = !empty($userSub['UF_SUBSCRIPTION_DATE']) ? strtotime($userSub['UF_SUBSCRIPTION_DATE']) : time();
                $curTime = time();
                $subscriptionUntilSec = $curTime >= $subscriptionDate ?
                    $curTime + self::$oneDaySec * $subscriptionDays : $subscriptionDate + self::$oneDaySec * $subscriptionDays;

                $fields = array(
                    "UF_SUBSCRIPTION" => 'Y',
                    "UF_SUBSCRIPTION_DATE" => DateTime::createFromTimestamp($subscriptionUntilSec)
                );

                // Проверяем истекла ли бесплатная подписка - удаляем ее при положительном утверждении
                $siFreeSubscriptionFinished = !empty($userSub['UF_SUBSCRIPTION_FREE_DATE']) && strtotime($userSub['UF_SUBSCRIPTION_FREE_DATE']) > time() ? false : true;
                if ($siFreeSubscriptionFinished && !empty($userSub['UF_SUBSCRIPTION_FREE_DATE'])) {
                    $fields["UF_FREE_SUBSCRIPTION"] = false;
                    $fields["UF_SUBSCRIPTION_FREE_DATE"] = false;
                }

                $userSubscription = WUserSubscriptionTable::createObject();
                $userSubscription->setUserId($userId);
                $userSubscription->setFree('N');
                $userSubscription->setDateFrom(new DateTime());
                $userSubscription->setDateTo(DateTime::createFromTimestamp($subscriptionUntilSec));
                $userSubscription->save();
                $user->Update($userId, $fields);
            }
        }
    }

    private static function getUserByRefCode(string $refCode) : ?int
    {
        if (!empty($refCode)) {
            return \Bitrix\Main\UserTable::getList(array(
                'select' => ['ID'],
                'filter' => ['UF_REFERRAL_CODE' => $refCode],
                'limit' => 1
            ))->fetch()['ID'];
        }

        return NULL;
    }

    private static function getUserSubscriptionInfo(int $userId) : ?array
    {
        return \Bitrix\Main\UserTable::getList(array(
            'select' => [
                'UF_SUBSCRIPTION',
                'UF_FREE_SUBSCRIPTION',
                'UF_SUBSCRIPTION_DATE',
                'UF_SUBSCRIPTION_FREE_DATE'
            ],
            'filter' => ['ID' => $userId],
            'limit' => 1
        ))->fetch();
    }

    private static function addRefOwnerFreeSubscription(string $refCode) : void
    {
        $refOwnerId = self::getUserByRefCode($refCode);
        if ($refOwnerId > 0 && Loader::includeModule(self::$moduleName)) {
            $WC = new ReferralSystem;
            $subscriptionDaysFree = (int)$WC->getSettingValue('referralAccessCountFree');

            $curTime = time();
            $addTimeDeferenceFree = self::$oneDaySec * $subscriptionDaysFree;
            $userSubscription = self::getUserSubscriptionInfo($refOwnerId);
            $subscriptionFreeDate = !empty($userSubscription['UF_SUBSCRIPTION_FREE_DATE']) &&  strtotime($userSubscription['UF_SUBSCRIPTION_FREE_DATE']) > $curTime ?
                strtotime($userSubscription['UF_SUBSCRIPTION_FREE_DATE']) : $curTime;
            $subscriptionFreeUntilSec = $subscriptionFreeDate + $addTimeDeferenceFree;

            $fields = array(
                "UF_FREE_SUBSCRIPTION" => 'Y',
                "UF_SUBSCRIPTION_FREE_DATE" => DateTime::createFromTimestamp($subscriptionFreeUntilSec)
            );

            // Проверяем истекла ли платная подписка - удаляем ее при положительном утверждении
            $siSubscriptionFinished = !empty($userSubscription['UF_SUBSCRIPTION_DATE']) && strtotime($userSubscription['UF_SUBSCRIPTION_DATE']) > time() ? false : true;
            if ($siSubscriptionFinished && !empty($userSubscription['UF_SUBSCRIPTION_DATE'])) {
                $fields["UF_SUBSCRIPTION"] = false;
                $fields["UF_SUBSCRIPTION_DATE"] = false;
            }

            if (!empty($userSubscription['UF_SUBSCRIPTION_DATE']) && $curTime < strtotime($userSubscription['UF_SUBSCRIPTION_DATE'])) {
                $subscriptionUntilSec = strtotime($userSubscription['UF_SUBSCRIPTION_DATE']) + $addTimeDeferenceFree;
                $fields["UF_SUBSCRIPTION_DATE"] = DateTime::createFromTimestamp($subscriptionUntilSec);
            }

            $userSubscription = WUserSubscriptionTable::createObject();
            $userSubscription->setUserId($refOwnerId);
            $userSubscription->setFree('Y');
            $userSubscription->setDateFrom(new DateTime());
            $userSubscription->setDateTo(DateTime::createFromTimestamp($subscriptionFreeUntilSec));
            $userSubscription->save();

            $user = new \CUser;
            $user->Update($refOwnerId, $fields);
        }
    }

    private static function addUserReferralPayment(int $refId, int $refOwnerId) : void
    {
        if (!empty($refId) && !empty($refOwnerId) && Loader::includeModule(self::$moduleName)) {
            $newReferral = new EO_WReferrals();
            $newReferral->setUserId($refOwnerId);
            $newReferral->setReferralId($refId);
            $newReferral->setPaydate(new DateTime());
            $newReferral->save();
        }
    }

    public static function initRegularSubscriptionPayments() : void
    {
        if (Loader::includeModule(self::$moduleName)) {
            ini_set('max_execution_time', 2000);

            $WC = new ReferralSystem;
            $subscriptionPrice = intval($WC->getSettingValue('subscriptionPrice').'00');

            $users = \Bitrix\Main\UserTable::getList(array(
                'select' => [
                    'ID',
                    'LOGIN',
                    'UF_TOKEN',
                    'UF_SUBSCRIPTION',
                    'UF_FREE_SUBSCRIPTION',
                    'UF_SUBSCRIPTION_DATE',
                    'UF_SUBSCRIPTION_FREE_DATE'
                ],
                'filter' => [
                    [
                        'LOGIC' => 'OR',
                        '<UF_SUBSCRIPTION_DATE' => new DateTime(),
                        '=UF_SUBSCRIPTION_DATE' => false,
                    ],
                    'UF_SUBSCRIPTION' => true,

                ],
            ))->fetchAll();

            if (!empty($users) && !empty($subscriptionPrice)) {
                $prevToken = '';
                foreach ($users as $user) {
                    if (!empty($user['UF_TOKEN'])) {

                        if (strtotime($user['UF_SUBSCRIPTION_FREE_DATE']) < time()) {
                            $orderId = self::createOrder($user['ID']);

                            if ($orderId > 0) {
                                $userName = $user['LOGIN'].' (ID='.$user['ID'].')';

                                // Останавливаем скрипт на время что бы прошла вторая оплата на одной и той же карте
                                if ($prevToken === $user['UF_TOKEN']) sleep(30);

                                $result = BePaid::makeCardTokenPayment($user['UF_TOKEN'], $subscriptionPrice, $orderId, $userName);

                                if ($result === true) {
                                    self::setOrderPaid($orderId);
                                    self::setUserSubscription($user['ID']);

                                    \CEventLog::Add(array(
                                        "SEVERITY" => "SECURITY",
                                        "AUDIT_TYPE_ID" => "Система подписок",
                                        "MODULE_ID" => "user",
                                        "ITEM_ID" => 'Оплата подписки пользователем с ID='.$user['ID'],
                                        "DESCRIPTION" => "Успешно оплачено!"
                                    ));
                                } else {
                                    self::cancelOrder($orderId);
                                    $message = "У пользователя с ID = $user[ID] не удалось произвести очередную оплату подписки!";
                                    \CEventLog::Add(array(
                                        "SEVERITY" => "SECURITY",
                                        "AUDIT_TYPE_ID" => "Ошибка системы подписок",
                                        "MODULE_ID" => "user",
                                        "ITEM_ID" => 'Проблема у пользователя с ID='.$user['ID'],
                                        "DESCRIPTION" => $message,
                                    ));
                                }
                                $prevToken = $user['UF_TOKEN'];

                            } else {
                                $message = "У пользователя с ID = $user[ID] произошла ошибка создания заказа при очередной оплате подписки!";
                                \CEventLog::Add(array(
                                    "SEVERITY" => "SECURITY",
                                    "AUDIT_TYPE_ID" => "Ошибка системы подписок",
                                    "MODULE_ID" => "user",
                                    "ITEM_ID" => 'Проблема у пользователя с ID='.$user['ID'],
                                    "DESCRIPTION" => $message,
                                ));
                            }
                        }
                    } else {
                        $message = "У пользователя с ID = $user[ID] активирована подписка БЕЗ ТОКЕНА ПЛТАТЕЖНОЙ КАРТЫ";
                        \CEventLog::Add(array(
                            "SEVERITY" => "SECURITY",
                            "AUDIT_TYPE_ID" => "Ошибка системы подписок",
                            "MODULE_ID" => "user",
                            "ITEM_ID" => 'Проблема у пользователя с ID='.$user['ID'],
                            "DESCRIPTION" => $message,
                        ));

                        $CUser = new \CUser;
                        $fields = ['UF_SUBSCRIPTION' => false];
                        $CUser->Update($user['ID'], $fields);
                    }
                }
            }
        }
    }
}