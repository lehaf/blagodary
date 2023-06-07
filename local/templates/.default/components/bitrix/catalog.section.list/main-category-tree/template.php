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
?>
<?if (!empty($arResult['SECTIONS'])):?>
    <ul class="category-list">
        <li class="category-list__item active">
            <a href="<?=$arParams['ALL_CATEGORIES_LINK']?>">
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-1"></use>
                </svg>
                Все категории</a>
        </li>
        <?foreach ($arResult['SECTIONS'] as $arSect):?>
            <li class="category-list__item <?=$arSect['SELECTED'] === true ? 'active' : ''?>" id="<?=$this->GetEditAreaID($arSect['ID'])?>">
                <a href="<?=$arSect['SECTION_PAGE_URL']?>">
                    <?if (!empty($arSect['PICTURE'])):?>
                        <img src="<?=$arSect['PICTURE']?>"
                             height="16"
                             width="16"
                             title="<?=$arSect['NAME']?>"
                             alt="<?=$arSect['NAME']?>"
                        >
                    <?else:?>
                        <svg>
                            <use xlink:href="<?=$standardSpriteImgPath?>"></use>
                        </svg>
                    <?endif?>
                    <?=$arSect['NAME']?></a>
            </li>
            <?if (!empty($arSect['ITEMS'])):?>
                <?foreach ($arSect['ITEMS'] as $arSectLvl2):?>
                    <li id="<?=$this->GetEditAreaID($arSectLvl2['ID'])?>"
                        class="category-list__item category-list__item--noImg <?=$arSectLvl2['SELECTED'] === true ? 'active' : ''?>">
                        <a href="<?=$arSectLvl2['SECTION_PAGE_URL']?>"><?=$arSectLvl2['NAME']?></a>
                        <?if (!empty($arSectLvl2['ITEMS'])):?>
                            <ul class="subcategory-list">
                                <?foreach ($arSectLvl2['ITEMS'] as $arSectLvl3):?>
                                    <li id="<?=$this->GetEditAreaID($arSectLvl3['ID'])?>"
                                        class="subcategory-list__item <?=$arSectLvl3['SELECTED'] === true ? 'active' : ''?>">
                                        <a href="<?=$arSectLvl3['SECTION_PAGE_URL']?>"><?=$arSectLvl3['NAME']?></a>
                                    </li>
                                <?endforeach;?>
                            </ul>
                        <?endif;?>
                    </li>
                <?endforeach;?>
            <?endif;?>
        <?endforeach;?>
    </ul>
<?endif;?>