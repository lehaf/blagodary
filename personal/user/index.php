<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @const string  SITE_TEMPLATE_PATH */

$APPLICATION->SetTitle("Персональные данные");

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
        <h2 class="title-section">Персональные данные</h2>
        <div class="profile-data">
            <h3 class="title-block title-block--left">Данные профиля</h3>
            <div class="profile-data__description">E-mail:</div>
            <div class="profile-data__email">test@google.com</div>
            <div class="profile-data__text">Вы указали этот e-mail при регистрации, его нельзя изменить.</div>
        </div>
        <form action="#" class="data-user">
            <div class="data-user-container">
                <div class="form-group">
                    <label for="dataUserName" class="data-user__label">Имя*</label>
                    <input type="text" placeholder="Павел" id="dataUserName">
                </div>
                <div class="form-group-row">
                    <div class="form-group">
                        <label for="dataUserGender" class="data-user__label">Пол</label>
                        <select name="country" class="custom-select custom-old" id="dataUserGender">
                            <option value="minsk" selected>Не выбран</option>
                            <option value="brest">Ж</option>
                            <option value="grodno">M</option>
                        </select>
                        <div class="form-group-description">Не будет отображаться в профиле</div>
                    </div>
                    <div class="form-group">
                        <label for="dataUserBirth" class="data-user__label">Дата рождения</label>
                        <input type="text" placeholder="27.10.2022" id="dataUserBirth">
                        <div class="form-group-description">Не будет отображаться в профиле</div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-bg data-user-btn">Сохранить изменения</button>
        </form>
    </div>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>