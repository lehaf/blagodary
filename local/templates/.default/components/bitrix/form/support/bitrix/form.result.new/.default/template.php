<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<div class="popUp popUp-support">
    <h5 class="popUp__title">Связь с технической поддержкой</h5>
    <span class="modal-cross">
        <svg>
            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
        </svg>
    </span>
    <?=$arResult["FORM_HEADER"]?>
        <div class="form-group">
            <div class="row">
                <div class="row__item">
                    <label for="name">
                        <input type="text"
                               name="form_<?=$arResult["QUESTIONS"]['NAME']['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arResult["QUESTIONS"]['NAME']['STRUCTURE'][0]['ID']?>"
                               id="name"
                               placeholder="Имя*"
                               required
                        >
                    </label>
                </div>
                <div class="row__item">
                    <label for="email">
                        <input type="email"
                               name="form_<?=$arResult["QUESTIONS"]['EMAIL']['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arResult["QUESTIONS"]['EMAIL']['STRUCTURE'][0]['ID']?>"
                               id="email"
                               placeholder="E-mail*"
                               required
                        >
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>
                <textarea placeholder="Текст сообщения*"
                          name="form_<?=$arResult["QUESTIONS"]['MESSAGE']['STRUCTURE'][0]['FIELD_TYPE'].'_'.$arResult["QUESTIONS"]['MESSAGE']['STRUCTURE'][0]['ID']?>"
                          required
                ></textarea>
            </label>
        </div>
        <div class="form-group">
            <input class="btn-bg popUp-complain-btn" type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == '' ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
        </div>
    <?=$arResult["FORM_FOOTER"]?>
</div>
