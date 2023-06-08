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
