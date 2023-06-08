<?php

if (!empty($arResult['ITEMS'][0])) {
    // Всегда обрабатываем только первый элемент
    $arItem = $arResult['ITEMS'][0];
    // Ресайзим картинку
    $arItem['DETAIL_PICTURE'] = CFile::ResizeImageGet(
        $arItem['DETAIL_PICTURE']['ID'],
        array("width" => 1250, "height" => 400),
        BX_RESIZE_IMAGE_PROPORTIONAL,
    );
    $arResult['ITEM'] = $arItem;
}