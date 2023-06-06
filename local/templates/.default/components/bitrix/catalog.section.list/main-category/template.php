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
        <li class="category-list__item">
            <a href="<?=$arParams['ALL_CATEGORIES_LINK']?>">
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-1"></use>
                </svg>
                Все категории</a>
        </li>
        <?foreach ($arResult['SECTIONS'] as $arSect):?>
            <li class="category-list__item" id="<?=$this->GetEditAreaID($arSect['ID'])?>">
                <a href="<?=$arSect['SECTION_PAGE_URL']?>">
                    <?if (!empty($arSect['PICTURE']['SRC'])):?>
                        <img src="<?=$arSect['PICTURE']['SRC']?>"
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
        <?endforeach;?>
    </ul>
<?endif;?>