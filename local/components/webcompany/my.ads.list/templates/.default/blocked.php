<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
/** @global string $typeOfView */
$this->setFrameMode(true);
?>
<div class="profile-error">
    <div class="profile-error__message">
        <span class="profile-error-icon">
            <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#error"></use></svg>
        </span>
        <h4 class="title-block">
            Ваша <span>Учетная запись заблокирована</span>. Вы не можете размещать новые объявления.
            Текущие объявления не публикуются для просмотра другим пользователям.
        </h4>
    </div>
    <?if (!empty($arResult['BLOCKED_TEXT'])):?>
        <div class="reason-blocking">
            <h4 class="title-block title-block--reason">Причина блокировки:</h4>
            <p class="profile-error__text profile-error__text--reason"><?=$arResult['BLOCKED_TEXT']?></p>
            <p class="profile-error__text">Для уточнения деталей вы можете связаться с технической поддержкой.</p>
            <button class="btn-bg contact-support">Связаться с поддержкой</button>
        </div>
    <?endif;?>
</div>

    <form action="#" class="popUp-form"></form>

<?$APPLICATION->IncludeComponent("bitrix:form", "support", Array(
    "AJAX_MODE" => "N",	// Включить режим AJAX
    "SEF_MODE" => "N",	// Включить поддержку ЧПУ
    "WEB_FORM_ID" => "1",	// ID веб-формы
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
    "VARIABLE_ALIASES" => array(
        "action" => "action",
    )
),
    false
);?>