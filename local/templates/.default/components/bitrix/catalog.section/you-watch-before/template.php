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
$locationSpritePath = SITE_TEMPLATE_PATH.'/html/assets/img/sprites/sprite.svg#location';
?>
<?if (!empty($arResult['ITEMS'])):?>
    <div class="viewed">
        <h2 class="title-section">Ранее вы смотрели</h2>
        <div class="viewed-slider">
            <?foreach ($arResult['ITEMS'] as $arItem):?>
                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="viewed-slider__item">
                    <span class="viewed-slider__item-img">
                        <img src="<?=$arItem['IMG']['src']?>"
                             title="<?=$arItem['NAME']?>"
                             alt="<?=$arItem['NAME']?>"
                        >
                    </span>
                    <span class="viewed-slider__item-description">
                        <span class="viewed-slider__item-title"><?=$arItem['NAME']?></span>
                            <span class="viewed-slider__item-data"><?=$arItem['TIMESTAMP_X']?></span>
                        </span>
                    <span class="favorite-card"></span>
                </a>
            <?endforeach;?>
        </div>
        <div class="viewed-slider-arrows slider-arrows-container">
            <div class="viewed-slider-prev slider-arrow-prev">
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-prev">
                    </use>
                </svg>
            </div>
            <div class="viewed-slider-next slider-arrow-next">
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-next"></use>
                </svg>
            </div>
        </div>
    </div>
<?endif;?>