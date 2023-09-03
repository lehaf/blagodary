<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @global object $APPLICATION */
/** @var array $arResult */
?>
<form action="<?=$arResult["FORM_TARGET"]?>" class="data-user" method="post"  enctype="multipart/form-data">
    <?=$arResult["BX_SESSION_CHECK"]?>
    <input type="hidden" name="lang" value="<?=LANG?>">
    <input type="hidden" name="ID" value=<?=$arResult["ID"]?>>
    <div class="data-user-container data-user-container--tel">
        <h3 class="title-block title-block--left">Контактные телефоны</h3>
        <div class="data-user-container--tel__text">Укажите номера телефонов, по которым покупатели смогут с вами связаться</div>
        <?if (!empty($arResult["strProfileError"])):?>
            <div class="error-message" style="margin-bottom: 10px;"><?ShowError($arResult["strProfileError"]);?></div>
        <?endif;?>
        <div class="form-tel-container">
            <?if (!empty($arResult["arUser"]["UF_PHONES"])):?>
                <?foreach ($arResult["arUser"]["UF_PHONES"] as $key => $phone):?>
                    <div class="form-group form-group--tel">
                        <label for="dataUserTel" class="data-user__label data-user__label--tel">Контактный телефон №<?=$key+1?></label>
                        <input type="tel" value="<?=$phone?>" name="UF_PHONES[]" placeholder="+375 (xx) xxx-xx-xx" class="dataUserTel" id="dataUserTel">
                        <span class="remove_phone"><svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use></svg></span>
                    </div>
                <?endforeach;?>
            <?else:?>
                <div class="form-group form-group--tel">
                    <label for="dataUserTel" class="data-user__label data-user__label--tel">Контактный телефон*</label>
                    <input type="tel" name="UF_PHONES[]" placeholder="+375 (xx) xxx-xx-xx" class="dataUserTel" id="dataUserTel">
                </div>
            <?endif;?>
        </div>
        <div class="add-new-phone">
            <span class="add-new-phone-btn">
                <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use></svg>
            </span>
            <div class="add-new-phone-text">Добавить телефон</div>
        </div>
    </div>
    <div class="data-user-container">
        <h3 class="title-block title-block--left">Местоположение</h3>
        <?if (!empty($arResult['REGION'])):?>
            <div class="form-group">
                <label for="selectForm" class="data-user__label">Область</label>
                <select name="PERSONAL_STATE" class="custom-select custom-old" id="REGION">
                    <?foreach ($arResult['REGION'] as $key => $region):?>
                        <option data-dependency="<?=$region['XML_ID']?>" value="<?=$region['VALUE']?>"
                            <?=$arResult["arUser"]["PERSONAL_STATE"] == $region['VALUE'] ? 'selected' : ($key === 0 ? 'selected' : '')?>
                        ><?=$region['VALUE']?></option>
                    <?endforeach;?>
                </select>
            </div>
        <?endif;?>
        <?if (!empty($arResult['CITY'])):?>
            <div class="form-group">
                <label for="selectFormNew" class="data-user__label">Город / Район</label>
                <select name="PERSONAL_CITY" class="custom-select new-select" id="CITY">
                    <?foreach ($arResult['CITY'] as $xmlId => $city):?>
                        <option data-dependency="<?=$city['UF_GROUP']?>" value="<?=$city['UF_NAME']?>"
                            <?=$arResult["arUser"]["PERSONAL_CITY"] == $city['UF_NAME'] ? 'selected' : ''?>
                        ><?=$city['UF_NAME']?></option>
                    <?endforeach;?>
                </select>
            </div>
        <?endif;?>
    </div>
    <button type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>" class="btn-bg data-user-btn">Сохранить изменения</button>
</form>


