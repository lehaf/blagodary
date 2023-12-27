<?php

if (!empty($arResult['ITEMS'][0])) {
    // Всегда обрабатываем только первый элемент
    $item = $arResult['ITEMS'][0];
    // Генерируем webp картинку
    if (\Bitrix\Main\Loader::includeModule("webp.img")) {
        $item['DETAIL_PICTURE']['SRC'] = \WebCompany\WebpImg::getResizeWebpSrc(
            $item['DETAIL_PICTURE'],
            $item['DETAIL_PICTURE']['WIDTH'],
            $item['DETAIL_PICTURE']['HEIGHT'],
            true,
            90
        );
    }
    $arResult['ITEM'] = $item;
}