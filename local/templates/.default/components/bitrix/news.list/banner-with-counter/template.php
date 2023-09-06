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
$arItem = $arResult['ITEMS'][0];
?>
<?php if (!empty($arItem['DETAIL_TEXT']) && !empty($arItem['DETAIL_PICTURE']['SRC']) && !empty($arItem['PROPERTIES']['COUNTER'])):?>
    <style>
        /* Десктоп */
        @media (min-width: 700px) {
            .banner-mini {
                background: url(<?=$arItem['DETAIL_PICTURE']['SRC']?>) no-repeat center/cover;
            }
        }
        /* Мобилка */
        @media (max-width: 700px) {
            background: url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>) no-repeat center/cover;
        }
    </style>
    <?
    // Добавляем эрмитаж
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $arItem["EDIT_LINK_TEXT"]);
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $arItem["DELETE_LINK_TEXT"],
        array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div id="<?=$this->GetEditAreaID($arItem['ID'])?>"
         class="banner-mini"
    >
        <div class="banner-mini-title">
            <?=$arItem['DETAIL_TEXT']?>
        </div>
        <div class="banner-mini-cnt">
            <?=$arItem['PROPERTIES']['COUNTER']['VALUE']?>
            <span><?=$arItem['PROPERTIES']['COUNTER']['SKLONEN']?></span>
        </div>
    </div>
<?php endif;?>