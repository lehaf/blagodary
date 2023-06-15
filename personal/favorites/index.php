<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @const string  SITE_TEMPLATE_PATH */

$APPLICATION->SetTitle("Избранные товары");

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
            <h2 class="title-section">Избранные товары</h2>
            <div class="favorites-list">
                <a href="#" class="announcements-list__item">
                    <div class="announcements-img">
                        <img src="assets/img/announcements-list/item-1.jpg" alt="img">
                    </div>
                    <div class="announcements-description">
                        <div class="announcements-description__head">
                            <h3>ШИНЫ, ДИСКИ на Мерседес оригинал R16 подходят Sprinter, Vito, и другие Ме.
                                Колпаки, R16, б/у</h3>
                            <span class="favorite-card active"></span>
                        </div>
                        <div class="announcements-description__location">
                            <div class="location">
                                <svg>
                                    <use xlink:href="assets/img/sprites/sprite.svg#location"></use>
                                </svg>
                                Минск, Партизанский район
                            </div>
                            <div class="announcements-data">
                                26.09.2022 в 12:02
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="announcements-list__item">
                    <div class="announcements-img">
                        <img src="assets/img/announcements-list/item-2.jpg" alt="img">
                    </div>
                    <div class="announcements-description">
                        <div class="announcements-description__head">
                            <h3>Свитер желтый из нейлона (размер S)</h3>
                            <span class="favorite-card active"></span>
                        </div>
                        <div class="announcements-description__location">
                            <div class="location">
                                <svg>
                                    <use xlink:href="assets/img/sprites/sprite.svg#location"></use>
                                </svg>
                                Минск, Партизанский район
                            </div>
                            <div class="announcements-data">
                                26.09.2022 в 12:02
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="announcements-list__item">
                    <div class="announcements-img">
                        <img src="assets/img/announcements-list/item-1.jpg" alt="img">
                    </div>
                    <div class="announcements-description">
                        <div class="announcements-description__head">
                            <h3>ШИНЫ, ДИСКИ на Мерседес оригинал R16 подходят Sprinter, Vito, и другие Ме.
                                Колпаки, R16, б/у</h3>
                            <span class="favorite-card active"></span>
                        </div>
                        <div class="announcements-description__location">
                            <div class="location">
                                <svg>
                                    <use xlink:href="assets/img/sprites/sprite.svg#location"></use>
                                </svg>
                                Минск, Партизанский район
                            </div>
                            <div class="announcements-data">
                                26.09.2022 в 12:02
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="announcements-list__item">
                    <div class="announcements-img">
                        <img src="assets/img/announcements-list/item-2.jpg" alt="img">
                    </div>
                    <div class="announcements-description">
                        <div class="announcements-description__head">
                            <h3>Свитер желтый из нейлона (размер S)</h3>
                            <span class="favorite-card active"></span>
                        </div>
                        <div class="announcements-description__location">
                            <div class="location">
                                <svg>
                                    <use xlink:href="assets/img/sprites/sprite.svg#location"></use>
                                </svg>
                                Минск, Партизанский район
                            </div>
                            <div class="announcements-data">
                                26.09.2022 в 12:02
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>