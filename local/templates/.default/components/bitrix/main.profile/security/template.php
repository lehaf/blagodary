<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @global object $APPLICATION */
/** @var array $arResult */
?>
<?if (!empty($arResult["arUser"]["EMAIL"])):?>
    <div class="profile-data">
        <h3 class="title-block title-block--left">Данные профиля</h3>
        <div class="profile-data__description">E-mail:</div>
        <div class="profile-data__email"><?=$arResult["arUser"]["EMAIL"]?></div>
        <div class="profile-data__text">Вы указали этот e-mail при регистрации, его нельзя изменить.</div>
    </div>
<?endif;?>
<form action="<?=$arResult["FORM_TARGET"]?>" class="data-user" method="post"  enctype="multipart/form-data">
    <?=$arResult["BX_SESSION_CHECK"]?>
    <input type="hidden" name="lang" value="<?=LANG?>">
    <input type="hidden" name="ID" value=<?=$arResult["ID"]?>>
    <div class="data-user-container">
        <div class="form-group">
            <label for="dataUserName" class="data-user__label">Имя*</label>
            <input type="text" placeholder="Введите ваше имя" id="dataUserName" name="NAME" value="<?=$arResult["arUser"]["NAME"]?>">
        </div>
        <div class="form-group-row">
            <div class="form-group">
                <label for="dataUserGender" class="data-user__label">Пол</label>
                <select name="PERSONAL_GENDER" class="custom-select custom-old" id="dataUserGender">
                    <option value="">Не выбран</option>
                    <option value="M"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "M" ? " SELECTED=\"SELECTED\"" : ""?>>М</option>
                    <option value="F"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "F" ? " SELECTED=\"SELECTED\"" : ""?>>Ж</option>
                </select>
                <div class="form-group-description">Не будет отображаться в профиле</div>
            </div>
            <div class="form-group">
                <? $APPLICATION->IncludeComponent(
                    'bitrix:main.calendar',
                    'birth',
                    array(
                        'SHOW_INPUT' => 'Y',
                        'FORM_NAME' => 'form1',
                        'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
                        'INPUT_VALUE' => $arResult["arUser"]["PERSONAL_BIRTHDAY"],
                        'SHOW_TIME' => 'N'
                    ),
                    null,
                    array('HIDE_ICONS' => 'Y')
                ); ?>
            </div>
        </div>
    </div>
    <button type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>" class="btn-bg data-user-btn">Сохранить изменения</button>
</form>

<form action="<?=$arResult["FORM_TARGET"]?>" class="data-user" method="post"  enctype="multipart/form-data">
    <?=$arResult["BX_SESSION_CHECK"]?>
    <input type="hidden" name="lang" value="<?=LANG?>">
    <input type="hidden" name="ID" value=<?=$arResult["ID"]?>>
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
            <input type="text" placeholder="Введите ваше имя" id="dataUserName" name="PASSWORD" value="<?=$arResult["arUser"]["PASSWORD"]?>">
            <span class="password-control"></span>
        </div>
        <div class="form-group ">
            <label for="dataUserNewPassword" class="data-user__label">Новый пароль*</label>
            <input type="password" name="CONFIRM_PASSWORD" class="dataUserPassword" placeholder="********" value="<?=$arResult["arUser"]["PASSWORD"]?>" id="dataUserNewPassword">
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