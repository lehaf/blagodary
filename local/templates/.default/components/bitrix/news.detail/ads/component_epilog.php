<?php

if (!empty($arResult['IBLOCK_SECTION_ID'])) {
    $GLOBALS['SECTION_ID'] = $arResult['IBLOCK_SECTION_ID'];
}

if (!empty($arResult['OWNER']['ID'])) {
    $GLOBALS['OWNER_ID'] = $arResult['OWNER']['ID'];
}