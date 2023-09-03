<?php

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as $key => &$arItem) {
        // Приводим время в нужный формат
        $unixTime = strtotime($arItem['DATE_CREATE']);
        $arItem['DATE_CREATE'] = date('d.m.Y в H:i',$unixTime);

        if (!empty($arItem['PROPERTIES']['REGION']['VALUE'])) {
            $arItem['PLACE'] = $arItem['PROPERTIES']['REGION']['VALUE'];
        }

        if (!empty($arItem['PROPERTIES']['CITY']['VALUE'])) {
            $propCityId[] = $arItem['PROPERTIES']['CITY']['PROPERTY_VALUE_ID'];
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

    $citiesPropVal = getCitiesById($propCityId);
    if (!empty($citiesPropVal)) {
        foreach ($arResult['ITEMS'] as &$arItem) {
            if (!empty($arItem['PROPERTIES']['CITY']['PROPERTY_VALUE_ID']) && !empty($citiesPropVal[$arItem['PROPERTIES']['CITY']['PROPERTY_VALUE_ID']])) {
                $arItem['PLACE'] .= ' / '.$citiesPropVal[$arItem['PROPERTIES']['CITY']['PROPERTY_VALUE_ID']];
            }
        }
        unset($arItem);
    }
}