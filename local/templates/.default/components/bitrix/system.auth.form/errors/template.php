<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!empty($arResult['ERROR_MESSAGE']) && $arResult['SHOW_ERRORS'] === 'Y'):?>
    <div id="alert-changepass" class="alert <?=$arResult['ERROR_MESSAGE']['TYPE'] === 'OK' ? 'alert-success' : 'alert-error'?>" style="display: block;">
        <?=ShowMessage($arResult['ERROR_MESSAGE'])?>
    </div>
<?php endif;?>


