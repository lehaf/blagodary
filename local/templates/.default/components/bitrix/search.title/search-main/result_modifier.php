<?php

$obPropRegionValues = \Bitrix\Iblock\PropertyEnumerationTable::getList(array(
    'order' => array('SORT' => 'ASC', 'ID' => 'ASC'),
    'select' => array('*'),
    'filter' => array('PROPERTY_ID' => [REGION_PROP_ID,CITY_PROP_ID]),
    'cache' => array(
        'ttl' => 360000,
        'cache_joins' => true
    ),
));

while ($arValue = $obPropRegionValues->fetch()) {
    if (REGION_PROP_ID == $arValue['PROPERTY_ID']) {
        $arResult['REGION'][] = $arValue['VALUE'];
    }

    if (CITY_PROP_ID == $arValue['PROPERTY_ID']) {
        $arResult['CITY'][] = $arValue['VALUE'];
    }
}
