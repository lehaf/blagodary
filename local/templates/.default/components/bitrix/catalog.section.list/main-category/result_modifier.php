<?php
if (!empty($arResult['SECTIONS'])) {
    foreach ($arResult['SECTIONS'] as $key => $arSection) {
        // удаляем разделы без элементов
        if ($arSection['ELEMENT_CNT'] == 0) unset($arResult['SECTIONS'][$key]);

        // Добавляем эрмитаж
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $arSection["EDIT_LINK_TEXT"]);
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $arSection["DELETE_LINK_TEXT"],
            array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    }
}