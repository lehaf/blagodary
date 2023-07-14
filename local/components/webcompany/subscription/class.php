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
                ob_end_clean();
                echo json_encode(['redirect' => $payResult->getPaymentUrl()]); die();
//                LocalRedirect($payResult->getPaymentUrl(),true);
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
            ob_end_clean();
            echo json_encode(['reload' => true]); die();
        }
    }

    public function prepareResult() : void
    {
        $this->userSubscriptionIsActive();
    }

    public function executeComponent() : void
    {
        if ($_GET['token']) $this->checkPayment();
        if ($_POST['action'] === 'subscribe') {
            $this->makePayment();
        } else {
            if ($_POST['action'] === 'unsubscribe'){
                $this->unsubscribeUser();
            }
        }
        $this->prepareResult();
        $this->includeComponentTemplate();
    }
}