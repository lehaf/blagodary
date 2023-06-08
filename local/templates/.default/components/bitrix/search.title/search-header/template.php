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

<div class="header-search" style="position:absolute; left: 377.5px">
    <form id="header-search" action="<?=$arResult["FORM_ACTION"]?>"></form>
    <label for="header-search">
        <input form="header-search"
               class="header-search__el"
               type="text"
               name="q"
               placeholder="<?=$arParams["PLACEHOLDER"]?>"
        >
    </label>
    <button form="header-search" type="submit" class="btn-bg btn-search"><?=$arParams["BUTTON_NAME"]?></button>
</div>


