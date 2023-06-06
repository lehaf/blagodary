<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
use Bitrix\Main\Page\Asset;

/** @global $APPLICATION */
$isMainPage = $APPLICATION->GetCurDir() === '/';

?>
<html>
<head>
    <?$APPLICATION->ShowHead();?>
    <?
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/html/css/style.css");
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
                <div class="header-search" style="position:absolute; left: 377.5px">
                    <label for="header-search">
                        <input type="text" class="header-search__el" id="header-search" name="header-search" placeholder="Искать товары">
                    </label>
                    <button class="btn-bg btn-search">Поиск</button>
                </div>
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

    <div class="bread-crumbs">
        <div class="wrapper">
            <ul class="bread-crumbs-list">
                <li class="bread-crumbs-list__item"><a href="#">Главная</a></li>
                <li class="bread-crumbs-list__item"><a href="#">Раздел</a></li>
                <li class="bread-crumbs-list__item"><a href="#">Страница выбранного товара</a></li>
                <li class="bread-crumbs-list__item mobile"><a href="#">Выбранный раздел товаров</a></li>
            </ul>
        </div>
    </div>

<div class="page">
    <div class="wrapper">
