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
    <form action="<?=$arResult["FORM_ACTION"]?>" class="main-search-form">
        <div class="form-group-search">
            <label for="form-search">Поиск по товарам</label>
            <input type="text" placeholder="<?=$arParams["PLACEHOLDER"]?>" name="q"
                   class="form-search-input" id="form-search">
        </div>
        <div class="form-group-search form-group-search--select">
            <label for="selectBanner">Область</label>
            <select name="country" class="custom-select custom-old" id="selectBanner">
                <option value="minsk" selected>Минск</option>
                <option value="brest">Минская область</option>
                <option value="grodno">Гродненская область</option>
                <option value="gomel">Гомельская область</option>
                <option value="mogilev">Могилевская область</option>
                <option value="vit">Витебская область</option>
            </select>
        </div>
        <div class="form-group-search form-group-search--select-new">
            <label for="selectBannerNew">Город / Район</label>
            <select name="city" class="custom-select new-select" data-select="new-list"
                    id="selectBannerNew">
            </select>
        </div>
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