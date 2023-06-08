<?php

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as &$arItem) {
        // Приводим время в нужный формат
        $unixTime = strtotime($arItem['TIMESTAMP_X']);
        $arItem['TIMESTAMP_X'] = date('d.m.Y в H:i',$unixTime);

        if (!empty($arItem['PROPERTIES']['REGION']['VALUE'])) {
            $arItem['PLACE'] = $arItem['PROPERTIES']['REGION']['VALUE'];
        }

        if (!empty($arItem['PROPERTIES']['CITY']['VALUE'])) {
            $arItem['PLACE'] .= ' / '.$arItem['PROPERTIES']['CITY']['VALUE'];
        }

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