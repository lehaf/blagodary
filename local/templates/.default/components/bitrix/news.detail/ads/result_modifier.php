<?php

if (!empty($arResult)) {

    // Генерируем webp картинку и ресайзим картинки если их нет - тавим заглушку
    if (\Bitrix\Main\Loader::includeModule("webp.img")) {
        if (!empty($arResult['PROPERTIES']['IMAGES']['VALUE'])) {
            foreach ($arResult['PROPERTIES']['IMAGES']['VALUE'] as $key => $imgId) {
                $arResult['IMAGES']['BIG_SLIDER'][$key]['src'] = \WebCompany\WebpImg::getResizeWebpSrc(
                    $imgId,
                    756,
                    505,
                    true,
                    90
                );

                if (count($arResult['PROPERTIES']['IMAGES']['VALUE']) > 1) {
                    $arResult['IMAGES']['LITTLE_SLIDER'][$key]['src'] = \WebCompany\WebpImg::getResizeWebpSrc(
                        $imgId,
                        110,
                        125,
                        true,
                        90
                    );
                }
            }
        } else {
            $arResult['IMAGES']['BIG_SLIDER'][]['src'] = \WebCompany\WebpImg::getResizeWebpSrc(
                NO_PHOTO_IMG_ID,
                756,
                505,
            );
        }
    } else {
        // Ресайзим картинки если их нет - тавим заглушку
        if (!empty($arResult['PROPERTIES']['IMAGES']['VALUE'])) {
            foreach ($arResult['PROPERTIES']['IMAGES']['VALUE'] as $imgId) {
                $arResult['IMAGES']['BIG_SLIDER'][] = CFile::ResizeImageGet(
                    $imgId,
                    array("width" => 756, "height" => 505),
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                );

                if (count($arResult['PROPERTIES']['IMAGES']['VALUE']) > 1) {
                    $arResult['IMAGES']['LITTLE_SLIDER'][] = CFile::ResizeImageGet(
                        $imgId,
                        array("width" => 110, "height" => 125),
                        BX_RESIZE_IMAGE_PROPORTIONAL,
                    );
                }
            }
        } else {
            $arResult['IMAGES']['BIG_SLIDER'][] = CFile::ResizeImageGet(
                NO_PHOTO_IMG_ID,
                array("width" => 756, "height" => 505),
                BX_RESIZE_IMAGE_PROPORTIONAL,
            );
        }
    }

    // Получаем данные владельца объявления а так же отзывы и рейтинг
    if ($arResult['PROPERTIES']['OWNER']['VALUE']) {
        $arResult['OWNER'] = getUserData($arResult['PROPERTIES']['OWNER']['VALUE']);

        if (!empty($arResult['OWNER']['ID'])) {
            $arResult['OWNER']['ADS_COUNT'] = getCountUserAds($arResult['OWNER']['ID']);
            $arResult['RATING'] = getUserRatingData($arResult['OWNER']['ID']);
        }
    }

    if (!empty($arResult['PROPERTIES']['CITY']['VALUE'])) {
        $propCityXml[] = $arResult['PROPERTIES']['CITY']['VALUE'];
        $citiesPropVal = getCitiesByXml($propCityXml);
        $arResult['PROPERTIES']['CITY']['VALUE'] = $citiesPropVal[$arResult['PROPERTIES']['CITY']['VALUE']];
    }

    $propertiesForAllSections = \CIBlockSectionPropertyLink::GetArray(ADS_IBLOCK_ID, 0);
    $propertiesForCurSection = \CIBlockSectionPropertyLink::GetArray(ADS_IBLOCK_ID, $arResult['IBLOCK_SECTION_ID']);
    $specialPropsId = [];
    foreach ($propertiesForCurSection as $propId => $prop) {
        if (is_array($propertiesForAllSections) && !array_key_exists($propId,$propertiesForAllSections)) {
            $specialPropsId[] = $propId;
        }
    }

    foreach ($arResult['PROPERTIES'] as $propCode => $prop) {
        if (is_array($specialPropsId) && in_array($prop['ID'], $specialPropsId) && !empty($prop['VALUE'])) {
            $arResult['FEATURES'][] = $prop;
        }
    }

    // Добавляем товару эрмитаж
    $arButtons = CIBlock::GetPanelButtons(
        $arResult["IBLOCK_ID"],
        $arResult["ID"],
        0,
        array("SECTION_BUTTONS"=>false, "SESSID"=>false)
    );

    $arResult["ADD_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];
    $arResult["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
    $arResult["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

    $arResult["ADD_LINK_TEXT"] = $arButtons["edit"]["add_element"]["TEXT"];
    $arResult["EDIT_LINK_TEXT"] = $arButtons["edit"]["edit_element"]["TEXT"];
    $arResult["DELETE_LINK_TEXT"] = $arButtons["edit"]["delete_element"]["TEXT"];

    $this->AddEditAction($arResult['ID'], $arResult['EDIT_LINK'], $arResult["EDIT_LINK_TEXT"]);
    $this->AddDeleteAction($arResult['ID'], $arResult['DELETE_LINK'], $arResult["DELETE_LINK_TEXT"],
        array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
    );

    $arResult['USERS_WITH_SUBSCRIPTION'] = getUserWithSubscribe();

    $this->getComponent()->setResultCacheKeys(['OWNER']);
}