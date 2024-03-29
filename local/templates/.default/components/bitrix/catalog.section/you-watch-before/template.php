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

// Включаем lazyload
if ($arParams['LAZY_LOAD_ON'] === 'Y') {
    $this->addExternalJs(SITE_TEMPLATE_PATH.'/html/js/image-defer.min.js');
    $pixel = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
}
?>
<?php if (!empty($arResult['ITEMS'])):?>
    <div class="viewed">
        <h2 class="title-section">Ранее вы смотрели</h2>
        <div class="viewed-slider">
            <?php foreach ($arResult['ITEMS'] as $key => $arItem):?>
                <?php
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $arItem["EDIT_LINK_TEXT"]);
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $arItem["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <a id="<?=$this->GetEditAreaID($arItem['ID'])?>" href="<?=$arItem['DETAIL_PAGE_URL']?>" class="viewed-slider__item">
                    <span class="viewed-slider__item-img">
                        <img
                            <?php if ($arParams['LAZY_LOAD_ON'] === 'Y' && $arParams['LAZY_LOAD_START'] <= $key && isset($pixel)):?>
                                src="<?=$pixel?>"
                                data-defer-src="<?=$arItem['IMG']['src']?>"
                            <?php else:?>
                                src="<?=$arItem['IMG']['src']?>"
                            <?php endif;?>
                            title="<?=$arItem['NAME']?>"
                            alt="<?=$arItem['NAME']?>"
                        >
                    </span>
                    <span class="viewed-slider__item-description">
                        <span class="viewed-slider__item-title"><?=$arItem['NAME']?></span>
                            <span class="viewed-slider__item-data"><?=$arItem['DATE_CREATE']?></span>
                        </span>
                    <span data-item="<?=$arItem['ID']?>" class="favorite-card"></span>
                </a>
            <?php endforeach;?>
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
<?php endif;?>