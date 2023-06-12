<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/** @var array $arResult */

\Bitrix\Main\Page\Asset::getInstance()->addCss(
	'/bitrix/css/main/system.auth/flat/style.css'
);
?>
<form name="<?=$arResult['FORM_ID'];?>" action="<?=POST_FORM_ACTION_URI;?>" class="login-form data-user">
    <div class="form-group mb-15 error">
        <label for="email" class="data-user__label">E-mail*</label>
        <input type="email" name="<?=$arResult['FIELDS']['login'];?>" id="email" placeholder="test@gmail.com" required>
        <div class="error-block">Некорректный адрес электронной почты</div>
    </div>
    <div class="form-group ">
        <label for="passwordLogin" class="data-user__label">Пароль*</label>
        <input class="dataUserPassword" type="password" name="<?=$arResult['FIELDS']['password'];?>" placeholder="Введите пароль" id="passwordLogin" required>
        <span class="password-control"></span>
    </div>
    <div class="form-group form-forgot">
        <a class="form-forgot__link" id="reset-password">Забыли пароль?</a>
    </div>
    <button type="submit" class="btn-bg">Войти</button>
</form>
