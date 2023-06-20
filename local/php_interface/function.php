<?php

use \Bitrix\Main\Data\Cache;
/** @global object $APPLICATION */

function pr($o, $show = false, $die = false, $fullBackTrace = false)
{
    global $USER;
//    if ($USER->IsAdmin() && $USER -> GetId() == 1100 || $show) {
    if ($USER->IsAdmin() || $show) {
        $bt = debug_backtrace();

        $firstBt = $bt[0];
        $dRoot = $_SERVER["DOCUMENT_ROOT"];
        $dRoot = str_replace("/", "\\", $dRoot);
        $firstBt["file"] = str_replace($dRoot, "", $firstBt["file"]);
        $dRoot = str_replace("\\", "/", $dRoot);
        $firstBt["file"] = str_replace($dRoot, "", $firstBt["file"]);
        ?>
        <div style='font-size:9pt; color:#000; background:#fff; border:1px dashed #000;'>
            <div style='padding:3px 5px; background:#99CCFF;'>

                <? if ($fullBackTrace == false): ?>
                    File: <b><?= $firstBt["file"] ?></b> [line: <?= $firstBt["line"] ?>]
                <? else: ?>
                    <? foreach ($bt as $value): ?>
                        <?
                        $dRoot = str_replace("/", "\\", $dRoot);
                        $value["file"] = str_replace($dRoot, "", $value["file"]);
                        $dRoot = str_replace("\\", "/", $dRoot);
                        $value["file"] = str_replace($dRoot, "", $value["file"]);
//                        echo '<pre>';
//                        print_r($value);
//                        echo '</pre>';
                        ?>

                        File: <b><?= $value["file"] ?></b> [line: <?= $value["line"] ?>] <?= $value['class'] . '->'.$value['function'].'()'?><br>
                    <? endforeach ?>
                <?endif; ?>
            </div>
            <pre style='padding:10px;'><? is_array($o) ? print_r($o) :  print_r(htmlspecialcharsbx($o)) ?></pre>
        </div>
        <?if ($die == true) {
            die();
        }?>
        <?
    } else {
        return false;
    }
}

function getSectionTree(int $sectionId) : ?array
{
    $cache = Cache::createInstance();
    if ($cache->initCache(360000, "section_tree_".$sectionId)) {
        $arSectionTree = $cache->getVars();
    } elseif ($cache->startDataCache()) {
        $arSectionTree = CIBlockSection::GetNavChain(false,$sectionId, array(), true);
        if (!empty($arSectionTree)) {
            foreach ($arSectionTree as &$arSection) {
                $arSection['SECTION_PAGE_URL'] = CIBlock::ReplaceDetailUrl($arSection['SECTION_PAGE_URL'], $arSection, true, 'S');
            }
            unset($arSection);
        }
        $cache->endDataCache($arSectionTree);
    }

    return $arSectionTree ?? NULL;
}

function getSectionData(int $sectionId, int $iblockId) : ?array
{
    $cache = \Bitrix\Main\Application::getInstance()->getManagedCache();
    $cacheId = "section_tree_".$sectionId;
    if ($cache->read(360000, $cacheId)) {
        $arSection = $cache->get($cacheId);
    } else {
        $sectionEntity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($iblockId);
        if (!empty($sectionEntity)) {
            $arSection = $sectionEntity::getList(array(
                "filter" => array("ID" => $sectionId, "ACTIVE" => "Y",),
                "select" => ["*", 'SECTION_PAGE_URL' => 'IBLOCK.SECTION_PAGE_URL', "UF_*"]
            ))->fetch();
            $arSection['SECTION_PAGE_URL'] = CIBlock::ReplaceDetailUrl($arSection['SECTION_PAGE_URL'], $arSection, true, 'S');
            // Добавляем ссылки для эрмитажа
            $arButtons = CIBlock::GetPanelButtons(
                $iblockId,
                $sectionId,
                0,
                array("SECTION_BUTTONS"=>false, "SESSID"=>false)
            );

            $arSection["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
            $arSection["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

            $arSection["EDIT_LINK_TEXT"] = $arButtons["edit"]["edit_element"]["TEXT"];
            $arSection["DELETE_LINK_TEXT"] = $arButtons["edit"]["delete_element"]["TEXT"];

            $cache->set($cacheId,$arSection);
        }
    }

    return $arSection ?? NULL;
}


function setBreadcrumb(array $arSectionTree) : void
{
    global $APPLICATION;
    if (!empty($arSectionTree)) {
        foreach ($arSectionTree as $arSection) {
            $APPLICATION->AddChainItem($arSection['NAME'], $arSection['SECTION_PAGE_URL']);
        }
    }
}

function sklonen(int $number, array $arVariants) : string
{
    $number = str_replace(' ','',$number);
    $cases = [ 2, 0, 1, 1, 1, 2 ];

    $intNum = abs( (int) strip_tags( $number ) );

    $titleIndex = ( $intNum % 100 > 4 && $intNum % 100 < 20 )
        ? 2
        : $cases[ min( $intNum % 10, 5 ) ];

    return $arVariants[$titleIndex];
}

function getSectionsTree($iblockId, $ttl = 360000, $cacheId = 'sections_tree') : ?array
{
    $cache = \Bitrix\Main\Application::getInstance()->getManagedCache();

    if ($cache->read($ttl,$cacheId)) {
        $sectionTree = $cache->get($cacheId); // достаем переменные из кеша
    } else {
        if (\Bitrix\Main\Loader::includeModule('iblock') && !empty($iblockId)) {
            $arSections = \Bitrix\Iblock\SectionTable::getList(array(
                'select' => array(
                    'ID',
                    'NAME',
                    'CODE',
                    'DEPTH_LEVEL',
                    'IBLOCK_SECTION_ID',
                    'PICTURE',
                    'SECTION_PAGE_URL' => 'IBLOCK.SECTION_PAGE_URL'
                ),
                'filter' => array('IBLOCK_ID' => $iblockId, 'ACTIVE'),
                'cache' => array(
                    'ttl' => $ttl,
                    'cache_joins' => true
                ),
            ))->fetchAll();

            if (!empty($arSections)) {
                $arSectionsLvl = [];
                foreach ($arSections as &$arSect) {
                    if ($arSect['DEPTH_LEVEL'] == 1 && !empty($arSect['PICTURE'])) $arSect['PICTURE'] = CFile::GetPath($arSect['PICTURE']);
                    $arSect['SECTION_PAGE_URL'] = CIBlock::ReplaceDetailUrl($arSect['SECTION_PAGE_URL'], $arSect, false, 'S');
                    $arSectionsLvl[$arSect['DEPTH_LEVEL']][$arSect['ID']] = $arSect;
                }
                unset($arSect);

                $arSectionsLvlReverse = array_reverse($arSectionsLvl, true);

                foreach ($arSectionsLvlReverse as $sectLvl => $arSections) {
                    foreach ($arSections as $sectId => $arSect) {
                        if ($sectLvl != 1) {
                            $arSectionsLvlReverse[$sectLvl-1][$arSect['IBLOCK_SECTION_ID']]['ITEMS'][$sectId] = $arSectionsLvlReverse[$sectLvl][$sectId];
                        }
                    }
                }

                $cache->set($cacheId, $arSectionsLvlReverse[1]);

                return $arSectionsLvlReverse[1];
            }
        }
    }
    return $sectionTree ?? NULL;
}

function getSectionsLvlTree($iblockId, $ttl = 360000, $cacheId = 'sections_lvl') : ?array
{
    $cache = \Bitrix\Main\Application::getInstance()->getManagedCache();

    if ($cache->read($ttl,$cacheId)) {
        $arSectionsLvl = $cache->get($cacheId); // достаем переменные из кеша
    } else {
        if (\Bitrix\Main\Loader::includeModule('iblock') && !empty($iblockId)) {
            $arSections = \Bitrix\Iblock\SectionTable::getList(array(
                'select' => array(
                    'ID',
                    'NAME',
                    'CODE',
                    'DEPTH_LEVEL',
                    'IBLOCK_SECTION_ID',
                    'PICTURE',
                    'SECTION_PAGE_URL' => 'IBLOCK.SECTION_PAGE_URL'
                ),
                'filter' => array('IBLOCK_ID' => $iblockId, 'ACTIVE'),
                'cache' => array(
                    'ttl' => $ttl,
                    'cache_joins' => true
                ),
            ))->fetchAll();

            if (!empty($arSections)) {
                $arSectionsLvl = [];
                foreach ($arSections as &$arSect) {
                    if ($arSect['DEPTH_LEVEL'] == 1 && !empty($arSect['PICTURE'])) $arSect['PICTURE'] = CFile::GetPath($arSect['PICTURE']);
                    $arSect['SECTION_PAGE_URL'] = CIBlock::ReplaceDetailUrl($arSect['SECTION_PAGE_URL'], $arSect, false, 'S');
                    if (!empty($arSect['IBLOCK_SECTION_ID'])) {
                        $arSectionsLvl[$arSect['DEPTH_LEVEL']][$arSect['IBLOCK_SECTION_ID']][$arSect['ID']] = $arSect;
                    } else {
                        $arSectionsLvl[$arSect['DEPTH_LEVEL']][$arSect['ID']] = $arSect;
                    }
                }
                unset($arSect);

                $cache->set($cacheId, $arSectionsLvl);

                return $arSectionsLvl;
            }
        }
    }
    return $arSectionsLvl ?? NULL;
}
