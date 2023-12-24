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

// Включаем lazyload
if ($arParams['LAZY_LOAD_ON'] === 'Y') {
    $this->addExternalJs(SITE_TEMPLATE_PATH.'/html/js/image-defer.min.js');
    $pixel = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
}
?>
<div class="announcements-content">
    <?php if (!empty($arResult['ITEMS'])):?>
        <div class="announcements-content__item announcements-content__item--card active">
            <?php foreach ($arResult['ITEMS'] as $key => $arItem):?>
                <?php
                // Добавляем эрмитаж
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $arItem["EDIT_LINK_TEXT"]);
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $arItem["DELETE_LINK_TEXT"], array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <a id="<?=$this->GetEditAreaID($arItem['ID'])?>" href="<?=$arItem['DETAIL_PAGE_URL']?>" class="announcements-card__item">
                    <span class="announcements-card__item-img">
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
                        <span class="announcements-card__item--title"><?=$arItem['NAME']?></span>
                        <div class="location">
                            <?php if (!empty($arItem['PLACE'])):?>
                                <svg>
                                    <use xlink:href="<?=$locationSpritePath?>"></use>
                                </svg>
                                <?=$arItem['PLACE']?>
                            <?php endif;?>
                        </div>
                        <span class="viewed-slider__item-data"><?=$arItem['DATE_CREATE']?></span>
                    </span>
                    <span data-item="<?=$arItem['ID']?>" class="favorite-card"></span>
                </a>
            <?php endforeach;?>
        </div>
        <?php if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
            <br /><?=$arResult["NAV_STRING"]?>
        <?php endif;?>
    <?php else:?>
        <div class="empty-ads">Объявлений в каталоге не найдено!</div>
    <?php endif;?>
</div>
