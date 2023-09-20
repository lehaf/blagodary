<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
?>
<div class="popUp popUp-complain">
    <h5 class="popUp__title"><?=!empty($arParams['FORM_TITLE']) ? $arParams['FORM_TITLE'] : ''?></h5>
    <span class="modal-cross">
        <svg>
            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
        </svg>
    </span>
    <?=$arResult["FORM_HEADER"]?>
        <div class="form-group">
            <input type="hidden"
                   name="form_<?=$arResult["QUESTIONS"]['USER_ID']['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arResult["QUESTIONS"]['USER_ID']['STRUCTURE'][0]['ID']?>"
                   value="<?=$arParams['COMPLAIN_USER_ID']?>"
            >
            <label class="complain-form-label">Причина жалобы:</label>
            <?if (!empty($arResult["QUESTIONS"]['COMPLAINS']['STRUCTURE'])):?>
                <?$firstKey = array_key_first($arResult["QUESTIONS"]['COMPLAINS']['STRUCTURE'])?>
                <div class="form-group-wrapper">
                    <?foreach ($arResult["QUESTIONS"]['COMPLAINS']['STRUCTURE'] as $key => $arField):?>
                        <div class="form-group__item radio-btn" style="width: 100%">
                            <label for="<?=$key?>"><?=$arField['MESSAGE']?></label>
                            <input type="radio"
                                   name="form_<?=$arField['FIELD_TYPE'].'_COMPLAINS'?>"
                                   id="<?=$key?>"
                                   <?=$firstKey === $key ? 'checked' : ''?>
                                    value="<?=$arField['ID']?>"
                            >
                        </div>
                    <?endforeach;?>
                </div>
            <?endif;?>
        </div>
        <div class="form-group">
            <label class="complain-form-label">Сообщение:</label>
            <label>
                <textarea placeholder="Введите сообщение" required></textarea>
            </label>
        </div>
        <div class="form-group">
            <input class="btn-bg popUp-complain-btn"
                   type="submit"
                   name="web_form_submit"
                   value="<?=htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == '' ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>"
            >
        </div>
    <?=$arResult["FORM_FOOTER"]?>
</div>
