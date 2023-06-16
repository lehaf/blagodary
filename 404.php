<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
$APPLICATION->SetTitle("404 Not Found");

echo 404;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>