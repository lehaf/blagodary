<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @const string  SITE_TEMPLATE_PATH */

$APPLICATION->SetTitle("Безопасность");

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
            <h2 class="title-section">Безопасность</h2>
            <form action="#" class="data-user">
                <div class="data-user-container">
                    <h3 class="title-block title-block--left">Изменение пароля</h3>
                    <div class="password-requirements">
                        <h4 class="password-requirements-title">Требования к паролю:</h4>
                        <ul class="password-requirements-list">
                            <li class="password-requirements-list__item">Минимум 8 символов</li>
                            <li class="password-requirements-list__item">Большая буква</li>
                            <li class="password-requirements-list__item">Маленькая буква</li>
                            <li class="password-requirements-list__item">Цифра</li>
                        </ul>
                    </div>
                    <div class="form-group ">
                        <label for="dataUserPassword" class="data-user__label">Текущий пароль*</label>
                        <input type="password" name="password" class="dataUserPassword" placeholder="********" id="dataUserPassword">
                        <span class="password-control"></span>
                    </div>
                    <div class="form-group ">
                        <label for="dataUserNewPassword" class="data-user__label">Новый пароль*</label>
                        <input type="password" name="password" class="dataUserPassword" placeholder="********" id="dataUserNewPassword">
                        <span class="password-control"></span>
                    </div>
                    <div class="form-group ">
                        <label for="dataUserPasswordRepeat" class="data-user__label">Повторите пароль*</label>
                        <input type="password" name="password" class="dataUserPassword" placeholder="********" id="dataUserPasswordRepeat">
                        <span class="password-control"></span>
                    </div>
                </div>
                <button type="submit" class="btn-bg data-user-btn">Сохранить изменения</button>
            </form>
        </div>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>