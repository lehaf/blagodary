<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @const string  SITE_TEMPLATE_PATH */

$APPLICATION->SetTitle("Контактная информация");

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
        <form action="#" class="data-user">
            <div class="data-user-container data-user-container--tel">
                <h3 class="title-block title-block--left">Контактные телефоны</h3>
                <div class="data-user-container--tel__text">Укажите номера телефонов, по которым покупатели смогут с вами связаться</div>
                <div class="form-tel-container">
                    <div class="form-group form-group--tel">
                        <label for="dataUserTel" class="data-user__label data-user__label--tel">Контактный телефон*</label>
                        <input type="tel" placeholder="+375 (xx) xxx-xx-xx" class="dataUserTel" id="dataUserTel">
                    </div>
                </div>
                <div class="add-new-phone">
                        <span class="add-new-phone-btn">
                            <svg><use xlink:href="assets/img/sprites/sprite.svg#plus"></use></svg>
                        </span>
                    <div class="add-new-phone-text">Добавить телефон</div>
                </div>
            </div>
            <div class="data-user-container">
                <h3 class="title-block title-block--left">Местоположение</h3>
                <div class="form-group">
                    <label for="selectForm" class="data-user__label">Область</label>
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
                    <label for="selectFormNew" class="data-user__label">Город / Район</label>
                    <select name="city" class="custom-select new-select" data-select="new-list"
                            id="selectFormNew">
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-bg data-user-btn">Сохранить изменения</button>
        </form>
    </div>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>