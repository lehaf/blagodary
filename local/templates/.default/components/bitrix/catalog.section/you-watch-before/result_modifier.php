<?php

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as &$arItem) {
        // Приводим время в нужный формат
        $unixTime = strtotime($arItem['DATE_CREATE']);
        $arItem['DATE_CREATE'] = date('d.m.Y в H:i',$unixTime);

        // Ресайзим картинки если их нет - тавим заглушку
        if (!empty($arItem['PROPERTIES']['IMAGES']['VALUE'])) {
            $arItem['IMG'] = CFile::ResizeImageGet(
                $arItem['PROPERTIES']['IMAGES']['VALUE'][0],
                array("width" => 240, "height" => 214),
                BX_RESIZE_IMAGE_PROPORTIONAL,
            );
        } else {
            $arItem['IMG'] = CFile::ResizeImageGet(
                NO_PHOTO_IMG_ID,
                array("width" => 240, "height" => 214),
                BX_RESIZE_IMAGE_PROPORTIONAL,
            );
        }
    }
    unset($arItem);
}