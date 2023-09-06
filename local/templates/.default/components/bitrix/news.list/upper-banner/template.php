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
$arItem = $arResult['ITEM'];
$this->addExternalJs(SITE_TEMPLATE_PATH.'/html/js/main-search.js');
?>
<?php if (!empty($arItem['DETAIL_TEXT']) && !empty($arItem['DETAIL_PICTURE']['SRC'])):?>
    <?
    // Добавляем эрмитаж
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $arItem["EDIT_LINK_TEXT"]);
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $arItem["DELETE_LINK_TEXT"],
        array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
    );
    ?>
    <main id="<?=$this->GetEditAreaID($arItem['ID'])?>" class="main"
          style="background: url(<?=$arItem['DETAIL_PICTURE']['SRC']?>) no-repeat center/cover">
        <div class="main-wrapper-text"><?=htmlspecialchars_decode($arItem['DETAIL_TEXT'])?></div>
        <?$APPLICATION->IncludeComponent(
            "bitrix:search.title",
            "search-main",
            array(
                "CATEGORY_0" => array(
                    0 => "iblock_products",
                ),
                "CATEGORY_0_TITLE" => "",
                "CHECK_DATES" => "N",
                "NUM_CATEGORIES" => "1",
                "ORDER" => "date",
                "PAGE" => "/ads/search/",
                "SHOW_INPUT" => "Y",
                "SHOW_OTHERS" => "N",
                "TOP_COUNT" => "5",
                "USE_LANGUAGE_GUESS" => "Y",
                "COMPONENT_TEMPLATE" => "search-main",
                "CATEGORY_0_iblock_products" => array(
                    0 => "2",
                ),
                "BUTTON_NAME" => "Найти",
                "PLACEHOLDER" => "Искать товары"
            ),
            false
        );?>
    </main>
<?php endif;?>