<?php

namespace WebCompany;

use Bitrix\Main\Loader;
use Bitrix\Sale\Order;
use Bitrix\Sale\PaySystem;

class Subscription extends \CBitrixComponent
{
    private int $productId;
    private int $userId;
    private string $currency = 'BYN';
    private string $paginationParam = 'orders_page';
    private int $paymentId = 2;
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

    private function userSubscriptionIsActive() : void
    {
        if (!empty($this->userId)) {
            $arUser = \Bitrix\Main\UserTable::getList(array(
                'select' => ['UF_SUBSCRIPTION'],
                'filter' => ['ID' => $this->userId],
                'limit' => 1,
                'cache' => [
                    'ttl' => 360000,
                    'cache_joins' => true
                ]
            ))->fetch();

            $isActive = $arUser['UF_SUBSCRIPTION'] == true;
        }

        if (!empty($isActive)) {
            $this->arResult['SUBSCRIPTION']['ACTIVE'] = true;
            $this->arResult['SUBSCRIPTION']['FREE'] = true;
        } else {
            $this->arResult['SUBSCRIPTION']['ACTIVE'] = false;
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
                        'DATE_SUBSCRIPTION_TO' => date('d.m.Y H:i',$unixTime+strtotime("+7 days"))
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
        ob_end_clean();
        echo json_encode($array);
        die();
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
                if (!$this->userSession->has('token')) {
                    $token = $payResult->getPsData()['PS_INVOICE_ID'];
                    $this->userSession->set('token', $token);
                }
                $this->sendJsonResponse(['redirect' => $payResult->getPaymentUrl()]);
            }
        }
    }

    private function checkPayment() : void
    {
        if ($this->userSession->has('token') && isset($_GET['token']) && $this->userSession->get('token') === $_GET['token']) {
            if ($_GET['status'] === 'successful') {
                $order = Order::load($this->userSession->get('subscriptionOrderId'));
                $paymentCollection = $order->getPaymentCollection();
                $onePayment = $paymentCollection[0];
                $onePayment->setPaid("Y"); // оплата
                $order->setField('STATUS_ID', 'F');
                $order->save();
                $this->userSession->remove('token');
                $this->userSession->remove('subscriptionOrderId');
                $user = new \CUser;
                $fields = Array(
                    "UF_SUBSCRIPTION" => 'Y'
                );
                $user->Update($this->userId, $fields);
                $_GET['clear_cache'] = 'Y';
            } else {
                $this->userSession->remove('token');
                unset($_GET['token']);
            }
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
        $this->userSubscriptionIsActive();

        $curOrdersPage = !empty($_GET[$this->paginationParam]) ? $_GET[$this->paginationParam] : 1;
        $ordersOffset = $curOrdersPage !== 0 ? $this->arParams['PAGE_RECORDS_COUNT'] * $curOrdersPage - $this->arParams['PAGE_RECORDS_COUNT'] : 0;
        $this->getUserSubscriptionHistory($this->arParams['PAGE_RECORDS_COUNT'], $ordersOffset, $curOrdersPage);
    }

    public function executeComponent() : void
    {
        if (!empty($_GET['token'])) $this->checkPayment();
        if ($_POST['component'] === $this->getName() && $_POST['action'] === 'subscribe') {
            $this->makePayment();
        } else {
            if ($_POST['component'] === $this->getName() && $_POST['action'] === 'unsubscribe'){
                $this->unsubscribeUser();
            }
        }
        $this->prepareResult();
        if (!empty($_GET[$this->paginationParam]) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') ob_end_clean();
        $this->includeComponentTemplate();
        if (!empty($_GET[$this->paginationParam]) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') die();
    }
}