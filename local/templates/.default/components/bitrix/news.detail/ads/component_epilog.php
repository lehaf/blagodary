<?php

if (!empty($arResult['IBLOCK_SECTION_ID'])) {
    $GLOBALS['SECTION_ID'] = $arResult['IBLOCK_SECTION_ID'];
}

if (!empty($arResult['OWNER']['ID'])) {
    $GLOBALS['OWNER_ID'] = $arResult['OWNER']['ID'];
}

// Логика показа номеров владельцев объявления
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && $_POST['action'] === 'checkUser') {
    ob_end_clean();
    $user = \Bitrix\Main\Engine\CurrentUser::get();
    $userId = $user->getId();
    $userWithSubscribe = getUserWithSubscribe();

    if (empty($userId)) {
        $res['ERROR_AUTHORIZE'] = true;
    } elseif (!in_array($userId, $userWithSubscribe)) {
        $res['ERROR_TITLE'] = 'У вас нет подписки';
        $res['ERROR_DESCRIPTION'] = 'Вы не можете просматривать контакты владельцев объявлений и размещать объявления. Оформите подписку в <a href="/personal/subscription/">личном кабинете</a>.';
    } elseif (empty($user->getFirstName())) {
        $res['ERROR_TITLE'] = 'Заполните поле "Имя"';
        $res['ERROR_DESCRIPTION'] = 'Что бы увидеть номера телефонов владельца объявления, заполните поле "Имя" в <a href="/personal/user/">личном кабинете</a>.';
    }

    if (!isset($res['ERROR_TITLE']) && !isset($res['ERROR_AUTHORIZE']) && !empty($arResult['OWNER_PHONES'])):
        ob_start()?>
        <ul class='phone-list'>
            <?php foreach ($arResult['OWNER_PHONES'] as $phone):?>
                <li class='phone-list__item'>
                    <svg>
                        <use xlink:href='<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#phone-list'></use>
                    </svg>
                    <a href='tel:<?=$phone?>'><?=$phone?></a>
                </li>
            <?php endforeach;?>
        </ul>
    <?php
        $res['PHONES'] = ob_get_contents();
        ob_end_clean();
    endif;

    echo json_encode($res);

    die();
}