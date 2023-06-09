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
/** @global string $typeOfView */
$this->setFrameMode(true);
$locationSpritePath = SITE_TEMPLATE_PATH.'/html/assets/img/sprites/sprite.svg#location';
$this->addExternalCss(SITE_TEMPLATE_PATH.'/html/css/loader.css');
$this->addExternalJs(SITE_TEMPLATE_PATH.'/html/js/switcher_view_app.js');
?>
<?if (!empty($arResult['ITEMS'])):?>
    <div class="announcements-content">
        <div class="announcements-content__item announcements-content__item--card active">
            <?foreach ($arResult['ITEMS'] as $arItem):?>
                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="announcements-card__item">
                    <span class="announcements-card__item-img">
                        <img src="<?=$arItem['IMG']['src']?>"
                             title="<?=$arItem['NAME']?>"
                             alt="<?=$arItem['NAME']?>"
                        >
                    </span>
                    <span class="viewed-slider__item-description">
                        <span class="announcements-card__item--title"><?=$arItem['NAME']?></span>
                        <div class="location">
                            <?if (!empty($arItem['PLACE'])):?>
                                <svg>
                                    <use xlink:href="<?=$locationSpritePath?>"></use>
                                </svg>
                                <?=$arItem['PLACE']?>
                            <?endif;?>
                        </div>
                        <span class="viewed-slider__item-data"><?=$arItem['TIMESTAMP_X']?></span>
                    </span>
                    <span class="favorite-card"></span>
                </a>
            <?endforeach;?>
        </div>
        <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
            <br /><?=$arResult["NAV_STRING"]?>
        <?endif;?>
    </div>
<?endif;?>