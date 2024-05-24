<?php

$_SERVER['DOCUMENT_ROOT'] = '/home/blagodarub/public_html';

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use WebCompany\Subscription;

// Запускаем обработку оплат за подписку у пользователей
Subscription::initRegularSubscriptionPayments();