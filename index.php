<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @global array $BLOCKED */
/** @const string  SITE_TEMPLATE_PATH */

use WebCompany\YouWatchBefore;
use Bitrix\Main\Page\Asset;

global $BLOCKED;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery-2.2.4.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/air-datepicker.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.maskedinput.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.selectbox.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/slick.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/main.js");

$obRequest = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$isAjax = $obRequest->getPost('isAjax') === 'Y';
$userWithSubscribe = getUserWithSubscribe();

$APPLICATION->SetTitle("Благодарю - прими или отдай");
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
        <div class="aside__item aside__item-category">
            <?php
            global $arSectFilter;
            $arSectFilter = array(
                "!UF_MAIN_CATEGORY" => false,
                "PROPERTY" => [
                    'OWNER' => $userWithSubscribe
                ]
            );

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "main-category",
                array(
                    "VIEW_MODE" => "TEXT",
                    "SHOW_PARENT_NAME" => "Y",
                    "IBLOCK_TYPE" => "products",
                    "IBLOCK_ID" => ADS_IBLOCK_ID,
                    "SECTION_URL" => "",
                    "COUNT_ELEMENTS" => "Y",
                    "TOP_DEPTH" => "1",
                    "SECTION_FIELDS" => "",
                    "SECTION_USER_FIELDS" => "",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_NOTES" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_FILTER" => "Y",
                    "FILTER_NAME" => "arSectFilter",
                    "ALL_CATEGORIES_LINK" => "/ads/"
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
                "SECTION_ID" => $_REQUEST["SECTION_ID"]
            ),
            false
        );?>
    </aside>
    <div class="page-content">
        <?php $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "upper-banner",
            Array(
                "DISPLAY_DATE" => "Y",	// Выводить дату элемента
                "DISPLAY_NAME" => "Y",	// Выводить название элемента
                "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
                "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
                "AJAX_MODE" => "Y",	// Включить режим AJAX
                "IBLOCK_TYPE" => "main",	// Тип информационного блока (используется только для проверки)
                "IBLOCK_ID" => UPPER_BANNER_IBLOCK_ID,	// Код информационного блока
                "NEWS_COUNT" => "1",	// Количество новостей на странице
                "SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
                "SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
                "SORT_BY2" => "ID",	// Поле для второй сортировки новостей
                "SORT_ORDER2" => "DESC",	// Направление для второй сортировки новостей
                "FILTER_NAME" => "",	// Фильтр
                "FIELD_CODE" => array(	// Поля
                    0 => "ID",
                    1 => "DETAIL_PICTURE",
                    2 => "DETAIL_TEXT",
                ),
                "PROPERTY_CODE" => array(),
                "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
                "DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
                "PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
                "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
                "SET_TITLE" => "N",	// Устанавливать заголовок страницы
                "SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
                "SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
                "SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
                "SET_LAST_MODIFIED" => "Y",	// Устанавливать в заголовках ответа время модификации страницы
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
                "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
                "HIDE_LINK_WHEN_NO_DETAIL" => "Y",	// Скрывать ссылку, если нет детального описания
                "PARENT_SECTION" => "",	// ID раздела
                "PARENT_SECTION_CODE" => "",	// Код раздела
                "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
                "CACHE_TYPE" => "A",	// Тип кеширования
                "CACHE_TIME" => "360000",	// Время кеширования (сек.)
                "CACHE_FILTER" => "Y",	// Кешировать при установленном фильтре
                "CACHE_GROUPS" => "Y",	// Учитывать права доступа
                "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
                "DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
                "PAGER_TITLE" => "Новости",	// Название категорий
                "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
                "PAGER_TEMPLATE" => "",	// Шаблон постраничной навигации
                "PAGER_DESC_NUMBERING" => "Y",	// Использовать обратную навигацию
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
                "PAGER_SHOW_ALL" => "Y",	// Показывать ссылку "Все"
                "PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
                "SET_STATUS_404" => "Y",	// Устанавливать статус 404
                "SHOW_404" => "N",	// Показ специальной страницы
                "MESSAGE_404" => "",
                "PAGER_BASE_LINK" => "/",	// Url для построения ссылок (по умолчанию - автоматически)
                "PAGER_PARAMS_NAME" => "arrPager",	// Имя массива с переменными для построения ссылок
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
            ),
            false
        );?>
        <?php
        $obViewedGoods = new YouWatchBefore();
        $arViewedGoodsId = $obViewedGoods->getGoodsFromCookie();
        if (!empty($arViewedGoodsId)) {
            global $arViewedGoodsFilter;
            $arViewedGoodsFilter = ['ID' => $arViewedGoodsId, '!=PROPERTY_OWNER' => $BLOCKED];
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "you-watch-before",
                array(
                    "LAZY_LOAD_ON" => "N",
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
        <?php $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "banner-with-counter",
                Array(
            "DISPLAY_DATE" => "Y",	// Выводить дату элемента
                "DISPLAY_NAME" => "Y",	// Выводить название элемента
                "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
                "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
                "AJAX_MODE" => "Y",	// Включить режим AJAX
                "IBLOCK_TYPE" => "main",	// Тип информационного блока (используется только для проверки)
                "IBLOCK_ID" => BANNER_COUNTER_IBLOCK_ID,	// Код информационного блока
                "NEWS_COUNT" => "1",	// Количество новостей на странице
                "SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
                "SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
                "SORT_BY2" => "ID",	// Поле для второй сортировки новостей
                "SORT_ORDER2" => "DESC",	// Направление для второй сортировки новостей
                "FILTER_NAME" => "",	// Фильтр
                "FIELD_CODE" => array(	// Поля
                    0 => "ID",
                    1 => "DETAIL_PICTURE",
                ),
                "PROPERTY_CODE" => array(	// Свойства
                    0 => "COUNTER",
                ),
                "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
                "DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
                "PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
                "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
                "SET_TITLE" => "N",	// Устанавливать заголовок страницы
                "SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
                "SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
                "SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
                "SET_LAST_MODIFIED" => "Y",	// Устанавливать в заголовках ответа время модификации страницы
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
                "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
                "HIDE_LINK_WHEN_NO_DETAIL" => "Y",	// Скрывать ссылку, если нет детального описания
                "PARENT_SECTION" => "",	// ID раздела
                "PARENT_SECTION_CODE" => "",	// Код раздела
                "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
                "CACHE_TYPE" => "A",	// Тип кеширования
                "CACHE_TIME" => "360000",	// Время кеширования (сек.)
                "CACHE_FILTER" => "Y",	// Кешировать при установленном фильтре
                "CACHE_GROUPS" => "Y",	// Учитывать права доступа
                "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
                "DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
                "PAGER_TITLE" => "Новости",	// Название категорий
                "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
                "PAGER_TEMPLATE" => "",	// Шаблон постраничной навигации
                "PAGER_DESC_NUMBERING" => "Y",	// Использовать обратную навигацию
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
                "PAGER_SHOW_ALL" => "Y",	// Показывать ссылку "Все"
                "PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
                "SET_STATUS_404" => "Y",	// Устанавливать статус 404
                "SHOW_404" => "N",	// Показ специальной страницы
                "MESSAGE_404" => "",
                "PAGER_BASE_LINK" => "/",	// Url для построения ссылок (по умолчанию - автоматически)
                "PAGER_PARAMS_NAME" => "arrPager",	// Имя массива с переменными для построения ссылок
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
            ),
            false
        );?>
        <?php if (!empty($userWithSubscribe)):?>
            <div class="announcements">
                <div class="announcements-header">
                    <h2 class="title-section">Все объявления</h2>
                    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/'.SITE_TEMPLATE_PATH.'/include/switcher.php';
                    /** @var string $typeOfView */?>
                </div>
                <?php if ($isAjax) $APPLICATION->RestartBuffer(); ?>
                <?php global $arrFilter;
                $arrFilter['=PROPERTY_OWNER'] = $userWithSubscribe;
                $arrFilter['!=PROPERTY_OWNER'] = $BLOCKED;
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    $typeOfView,
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
                        "ELEMENT_SORT_FIELD" => "active_from",
                        "ELEMENT_SORT_FIELD2" => "id",
                        "ELEMENT_SORT_ORDER" => "ASC",
                        "ELEMENT_SORT_ORDER2" => "DESC",
                        "ENLARGE_PRODUCT" => "PROP",
                        "ENLARGE_PROP" => "NEWPRODUCT",
                        "FILTER_NAME" => "arrFilter",
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
                        "PAGER_TITLE" => "Все объявления",
                        "PAGE_ELEMENT_COUNT" => "4",
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
                        "COMPONENT_TEMPLATE" => "ads-list",
                        "DISPLAY_COMPARE" => "N",
                        "SECTION_ID" => $_REQUEST["SECTION_ID"],
                        "SECTION_CODE" => "",
                        "SECTION_USER_FIELDS" => array(
                            0 => "",
                            1 => "",
                        ),
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "LINE_ELEMENT_COUNT" => "3",
                        "BACKGROUND_IMAGE" => "-",
                        "SECTION_URL" => "",
                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "BROWSER_TITLE" => "-",
                        "META_KEYWORDS" => "-",
                        "META_DESCRIPTION" => "-",
                        "PRODUCT_ID_VARIABLE" => "id",
                        "PRICE_CODE" => array(
                        ),
                        "PRICE_VAT_INCLUDE" => "Y",
                        "BASKET_URL" => "/personal/basket.php",
                        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                        "PRODUCT_PROPS_VARIABLE" => "prop",
                        "PARTIAL_PRODUCT_PROPERTIES" => "N",
                        "MESSAGE_404" => ""
                    ),
                    false
                ); ?>
                <?php if ($isAjax) die(); ?>
            </div>
        <?php endif;?>
    </div>
</div>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>