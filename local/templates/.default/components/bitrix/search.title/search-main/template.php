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
$this->setFrameMode(true);?>

<div class="main-search">
    <form id="main-search" action="<?=$arResult["FORM_ACTION"]?>" class="main-search-form">
        <div class="form-group-search">
            <label for="form-search">Поиск по товарам</label>
            <input type="text" placeholder="<?=$arParams["PLACEHOLDER"]?>" name="q"
                   class="form-search-input" id="form-search-main">
        </div>
        <?if (!empty($arResult['REGION'])):?>
            <div class="form-group-search form-group-search--select">
                <label for="selectBanner">Область</label>
                <select name="region" class="custom-select custom-old" id="selectRegion">
                    <option data-dependency="" value="" selected>Вся Беларусь</option>
                    <?foreach ($arResult['REGION'] as $xmlId => $regionName):?>
                        <option data-dependency="<?=$xmlId?>" value="<?=$regionName?>"><?=$regionName?></option>
                    <?endforeach;?>
                </select>
            </div>
        <?endif;?>
        <?if (!empty($arResult['CITY'])):?>
            <div class="form-group-search form-group-search--select-new">
                <label for="selectBannerNew">Город / Район</label>
                <select name="city" class="custom-select new-select"  id="selectCity">
                    <option data-dependency="" value="" selected>Любой</option>
                    <?foreach ($arResult['CITY'] as $key => $city):?>
                        <option data-dependency="<?=$city['UF_GROUP']?>" value="<?=$city['UF_NAME']?>"><?=$city['UF_NAME']?></option>
                    <?endforeach;?>
                </select>
            </div>
        <?endif;?>
        <div class="form-group-search">
            <button class="btn-bg btn--main-search">
                <?=$arParams["BUTTON_NAME"]?>
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#search-white"></use>
                </svg>
            </button>
        </div>
    </form>
</div>