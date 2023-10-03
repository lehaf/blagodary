<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$standardSpriteImgPath = SITE_TEMPLATE_PATH.'/html/assets/img/sprites/category.svg#item-17';
$curPage = $APPLICATION->GetCurPage();
?>
<?if (!empty($arResult['SECTIONS']) && !empty($arResult['CATEGORIES'])):?>
<?php $firstSectionKey = array_key_first($arResult['SECTIONS'])?>
    <div class="page-container">
        <aside class="aside">
            <button class="btn-bg btn-category btn-category-close">
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#category-open"></use>
                </svg>
                Категории
            </button>
            <ul class="category-list">
                <li class="category-list__item active">
                    <span class="main-menu-link">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-1"></use>
                        </svg>
                        Все категории
                    </span>
                </li>
                <?foreach ($arResult['CATEGORIES'] as $key => $arCategory):?>
                    <li class="category-list__item category-list__item--pop-up <?=$key === 0 ? 'is-active' : ''?>"
                        id="<?=$this->GetEditAreaID($arCategory['ID'])?>"
                        data-category="<?=$arCategory['NAME']?>"
                    >
                        <a href="<?=$arCategory['LINK']?>">
                            <?if (!empty($arCategory['PICTURE']['SRC'])):?>
                                <img src="<?=$arCategory['PICTURE']['SRC']?>"
                                     height="16"
                                     width="16"
                                     title="<?=$arCategory['NAME']?>"
                                     alt="<?=$arCategory['NAME']?>"
                                >
                            <?else:?>
                                <svg>
                                    <use xlink:href="<?=$standardSpriteImgPath?>"></use>
                                </svg>
                            <?endif?>
                            <?=$arCategory['NAME']?>
                        </a>
                    </li>
                <?endforeach;?>
            </ul>
        </aside>
        <div class="page-content">
            <?foreach ($arResult['SECTIONS'] as $key => $arSection):?>
                <div class="category-content <?=$firstSectionKey === $key ? 'is-active' : ''?>" data-category="<?=$arSection['NAME']?>">
                    <h3 class="title-section"><?=$arSection['NAME']?></h3>
                    <?if (!empty($arSection['ITEMS'])):?>
                        <div class="category-content-wrapper">
                            <?foreach ($arSection['ITEMS'] as $arSectionLvl2):?>
                                <ul class="subcategory">
                                    <li class="subcategory__item" id="<?=$this->GetEditAreaID($arSectionLvl2['ID'])?>">
                                        <a href="<?=$arSectionLvl2['SECTION_PAGE_URL']?>"><?=$arSectionLvl2['NAME']?></a>
                                    </li>
                                    <?if (!empty($arSectionLvl2['ITEMS'])):?>
                                        <?foreach ($arSectionLvl2['ITEMS'] as $arSectionLvl3):?>
                                            <li class="subcategory__item" id="<?=$this->GetEditAreaID($arSectionLvl3['ID'])?>">
                                                <a href="<?=$arSectionLvl3['SECTION_PAGE_URL']?>"><?=$arSectionLvl3['NAME']?></a>
                                            </li>
                                        <?endforeach;?>
                                    <?endif;?>
                                </ul>
                            <?endforeach;?>
                        </div>
                    <?endif;?>
                </div>
            <?endforeach;?>
        </div>
    </div>
<?endif;?>