<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
use Bitrix\Main\Page\Asset;
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
            <ul class="top-nav">
                <li class="top-nav__link"><a href="#">О сервисе</a></li>
                <li class="top-nav__link"><a href="#">Вопрос-ответ</a></li>
            </ul>
        </div>
    </div>
    <div class="header-bottom">
        <div class="wrapper">
            <div class="header-bottom-content">
                <a href="#" class="header-logo">
                    <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/header-logo.svg" alt="logo">
                </a>
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
<div class="page">
    <div class="wrapper">
