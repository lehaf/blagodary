<?php

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandlerCompatible(
    'main',
    'OnAfterUserLogout',
    'deleteUserCookiesOnLogout',
);

$eventManager->addEventHandlerCompatible(
    'main',
    'OnProlog',
    'checkUserAuthorize',
);
