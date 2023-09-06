<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

global $APPLICATION;
$obRequest = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$isAjax = $obRequest->getPost('forgot_pass') === 'Y';

if ($isAjax) {
    $APPLICATION->RestartBuffer();
    if (!empty($arResult['ERRORS'])) {
        echo json_encode($arResult['ERRORS']);
    } else {
        if (!empty($arResult['SUCCESS'])) echo json_encode(['SUCCESS' => $arResult['SUCCESS']]);
    }
    die();
}
?>
<div class="popUp popUp-reset-mail">
    <h3 class="reset-mail__title">Введите E-mail от своего профиля</h3>
    <p class="reset-mail__subtitle">Мы отправим на него ссылку для восстановления пароля</p>
    <div class="alert alert-success" style="display: none"></div>
    <form id="forgot-pass" name="bform" method="post" target="_top" action="<?= POST_FORM_ACTION_URI;?>" class="form-reset-mail data-user">
        <div class="form-group">
            <label for="reset-email" class="data-user__label">E-mail*</label>
            <input type="email" name="<?= $arResult['FIELDS']['login'];?>" maxlength="255" value="<?= \htmlspecialcharsbx($arResult['LAST_LOGIN']);?>"  placeholder="test@gmail.com">
        </div>
        <button type="submit" class="btn-bg" id="submit-reset-password"  name="<?= $arResult['FIELDS']['action'];?>" value="<?= Loc::getMessage('MAIN_AUTH_PWD_FIELD_SUBMIT');?>" >Отправить</button>
        <?if ($arResult['AUTH_AUTH_URL'] || $arResult['AUTH_REGISTER_URL']):?>
            <noindex>
                <?if ($arResult['AUTH_AUTH_URL']):?>
                    <div class="bx-authform-link-container">
                        <a href="<?= $arResult['AUTH_AUTH_URL'];?>" rel="nofollow">
                            <?= Loc::getMessage('MAIN_AUTH_PWD_URL_AUTH_URL');?>
                        </a>
                    </div>
                <?endif;?>
                <?if ($arResult['AUTH_REGISTER_URL']):?>
                    <div class="bx-authform-link-container">
                        <a href="<?= $arResult['AUTH_REGISTER_URL'];?>" rel="nofollow">
                            <?= Loc::getMessage('MAIN_AUTH_PWD_URL_REGISTER_URL');?>
                        </a>
                    </div>
                <?endif;?>
            </noindex>
        <?endif;?>
    </form>
    <span class="modal-cross">
        <svg>
            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup-white"></use>
        </svg>
    </span>
</div>

<script type="text/javascript">
	document.bform.<?= $arResult['FIELDS']['login'];?>.focus();
</script>
