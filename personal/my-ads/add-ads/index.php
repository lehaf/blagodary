<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @global object $USER */
/** @const string  SITE_TEMPLATE_PATH */

if (!$USER->IsAuthorized()) LocalRedirect('/');

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
        <?$APPLICATION->IncludeComponent(
            "webcompany:add.element.form",
            "",
            Array(
            )
        );?>
    </div>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>