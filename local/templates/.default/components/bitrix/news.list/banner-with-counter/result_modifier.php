<?php

if (!empty($arResult['ITEMS'][0])) {
    // Всегда обрабатываем только первый элемент
    $arItem = &$arResult['ITEMS'][0];
    // Генерируем правильное склонение для числа
    $arVariants = [
        'вещь',
        'вещи',
        'вещей',
    ];
    $arItem['PROPERTIES']['COUNTER']['SKLONEN'] = sklonen((int)$arItem['PROPERTIES']['COUNTER']['VALUE'],$arVariants);
    // Собираем числов вида 35 557 вместо 35557
    $reversCounter = strrev($arItem['PROPERTIES']['COUNTER']['VALUE']);
    $arReversCounter = implode(' ',str_split($reversCounter, 3));
    $arItem['PROPERTIES']['COUNTER']['VALUE'] = strrev($arReversCounter);

    // Генерируем webp картинку
    if (\Bitrix\Main\Loader::includeModule("webp.img")) {
        // Декстоп
        $arItem['DETAIL_PICTURE']['SRC'] = \WebCompany\WebpImg::getResizeWebpSrc(
            $arItem['DETAIL_PICTURE'],
            $arItem['DETAIL_PICTURE']['WIDTH'],
            $arItem['DETAIL_PICTURE']['HEIGHT'],
            true,
            90
        );

        // мобилка
        $arItem['PREVIEW_PICTURE']['SRC'] = \WebCompany\WebpImg::getResizeWebpSrc(
            $arItem['PREVIEW_PICTURE'],
            $arItem['PREVIEW_PICTURE']['WIDTH'],
            $arItem['PREVIEW_PICTURE']['HEIGHT'],
            true,
            90
        );
    }
}
