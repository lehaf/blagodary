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
<?if (!empty($arResult['SECTIONS'])):?>
<?php $firstSectionKey = array_key_first($arResult['SECTIONS'])?>
    <ul>
        <li class="category-list__item active">
            <a href="javascript:return false">
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-1"></use>
                </svg>
                Все категории
            </a>
        </li>
        <?foreach ($arResult['SECTIONS'] as $key => $arSection):?>
            <li class="category-list__item">
                <a href="<?=$arSection['SECTION_PAGE_URL']?>" class="parent">
                    <?if (!empty($arSection['PICTURE']['SRC'])):?>
                        <img src="<?=$arSection['PICTURE']['SRC']?>"
                             height="16"
                             width="16"
                             title="<?=$arSection['NAME']?>"
                             alt="<?=$arSection['NAME']?>"
                        >
                    <?else:?>
                        <svg>
                            <use xlink:href="<?=$standardSpriteImgPath?>"></use>
                        </svg>
                    <?endif?>
                    <?=$arSection['NAME']?>
                </a>
                <?if (!empty($arSection['ITEMS'])):?>
                    <ul>
                        <li>
                            <a href="#" class="back">Назад
                                <span class="popUp-cross mobile_menu__cross">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
                                    </svg>
                                </span>
                            </a>
                        </li>
                        <li class="category-list__item-active">
                            <a href="<?=$arSection['SECTION_PAGE_URL']?>">Все объявления категории</a>
                        </li>
                        <?foreach ($arSection['ITEMS'] as $keyLvl2 => $arSectionLvl2):?>
                            <li>
                                <?if (!empty($arSectionLvl2['ITEMS'])):?>
                                    <div class="menu-subcategory"><?=$arSectionLvl2['NAME']?></div>
                                    <div class="menu-subcategory-content">
                                        <?foreach ($arSectionLvl2['ITEMS'] as $keyLvl3 => $arSectionLvl3):?>
                                            <a href="<?=$arSectionLvl3['SECTION_PAGE_URL']?>"><?=$arSectionLvl3['NAME']?></a>
                                        <?endforeach;?>
                                    </div>
                                <?else:?>
                                    <a href="<?=$arSectionLvl2['SECTION_PAGE_URL']?>"><?=$arSectionLvl2['NAME']?></a>
                                <?endif;?>
                            </li>
                        <?endforeach;?>
                    </ul>
                <?endif;?>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>