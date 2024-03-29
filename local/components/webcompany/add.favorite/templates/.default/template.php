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
$this->addExternalCss(SITE_TEMPLATE_PATH . "/html/css/loader.css");
?>
<div class="favorites-container">
    <?php if (!empty($arResult['ITEMS'])):?>
        <div class="favorites-list">
            <?php foreach ($arResult['ITEMS'] as $arItem):?>
                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="announcements-list__item">
                    <div class="announcements-img">
                        <img src="<?=$arItem['IMG']['src']?>"
                             title="<?=$arItem['NAME']?>"
                             alt="<?=$arItem['NAME']?>"
                        >
                    </div>
                    <div class="announcements-description">
                        <div class="announcements-description__head">
                            <h3><?=$arItem['NAME']?></h3>
                            <span data-item="<?=$arItem['ID']?>" class="favorite-card active"></span>
                        </div>
                        <div class="announcements-description__location">
                            <div class="location">
                                <?php if (!empty($arItem['REGION']) && !empty($arItem['CITY'])):?>
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#location"></use>
                                    </svg>
                                    <?=$arItem['REGION'].', '.$arItem['CITY']?>
                                <?php endif;?>
                            </div>
                            <div class="announcements-data"><?=$arItem['DATE_CREATE']?></div>
                        </div>
                    </div>
                </a>
            <?php endforeach;?>
        </div>
    <?php else:?>
        <div class="favorites-list">У вас нет избранных товаров</div>
    <?php endif;?>
</div>
