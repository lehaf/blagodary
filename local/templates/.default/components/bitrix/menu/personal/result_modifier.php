<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @global object $APPLICATION */

if (!empty($arResult)) {
    $curPage = $APPLICATION->GetCurPage();
    foreach ($arResult as &$arMenuLink) {
        if (!empty($arMenuLink['PARAMS']['PAGES'])) {
            foreach ($arMenuLink['PARAMS']['PAGES'] as $innerPageName => $innerPageLink) {
                if ($curPage == $innerPageLink) {
                    $arMenuLink['ACTIVE_MENU_NAME'] = $innerPageName;
                    $arMenuLink['SELECTED'] = 'Y';
                }
            }
        }
    }
    unset($arMenuLink);
}