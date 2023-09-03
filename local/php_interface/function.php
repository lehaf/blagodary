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

function getUserData($userId, $arSelect = []) : ?array
{
    if (empty($arSelect))
    $arSelect = [
        'ID',
        'NAME',
        'REGION' => 'PERSONAL_STATE',
        'CITY' => 'PERSONAL_CITY',
        'UF_PHONES',
        'UF_SUBSCRIPTION'
    ];
    $arUserInfo = \Bitrix\Main\UserTable::getList(array(
        'select' => $arSelect,
        'filter' => ['ID' => $userId],
        'limit' => 1,
        'cache' => [
            'ttl' => 360000,
            'cache_joins' => true
        ]
    ))->fetch();

    return is_array($arUserInfo) ? $arUserInfo : NULL;
}

function getUserBlockedList() : array
{
    $arUsersBlocked = \Bitrix\Main\UserTable::getList(array(
        'select' => ['ID'],
        'filter' => ['BLOCKED' => 'Y'],
        'cache' => [
            'ttl' => 360000,
            'cache_joins' => true
        ]
    ))->fetch();

    return !empty($arUsersBlocked) ? $arUsersBlocked : [];
}

function getUserRatingData(int $userId) : array
{
    $ttl = 360000;
    $arRating = [];

    if (defined('RATING_IBLOCK_ID') && !empty($userId)) {
        $ratingSectionEntity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(RATING_IBLOCK_ID);
        $userRatingSectionId = $ratingSectionEntity::getList(array(
            "filter" => array("UF_USER_ID" => $userId),
            "select" => array("ID"),
            'cache' => array(
                'ttl' => $ttl,
                'cache_joins' => true
            )
        ))->fetch()['ID'];

        if (!empty($userRatingSectionId)) {
            $className = \Bitrix\Iblock\Iblock::wakeUp(RATING_IBLOCK_ID)->getEntityDataClass();
            $obCollection = $className::getList(array(
                'select' => array('ID', 'USER', 'RATING', 'DATE_CREATE'),
                'filter' => array('IBLOCK_SECTION_ID' => $userRatingSectionId),
                'cache' => array(
                    'ttl' => $ttl,
                    'cache_joins' => true
                )
            ))->fetchCollection();

            $totalRatting = 0;
            $arUsersId = [];
            foreach ($obCollection as $obReview) {
                $uId = $obReview->getUser()->getValue();
                $unixTime = strtotime($obReview->getDateCreate());
                $date = date('d.m.Y',$unixTime);
                $arUsersId[] = $uId;
                $arRating['LIST'][$uId] = [
                    'DATE' => $date,
                    'RATING' => $obReview->getRating()->getValue()
                ];
                $totalRatting += $obReview->getRating()->getValue();
            }

            if (!empty($arRating['LIST']))
                $arRating['REVIEWS_COUNT'] = count($arRating['LIST']);

            if ($totalRatting !== 0) {
                $arRating['TOTAL'] = round($totalRatting / $obCollection->count(),1);
                if (strlen($arRating['TOTAL']) == 1) $arRating['TOTAL'] = $arRating['TOTAL'].'.0';
            }

            $arUsers = \Bitrix\Main\UserTable::getList(array(
                'select' => ['ID', 'NAME'],
                'filter' => ['ID' => $arUsersId],
                'cache' => [
                    'ttl' => $ttl,
                    'cache_joins' => true
                ]
            ))->fetchAll();

            if (!empty($arUsers)) {
                foreach ($arUsers as $arUser) {
                    if (is_array($arRating['LIST'][$arUser['ID']]))
                        $arRating['LIST'][$arUser['ID']]['NAME'] = $arUser['NAME'];
                }
            }
        }
    }

    return $arRating;
}

function getCountUserAds(int $userId) : ?int
{
    if (!empty($userId) && defined('ADS_IBLOCK_ID')) {
        $className = \Bitrix\Iblock\Iblock::wakeUp(ADS_IBLOCK_ID)->getEntityDataClass();
        $count =  $className::getList(array(
            'filter' => array('OWNER.VALUE' => $userId, 'ACTIVE' => 'Y'),
            'cache' => array(
                'ttl' => 360000,
                'cache_joins' => true
            )
        ))->fetchCollection()->count();
    }

    return $count ?? NULL;
}
function formateRegisterDate (string $registerDate) : string
{
    $arMonth = [
        'января',
        'февраля',
        'марта',
        'апреля',
        'майя',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
    ];

    $unixTime = strtotime($registerDate);
    $year = date('Y',$unixTime);
    $month = date('n',$unixTime) - 1;
    return $arMonth[$month].' '.$year;

}

function redirectTo404() : void
{
    \CHTTP::setStatus("404 Not Found");
    LocalRedirect('/404.php');
}


function getCitiesById(array $propId) : array
{
    $propCityVal = [];
    if (\Bitrix\Main\Loader::includeModule("highloadblock") && defined('HL_PROP_CITY')) {
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity(HL_PROP_CITY);
        $HLCity = $entity->getDataClass();

        $elements = $HLCity::getList(array(
            "select" => array("ID", 'UF_NAME'),
            "filter" => array("=ID" => $propId)  // Задаем параметры фильтра выборки
        ))->fetchAll();

        if (!empty($elements)) {
            foreach ($elements as $propVal) {
                $propCityVal[$propVal['ID']] = $propVal['UF_NAME'];
            }
        }
    }
    return $propCityVal;
}