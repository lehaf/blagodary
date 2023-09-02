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
<?php if (!empty($arResult['SECTIONS'])):?>
    <div class="question-block">
        <?php foreach ($arResult['SECTIONS'] as $key => $section):?>
            <?php if (!empty($section['ID']) && !empty($section['NAME'])):?>
                    <div class="question-block__item <?=$key === 0 ? 'active' : ''?>"
                         data-question="<?=$section['ID']?>">
                        <?=$section['NAME']?>
                    </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
<?php endif;?>
<?php if (!empty($arResult['ITEMS'])):?>
    <?php foreach ($arResult['ITEMS'] as $sectionId => $questions):?>
        <div class="question-content">
            <div class="question-content__item <?=$arResult['ACTIVE_SECTION'] == $sectionId ? 'active' : ''?>" data-question="<?=$sectionId?>">
                <div class="questions-list">
                    <?php if (!empty($questions)):?>
                        <?php foreach ($questions as $item):?>
                            <?php if (!empty($item['NAME']) && !empty($item['DETAIL_TEXT'])):?>
                                <?php
                                // Добавляем эрмитаж
                                $this->AddEditAction($item['ID'], $item['EDIT_LINK'], $item["EDIT_LINK_TEXT"]);
                                $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], $item["DELETE_LINK_TEXT"],
                                    array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                                ?>
                                <div class="questions-list__item" id="<?=$this->GetEditAreaID($item['ID'])?>">
                                    <div class="questions-item-header"><?=$item['NAME']?></div>
                                    <div class="questions-item-body active">
                                        <div class="questions-item-body-container">
                                            <?=$item['DETAIL_TEXT']?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    <?php endforeach;?>
<?php endif;?>
