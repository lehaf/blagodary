<?php

if (!empty($arResult['ITEMS'])) {
    $propCityXml = [];
    foreach ($arResult['ITEMS'] as $key => &$item) {
        // Приводим время в нужный формат
        $unixTime = strtotime($item['DATE_CREATE']);
        $item['DATE_CREATE'] = date('d.m.Y в H:i',$unixTime);

        if (!empty($item['PROPERTIES']['REGION']['VALUE'])) {
            $item['PLACE'] = $item['PROPERTIES']['REGION']['VALUE'];
        }

        if (!empty($item['PROPERTIES']['CITY']['VALUE'])) {
            $propCityXml[] = $item['PROPERTIES']['CITY']['VALUE'];
        }

        // Генерируем webp картинку и ресайзим картинки если их нет - тавим заглушку
        if (\Bitrix\Main\Loader::includeModule("webp.img")) {
            if (!empty($item['PROPERTIES']['IMAGES']['VALUE'][0])) {
                $item['IMG']['src'] = \WebCompany\WebpImg::getResizeWebpSrc(
                    $item['PROPERTIES']['IMAGES']['VALUE'][0],
                    400,
                    320,
                    true,
                    90
                );
            } else {
                $item['IMG']['src'] = \WebCompany\WebpImg::getResizeWebpSrc(
                    NO_PHOTO_IMG_ID,
                    300,
                    220,
                    true,
                    90
                );
            }
        } else {
            // Ресайзим картинки если их нет - тавим заглушку
            if (!empty($item['PROPERTIES']['IMAGES']['VALUE'][0])) {
                $item['IMG'] = CFile::ResizeImageGet(
                    $item['PROPERTIES']['IMAGES']['VALUE'][0],
                    array("width" => 400, "height" => 320),
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                );
            } else {
                $item['IMG'] = CFile::ResizeImageGet(
                    NO_PHOTO_IMG_ID,
                    array("width" => 300, "height" => 220),
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                );
            }
        }
    }
    unset($item);

    $citiesPropVal = getCitiesByXml($propCityXml);
    if (!empty($citiesPropVal)) {
        foreach ($arResult['ITEMS'] as &$item) {
            if (!empty($item['PROPERTIES']['CITY']['VALUE']) && !empty($citiesPropVal[$item['PROPERTIES']['CITY']['VALUE']])) {
                $item['PLACE'] .= ' / '.$citiesPropVal[$item['PROPERTIES']['CITY']['VALUE']];
            }
        }
        unset($item);
    }
}