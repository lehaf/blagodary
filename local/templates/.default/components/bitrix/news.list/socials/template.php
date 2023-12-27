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
?>
<?php if (!empty($arResult['ITEMS'])):?>
    <ul class="social-media">
        <?php foreach ($arResult['ITEMS'] as $item):?>
            <?php if (!empty($arResult['ITEMS'])):?>
                <?php
                // Добавляем эрмитаж
                $this->AddEditAction($item['ID'], $item['EDIT_LINK'], $item["EDIT_LINK_TEXT"]);
                $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], $item["DELETE_LINK_TEXT"],
                    array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <li class="social-media__item" id="<?=$this->GetEditAreaID($item['ID'])?>">
                    <a href="<?=$item['PROPERTIES']['LINK']['VALUE']?>" target="_blank">
                        <img src="<?=$item['PROPERTIES']['IMG']['VALUE']?>"
                             title="<?=$item['NAME']?>"
                             alt="<?=$item['NAME']?>"
                        >
                    </a>
                </li>
            <?php endif;?>
        <?php endforeach;?>
    </ul>
<?php endif;?>

