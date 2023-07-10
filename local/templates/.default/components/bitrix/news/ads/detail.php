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
/** @global array $BLOCKED */

global $BLOCKED;
$curUserId = $USER->GetId();
$this->setFrameMode(true);
?>
<?php $ElementID = $APPLICATION->IncludeComponent(
"bitrix:news.detail",
"ads",
[
    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
    "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
    "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
    "META_KEYWORDS" => $arParams["META_KEYWORDS"],
    "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
    "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
    "SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
    "SET_TITLE" => $arParams["SET_TITLE"],
    "MESSAGE_404" => $arParams["MESSAGE_404"],
    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
    "SHOW_404" => $arParams["SHOW_404"],
    "FILE_404" => $arParams["FILE_404"],
    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
    "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
    "ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
    "DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
    "DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
    "PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
    "PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
    "CHECK_DATES" => $arParams["CHECK_DATES"],
    "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
    "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
    "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
    "USE_SHARE" => $arParams["USE_SHARE"],
    "SHARE_HIDE" => $arParams["SHARE_HIDE"],
    "SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
    "SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
    "SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
    "SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
    "ADD_ELEMENT_CHAIN" => $arParams["ADD_ELEMENT_CHAIN"],
    'STRICT_SECTION_CHECK' => $arParams['STRICT_SECTION_CHECK'],
],
$component,
['HIDE_ICONS' => 'Y']
);?>
<?if (!empty($curUserId)):?>
    <?php $APPLICATION->IncludeComponent(
        "bitrix:form.result.new",
        "complain",
        Array(
            'COMPLAIN_USER_ID' => !empty($GLOBALS['OWNER_ID']) ? $GLOBALS['OWNER_ID'] : '',
            "AJAX_MODE" => "N",	// Включить режим AJAX
            "SEF_MODE" => "N",	// Включить поддержку ЧПУ
            "WEB_FORM_ID" => "COMPLAIN",	// ID веб-формы
            "RESULT_ID" => "",	// ID результата
            "START_PAGE" => "new",	// Начальная страница
            "SHOW_LIST_PAGE" => "N",	// Показывать страницу со списком результатов
            "SHOW_EDIT_PAGE" => "N",	// Показывать страницу редактирования результата
            "SHOW_VIEW_PAGE" => "N",	// Показывать страницу просмотра результата
            "SUCCESS_URL" => "",	// Страница с сообщением об успешной отправке
            "SHOW_ANSWER_VALUE" => "N",	// Показать значение параметра ANSWER_VALUE
            "SHOW_ADDITIONAL" => "Y",	// Показать дополнительные поля веб-формы
            "SHOW_STATUS" => "N",	// Показать текущий статус результата
            "EDIT_ADDITIONAL" => "Y",	// Выводить на редактирование дополнительные поля
            "EDIT_STATUS" => "Y",	// Выводить форму смены статуса
            "NOT_SHOW_FILTER" => "",	// Коды полей, которые нельзя показывать в фильтре
            "NOT_SHOW_TABLE" => "",	// Коды полей, которые нельзя показывать в таблице
            "CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
            "CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
            "IGNORE_CUSTOM_TEMPLATE" => "Y",	// Игнорировать свой шаблон
            "USE_EXTENDED_ERRORS" => "Y",	// Использовать расширенный вывод сообщений об ошибках
            "CACHE_TYPE" => "A",	// Тип кеширования
            "CACHE_TIME" => "3600",	// Время кеширования (сек.)
            "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
            "AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
            "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
            "SEF_FOLDER" => "/communication/web-forms/",	// Каталог ЧПУ (относительно корня сайта)
            "COMPONENT_TEMPLATE" => ".default",
            "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
            "NAME_TEMPLATE" => "",
            "FORM_CLASS" => "complain-form",
            "FORM_TITLE" => "Пожаловаться на пользователя",
            "VARIABLE_ALIASES" => array(
                "action" => "action",
            )
        ), false);?>
<?endif;?>
<?php
if (!empty($GLOBALS['SECTION_ID'])) {

    global $arAdsFilter;
    $arAdsFilter = [
        'IBLOCK_SECTION_ID' => $GLOBALS['SECTION_ID'],
        '!=PROPERTY_OWNER' => $BLOCKED,
        '!ID' => $ElementID,
    ];

    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "ads-section",
        array(
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "AJAX_MODE" => "N",
            "IBLOCK_TYPE" => "products",
            "IBLOCK_ID" => ADS_IBLOCK_ID,
            "NEWS_COUNT" => "10",
            "SORT_BY1" => "RAND",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "ACTIVE_FROM",
            "SORT_ORDER2" => "DESC",
            "FILTER_NAME" => "arAdsFilter",
            "FIELD_CODE" => array(
                0 => "ID",
                1 => "DETAIL_PICTURE",
            ),
            "PROPERTY_CODE" => array(
                0 => "IMAGES",
            ),
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "SET_TITLE" => "Y",
            "SET_BROWSER_TITLE" => "Y",
            "SET_META_KEYWORDS" => "Y",
            "SET_META_DESCRIPTION" => "Y",
            "SET_LAST_MODIFIED" => "Y",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "Y",
            "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "INCLUDE_SUBSECTIONS" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "CACHE_FILTER" => "Y",
            "CACHE_GROUPS" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_TITLE" => "Объявления",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "ads",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "Y",
            "PAGER_BASE_LINK_ENABLE" => "Y",
            "SET_STATUS_404" => "Y",
            "SHOW_404" => "N",
            "MESSAGE_404" => "",
            "PAGER_BASE_LINK" => "",
            "PAGER_PARAMS_NAME" => "arrPager",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "COMPONENT_TEMPLATE" => "ads",
            "STRICT_SECTION_CHECK" => "N"
        ),
        false
    );
}
?>

<?
$obViewedGoods = new YouWatchBefore();
$arViewedGoodsId = $obViewedGoods->getGoodsFromCookie();
if (!empty($arViewedGoodsId)) {
    global $arViewedGoodsFilter;
    $arViewedGoodsFilter = ['ID' => $arViewedGoodsId,'!ID' => $ElementID, '!=PROPERTY_OWNER' => $BLOCKED,];
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "you-watch-before-detail",
        array(
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
