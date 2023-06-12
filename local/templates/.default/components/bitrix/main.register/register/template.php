<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

$obRequest = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$isAjax = $obRequest->getPost('register_submit_button') === 'Y';

if ($isAjax) $APPLICATION->RestartBuffer();
   if (!empty($arResult["ERRORS"])) {
       foreach ($arResult["ERRORS"] as $key => $error)
           if (intval($key) == 0 && $key !== 0)
               $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);
                echo json_encode($arResult["ERRORS"]);
   }
if ($isAjax) die();
?>
<?if (!empty($arResult["SHOW_FIELDS"])):?>
    <form id="register" action="<?=POST_FORM_ACTION_URI?>" name="regform" class="registration-form data-user">
        <?foreach ($arResult["SHOW_FIELDS"] as $fieldCode):?>
            <?switch ($fieldCode):
                case 'LOGIN':?>
                    <div class="form-group mb-15">
                        <label for="emailRegistration"
                               class="data-user__label"
                        >E-mail<?=in_array($fieldCode,$arResult['REQUIRED_FIELDS']) !== false? '*' : ''?></label>
                        <input type="email"
                               name="REGISTER[<?=$fieldCode?>]"
                               id="emailRegistration"
                               placeholder="test@gmail.com"
                               data-field="<?=$fieldCode?>"
                        >
                    </div>
                <?break?>
                <?case 'PASSWORD':?>
                    <div class="form-group mb-15">
                        <label for="passwordRegistration"
                               class="data-user__label"
                        >Пароль<?=in_array($fieldCode,$arResult['REQUIRED_FIELDS']) !== false? '*' : ''?></label>
                        <input type="password"
                               name="REGISTER[<?=$fieldCode?>]"
                               class="dataUserPassword"
                               placeholder="Введите пароль"
                               id="passwordRegistration"
                               data-field="<?=$fieldCode?>"
                        >
                        <span class="password-control"></span>
                        <ul class="description-password">
                            <li class="description-password__item">Минимум 8 символов</li>
                            <li class="description-password__item">Большая буква</li>
                            <li class="description-password__item">Маленькая буква</li>
                            <li class="description-password__item">Цифра</li>
                        </ul>
                    </div>
                <?break?>
                <?case 'CONFIRM_PASSWORD':?>
                    <div class="form-group">
                        <label for="passwordRegistrationConfirm"
                               class="data-user__label"
                        >Подтвердить пароль<?=in_array($fieldCode,$arResult['REQUIRED_FIELDS']) !== false? '*' : ''?></label>
                        <input type="password"
                               name="REGISTER[<?=$fieldCode?>]"
                               class="dataUserPassword"
                               placeholder="Повторно введите пароль"
                               id="passwordRegistrationConfirm"
                               data-field="<?=$fieldCode?>"
                        >
                        <span class="password-control"></span>
                    </div>
                <?break?>
            <?endswitch;?>
        <?endforeach;?>
        <div class="form-group checkbox">
            <div class="form-group__item checkbox">
                <label for="accept-register" class="label-checkbox">
                    <input type="checkbox" name="accept-register" id="accept-register">
                    <span class="user-agreement">Я принимаю условия <a href="/agreement/">Пользовательского соглашения</a></span>
                </label>
            </div>
        </div>
        <button type="submit" class="btn-bg" >Зарегистрироваться</button>
    </form>
<?endif;?>

