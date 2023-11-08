<?php
define("AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @const string  SITE_TEMPLATE_PATH */

$APPLICATION->SetTitle("Смена пароля");

?>
<div class="question-content">
    <div class="services-more">
        <h1><?php $APPLICATION->ShowTitle()?></h1>
        <?php $APPLICATION->IncludeComponent(
            "bitrix:system.auth.form",
            "errors",
            array(
                "SHOW_ERRORS" => "Y",
                "COMPONENT_TEMPLATE" => "errors",
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO"
            ),
            false
        );
         $APPLICATION->IncludeComponent(
            "bitrix:system.auth.changepasswd",
            "simple",
            array(
                "SHOW_ERRORS" => "Y"
            ),
            false
        );?>
    </div>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");