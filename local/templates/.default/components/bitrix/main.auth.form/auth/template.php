<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/** @var object $APPLICATION */
/** @var array $arResult */

$obRequest = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$isAjax = $obRequest->getPost('AUTH_ACTION') === 'Y' && $obRequest->getPost('forgot_pass') !== 'Y';
if ($isAjax) {
    $APPLICATION->RestartBuffer();
    if (!empty($arResult['ERRORS'])) {
        echo json_encode($arResult["ERRORS"]);
    }
    die();
}

?>
<form id="auth-form" name="<?=$arResult['FORM_ID'];?>" action="<?=POST_FORM_ACTION_URI;?>" class="login-form data-user">
    <div class="form-group mb-15">
        <label for="email" class="data-user__label">E-mail*</label>
        <input type="email" name="<?=$arResult['FIELDS']['login'];?>" id="email" placeholder="test@gmail.com">
    </div>
    <div class="form-group ">
        <label for="passwordLogin" class="data-user__label">Пароль*</label>
        <input class="dataUserPassword"
               type="password"
               name="<?=$arResult['FIELDS']['password'];?>"
               placeholder="Введите пароль"
               id="passwordLogin"
        >
        <span class="password-control"></span>
    </div>
    <div class="form-group form-forgot">
        <a class="form-forgot__link" id="reset-password">Забыли пароль?</a>
    </div>
    <button type="submit" class="btn-bg">Войти</button>
</form>

<?if($arResult["AUTH_SERVICES"]):?>
    <?$this->SetViewTarget('auth_socials');?>
        <? $APPLICATION->IncludeComponent(
            "bitrix:socserv.auth.form",
            "socials",
            array(
                "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                "CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
                "AUTH_URL"=>$arResult["AUTH_URL"],
                "POST"=>$arResult["POST"],
            ),
            false,
            array("HIDE_ICONS"=>"Y")
        ); ?>
    <?$this->EndViewTarget();?>
<?endif?>