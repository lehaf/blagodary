<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<? if (!empty($arResult['ITEMS'])):?>
    <div class="aside__item aside__item-form">
        <div class="aside-form">
            <form id="filter" class="aside-form-search" name="<?=$arResult["FILTER_NAME"]."_form"?>" action="<?=$arResult["FORM_ACTION"]?>">
                <div class="form-group-search aside-form__item mobile-input-search">
                    <label for="form-search-mobile">Поиск по товарам</label>
                    <input type="text" placeholder="Искать товары" name="form-search"
                           class="form-search-input" id="form-search-mobile">
                </div>
                <?foreach ($arResult['ITEMS'] as $arFilter):?>
                    <?switch ($arFilter['DISPLAY_TYPE']):
                        case 'F':?>
                            <?if (!empty($arFilter['VALUES'])):?>
                                <div class="form-group-search aside-form__item">
                                    <label><?=$arFilter['NAME']?></label>
                                    <div class="form-group-wrapper checkbox">
                                        <?foreach ($arFilter['VALUES'] as $key => $arVal):?>
                                            <div class="form-group__item">
                                                <label for="<?=$arVal['CONTROL_ID']?>" class="label-checkbox">
                                                    <input type="checkbox" name="<?=$arVal['CONTROL_NAME']?>" id="<?=$arVal['CONTROL_ID']?>">
                                                    <span><?=$arVal['VALUE']?></span>
                                                </label>
                                            </div>
                                        <?endforeach;?>
                                    </div>
                                </div>
                            <?endif;?>
                        <?break;?>
                        <?case 'K':?>
                            <?if (!empty($arFilter['VALUES'])):?>
                                <div class="form-group-search aside-form__item">
                                    <label><?=$arFilter['NAME']?></label>
                                    <div class="form-group-wrapper">
                                        <?foreach ($arFilter['VALUES'] as $key => $arVal):?>
                                            <div class="form-group__item">
                                                <label for="<?=$arVal['CONTROL_ID']?>"><?=$arVal['VALUE']?></label>
                                                <input type="radio" name="<?=$arVal['CONTROL_NAME']?>" id="<?=$arVal['CONTROL_ID']?>" value="<?=$arVal['CONTROL_ID']?>">
                                            </div>
                                        <?endforeach;?>
                                    </div>
                                </div>
                            <?endif;?>
                        <?break;?>
                        <?case 'P':?>
                            <?if (!empty($arFilter['VALUES'])):?>
                            <?$firstKey = array_key_first($arFilter['VALUES'])?>
                                <div class="form-group-search form-group-search--select aside-form__item">
                                    <label for="<?=$arFilter['NAME']?>"><?=$arFilter['NAME']?></label>
                                    <select name="<?=$arFilter['VALUES'][$firstKey]['CONTROL_NAME_ALT']?>" class="custom-select custom-old" id="<?=$arFilter['NAME']?>">
                                        <?foreach ($arFilter['VALUES'] as $key => $arVal):?>
                                            <option value="<?=$arVal['HTML_VALUE_ALT']?>" <?=$key === $firstKey ? 'selected' : ''?>><?=$arVal['VALUE']?></option>
                                        <?endforeach;?>
                                    </select>
                                </div>
                            <?endif;?>
                        <?break;?>
                        <?case 'B':?>
                            <?if (!empty($arFilter['VALUES'])):?>
                                <div class="form-group-search aside-form__item">
                                    <label for="range-min"><?=$arFilter['NAME']?></label>
                                    <div class="form-group-range">
                                        <div class="range__item range-min">
                                            <input type="text"
                                                   class="range__item-input"
                                                   placeholder="От"
                                                   name="<?=$arFilter["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                                   id="<?=$arFilter["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                                   value="<?=$arFilter["VALUES"]["MIN"]["VALUE"]?>"
                                            >
                                        </div>
                                        <div class="range__item range-max">
                                            <input type="text"
                                                   class="range__item-input"
                                                   placeholder="До"
                                                   name="<?=$arFilter["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                                   id="<?=$arFilter["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                                   value="<?=$arFilter["VALUES"]["MAX"]["VALUE"]?>"
                                            >
                                        </div>
                                    </div>
                                </div>
                            <?endif;?>
                        <?break;?>
                        <?case 'A':?>
                            <?if (!empty($arFilter['VALUES'])):?>
                                <div class="form-group-search aside-form__item">
                                    <label for="range-min"><?=$arFilter['NAME']?></label>
                                    <div class="form-group-range">
                                        <div class="range__item range-min">
                                            <input type="text"
                                                   class="range__item-input"
                                                   placeholder="От"
                                                   name="<?=$arFilter["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                                   id="<?=$arFilter["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                                   value="<?=$arFilter["VALUES"]["MIN"]["VALUE"]?>"
                                            >
                                        </div>
                                        <div class="range__item range-max">
                                            <input type="text"
                                                   class="range__item-input"
                                                   placeholder="До"
                                                   name="<?=$arFilter["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                                   id="<?=$arFilter["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                                   value="<?=$arFilter["VALUES"]["MAX"]["VALUE"]?>"
                                            >
                                        </div>
                                    </div>
                                </div>
                            <?endif;?>
                        <?break;?>
                    <?endswitch;?>
                <?endforeach;?>
                <div class="aside-form__item--btn">
                    <button id="filter-submit" class="btn-bg btn--main-search">
                        Найти
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#search-white"></use>
                        </svg>
                    </button>
                    <button id="filter-reset" type="reset" class="btn-reset btn-reset--scroll">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-btn"></use>
                        </svg>
                        Сбросить фильтры
                    </button>
                </div>
            </form>
        </div>
    </div>
<?endif;?>