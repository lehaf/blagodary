<?php

namespace WebCompany;

use Bitrix\Main\Loader;
use Bitrix\Sale\Order;
use Bitrix\Sale\PaySystem;
use WebCompany\Subscription;
use WebCompany\WReferralsTable;
use WebCompany\WUserSubscriptionTable;
use WebCompany\ReferralSystem;
use Bitrix\Main\Type\DateTime;


class SubscriptionManager extends \CBitrixComponent
{
    private string $moduleName = 'webco.settings';
    private object $nav;
    private int $userId;
    private string $paginationParam = 'orders_page';


    public function __construct($component = \null)
    {
        global $USER;
        $this->userId = $USER->GetID();

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



    private function getUserSubscriptionHistory() : void
    {
        if (!empty($this->userId)) {
            $this->nav = new \Bitrix\Main\UI\PageNavigation("history");
            $this->nav->setPageSize($this->arParams['NAVIGATION_PAGE_COUNT'])->initFromUri();

            $filter = ["USER_ID" => $this->userId];
            $userSubscription = WUserSubscriptionTable::getList([
                'order' => ['DATE_FROM' => 'DESC'],
                'select' => ['*'],
                'filter' => $filter,
                'offset' => $this->nav->getOffset(),
                'limit' => $this->nav->getLimit(),
                'cache' => [
                    'ttl' => 360000,
                    'cache_joins' => true
                ]
            ]);
            $this->nav->setRecordCount(WUserSubscriptionTable::getCount($filter));
            $this->arResult['NAVIGATION_OBJECT'] = $this->nav;

            $subscriptionHistory = $userSubscription->fetchAll();
            if (!empty($subscriptionHistory)) {
                foreach ($subscriptionHistory as $order) {
                    $dateFrom = strtotime($order['DATE_FROM']);
                    $dateTo = strtotime($order['DATE_TO']);
                    $this->arResult['ORDER_HISTORY'][] = [
                        'DATE_PAYED' => date('d.m.Y',$dateFrom),
                        'DATE_SUBSCRIPTION_FROM' => date('d.m.Y H:i',$dateFrom),
                        'DATE_SUBSCRIPTION_TO' => date('d.m.Y H:i',$dateTo),
                        'FREE' => $order['FREE']
                    ];
                }
            }
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


    public function prepareResult() : void
    {
        Loader::includeModule($this->moduleName);
        $WC = new ReferralSystem;
        $this->arResult['NO_SUBSCRIPTION_TEXT'] = $WC->getSettingValue('noSubscriptionText');
        $this->arResult['SUBSCRIPTION_PRICE'] = intval($WC->getSettingValue('subscriptionPrice'));
        $this->getUserSubscriptionHistory();
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
                    return true;
                } else {
                    $this->arResult['ERRORS'][] = "Нельзя производить оплату по своей реферальной ссылке!";
                }
            } else {
                $this->arResult['ERRORS'][] = "Пользователя с такой реферальной ссылкой не существует!";
            }

        }

        return false;
    }

    public function executeComponent() : void
    {
        Subscription::checkLastUserPayment($this->userId);
        $userSubscriptionActive = $this->userSubscriptionIsActive();

        // Если подписка не активна
        if (!$userSubscriptionActive) {
            // если пользователь перешел по реферальной ссылке или Если пользователь нажал подписатся
            if (!empty($_GET['referral']) || $_POST['component'] === $this->getName() && $_POST['action'] === 'subscribe') {

                if (Loader::includeModule($this->moduleName)) {

                    $WC = new ReferralSystem;
                    $subscriptionPrice = intval($WC->getSettingValue('subscriptionPrice').'00');

                    $response = Subscription::subscribeUser(
                        \Bitrix\Main\Engine\CurrentUser::get()->getFullName(),
                        \Bitrix\Main\Engine\CurrentUser::get()->getEmail(),
                        $subscriptionPrice,
                        'BYN',
                        !empty( $_GET['referral']) ?  $_GET['referral'] : ''
                    );

                    if (!empty($_GET['referral']) && !empty($response['checkout']['redirect_url']))
                        LocalRedirect($response['checkout']['redirect_url'], true);

                    if (!empty($response['checkout']['redirect_url']))
                        $this->sendJsonResponse(['redirect' => $response['checkout']['redirect_url']]);
                }
            }
        } else {

            if (!empty($_GET['referral'])  && $_POST['action'] !== 'unsubscribe') {
                if ($this->checkReferralsOwner($_GET['referral'])) {
                    $this->arResult['WARNINGS'][] = "У вас уже оформлена платная подписка до ".$this->arResult["SUBSCRIPTION"]["DATE"]."! Оплата по реферальной ссылке невозможна!";
                }
            }

            if ($_POST['component'] === $this->getName() && $_POST['action'] === 'subscribe') $this->activePaidSubscription();


            if ($_POST['component'] === $this->getName() && $_POST['action'] === 'unsubscribe'){
                if (Subscription::unsubscribeUser()) $this->sendJsonResponse(['reload' => true]);
            }
        }

        $this->prepareResult();
        if (!empty($_GET[$this->paginationParam]) && $this->isAjaxRequest()) ob_end_clean();
        $this->includeComponentTemplate();
        if (!empty($_GET[$this->paginationParam]) && $this->isAjaxRequest()) die();
    }
}