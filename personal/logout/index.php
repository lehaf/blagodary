<?php require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

$obRequest = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$isLogoutUser = $obRequest->get('logout') === 'y';

if ($isLogoutUser) {
    global $USER;
    $USER->Logout();
}
LocalRedirect("/");