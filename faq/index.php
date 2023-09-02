<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @const string  SITE_TEMPLATE_PATH */

$APPLICATION->SetTitle("Вопрос-ответ");

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery-2.2.4.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.formstyler.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/air-datepicker.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.maskedinput.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/slick.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/main.js");

?>
    <div class="question-content">
        <h2 class="title-section"><?=$APPLICATION->ShowTitle()?></h2>
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "faq",
            Array(
                "DISPLAY_DATE" => "Y",	// Выводить дату элемента
                "DISPLAY_NAME" => "Y",	// Выводить название элемента
                "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
                "DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
                "AJAX_MODE" => "Y",	// Включить режим AJAX
                "IBLOCK_TYPE" => "content",	// Тип информационного блока (используется только для проверки)
                "IBLOCK_ID" => FAQ_IBLOCK_ID,	// Код информационного блока
                "NEWS_COUNT" => "100",	// Количество новостей на странице
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
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
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
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>