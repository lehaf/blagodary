<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$obPropRegionValues = \Bitrix\Iblock\PropertyEnumerationTable::getList(array(
    'order' => array('SORT' => 'ASC', 'ID' => 'ASC'),
    'select' => array('*'),
    'filter' => array('PROPERTY_ID' => [REGION_PROP_ID]),
    'cache' => array(
        'ttl' => 360000,
        'cache_joins' => true
    ),
));

while ($arValue = $obPropRegionValues->fetch()) {
    if (REGION_PROP_ID == $arValue['PROPERTY_ID']) {
        $arResult['REGION'][] = $arValue;
    }
}

if (\Bitrix\Main\Loader::includeModule("highloadblock") && defined('HL_PROP_CITY')) {
    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity(HL_PROP_CITY);
    $hlClass = $entity->getDataClass();
    $citiesValues = $hlClass::getList([
        'select' => ['UF_XML_ID','UF_NAME','UF_GROUP'],
        'cache' => [
            'ttl' => 36000000,
            'cache_joins' => true
        ]
    ])->fetchAll();

    foreach ($citiesValues as $city) {
        $arResult['CITY'][$city['UF_XML_ID']] = $city;
    }
}