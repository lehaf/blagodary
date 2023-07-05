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

        if (!empty($arResult['OWNER']['ID']) && defined('ADS_IBLOCK_ID')) {
            $className = \Bitrix\Iblock\Iblock::wakeUp(ADS_IBLOCK_ID)->getEntityDataClass();
            $arResult['OWNER']['ADS_COUNT'] = $className::getList(array(
                'filter' => array('OWNER.VALUE' => $arResult['OWNER']['ID']),
                'cache' => array(
                    'ttl' => 360000,
                    'cache_joins' => true
                )
            ))->fetchCollection()->count();
        }

        if (defined('RATING_IBLOCK_ID') && !empty($arResult['OWNER']['ID'])) {
            $ratingSectionEntity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(RATING_IBLOCK_ID);
            $userRatingSectionId = $ratingSectionEntity::getList(array(
                "filter" => array("UF_USER_ID" => $arResult['OWNER']['ID']),
                "select" => array("ID"),
            ))->fetch()['ID'];

            if (!empty($userRatingSectionId)) {
                $className = \Bitrix\Iblock\Iblock::wakeUp(RATING_IBLOCK_ID)->getEntityDataClass();
                $obCollection = $className::getList(array(
                    'select' => array('ID', 'USER', 'RATING', 'DATE_CREATE'),
                    'filter' => array('IBLOCK_SECTION_ID' => $userRatingSectionId),
                    'cache' => array(
                        'ttl' => 360000,
                        'cache_joins' => true
                    )
                ))->fetchCollection();

                $totalRatting = 0;
                $arUsersId = [];
                foreach ($obCollection as $obReview) {
                    $userId = $obReview->getUser()->getValue();
                    $unixTime = strtotime($obReview->getDateCreate());
                    $date = date('d.m.Y',$unixTime);
                    $arUsersId[] = $userId;
                    $arResult['RATING']['LIST'][$userId] = [
                        'DATE' => $date,
                        'RATTING' => $obReview->getRating()->getValue()
                    ];
                    $totalRatting += $obReview->getRating()->getValue();
                }

                if (!empty($arResult['RATING']['LIST']))
                    $arResult['RATING']['REVIEWS_COUNT'] = count($arResult['RATING']['LIST']);

                if ($totalRatting !== 0) {
                    $arResult['RATING']['TOTAL'] = round($totalRatting / $obCollection->count(),1);
                    if (strlen($arResult['RATING']['TOTAL']) == 1) $arResult['RATING']['TOTAL'] = $arResult['RATING']['TOTAL'].'.0';
                }

                $arUsers = \Bitrix\Main\UserTable::getList(array(
                    'select' => ['ID', 'NAME'],
                    'filter' => ['ID' => $arUsersId],
                    'cache' => [
                        'ttl' => 360000,
                        'cache_joins' => true
                    ]
                ))->fetchAll();

                if (!empty($arUsers)) {
                    foreach ($arUsers as $arUser) {
                        if (is_array($arResult['RATING']['LIST'][$arUser['ID']]))
                            $arResult['RATING']['LIST'][$arUser['ID']]['NAME'] = $arUser['NAME'];
                    }
                }
            }
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
}