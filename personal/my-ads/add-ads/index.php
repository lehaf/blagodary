<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @global object $USER */
/** @const string  SITE_TEMPLATE_PATH */

$APPLICATION->SetTitle("Подать объявление");

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery-2.2.4.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.formstyler.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/air-datepicker.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.maskedinput.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/slick.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/main.js");

?>
<div class="page-container">
    <aside class="aside aside-cabinet">
        <div class="profile-menu">
            <div class="menu-authorized">
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
    </aside>
    <div class="page-content page-content--profile">
        <h2 class="title-section"><?=$APPLICATION->ShowTitle()?></h2>
        <form action="#" class="announcement-form form-block">
            <div class="dropzone">
                <h3 class="title-block title-block--left mobile-center">Фотографии</h3>
                <div class="form-group form-group__file">
                    <label for="inputFile">
                        <input type="file" multiple accept="image/*" id="inputFile">
                        <span class="input-file-btn">
                            <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use></svg>
                            Добавить фотографии
                        </span>
                    </label>
                    <span class="drop-info-text">или перетащите сюда</span>
                </div>
                <div class="dropzone__description">
                    <p>Используйте реальные фото вашего товара в разных ракурсах. Максимальный размер: 10 МБ.</p>
                    <div class="dropzone_count">
                        Загружено <span class="dropzone_count__loaded">0</span> из 9
                    </div>
                </div>
                <div class="dropzone__content">

                </div>
            </div>
            <div class="product-name">
                <div class="form-group">
                    <label for="productName" class="data-user__label">Название товара*</label>
                    <input type="text" placeholder="Например, телевизор Horizont" id="productName">
                </div>
            </div>
            <div class="form-wrapper" id="categorySelection">
                <div class="category-selection">
                    <div class="category-selection-main">
                        <h3 class="title-block title-block--left">Выбор категории*</h3>
                        <ul class="category-list category-list--selection">
                            <li class="category-list__item is-active" data-announcement-category="1"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-2"></use>
                                    </svg>
                                    Бытовая техника</a></li>
                            <li class="category-list__item" data-announcement-category="2"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-3"></use>
                                    </svg>
                                    Компьютерная техника</a></li>
                            <li class="category-list__item" data-announcement-category="3"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-4"></use>
                                    </svg>
                                    Телефоны и планшеты</a></li>
                            <li class="category-list__item" data-announcement-category="4"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-5"></use>
                                    </svg>
                                    Электроника</a></li>
                            <li class="category-list__item" data-announcement-category="5"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-6"></use>
                                    </svg>
                                    Женский гардероб</a></li>
                            <li class="category-list__item" data-announcement-category="6"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-7"></use>
                                    </svg>
                                    Мужской гардероб</a></li>
                            <li class="category-list__item" data-announcement-category="8"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-8"></use>
                                    </svg>
                                    Красота и здоровье</a></li>
                            <li class="category-list__item no-fill" data-announcement-category="9"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-9"></use>
                                    </svg>
                                    Все для детей и мам</a></li>
                            <li class="category-list__item" data-announcement-category="10"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-10"></use>
                                    </svg>
                                    Мебель</a></li>
                            <li class="category-list__item" data-announcement-category="11"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-11"></use>
                                    </svg>
                                    Все для дома</a></li>
                            <li class="category-list__item" data-announcement-category="12"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-12"></use>
                                    </svg>
                                    Ремонт и стройка</a></li>
                            <li class="category-list__item no-fill" data-announcement-category="13"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-13"></use>
                                    </svg>
                                    Сад и огород</a></li>
                            <li class="category-list__item no-fill" data-announcement-category="14"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-14"></use>
                                    </svg>
                                    Хобби, спорт и туризм</a></li>
                            <li class="category-list__item" data-announcement-category="15"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-15"></use>
                                    </svg>
                                    Свадьба и праздники</a></li>
                            <li class="category-list__item no-fill" data-announcement-category="16"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-16"></use>
                                    </svg>
                                    Животные</a></li>
                            <li class="category-list__item" data-announcement-category="17"><a href="#">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-17"></use>
                                    </svg>
                                    Прочее</a></li>
                        </ul>
                    </div>
                    <div class="category-selection-subcategory">
                        <h3 class="title-block title-block--left title-subcategory">Подкатегории выбранной категории</h3>
                        <div class="category-selection-content">
                            <div class="category-selection-content__item is-active" data-announcement-category="1">
                                <ul class="category-selection-list">
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Периферия </li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                </ul>
                            </div>
                            <div class="category-selection-content__item" data-announcement-category="2">
                                <ul class="category-selection-list">
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Периферия </li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                </ul>
                            </div>
                            <div class="category-selection-content__item" data-announcement-category="3">
                                <ul class="category-selection-list">
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Периферия </li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                </ul>
                            </div>
                            <div class="category-selection-content__item" data-announcement-category="4">
                                <ul class="category-selection-list">
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Периферия </li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                </ul>
                            </div>
                            <div class="category-selection-content__item" data-announcement-category="5">
                                <ul class="category-selection-list">
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Периферия </li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                </ul>
                            </div>
                            <div class="category-selection-content__item" data-announcement-category="6">
                                <ul class="category-selection-list">
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Периферия </li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                </ul>
                            </div>
                            <div class="category-selection-content__item" data-announcement-category="7">
                                <ul class="category-selection-list">
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Периферия </li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                </ul>
                            </div>
                            <div class="category-selection-content__item" data-announcement-category="8">
                                <ul class="category-selection-list">
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Периферия </li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                </ul>
                            </div>
                            <div class="category-selection-content__item" data-announcement-category="9">
                                <ul class="category-selection-list">
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Периферия </li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                </ul>
                            </div>
                            <div class="category-selection-content__item" data-announcement-category="10">
                                <ul class="category-selection-list">
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Периферия </li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                </ul>
                            </div>
                            <div class="category-selection-content__item" data-announcement-category="11">
                                <ul class="category-selection-list">
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры</li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Периферия и аксессуары</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                    <li class="category-selection-list__item">Периферия </li>
                                    <li class="category-selection-list__item">Комплектующие</li>
                                    <li class="category-selection-list__item">Ноутбуки</li>
                                    <li class="category-selection-list__item">Компьютеры и системные блоки</li>
                                    <li class="category-selection-list__item">Компьютеры / системные блоки / аксессуары</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="category-selection-ready">
                    <h3 class="title-block title-block--left">Выбор категории*</h3>
                    <div class="category-selection-ready__main" id="category-select"></div>
                    <div class="btn-bg category-selection-ready-btn">
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#pen"></use></svg>
                        Изменить подкатегорию</div>
                </div>
                <div class="extra-options">
                    <h3 class="title-block title-block--left">Дополнительные параметры для выбранной подкатегории:</h3>
                    <div class="form-group">
                        <label for="extraOptionsSelect" class="data-user__label">Выпадающий список</label>
                        <select name="country" class="custom-select " id="extraOptionsSelect">
                            <option value="1" selected>Параметр 1</option>
                            <option value="2">Параметр 2</option>
                            <option value="3">Параметр 3</option>
                        </select>
                    </div>
                    <div class="form-container">
                        <label for="rangeStart" class="data-user__label data-user__label--range">Диапазон</label>
                        <div class="form-group-wrapper form-group-wrapper--range">
                            <div class="for-group for-group--range">
                                <input type="text" id="rangeStart" placeholder="От">
                            </div>
                            <div class="for-group for-group--range">
                                <input type="text" id="rangeEnd" placeholder="До">
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-100">
                        <label class="data-user__label">Выбор из одного варианта</label>
                        <div class="form-group-wrapper form-group-radio">
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
                            <div class="form-group__item">
                                <label for="radio-5">Параметр 1</label>
                                <input type="radio" id="radio-5" name="radio-btn">
                            </div>
                            <div class="form-group__item">
                                <label for="radio-6">Параметр 2 c длинным названием в 2 строки</label>
                                <input type="radio" id="radio-6" name="radio-btn">
                            </div>
                            <div class="form-group__item">
                                <label for="radio-7">Параметр 2</label>
                                <input type="radio" id="radio-7" name="radio-btn">
                            </div>
                            <div class="form-group__item">
                                <label for="radio-8">Параметр 2</label>
                                <input type="radio" id="radio-8" name="radio-btn">
                            </div>
                            <div class="form-group__item">
                                <label for="radio-9">Параметр 2 c длинным названием в 2 строки</label>
                                <input type="radio" id="radio-9" name="radio-btn">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="data-user__label">Множественный выбор</label>
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
                </div>
                <div class="form-textarea">
                    <h3 class="title-block title-block--left mb-20">Описание*:</h3>
                    <div class="form-group">
                        <label>
                            <textarea placeholder="Текст сообщения" id="announcementTextarea" maxlength="4000"></textarea>
                        </label>
                        <div class="form-textarea-description">
                            <div class="min-text">Минимально: 20 знаков</div>
                            <div class="result-text">
                                <div class="result-text-value">0</div>
                                из
                                <div class="result-text-max">4000</div>
                                знаков
                            </div>
                        </div>
                    </div>

                </div>

                <div class="from-person-location">
                    <h3 class="title-block title-block--left">Местоположение:</h3>
                    <div class="data-user-container">
                        <div class="form-group">
                            <label for="selectForm" class="data-user__label">Область*</label>
                            <select name="country" class="custom-select custom-old" id="selectForm">
                                <option value="minsk" selected>Минск</option>
                                <option value="brest">Минская область</option>
                                <option value="grodno">Гродненская область</option>
                                <option value="gomel">Гомельская область</option>
                                <option value="mogilev">Могилевская область</option>
                                <option value="vit">Витебская область</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="selectFormNew" class="data-user__label">Город / Район*</label>
                            <select name="city" class="custom-select new-select" data-select="new-list"
                                    id="selectFormNew">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="from-person-phone">
                    <h3 class="title-block title-block--left">О продавце:</h3>
                    <div class="data-user-container data-user-container--tel">
                        <div class="form-group">
                            <label for="personName" class="data-user__label">Имя*</label>
                            <input type="text" placeholder="Константин" id="personName">
                        </div>
                        <div class="form-tel-container">
                            <div class="form-group form-group--tel">
                                <label for="dataUserTel" class="data-user__label">Контактный телефон*</label>
                                <input type="tel" placeholder="+375 (xx) xxx-xx-xx" class="dataUserTel" id="dataUserTel">
                            </div>
                        </div>
                        <div class="add-new-phone">
                            <span class="add-new-phone-btn">
                                <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use></svg>
                            </span>
                            <div class="add-new-phone-text">Добавить телефон</div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn--form">
                    <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use></svg>
                    Подать объявление
                </button>
            </div>
        </form>
    </div>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>