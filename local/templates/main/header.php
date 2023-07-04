<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Page\Asset;

/** @global object $APPLICATION */
/** @global object $USER */

global $BLOCKED;
$BLOCKED = getUserBlockedList();
$curPage = $APPLICATION->GetCurPage();
$isMainPage = $curPage === '/';
$isAddAdsPage = $curPage === '/personal/my-ads/add-ads/';
$pageSpecialClass = $APPLICATION->GetDirProperty("pageSpecialClass");
$bUserIsBlocked = in_array($USER->GetId(),$BLOCKED);
?>
<html>
<head>
    <?$APPLICATION->ShowHead();?>
    <?
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/html/css/style.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/html/css/linksstyle.css");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/add-favorite-app.js");
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
                    <?if (!$bUserIsBlocked):?>
                        <?if ($USER->IsAuthorized()) :?>
                            <?if (!$isAddAdsPage):?>
                                <a href="/personal/my-ads/add-ads/" class="btn submit-an-ad">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use>
                                    </svg>
                                    Подать объявление
                                </a>
                                <a href="/personal/my-ads/add-ads/" class="btn submit-an-ad submit-an-ad--mobile">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use>
                                    </svg>
                                </a>
                            <?else:?>
                                <button class="btn submit-an-ad sign-in">
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
                            <?endif;?>
                        <?else:?>
                            <button class="btn submit-an-ad sign-in sign-in-modal">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use>
                                </svg>
                                Подать объявление
                            </button>
                            <button class="btn submit-an-ad submit-an-ad--mobile sign-in-modal">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use>
                                </svg>
                            </button>
                        <?endif;?>
                    <?endif;?>
                    <?if ($USER->IsAuthorized()) :?>
                        <div class="header-account-menu">
                        <button class="btn-white sign-in user-authorized is-active">Личный кабинет
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#authorized"></use>
                            </svg>
                        </button>
                        <button class="btn-white sign-in sign-in--mobile is-active">
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#sign-in-mobile">
                                </use>
                            </svg>
                        </button>
                        <div class="menu-authorized">
                            <div class="mobile_menu_content__title mobile_menu_content__title--authorized">
                                Личный кабинет
                                <span class="menu-authorized__cross">
                                     <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
                                     </svg>
                                </span>
                            </div>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "personal",
                                Array(
                                    "ROOT_MENU_TYPE" => "personal",
                                    "MAX_LEVEL" => "1",
                                    "CHILD_MENU_TYPE" => "",
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
                    <?else:?>
                        <button class="btn-white sign-in sign-in-modal">Войти</button>
                        <button class="btn-white sign-in sign-in-modal sign-in--mobile">
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#sign-in-mobile">
                                </use>
                            </svg>
                        </button>
                    <?endif;?>
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
