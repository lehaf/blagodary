<?php

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as &$item) {
        // Приводим время в нужный формат
        $unixTime = strtotime($item['DATE_CREATE']);
        $item['DATE_CREATE'] = date('d.m.Y в H:i',$unixTime);

        // Генерируем webp картинку и ресайзим картинки если их нет - тавим заглушку
        if (\Bitrix\Main\Loader::includeModule("webp.img")) {
            if (!empty($item['PROPERTIES']['IMAGES']['VALUE'][0])) {
                $item['IMG']['src'] = \WebCompany\WebpImg::getResizeWebpSrc(
                    $item['PROPERTIES']['IMAGES']['VALUE'][0],
                    510,
                    380,
                    true,
                    90
                );
            } else {
                $item['IMG']['src'] = \WebCompany\WebpImg::getResizeWebpSrc(
                    NO_PHOTO_IMG_ID,
                    410,
                    300,
                    true,
                    90
                );
            }
        } else {
            // Ресайзим картинки если их нет - тавим заглушку
            if (!empty($item['PROPERTIES']['IMAGES']['VALUE'][0])) {
                $item['IMG'] = CFile::ResizeImageGet(
                    $item['PROPERTIES']['IMAGES']['VALUE'][0],
                    array("width" => 500, "height" => 380),
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                );
            } else {
                $item['IMG'] = CFile::ResizeImageGet(
                    NO_PHOTO_IMG_ID,
                    array("width" => 410, "height" => 300),
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                );
            }   
        }
    }
    unset($item);
}