<?php

if (!empty($arResult['ITEMS'][0])) {
    // Всегда обрабатываем только первый элемент
    $arItem = $arResult['ITEMS'][0];
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
}