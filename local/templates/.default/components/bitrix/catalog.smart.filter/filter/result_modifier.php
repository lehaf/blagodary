<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!empty($arResult['ITEMS'])) {
    $propRegionJson = [];
    if (\Bitrix\Main\Loader::includeModule("highloadblock") && defined('HL_PROP_CITY')) {
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity(HL_PROP_CITY);
        $hlClass = $entity->getDataClass();
        $citiesValues = $hlClass::getList([
            'select' => ['UF_XML_ID', 'UF_GROUP', 'UF_NAME'],
            'cache' => [
                'ttl' => 36000000,
                'cache_joins' => true
            ]
        ])->fetchAll();

        foreach ($citiesValues as $city) {
            $propRegionJson[$city['UF_GROUP']][] = $city['UF_NAME'];
        }
    }

    foreach ($arResult['ITEMS'] as $propKey => $prop) {
        if ($prop['CODE'] === 'REGION' && !empty($prop['VALUES']) && !empty($propRegionJson)) {
            foreach ($prop['VALUES'] as $valKey => $val) {
                if (!empty($propRegionJson[$val['URL_ID']])) {
                    $arResult['ITEMS'][$propKey]['VALUES'][$valKey]['CITIES'] = json_encode($propRegionJson[$val['URL_ID']]);
                }
            }
        }
    }
}
