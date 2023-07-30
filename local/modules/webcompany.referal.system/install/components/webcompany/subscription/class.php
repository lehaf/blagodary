<?php

namespace WebCompany;

use Bitrix\Main\Loader;
use Bitrix\Sale\Order;
use Bitrix\Sale\PaySystem;
use WebCompany\WReferralsTable;
use Bitrix\Main\Type\DateTime;


class Subscription extends \CBitrixComponent
{
    private string $moduleName = 'webcompany.referal.system';
    private int $productId;
    private int $userId;
    private string $currency = 'BYN';
    private string $paginationParam = 'orders_page';
    private int $paymentId = 2;
    private int $oneDaySec = 86400;
    private int $subscriptionDaysFree = 3;
    private int $subscriptionDays = 1;
    private object $userSession;

    public function __construct($component = \null)
    {
        if (Loader::includeModule('sale')) {
            global $USER;
            $this->userId = $USER->GetID();
            $this->productId = SUBSCRIBE_GOOD_ID;
            $this->userSession = \Bitrix\Main\Application::getInstance()->getSession();
        }
        parent::__construct($component);
    }

    private function isAjaxRequest() : bool
    {
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') return true;
        return false;
    }

    private function getUserSubscriptionInfo(int $userId) : ?array
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

    private function userSubscriptionIsActive() : bool
    {
        if (!empty($this->userId) && !isset($this->arResult['SUBSCRIPTION']['ACTIVE'])) {
            $user = $this->getUserSubscriptionInfo($this->userId);

            $isSubscriptionActive = !empty($user['UF_SUBSCRIPTION_DATE']) && time() < strtotime($user['UF_SUBSCRIPTION_DATE']);
            $isSubscriptionFreeActive = !empty($user['UF_SUBSCRIPTION_FREE_DATE']) && time() < strtotime($user['UF_SUBSCRIPTION_FREE_DATE']);
            $this->arResult['SUBSCRIPTION']['PAID'] = $isSubscriptionActive;
            $this->arResult['SUBSCRIPTION']['PAID_CONFIRM'] = $user['UF_SUBSCRIPTION'] == true;
            $this->arResult['SUBSCRIPTION']['FREE'] = $isSubscriptionFreeActive;
            $this->arResult['SUBSCRIPTION']['FREE_CONFIRM'] = $user['UF_FREE_SUBSCRIPTION'] == true;

            if ($isSubscriptionActive || $isSubscriptionFreeActive) {
                $this->arResult['SUBSCRIPTION']['ACTIVE'] = true;

                if (!empty($user['UF_SUBSCRIPTION_DATE'])) {
                    $this->arResult['SUBSCRIPTION']['DATE'] = date('d.m.Y H:i',strtotime($user['UF_SUBSCRIPTION_DATE']));
                }

                if (!empty($user['UF_SUBSCRIPTION_FREE_DATE'])) {
                    $this->arResult['SUBSCRIPTION']['FREE_DATE'] = date('d.m.Y H:i',strtotime($user['UF_SUBSCRIPTION_FREE_DATE']));
                }
                return true;
            } else {
                $this->arResult['SUBSCRIPTION']['ACTIVE'] = false;
            }
        }
        return false;
    }

    private function checkReferralsOwner(string $referralCode) : bool
    {
        if (!empty($referralCode)) {
            $ownerId = \Bitrix\Main\UserTable::getList(array(
                'select' => ['ID'],
                'filter' => ['UF_REFERRAL_CODE' => $referralCode],
                'limit' => 1,
                'cache' => [
                    'ttl' => 360000,
                    'cache_joins' => true
                ]
            ))->fetch()['ID'];

            if (!empty($ownerId)) {
                if ($ownerId != $this->userId) {
                    $this->userSession->set('referralOwner',$ownerId);
                    return true;
                }
            } else {
                $this->arResult['ERRORS'][] = "Пользователя с такой реферальной ссылкой не существует!";
            }
        }
        return false;
    }

    private function addUserReferralPayment() : void
    {
        if (!empty($this->userId) && $this->userSession->has('referralOwner') && Loader::includeModule($this->moduleName)) {
            $newReferral = new EO_WReferrals();
            $newReferral->setUserId($this->userSession->get('referralOwner'));
            $newReferral->setReferralId($this->userId);
            $newReferral->setPaydate(new DateTime());
            $newReferral->save();
        }
    }

    private function getUserSubscriptionHistory(int $ordersLimit, int $ordersOffset = 0, $curPage = 1) : void
    {
        if (!empty($this->userId)) {
            $userOrders = \Bitrix\Sale\Order::getList([
                'order' => ['ID' => 'DESC'],
                'select' => ['ID','DATE_PAYED'],
                'filter' => [
                    "USER_ID" => $this->userId, //по пользователю
//                    "STATUS_ID" =>$statusId, //по статусу
                    "PAYED" => "Y", //оплаченные
                    "CANCELED" =>"N", //не отмененные
                ],
                'limit' => $ordersLimit,
                'offset' => $ordersOffset,
                'count_total' => true,
                'cache' => [
                    'ttl' => 360000,
                    'cache_joins' => true
                ]
            ]);

            $orders = $userOrders->fetchAll();
            if (!empty($orders)) {
                foreach ($orders as $order) {
                    $unixTime = strtotime($order['DATE_PAYED']);
                    $this->arResult['ORDER_HISTORY'][] = [
                        'DATE_PAYED' => date('d.m.Y',$unixTime),
                        'DATE_SUBSCRIPTION_FROM' => date('d.m.Y H:i',$unixTime),
                        'DATE_SUBSCRIPTION_TO' => date('d.m.Y H:i',$unixTime+$this->oneDaySec*$this->subscriptionDays)
                    ];
                }
                $this->setPaginationParams($userOrders->getCount(), $ordersLimit, $curPage);
            }
        }
    }

    private function setPaginationParams(int $ordersCount, int $ordersLimit, int $curPage) : void
    {
        $countPages = ceil($ordersCount/$ordersLimit);
        if ($countPages > 1) {
            $maxPageLinks = 5;
            $pageOffset = floor($maxPageLinks/2);

            $this->arResult['ORDER_PAGINATION'] = [
                'CUR_PAGE' => $curPage
            ];

            if ($curPage > 1) $this->arResult['ORDER_PAGINATION']['LEFT_ARROW_LINK'] = '?'.$this->paginationParam.'='.$curPage-1;
            if ($curPage < $countPages) $this->arResult['ORDER_PAGINATION']['RIGHT_ARROW_LINK'] = '?'.$this->paginationParam.'='.$curPage+1;

            if ($curPage > 1  &&  $curPage > 1 + $maxPageLinks && $curPage-1 != 2) {
                $this->arResult['ORDER_PAGINATION']['PAGES'][1] = '?'.$this->paginationParam.'='.'1';
                $this->arResult['ORDER_PAGINATION']['PAGES']['...'] = '?'.$this->paginationParam.'='.floor($curPage/2);
            }

            $pageStart = ($curPage - $pageOffset) < 1 || ($curPage - $pageOffset) >= ($countPages - $maxPageLinks) ? 1 : $curPage - $pageOffset;
            if ($curPage == $countPages) {
                $pageEnd = $countPages;
            } else {
                $pageEnd = $curPage + $pageOffset;
            }
            if ($pageEnd === $countPages) $pageStart = ($countPages - $maxPageLinks) <= 0 ? 1 : $countPages - $maxPageLinks;
            if ($pageStart === 1 && $maxPageLinks >= $countPages) $pageEnd = $maxPageLinks;
            for ($i = $pageStart; $i <= $pageEnd && $i <= $countPages; $i++) {
                $this->arResult['ORDER_PAGINATION']['PAGES'][$i] = '?'.$this->paginationParam.'='.$i;
            }

            if ($curPage < $countPages - $maxPageLinks  &&  $curPage < $countPages && $curPage+1 != $countPages-1) {
                $this->arResult['ORDER_PAGINATION']['PAGES']['...'] = '?'.$this->paginationParam.'='.round($countPages+$curPage/2);
                $this->arResult['ORDER_PAGINATION']['PAGES'][$countPages] = '?'.$this->paginationParam.'='.$countPages;
            }
        }
    }
    private function createOrder() : void
    {
        $basket = \Bitrix\Sale\Basket::create(SITE_ID);
        $item = $basket->createItem('catalog', $this->productId);
        $item->setField('QUANTITY', 1);
        $item->setField('CURRENCY', $this->currency);
        $item->setField('PRODUCT_PROVIDER_CLASS', '\Bitrix\Catalog\Product\CatalogProvider');
        $basket->refresh();
        $order = \Bitrix\Sale\Order::create(SITE_ID, $this->userId, $this->currency);
        $order->setPersonTypeId(1);
        $order->setBasket($basket);
        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem(
            \Bitrix\Sale\PaySystem\Manager::getObjectById($this->paymentId) //ID платежной системы
        );
        $payment->setField("SUM", $order->getPrice());
        $payment->setField("CURRENCY", $order->getCurrency());
        $orderSaveRes = $order->save();

        if ($orderSaveRes->isSuccess() && !empty($this->userSession)) {
            $this->userSession->set('subscriptionOrderId',$orderSaveRes->getId());
        } else {
            var_dump($orderSaveRes->getErrorMessages());
        }
    }

    private function sendJsonResponse(array $array) : void
    {
        if ($this->isAjaxRequest()) {
            ob_end_clean();
            echo json_encode($array);
            die();
        }
    }

    private function initPaySystem() : void
    {
        if (!empty($this->userSession) && $this->userSession->has('subscriptionOrderId')) {
            $order = Order::load($this->userSession->get('subscriptionOrderId'));
            $payment = $order->getPaymentCollection()[0];
            $service = PaySystem\Manager::getObjectById($payment->getPaymentSystemId());
            $context = \Bitrix\Main\Application::getInstance()->getContext();
            $payResult = $service->initiatePay($payment, $context->getRequest());
            if (!$payResult->isSuccess()){
                echo implode('<br>', $payResult->getErrorMessages());
            } else {
                $token = $payResult->getPsData()['PS_INVOICE_ID'];
                $this->userSession->set('token', $token);

                if (!$this->userSession->has('referralOwner') || $this->isAjaxRequest()) {
                    $this->sendJsonResponse(['redirect' => $payResult->getPaymentUrl()]);
                } else {
                    LocalRedirect($payResult->getPaymentUrl(),true);
                }
            }
        }
    }

    private function addRefOwnerFreeSubscription(\CUser $user, int $refOwnerId) : void
    {
        if ($refOwnerId > 0) {
            $curTime = time();
            $addTimeDeferenceFree = $this->oneDaySec * $this->subscriptionDaysFree;
            $userSubscription = $this->getUserSubscriptionInfo($refOwnerId);
            $subscriptionFreeDate = !empty($userSubscription['UF_SUBSCRIPTION_FREE_DATE']) &&  strtotime($userSubscription['UF_SUBSCRIPTION_FREE_DATE']) > $curTime ?
                strtotime($userSubscription['UF_SUBSCRIPTION_FREE_DATE']) : $curTime;
            $subscriptionFreeUntilSec = $subscriptionFreeDate + $addTimeDeferenceFree;

            $fields = array(
                "UF_FREE_SUBSCRIPTION" => 'Y',
                "UF_SUBSCRIPTION_FREE_DATE" => DateTime::createFromTimestamp($subscriptionFreeUntilSec)
            );

            if (!empty($userSubscription['UF_SUBSCRIPTION_DATE']) && $curTime < strtotime($userSubscription['UF_SUBSCRIPTION_DATE'])) {
                $subscriptionUntilSec = strtotime($userSubscription['UF_SUBSCRIPTION_DATE']) + $addTimeDeferenceFree;
                $fields["UF_SUBSCRIPTION_DATE"] = DateTime::createFromTimestamp($subscriptionUntilSec);
            }
            $user->Update($this->userSession->get('referralOwner'), $fields);
        }
    }

    private function activePaidSubscription() : void
    {
        if (!empty($this->userId)) {
            $user = new \CUser;
            $fields = array(
                "UF_SUBSCRIPTION" => 'Y'
            );
            $user->Update($this->userId, $fields);
            $this->sendJsonResponse(['reload' => true]);
        }
    }

    private function setOrderPaid(int $orderId) : void
    {
        if (!empty($orderId)) {
            $order = Order::load($orderId);
            $paymentCollection = $order->getPaymentCollection();
            $onePayment = $paymentCollection[0];
            $onePayment->setPaid("Y"); // оплата
            $order->setField('STATUS_ID', 'F');
            $order->save();
        }
    }

    private function setUserSubscription(\CUser $user) : void
    {
        if (!empty($this->userId)) {
            $subscriptionDate = !empty($this->arResult['SUBSCRIPTION']['DATE']) ? strtotime($this->arResult['SUBSCRIPTION']['DATE']) : time();
            $curTime = time();
            $subscriptionUntilSec = $curTime >= $subscriptionDate ?
            $curTime + $this->oneDaySec * $this->subscriptionDays : $subscriptionDate + $this->oneDaySec * $this->subscriptionDays;
            $fields = Array(
                "UF_SUBSCRIPTION" => 'Y',
                "UF_SUBSCRIPTION_DATE" => DateTime::createFromTimestamp($subscriptionUntilSec)
            );
            $user->Update($this->userId, $fields);
        }
    }

    private function checkPayment() : void
    {
        if ($this->userSession->has('token') && isset($_GET['token']) && $this->userSession->get('token') === $_GET['token']) {
            if ($_GET['status'] === 'successful' && !empty($this->userSession->get('subscriptionOrderId'))) {
                $this->setOrderPaid($this->userSession->get('subscriptionOrderId'));
                $this->userSession->remove('token');
                $this->userSession->remove('subscriptionOrderId');
                $user = new \CUser;
                $this->setUserSubscription($user);
                if ($this->userSession->has('referralOwner')) {
                    $this->addUserReferralPayment();
                    $this->addRefOwnerFreeSubscription($user, $this->userSession->get('referralOwner'));
                    $this->userSession->remove('referralOwner');
                }
                LocalRedirect('');
            } else {
                $this->userSession->remove('token');
                unset($_GET['token']);
            }
        }
    }

    private function clearSessionSubscriptionData() : void
    {
        if ($this->userSession->has('token')) $this->userSession->remove('token');
        if ($this->userSession->has('subscriptionOrderId')) {
            Order::deleteNoDemand($this->userSession->get('subscriptionOrderId'));
            $this->userSession->remove('subscriptionOrderId');
        }
    }

    public function makePayment() : void
    {
        if (!$this->userSession->has('subscriptionOrderId')) $this->createOrder();
        $this->checkPayment();
        $this->initPaySystem();
    }

    public function unsubscribeUser() : void
    {
        if (!empty($this->userId)) {
            $user = new \CUser;
            $fields = Array(
                "UF_SUBSCRIPTION" => false
            );
            $user->Update($this->userId, $fields);
            $this->sendJsonResponse(['reload' => true]);
        }
    }

    public function prepareResult() : void
    {
        $curOrdersPage = !empty($_GET[$this->paginationParam]) ? $_GET[$this->paginationParam] : 1;
        $ordersOffset = $curOrdersPage !== 0 ? $this->arParams['PAGE_RECORDS_COUNT'] * $curOrdersPage - $this->arParams['PAGE_RECORDS_COUNT'] : 0;
        $this->getUserSubscriptionHistory($this->arParams['PAGE_RECORDS_COUNT'], $ordersOffset, $curOrdersPage);
    }

    public function executeComponent() : void
    {
        $userSubscriptionActive = $this->userSubscriptionIsActive();
        if (!empty($_GET['token'])) $this->checkPayment();
        if (!$userSubscriptionActive) {
            if (!empty($_GET['referral']) && $this->checkReferralsOwner($_GET['referral']) ||
                $_POST['component'] === $this->getName() && $_POST['action'] === 'subscribe') {
                if ($this->userSession->has('token') && $this->userSession->has('subscriptionOrderId')) $this->clearSessionSubscriptionData();
                $this->makePayment();
            }

        } else {

            if (!empty($_GET['referral'])  && $_POST['action'] !== 'unsubscribe') {
                if ($this->checkReferralsOwner($_GET['referral'])) {
                    $this->arResult['WARNINGS'][] = "У вас уже оформлена платная подписка до ".$this->arResult["SUBSCRIPTION"]["DATE"]."! Оплата по реферальной ссылке невозможна!";
                }
            }

            if ($_POST['component'] === $this->getName() && $_POST['action'] === 'subscribe') $this->activePaidSubscription();


            if ($_POST['component'] === $this->getName() && $_POST['action'] === 'unsubscribe'){
                $this->unsubscribeUser();
            }
        }

        $this->prepareResult();
        if (!empty($_GET[$this->paginationParam]) && $this->isAjaxRequest()) ob_end_clean();
        $this->includeComponentTemplate();
        if (!empty($_GET[$this->paginationParam]) && $this->isAjaxRequest()) die();
    }
}