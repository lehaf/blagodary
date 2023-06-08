<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
use Bitrix\Main\Page\Asset;

/** @global $APPLICATION */
$isMainPage = $APPLICATION->GetCurDir() === '/';
$pageSpecialClass = $APPLICATION->GetDirProperty("pageSpecialClass");
?>
<html>
<head>
    <?$APPLICATION->ShowHead();?>
    <?
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/html/css/style.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/html/css/linksstyle.css");
    ?>
    <title><?$APPLICATION->ShowTitle()?></title>
</head>
<body>
<?$APPLICATION->ShowPanel()?>
<div class="fake-header" style="height: 126px;"></div>
<header class="header">
    <div class="header-top">
        <div class="wrapper">
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "top",
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
    <div class="header-bottom">
        <div class="wrapper">
            <div class="header-bottom-content">
                <?if (!$isMainPage):?><a href="/" class="header-logo"><?else:?><div><?endif;?>
                    <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/header-logo.svg" alt="logo">
                <?if (!$isMainPage):?></a><?else:?></div><?endif;?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:search.title",
                    "search-header",
                    array(
                        "CATEGORY_0" => array(
                            0 => "iblock_products",
                        ),
                        "CATEGORY_0_TITLE" => "Поиск",
                        "CHECK_DATES" => "N",
                        "CONTAINER_ID" => "title-search",
                        "INPUT_ID" => "title-search-input",
                        "NUM_CATEGORIES" => "1",
                        "ORDER" => "date",
                        "PAGE" => "/ads/search/",
                        "SHOW_INPUT" => "Y",
                        "SHOW_OTHERS" => "N",
                        "TOP_COUNT" => "5",
                        "USE_LANGUAGE_GUESS" => "Y",
                        "COMPONENT_TEMPLATE" => "search-header",
                        "CATEGORY_0_iblock_products" => array(
                            0 => "2",
                        ),
                        "BUTTON_NAME" => "Поиск",
                        "PLACEHOLDER" => "Искать товары"
                    ),
                    false
                );?>
                <div class="header-account">
                    <button class="btn submit-an-ad">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use>
                        </svg>
                        Подать объявление
                    </button>
                    <button class="btn submit-an-ad submit-an-ad--mobile">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use>
                        </svg>
                    </button>
                    <button class="btn-white sign-in">Войти</button>
                    <button class="btn-white sign-in sign-in--mobile">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#sign-in-mobile">
                            </use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
<?if (!$isMainPage):?>
    <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        "",
            Array(
            "START_FROM" => "0",
            "PATH" => "",
            "SITE_ID" => "s1"
        )
    );?>
<?endif;?>

<div class="page <?=!empty($pageSpecialClass) ? $pageSpecialClass : ''?>">
    <div class="wrapper">
