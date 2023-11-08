<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arResult */

?>
<div class="password-requirements">
    <h4 class="password-requirements-title">Требования к паролю:</h4>
    <ul class="password-requirements-list">
        <li class="password-requirements-list__item">Использовать латинские символы</li>
        <li class="password-requirements-list__item">Минимум 8 символов</li>
        <li class="password-requirements-list__item">Большая буква</li>
        <li class="password-requirements-list__item">Маленькая буква</li>
        <li class="password-requirements-list__item">Цифра</li>
    </ul>
</div>
<form class="data-user" id="changePass" method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
    <?php if (!empty($arResult["BACKURL"])):?>
        <input type="hidden" name="backurl" value="/">
    <?php endif ?>
    <input type="hidden" name="AUTH_FORM" value="Y">
    <input type="hidden" name="TYPE" value="CHANGE_PWD">
    <input type="hidden" name="USER_LOGIN" maxlength="50" value="<?=$_GET["USER_LOGIN"]?>" class="bx-auth-input">
    <input type="hidden" name="USER_CHECKWORD" maxlength="50" value="<?=$_GET["USER_CHECKWORD"]?>" class="bx-auth-input" autocomplete="off" />
    <div class="form-group">
        <label for="reset-email" class="data-user__label">Новый пароль*</label>
        <input type="password"
               name="USER_PASSWORD"
               maxlength="255"
               placeholder="Введите новый пароль"
        >
    </div>
    <div class="form-group">
        <label for="reset-email" class="data-user__label">Повторите пароль*</label>
        <input type="password"
               name="USER_CONFIRM_PASSWORD"
               maxlength="255"
               placeholder="Повторите пароль"
               data-validate="n"
        >
    </div>
    <?php if($arResult["USE_CAPTCHA"]):?>
        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
        <span class="starrequired">*</span><?=GetMessage("system_auth_captcha")?>
        <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" >
    <?php endif?>
    <button id="change-pass" class="btn-bg" form="changePass">Сменить пароль</button>
</form>




