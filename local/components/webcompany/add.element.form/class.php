<?php

namespace WebCompany;

class AddElementForm extends \CBitrixComponent
{
    private array $arNeedsUserInfo = [
        'ID',
        'NAME',
        'REGION' => 'PERSONAL_STATE',
        'CITY' => 'PERSONAL_CITY'
    ];

    private ?int $curUserId;

    public function __construct($component = \null)
    {
        $this->curUserId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
        parent::__construct($component);
    }

    private function getUserInfo() : ?array
    {
        if (!empty($this->curUserId)) {
            $arUserInfo = \Bitrix\Main\UserTable::getList(array(
                'select' => $this->arNeedsUserInfo,
                'filter' => ['ID' => $this->curUserId],
                'limit' => 1
            ))->fetch();
        }
        return $arUserInfo ?? NULL;
    }

    private function getRegionsAndCitiesProps() : array
    {
        $arResult = [];
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
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
        }
        return $arResult;
    }

    function getSectionsLvlTree() : ?array
    {
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
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
                'filter' => array('IBLOCK_ID' => ADS_IBLOCK_ID, 'ACTIVE'),
                'cache' => array(
                    'ttl' => 360000,
                    'cache_joins' => true
                ),
            ))->fetchAll();

            if (!empty($arSections)) {
                $arSectionsLvl = [];
                foreach ($arSections as &$arSect) {
                    if ($arSect['DEPTH_LEVEL'] == 1 && !empty($arSect['PICTURE'])) $arSect['PICTURE'] = \CFile::GetPath($arSect['PICTURE']);
                    $arSect['SECTION_PAGE_URL'] = \CIBlock::ReplaceDetailUrl($arSect['SECTION_PAGE_URL'], $arSect, false, 'S');
                    if (!empty($arSect['IBLOCK_SECTION_ID'])) {
                        $arSectionsLvl[$arSect['DEPTH_LEVEL']][$arSect['IBLOCK_SECTION_ID']][$arSect['ID']] = $arSect;
                    } else {
                        $arSectionsLvl[$arSect['DEPTH_LEVEL']][$arSect['ID']] = $arSect;
                    }
                }
                unset($arSect);

                return $arSectionsLvl;
            }
        }

        return $arSectionsLvl ?? NULL;
    }

    public function isPostFormData() : bool
    {
        if (!empty($_POST)) return true;
        return false;
    }

    public function prepareResult() : void
    {
        $arResult['USER'] = $this->getUserInfo();
        $arResult['SECTIONS_LVL'] = $this->getSectionsLvlTree();
        $arResult['SELECTS'] = $this->getRegionsAndCitiesProps();
        $this->arResult = $arResult;
    }
    public function executeComponent() : void
    {
        if ($this->isPostFormData()) {
            pr($_FILES);
            pr($_POST);
        }
        $this->prepareResult();
        $this->includeComponentTemplate();
    }
}