<?php

if (!empty($arResult['ITEMS'])) {
    $sectionsId = [];
    $newItems = [];
    foreach ($arResult['ITEMS'] as $item) {
        if (!empty($item['IBLOCK_SECTION_ID'])) {
            if (!in_array($item['IBLOCK_SECTION_ID'], $sectionsId)) $sectionsId[] = $item['IBLOCK_SECTION_ID'];
            $newItems[$item['IBLOCK_SECTION_ID']][] = $item;
        }
    }

    $arResult['ITEMS'] = $newItems;
    $arResult['SECTIONS'] = \Bitrix\Iblock\SectionTable::getList(array(
        'order' => ['SORT' => "ASC"],
        'select' => array('ID', 'NAME'),
        'filter' => array('IBLOCK_ID' => FAQ_IBLOCK_ID, "ID" => $sectionsId),
        'cache' => array(
            'ttl' => 360000,
            'cache_joins' => true
        ),
    ))->fetchAll();
    $arResult['ACTIVE_SECTION'] = $arResult['SECTIONS'][0]['ID'];
}
