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
    <div class="other-announcements">
        <h2 class="title-section">Другие объявления из выбранной категории</h2>
        <div class="other-announcements-content">
            <?foreach ($arResult['ITEMS'] as $arItem):?>
                <?
                // Добавляем эрмитаж
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $arItem["EDIT_LINK_TEXT"]);
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $arItem["DELETE_LINK_TEXT"],
                    array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
                );
                ?>
                <a id="<?=$this->GetEditAreaID($arItem['ID'])?>" href="<?=$arItem['DETAIL_PAGE_URL']?>" class="announcements-card__item">
                    <span class="announcements-card__item-img">
                        <img src="<?=$arItem['IMG']['src']?>"
                             title="<?=$arItem['NAME']?>"
                             alt="<?=$arItem['NAME']?>"
                        >
                    </span>
                    <span class="viewed-slider__item-description">
                          <span class="announcements-card__item--title"><?=$arItem['NAME']?></span>
                            <div class="location">
                                    <svg>
                                        <use xlink:href="<?=$locationSpritePath?>"></use>
                                    </svg>
                                    Минск, Партизанский район
                                </div>
                            <span class="viewed-slider__item-data"><?=$arItem['TIMESTAMP_X']?></span>
                    </span>
                    <span data-item="<?=$arItem['ID']?>" class="favorite-card"></span>
                </a>
            <?endforeach;?>
        </div>
    </div>
<?endif;?>