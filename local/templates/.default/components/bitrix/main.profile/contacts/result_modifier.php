<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$propRegionJson = [];
if (\Bitrix\Main\Loader::includeModule("highloadblock") && defined('HL_PROP_CITY')) {
    $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity(HL_PROP_CITY);
    $hlClass = $entity->getDataClass();
    $citiesValues = $hlClass::getList([
        'order' => ['UF_NAME' => 'ASC'],
        'select' => ['UF_NAME','UF_GROUP', 'UF_NAME'],
        'cache' => [
            'ttl' => 36000000,
            'cache_joins' => true
        ]
    ])->fetchAll();

    foreach ($citiesValues as $city) {
        $propRegionJson[$city['UF_GROUP']][] = $city['UF_NAME'];
        $arResult['CITY'][] = $city;
    }
}

$obPropRegionValues = \Bitrix\Iblock\PropertyEnumerationTable::getList(array(
    'order' => array('VALUE' => 'ASC'),
    'select' => array('*'),
    'filter' => array('PROPERTY_ID' => [REGION_PROP_ID]),
    'cache' => array(
        'ttl' => 360000,
        'cache_joins' => true
    ),
));

while ($arValue = $obPropRegionValues->fetch()) {
    if (REGION_PROP_ID == $arValue['PROPERTY_ID']) {
        $arResult['REGION'][$arValue['XML_ID']] = [
            'NAME' => $arValue['VALUE'],
            'CITIES' => json_encode($propRegionJson[$arValue['XML_ID']])
        ];
    }
}
