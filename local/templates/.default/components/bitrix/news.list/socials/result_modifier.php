<?php

if (!empty($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as &$item) {
        if (!empty($item['PROPERTIES']['IMG']['VALUE']))
            $item['PROPERTIES']['IMG']['VALUE'] = CFile::GetPath($item['PROPERTIES']['IMG']['VALUE']);
    }
    unset($item);
}
