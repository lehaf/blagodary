<?php

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as &$arItem) {
        // Приводим время в нужный формат
        $unixTime = strtotime($arItem['TIMESTAMP_X']);
        $arItem['TIMESTAMP_X'] = date('d.m.Y в H:i',$unixTime);

        // Ресайзим картинки если их нет - тавим заглушку
        if (!empty($arItem['PROPERTIES']['IMAGES']['VALUE'][0])) {
            $arItem['IMG'] = CFile::ResizeImageGet(
                $arItem['PROPERTIES']['IMAGES']['VALUE'][0],
                array("width" => 580, "height" => 528),
                BX_RESIZE_IMAGE_PROPORTIONAL,
            );
        } else {
            $arItem['IMG'] = CFile::ResizeImageGet(
                NO_PHOTO_IMG_ID,
                array("width" => 580, "height" => 528),
                BX_RESIZE_IMAGE_PROPORTIONAL,
            );
        }
    }
    unset($arItem);
}