<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!empty($arResult['ITEMS'])) {
    $propCitiesGroups = [];
    if (\Bitrix\Main\Loader::includeModule("highloadblock") && defined('HL_PROP_CITY')) {
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity(HL_PROP_CITY);
        $hlClass = $entity->getDataClass();
        $citiesValues = $hlClass::getList([
            'select' => ['UF_XML_ID', 'UF_GROUP'],
            'cache' => [
                'ttl' => 36000000,
                'cache_joins' => true
            ]
        ])->fetchAll();

        foreach ($citiesValues as $city) {
            $propCitiesGroups[$city['UF_XML_ID']] = $city['UF_GROUP'];
        }
    }

    $cityPropXml = [];
    foreach ($arResult['ITEMS'] as $propKey => $prop) {
        if ($prop['CODE'] === 'CITY' && !empty($prop['VALUES']) && !empty($propCitiesGroups)) {
            foreach ($prop['VALUES'] as $valKey => $val) {
                if (!empty($propCitiesGroups[$val['URL_ID']])) {
                    $arResult['ITEMS'][$propKey]['VALUES'][$valKey]['CITY_GROUP'] = $propCitiesGroups[$val['URL_ID']];
                }
            }
        }
    }
}
