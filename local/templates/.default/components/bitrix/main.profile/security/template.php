<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @global object $APPLICATION */
/** @var array $arResult */
?>
<form action="<?=$arResult["FORM_TARGET"]?>" class="data-user" method="post"  enctype="multipart/form-data">
    <?=$arResult["BX_SESSION_CHECK"]?>
    <input type="hidden" name="lang" value="<?=LANG?>">
    <input type="hidden" name="ID" value=<?=$arResult["ID"]?>>
    <div class="data-user-container">
        <h3 class="title-block title-block--left">Изменение пароля</h3>
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
        <?ShowError($arResult["strProfileError"]);?>
        <div class="form-group ">
            <label for="dataUserNewPassword" class="data-user__label">Новый пароль*</label>
            <input type="password"
                   name="NEW_PASSWORD"
                   maxlength="50"
                   minlength="8"
                   pattern="^(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                   autocomplete="off"
                   class="dataUserPassword"
                   placeholder="********"
                   id="dataUserNewPassword"
            >
            <span class="password-control"></span>
        </div>
        <div class="form-group ">
            <label for="dataUserPasswordRepeat" class="data-user__label">Повторите пароль*</label>
            <input type="password"
                   name="NEW_PASSWORD_CONFIRM"
                   maxlength="50"
                   minlength="8"
                   pattern="^(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                   autocomplete="off"
                   class="dataUserPassword"
                   placeholder="********"
                   id="dataUserPasswordRepeat"
            >
            <span class="password-control"></span>
        </div>
    </div>
    <button type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>" class="btn-bg data-user-btn">Сохранить изменения</button>
</form>
