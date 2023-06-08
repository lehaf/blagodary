<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @const string  SITE_TEMPLATE_PATH */
use WebCompany\YouWatchBefore;
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery-2.2.4.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.formstyler.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/air-datepicker.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.maskedinput.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/slick.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/main.js");

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
            $arSectFilter = Array("!UF_MAIN_CATEGORY" => false);
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "main-category",
                Array(
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
        <div class="aside__item aside__item-form">
            <div class="aside-form">
                <form class="aside-form-search" action="#">
                    <div class="form-group-search aside-form__item mobile-input-search">
                        <label for="form-search-mobile">Поиск по товарам</label>
                        <input type="text" placeholder="Искать товары" name="form-search"
                               class="form-search-input" id="form-search-mobile">
                    </div>
                    <div class="form-group-search form-group-search--select aside-form__item">
                        <label for="selectForm">Область</label>
                        <select name="country" class="custom-select custom-old" id="selectForm">
                            <option value="minsk" selected>Минск</option>
                            <option value="brest">Минская область</option>
                            <option value="grodno">Гродненская область</option>
                            <option value="gomel">Гомельская область</option>
                            <option value="mogilev">Могилевская область</option>
                            <option value="vit">Витебская область</option>
                        </select>
                    </div>
                    <div class="form-group-search form-group-search--select-new aside-form__item">
                        <label for="selectFormNew">Город / Район</label>
                        <select name="city" class="custom-select new-select" data-select="new-list"
                                id="selectFormNew">
                        </select>
                    </div>
                    <div class="form-group-search aside-form__item">
                        <label for="range-min">Диапазон</label>
                        <div class="form-group-range">
                            <div class="range__item range-min">
                                <input type="text" class="range__item-input" placeholder="От" name="range-min"
                                       id="range-min">
                            </div>
                            <div class="range__item range-max">
                                <input type="text" class="range__item-input" placeholder="От" name="range-max">
                            </div>
                        </div>
                    </div>
                    <div class="form-group-search aside-form__item">
                        <label>Выбор из одного варианта</label>
                        <div class="form-group-wrapper">
                            <div class="form-group__item">
                                <label for="radio-1">Параметр 1</label>
                                <input type="radio" id="radio-1" name="radio-btn">
                            </div>
                            <div class="form-group__item">
                                <label for="radio-2">Параметр 2 c длинным названием в 2 строки</label>
                                <input type="radio" id="radio-2" name="radio-btn">
                            </div>
                            <div class="form-group__item">
                                <label for="radio-3">Параметр 2</label>
                                <input type="radio" id="radio-3" name="radio-btn">
                            </div>
                            <div class="form-group__item">
                                <label for="radio-4">Параметр 2</label>
                                <input type="radio" id="radio-4" name="radio-btn">
                            </div>
                        </div>
                    </div>
                    <div class="form-group-search aside-form__item">
                        <label>Множественный выбор</label>
                        <div class="form-group-wrapper checkbox">
                            <div class="form-group__item">
                                <label for="checkbox-1" class="label-checkbox">
                                    <input type="checkbox" name="value-1" id="checkbox-1">
                                    <span>Параметр 1</span>
                                </label>

                            </div>
                            <div class="form-group__item checkbox">
                                <label for="checkbox-2" class="label-checkbox">
                                    <input type="checkbox" name="value-1" id="checkbox-2">
                                    <span>Параметр 2</span>
                                </label>
                            </div>
                            <div class="form-group__item checkbox">
                                <label for="checkbox-3" class="label-checkbox">
                                    <input type="checkbox" name="value-1" id="checkbox-3">
                                    <span>Параметр 3</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="aside-form__item--btn">
                        <button class="btn-bg btn--main-search">
                            Найти
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#search-white"></use>
                            </svg>
                        </button>
                        <button type="reset" class="btn-reset btn-reset--scroll">
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-btn"></use>
                            </svg>
                            Сбросить фильтры
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </aside>
    <div class="page-content">
        <?$APPLICATION->IncludeComponent(
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
                "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
                "SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
                "SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
                "SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
                "SET_LAST_MODIFIED" => "Y",	// Устанавливать в заголовках ответа время модификации страницы
                "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",	// Включать инфоблок в цепочку навигации
                "ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
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
        <?
        $obViewedGoods = new YouWatchBefore();
        $arViewedGoodsId = $obViewedGoods->getGoodsFromCookie();
        if (!empty($arViewedGoodsId)) {
            global $arViewedGoodsFilter;
            $arViewedGoodsFilter = ['ID' => $arViewedGoodsId];
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "you-watch-before",
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
        <?$APPLICATION->IncludeComponent(
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
                "SET_TITLE" => "Y",	// Устанавливать заголовок страницы
                "SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
                "SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
                "SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
                "SET_LAST_MODIFIED" => "Y",	// Устанавливать в заголовках ответа время модификации страницы
                "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",	// Включать инфоблок в цепочку навигации
                "ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
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
        <div class="announcements">
            <div class="announcements-header">
                <h2 class="title-section">Все объявления</h2>
                <div class="announcements-switch">
                    <div class="announcements-switch__item switch-list active">
                        <svg width="22" height="18" viewBox="0 0 22 18" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 8H7C7.26522 8 7.51957 7.89464 7.70711 7.70711C7.89464 7.51957 8 7.26522 8 7V1C8 0.734784 7.89464 0.48043 7.70711 0.292893C7.51957 0.105357 7.26522 0 7 0H1C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1V7C0 7.26522 0.105357 7.51957 0.292893 7.70711C0.48043 7.89464 0.734784 8 1 8ZM2 2H6V6H2V2ZM7 18C7.26522 18 7.51957 17.8946 7.70711 17.7071C7.89464 17.5196 8 17.2652 8 17V11C8 10.7348 7.89464 10.4804 7.70711 10.2929C7.51957 10.1054 7.26522 10 7 10H1C0.734784 10 0.48043 10.1054 0.292893 10.2929C0.105357 10.4804 0 10.7348 0 11V17C0 17.2652 0.105357 17.5196 0.292893 17.7071C0.48043 17.8946 0.734784 18 1 18H7ZM2 12H6V16H2V12ZM21 3H11C10.7348 3 10.4804 3.10536 10.2929 3.29289C10.1054 3.48043 10 3.73478 10 4C10 4.26522 10.1054 4.51957 10.2929 4.70711C10.4804 4.89464 10.7348 5 11 5H21C21.2652 5 21.5196 4.89464 21.7071 4.70711C21.8946 4.51957 22 4.26522 22 4C22 3.73478 21.8946 3.48043 21.7071 3.29289C21.5196 3.10536 21.2652 3 21 3ZM21 13H11C10.7348 13 10.4804 13.1054 10.2929 13.2929C10.1054 13.4804 10 13.7348 10 14C10 14.2652 10.1054 14.5196 10.2929 14.7071C10.4804 14.8946 10.7348 15 11 15H21C21.2652 15 21.5196 14.8946 21.7071 14.7071C21.8946 14.5196 22 14.2652 22 14C22 13.7348 21.8946 13.4804 21.7071 13.2929C21.5196 13.1054 21.2652 13 21 13Z"/>
                            <path d="M1 8H7C7.26522 8 7.51957 7.89464 7.70711 7.70711C7.89464 7.51957 8 7.26522 8 7V1C8 0.734784 7.89464 0.48043 7.70711 0.292893C7.51957 0.105357 7.26522 0 7 0H1C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1V7C0 7.26522 0.105357 7.51957 0.292893 7.70711C0.48043 7.89464 0.734784 8 1 8ZM2 2H6V6H2V2ZM7 18C7.26522 18 7.51957 17.8946 7.70711 17.7071C7.89464 17.5196 8 17.2652 8 17V11C8 10.7348 7.89464 10.4804 7.70711 10.2929C7.51957 10.1054 7.26522 10 7 10H1C0.734784 10 0.48043 10.1054 0.292893 10.2929C0.105357 10.4804 0 10.7348 0 11V17C0 17.2652 0.105357 17.5196 0.292893 17.7071C0.48043 17.8946 0.734784 18 1 18H7ZM2 12H6V16H2V12ZM21 3H11C10.7348 3 10.4804 3.10536 10.2929 3.29289C10.1054 3.48043 10 3.73478 10 4C10 4.26522 10.1054 4.51957 10.2929 4.70711C10.4804 4.89464 10.7348 5 11 5H21C21.2652 5 21.5196 4.89464 21.7071 4.70711C21.8946 4.51957 22 4.26522 22 4C22 3.73478 21.8946 3.48043 21.7071 3.29289C21.5196 3.10536 21.2652 3 21 3ZM21 13H11C10.7348 13 10.4804 13.1054 10.2929 13.2929C10.1054 13.4804 10 13.7348 10 14C10 14.2652 10.1054 14.5196 10.2929 14.7071C10.4804 14.8946 10.7348 15 11 15H21C21.2652 15 21.5196 14.8946 21.7071 14.7071C21.8946 14.5196 22 14.2652 22 14C22 13.7348 21.8946 13.4804 21.7071 13.2929C21.5196 13.1054 21.2652 13 21 13Z"/>
                        </svg>
                    </div>
                    <div class="announcements-switch__item switch-card">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <mask id="path-1-inside-1_404_2873" fill="white">
                                <rect width="8" height="8" rx="1" stroke-width="0"/>
                            </mask>
                            <rect width="8" height="8" rx="1" stroke-width="4"
                                  mask="url(#path-1-inside-1_404_2873)"/>
                            <mask id="path-2-inside-2_404_2873" fill="white">
                                <rect x="10" width="8" height="8" rx="1" stroke-width="0"/>
                            </mask>
                            <rect x="10" width="8" height="8" rx="1" stroke-width="4"
                                  mask="url(#path-2-inside-2_404_2873)"/>
                            <mask id="path-3-inside-3_404_2873" fill="white">
                                <rect x="10" y="10" width="8" height="8" rx="1" stroke-width="0"/>
                            </mask>
                            <rect x="10" y="10" width="8" height="8" rx="1" stroke-width="4"
                                  mask="url(#path-3-inside-3_404_2873)"/>
                            <mask id="path-4-inside-4_404_2873" fill="white">
                                <rect y="10" width="8" height="8" rx="1" stroke-width="0"/>
                            </mask>
                            <rect y="10" width="8" height="8" rx="1" stroke-width="4"
                                  mask="url(#path-4-inside-4_404_2873)"/>
                        </svg>

                    </div>
                </div>
            </div>
            <? $APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"ads", 
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
		"FILTER_NAME" => "",
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
		"COMPONENT_TEMPLATE" => "ads",
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
);?>
        </div>
    </div>
</div>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>