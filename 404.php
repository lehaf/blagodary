<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object  $APPLICATION */

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/html/css/404.css");

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
$APPLICATION->SetTitle("Ничего не найдено!");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
?>
<div class="container">
    <div class="error-code">4<span class="heart">♡</span>4</div>
    <div class="error-text">Такой страницы не существует</div>
    <a class="btn-bg back-to-main" href="/">На главную</a>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");