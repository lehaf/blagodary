<?php

if (!empty($arResult['SECTIONS'])) {
    $newSections = [];
    $rootSectionId = null;
    $depthLevelSections = [];

    foreach ($arResult['SECTIONS'] as $arSection) {
        // удаляем разделы без элементов
        if ($arSection['ELEMENT_CNT'] == 0) continue;
        // Добавляем эрмитаж
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $arSection["EDIT_LINK_TEXT"]);
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $arSection["DELETE_LINK_TEXT"],
            array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

        $depthLevelSections[$arSection['DEPTH_LEVEL']][$arSection['ID']] = $arSection;


        // Строим новое дерево разделов
        if ($arSection['DEPTH_LEVEL'] == 1) {
            $rootSectionId = $arSection['ID'];
            $arResult['CATEGORIES'][] = [
                'ID' => $arSection['ID'],
                'NAME' => $arSection['NAME'],
                'LINK' => $arSection['SECTION_PAGE_URL'],
                'PICTURE' => $arSection['PICTURE'],
                'EDIT_LINK' => $arSection['EDIT_LINK'],
                'DELETE_LINK' => $arSection['DELETE_LINK'],
            ];
            $newSections[$arSection['ID']] = $arSection;
        }

        if ($arSection['DEPTH_LEVEL'] == 2) {
            $newSections[$rootSectionId]['ITEMS'][$arSection['ID']] = $arSection;
        }

        if ($arSection['DEPTH_LEVEL'] == 3) {
            $newSections[$rootSectionId]['ITEMS'][$arSection['IBLOCK_SECTION_ID']]['ITEMS'][$arSection['ID']] = $arSection;
        }
    }

    if (!empty($depthLevelSections)) {
        krsort($depthLevelSections);
        foreach ($depthLevelSections as $depthLevel => $sections) {
            if (!empty($sections)) {
                foreach ($sections as $sectId => $sect) {
                    if ($depthLevel > 1) {
                        $depthLevelSections[$depthLevel-1][$sect['IBLOCK_SECTION_ID']]['ITEMS'][$sectId] = $depthLevelSections[$depthLevel][$sectId];
                    }
                }
            }
        }
    }

    $arResult['SECTIONS'] = $depthLevelSections[1];
}