<?php

use WebCompany\YouWatchBefore;

if (!empty($arResult)) {
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
                    array("width" => 92, "height" => 96),
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
    // Получаем данные владельца объявления а так же отзывы и рейтинг
    if ($arResult['PROPERTIES']['OWNER']['VALUE']) {
        $arResult['OWNER'] = getUserData($arResult['PROPERTIES']['OWNER']['VALUE']);

        if (!empty($arResult['OWNER']['ID'])) {
            $arResult['OWNER']['ADS_COUNT'] = getCountUserAds($arResult['OWNER']['ID']);
            $arResult['RATING'] = getUserRatingData($arResult['OWNER']['ID']);
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

    $obViewedGoods = new YouWatchBefore();
    $obViewedGoods->setCookie($arResult['ID']);


    $this->getComponent()->setResultCacheKeys(['OWNER']);
}