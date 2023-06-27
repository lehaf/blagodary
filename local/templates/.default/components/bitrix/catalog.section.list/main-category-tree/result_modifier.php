<?php
if (!empty($arResult['SECTIONS']) && !empty($arParams['ROOT_SECTION']) && !empty($arParams['ACTIVE_SECTION_ID'])) {
    array_unshift($arResult['SECTIONS'],$arParams['ROOT_SECTION']);
    $rootSectionId = null;
    $newSections = [];
    foreach ($arResult['SECTIONS'] as $key => &$arSection) {
        // удаляем разделы без элементов
        if ($arSection['ELEMENT_CNT'] == 0 && $arSection['DEPTH_LEVEL'] != 1) continue;

        if ($arSection['ID'] === $arParams['ACTIVE_SECTION_ID']) $arSection['SELECTED'] = true;

        if (!empty($arSection['PICTURE']) && !is_array($arSection['PICTURE'])) {
            $arSection['PICTURE'] = CFile::GetPath($arSection['PICTURE']);
        }

        if ($arSection['DEPTH_LEVEL'] == 1) {
            $rootSectionId = $arSection['ID'];
            $newSections[$arSection['ID']] = $arSection;
        }

        if ($arSection['DEPTH_LEVEL'] == 2) {
            $newSections[$rootSectionId]['ITEMS'][$arSection['ID']] = $arSection;
        }

        if ($arSection['DEPTH_LEVEL'] == 3) {
            $newSections[$rootSectionId]['ITEMS'][$arSection['IBLOCK_SECTION_ID']]['ITEMS'][$arSection['ID']] = $arSection;
        }

        // Добавляем эрмитаж
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $arSection["EDIT_LINK_TEXT"]);
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $arSection["DELETE_LINK_TEXT"],
            array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
        );
    }
    unset($arSection);
    $arResult['SECTIONS'] = $newSections;
}
