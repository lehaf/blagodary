<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use WebCompany\Subscription;

$json = file_get_contents('php://input');
$paymentRes = json_decode($json, true);

if (!empty($paymentRes['transaction']))
    Subscription::checkUserSubscribeFirstPayment($paymentRes['transaction']);

