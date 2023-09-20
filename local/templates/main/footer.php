<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $USER, $APPLICATION;
?>
    </div>
</div>
<?php $APPLICATION->ShowViewContent('viewed-detail');?>
<footer class="footer">
    <div class="footer-top">
        <div class="wrapper">
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "bottom",
                Array(
                    "ROOT_MENU_TYPE" => "top",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "top",
                    "USE_EXT" => "N",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "Y",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "360000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => ""
                )
            );?>
        </div>
    </div>
    <div class="footer-content">
        <div class="wrapper">
            <div class="footer-text">
                <?php  $APPLICATION->IncludeFile(
                '/include/footer-descr.php',
                    Array(),
                    Array(
                    "MODE"      => "text",
                    "NAME"      => "Описание сервиса",
                ));?>
            </div>
            <?php $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "socials",
                Array(
                    "DISPLAY_DATE" => "Y",	// Выводить дату элемента
                    "DISPLAY_NAME" => "Y",	// Выводить название элемента
                    "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
                    "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
                    "AJAX_MODE" => "Y",	// Включить режим AJAX
                    "IBLOCK_TYPE" => "contacts",	// Тип информационного блока (используется только для проверки)
                    "IBLOCK_ID" => SOCIALS_IBLOCK_ID,	// Код информационного блока
                    "NEWS_COUNT" => "10",	// Количество новостей на странице
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
        </div>
    </div>
</footer>
<div class="substrate"></div>

<div class="category-pop-up">
    <div class="wrapper">
        <?php $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "all-menu",
            Array(
                "VIEW_MODE" => "TEXT",
                "SHOW_PARENT_NAME" => "Y",
                "IBLOCK_TYPE" => "products",
                "IBLOCK_ID" => ADS_IBLOCK_ID,
                "SECTION_URL" => "",
                "COUNT_ELEMENTS" => "Y",
                "TOP_DEPTH" => "3",
                "SECTION_FIELDS" => "",
                "SECTION_USER_FIELDS" => "",
                "ADD_SECTIONS_CHAIN" => "Y",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_NOTES" => "Y",
                "CACHE_GROUPS" => "Y",
                "CACHE_FILTER" => "Y",
                "ALL_CATEGORIES_LINK" => "/"
            )
        );?>
    </div>
</div>


<div id="mob-filter-header" class="popUp-overlay">
    <div class="popUp-overlay-header">
        <span class="popUp-title">Фильтры</span>
        <span class="popUp-cross">
            <svg>
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
            </svg>
        </span>
    </div>
</div>
<div class="mobile_menu_container">
    <div class="mobile_menu_content">
        <div class="mobile_menu_content__title">
            Категории
            <span class="popUp-cross mobile_menu__cross">
            <svg>
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
            </svg>
        </span>
        </div>
        <?php $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "all-menu-mobile",
            Array(
                "VIEW_MODE" => "TEXT",
                "SHOW_PARENT_NAME" => "Y",
                "IBLOCK_TYPE" => "products",
                "IBLOCK_ID" => ADS_IBLOCK_ID,
                "SECTION_URL" => "",
                "COUNT_ELEMENTS" => "Y",
                "TOP_DEPTH" => "3",
                "SECTION_FIELDS" => "",
                "SECTION_USER_FIELDS" => "",
                "ADD_SECTIONS_CHAIN" => "Y",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_NOTES" => "Y",
                "CACHE_GROUPS" => "Y",
                "CACHE_FILTER" => "Y",
                "ALL_CATEGORIES_LINK" => "/"
            )
        );?>

    </div>
</div>
<div class="mobile_menu_overlay"></div>
<?php $APPLICATION->IncludeComponent(
    "bitrix:main.auth.forgotpasswd",
    "forgot_pass",
    Array()
);?>
<?php if (!$USER->IsAuthorized()) :?>
    <div class="popUp popUp-login">
        <div class="login-btn-list">
            <button class="login-btn-list__item login-btn active">Вход</button>
            <button class="login-btn-list__item registration-btn">Регистрация</button>
        </div>
        <div class="login-services">
            <?$APPLICATION->ShowViewContent('auth_socials');?>
        </div>
        <div class="popUp-login-content">
            <div class="login-content active">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.auth.form",
                    "auth",
                    Array(
                        "AUTH_FORGOT_PASSWORD_URL" => "",
                        "AUTH_REGISTER_URL" => "",
                        "AUTH_SUCCESS_URL" => "",
                    ),
                    false
                ); ?>
            </div>
            <div class="registration-content">
                <?$APPLICATION->IncludeComponent(
	"bitrix:main.register",
	"register",
                array(
                    "AUTH" => "Y",
                    "REQUIRED_FIELDS" => array(
                    ),
                    "SET_TITLE" => "N",
                    "SHOW_FIELDS" => array(
                    ),
                    "SUCCESS_PAGE" => "",
                    "USER_PROPERTY" => array(
                    ),
                    "USER_PROPERTY_NAME" => "",
                    "USE_BACKURL" => "N",
                    "COMPONENT_TEMPLATE" => "register"
                ),
                false
            );?>
            </div>
        </div>
        <span class="modal-cross">
            <svg>
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup-white"></use>
            </svg>
        </span>
    </div>
<?endif?>
</body>
</html>