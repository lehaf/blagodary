<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use WebCompany\YouWatchBefore;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
/** @global  array $BLOCKED */

global $BLOCKED;

$this->setFrameMode(true);
$isAjax = $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

$isNotFirstPage = strpos(implode('',array_keys($_GET)),'PAGEN');
if (!empty($arResult["VARIABLES"]['SECTION_ID']) && defined('ADS_IBLOCK_ID')) {
    $arActiveSection = getSectionData($arResult["VARIABLES"]['SECTION_ID'],ADS_IBLOCK_ID); // Выбранный текущий раздел
    $APPLICATION->SetTitle($arActiveSection['NAME']);
    $arSectionTree = getSectionTree($arActiveSection['ID']); // Получаем дерево разделов
    $rootSectionId = $arSectionTree[0]['ID'] ?? $arSectionTree['ID']; // Получаем id корневого раздела
    $arRootSection = getSectionData($rootSectionId,ADS_IBLOCK_ID); // Получаем данные по корневому разделу
}
$userWithSubscribe = getUserWithSubscribe();
?>

<div class="page-container">
    <aside class="aside">
        <div class="aside__item aside__item-btn">
            <button class="btn-bg btn-category btn-category-open">
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#btn-category"></use>
                </svg>
                Категории
            </button>
            <button class="btn-bg btn-category mobile_menu">
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#btn-category"></use>
                </svg>
                Категории
            </button>
            <button class="btn-filter">
                Фильтры
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#filter-btn"></use>
                </svg>
            </button>
        </div>
        <div class="aside__item aside__item-category ">
            <?php

            global $additionalCountFilter;
            $additionalCountFilter = [
                '=PROPERTY_OWNER' => $userWithSubscribe
            ];

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "main-category-tree",
                Array(
                    "VIEW_MODE" => "TEXT",
                    "SHOW_PARENT_NAME" => "Y",
                    "IBLOCK_TYPE" => "products",
                    "IBLOCK_ID" => ADS_IBLOCK_ID,
                    "SECTION_URL" => "",
                    "SECTION_ID" => $rootSectionId,
                    "COUNT_ELEMENTS" => "Y",
                    "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                    "ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
                    "TOP_DEPTH" => "3",
                    "SECTION_FIELDS" => "",
                    "SECTION_USER_FIELDS" => "",
                    "ADD_SECTIONS_CHAIN" => $arParams['ADD_SECTIONS_CHAIN'],
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_NOTES" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_FILTER" => "Y",
                    "FILTER_NAME" => "arSectFilter",
                    "ALL_CATEGORIES_LINK" => "/",
                    "ROOT_SECTION" => $arRootSection,
                    "ACTIVE_SECTION_ID" => $arActiveSection['ID'],
                )
            );?>
        </div>
        <?php
        global $smartPreFilter;
        $smartPreFilter['=PROPERTY_OWNER'] = $userWithSubscribe;

        $APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter",
            "filter",
            array(
                "COMPONENT_TEMPLATE" => "",
                "IBLOCK_TYPE" => "products",
                "IBLOCK_ID" => ADS_IBLOCK_ID,
                "FILTER_NAME" => "arrFilter",
                "HIDE_NOT_AVAILABLE" => "N",
                "DISPLAY_ELEMENT_COUNT" => "Y",
                "SEF_MODE" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "N",
                "SAVE_IN_SESSION" => "N",
                "INSTANT_RELOAD" => "Y",
                "PAGER_PARAMS_NAME" => "arrPager",
                "PRICE_CODE" => array(
                    0 => "BASE",
                ),
                "CONVERT_CURRENCY" => "Y",
                "SECTION_TITLE" => "-",
                "SECTION_DESCRIPTION" => "-",
                "POPUP_POSITION" => "left",
                "SEF_RULE" => "/ads/#SECTION_CODE#/filter/#SMART_FILTER_PATH#/",
                "SECTION_CODE_PATH" => "",
                "SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"],
                "CURRENCY_ID" => "RUB",
                "PREFILTER_NAME" => "smartPreFilter",
                "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
                "XML_EXPORT" => "N",
                "TEMPLATE_THEME" => "blue",
                "SECTION_ID" => $arActiveSection['ID']
            ),
            false
        );?>
    </aside>
    <div class="page-content">
        <div class="announcements">
            <div class="announcements-header">
                <h2 class="title-section"><?=$APPLICATION->ShowTitle()?></h2>
                <?php include_once $_SERVER['DOCUMENT_ROOT'].'/'.SITE_TEMPLATE_PATH.'/include/switcher.php'; /** @var string $typeOfView */?>
            </div>
            <?php if ($isAjax) $APPLICATION->RestartBuffer(); ?>
            <?php
            global $arFilterAds, $arrFilter;
            $arFilterAds = [
                'INCLUDE_SUBSECTIONS' => 'Y',
                '=PROPERTY_OWNER' => $userWithSubscribe,
                '!=PROPERTY_OWNER' => $BLOCKED,
                ...$arrFilter
            ];

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                $typeOfView,
                array(
                    "LAZY_LOAD_ON" => "Y",
                    "LAZY_LOAD_START" => "12",
                    'SECTION_ID' => $arActiveSection['ID'],
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "PAGE_ELEMENT_COUNT" => $arParams["NEWS_COUNT"],
                    "ELEMENT_SORT_FIELD" => $arParams["SORT_BY1"],
                    "ELEMENT_SORT_ORDER" => $arParams["SORT_BY1"],
                    "ELEMENT_SORT_FIELD2" => $arParams["SORT_BY2"],
                    "ELEMENT_SORT_ORDER2" => $arParams["SORT_ORDER2"],
                    "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "MESSAGE_404" => $arParams["MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                    "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
                    "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
                    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                    "FILTER_NAME" => 'arFilterAds',
                    "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],
                ),
                false
            );
            ?>
            <?php if ($isAjax) die(); ?>
        </div>
        <?php if (!empty($arActiveSection['DESCRIPTION']) && !empty($arActiveSection['UF_SEO_TITLE']) && $isNotFirstPage === false && empty($arrFilter)):?>
            <div class="text-block">
                <h2 class="title-section"><?=$arActiveSection['UF_SEO_TITLE']?></h2>
                <p class="text"><?=$arActiveSection['DESCRIPTION']?></p>
            </div>
        <?php endif;?>
        <?php
        $obViewedGoods = new YouWatchBefore();
        $arViewedGoodsId = $obViewedGoods->getGoodsFromCookie();
        if (!empty($arViewedGoodsId)) {
            global $arViewedGoodsFilter;
            $arViewedGoodsFilter = ['ID' => $arViewedGoodsId, '!=PROPERTY_OWNER' => $BLOCKED, '=PROPERTY_OWNER' => $userWithSubscribe];
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "you-watch-before",
                array(
                    "LAZY_LOAD_ON" => "Y",
                    "LAZY_LOAD_START" => "0",
                    "ACTION_VARIABLE" => "",
                    "ADD_PICT_PROP" => "MORE_PHOTO",
                    "ADD_PROPERTIES_TO_BASKET" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPATIBLE_MODE" => "N",
                    "CONVERT_CURRENCY" => "Y",
                    "CURRENCY_ID" => "RUB",
                    "CUSTOM_FILTER" => "",
                    "DATA_LAYER_NAME" => "dataLayer",
                    "DETAIL_URL" => "",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "id",
                    "ELEMENT_SORT_FIELD2" => "sort",
                    "ELEMENT_SORT_ORDER" => $arViewedGoodsId,
                    "ELEMENT_SORT_ORDER2" => "asc",
                    "ENLARGE_PRODUCT" => "PROP",
                    "ENLARGE_PROP" => "NEWPRODUCT",
                    "FILTER_NAME" => "arViewedGoodsFilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "IBLOCK_ID" => ADS_IBLOCK_ID,
                    "IBLOCK_TYPE" => "products",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "ads",
                    "PAGER_TITLE" => "Ранее смотрели",
                    "PAGE_ELEMENT_COUNT" => "10",
                    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                    "RCM_TYPE" => "personal",
                    "SEF_MODE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SHOW_ALL_WO_SECTION" => "N",
                    "SHOW_CLOSE_POPUP" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "Y",
                    "SHOW_FROM_SECTION" => "N",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "Y",
                    "SLIDER_INTERVAL" => "3000",
                    "SLIDER_PROGRESS" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_ENHANCED_ECOMMERCE" => "Y",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "COMPONENT_TEMPLATE" => "you-watch-before",
                    "DISPLAY_COMPARE" => "N"
                ),
                false
            );
        }
      ?>
    </div>
</div>
<?php
if (!empty($arSectionTree)) {
    array_shift($arSectionTree); // Удаляем рут раздел (т.к. он уже есть в крошках)
    setBreadcrumb($arSectionTree); // Доставляем недостающие крошки
}
