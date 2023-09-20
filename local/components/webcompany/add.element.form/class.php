<?php

namespace WebCompany;

use Bitrix\Main\Loader;
use Bitrix\Iblock\ORM\PropertyValue;
use \Bitrix\Main\Data\Cache;

class AddElementForm extends \CBitrixComponent
{
    private string $editPageTitle = 'Редактировать объявление';
    private string $errorLogTitle = 'Ошибка создания объявления!';
    private string $errorLogDesc = "В компоненте webcompany:add.element.form при создании нового объявления возникли следующие ошибки:";
    private string $successRedirectPath = '/personal/my-ads/';
    private array $arNeedsUserInfo = ['ID', 'NAME', 'REGION' => 'PERSONAL_STATE', 'CITY' => 'PERSONAL_CITY', 'UF_PHONES'];
    private array $arPostValidFields = [
        'NAME' => 'Название товара',
        'IBLOCK_SECTION_ID' => 'Выбор категории',
        'DETAIL_TEXT' => 'Описание',
        'REGION' => 'Область',
        'IMAGES' => 'Фотографии',
        'CITY' => 'Город / Район',
        'OWNER_NAME' => 'Имя',
        'OWNER_PHONE' => 'Контактный телефон'
    ];
    private array $arItemSelect = [
        'ID',
        'NAME',
        'IBLOCK_SECTION_ID',
        'DETAIL_TEXT',
        'REGION',
        'CITY',
        'IMAGES.FILE',
        'IMAGES',
        'OWNER_NAME',
        'OWNER_PHONE'
    ];
    private array $arMultipleFields = ['OWNER_PHONE','IMAGES'];
    private string $propOwnerCode = 'OWNER';
    private string $fieldOwnerPhoneName = 'OWNER_PHONE';
    private string $fieldOwnerPhonePattern = '/(?:\+375|80)\s?\(?\d\d\)?\s?\d\d(?:\d[\-\s]\d\d[\-\s]\d\d|[\-\s]\d\d[\-\s]\d\d\d|\d{5})/';
    private string $fieldDescriptionName = 'DETAIL_TEXT';
    private int $maxDescriptionLen = 4000;
    private array $arValidImgFormat = ['png', 'jpg', 'jpeg'];
    private string $postImagesArrayName = 'IMAGES';
    private int $maxImgSizeBytes = 10485760; // 10 MB
    private int $maxCountUploadImg = 10;
    private array $arErrors = [];
    private ?int $curUserId;
    private ?array $arFieldsForRecord;
    private ?array $arImgForRecord;


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
                'filter' => array('PROPERTY_ID' => [REGION_PROP_ID]),
                'cache' => array(
                    'ttl' => 360000,
                    'cache_joins' => true
                ),
            ));

            while ($arValue = $obPropRegionValues->fetch()) {
                if (REGION_PROP_ID == $arValue['PROPERTY_ID']) {
                    $arResult['REGION'][$arValue['ID']] = $arValue;
                }
            }

            if (\Bitrix\Main\Loader::includeModule("highloadblock") && defined('HL_PROP_CITY')) {
                $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity(HL_PROP_CITY);
                $hlClass = $entity->getDataClass();
                $citiesValues = $hlClass::getList([
                    'select' => ['UF_XML_ID','UF_NAME','UF_GROUP'],
                    'cache' => [
                        'ttl' => 36000000,
                        'cache_joins' => true
                    ]
                ])->fetchAll();

                foreach ($citiesValues as $city) {
                    $arResult['CITY'][$city['UF_XML_ID']] = $city;
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

    public function editSomeFields(&$arFields) : void
    {
        if (!empty($this->curUserId)) {
            $arFields[$this->propOwnerCode] = $this->curUserId;
        }

        if (!empty($this->arResult['SELECTS']['REGION'])) {
            $regionValueId = array_search($arFields['REGION'],$this->arResult['SELECTS']['REGION']);
            if ($regionValueId) $arFields['REGION'] = $regionValueId;
        }

        if (!empty($this->arResult['SELECTS']['CITY'])) {
            $cityValueId = array_search($arFields['CITY'],$this->arResult['SELECTS']['CITY']);
            if ($cityValueId) $arFields['CITY'] = $cityValueId;
        }

        $arFields['CODE'] = $this->createSymbolCode($arFields['NAME']);
    }

    private function checkPostArrayFields(string $fieldName, array$arFieldValue) : array
    {
//        if (!empty($arFieldValue)) {
//            foreach ($arFieldValue as &$value) {
//                $value = htmlspecialchars(trim($value));
//                if ($fieldName === $this->fieldOwnerPhoneName && !preg_match($this->fieldOwnerPhonePattern,$value)) {
//                    $this->arErrors[$fieldName][] = "Поле '".$this->arPostValidFields[$fieldName]."' заполнено некорректно!";
//                    break;
//                }
//            }
//            unset($value);
//        }
        return $arFieldValue;
    }

    private function checkPostFields() : bool
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $arCheckedFields = [];
            foreach ($_POST as $propName => $propValue) {
                if (key_exists($propName, $this->arPostValidFields)) {

                    $fieldValue = is_array($propValue) ? $this->checkPostArrayFields($propName,$propValue) : htmlspecialchars(trim($propValue));
                    // Проверяем, что все поля заполнены
                    if (empty($fieldValue)) {
                        $this->arErrors[$propName][] = "Поле '".$this->arPostValidFields[$propName]."' обязательно для заполнения!";
                        continue;
                    }

                    // Проверяем, что длина Описания не превышена
                    if ($propName === $this->fieldDescriptionName && strlen($fieldValue) > $this->maxDescriptionLen) {
                        $this->arErrors[$propName][] = "Длина поля $propName не должна превышать $this->maxDescriptionLen символов.";
                        continue;
                    }

                    $arCheckedFields[$propName] = $fieldValue;
                }
            }

            if (empty($this->arErrors)) {
                $this->editSomeFields($arCheckedFields);
                $this->arFieldsForRecord = $arCheckedFields;
                return true;
            }

        } else {
            $this->arErrors[] = "Ошибка! Данные не были отправлены.";
        }
        return false;
    }

    private function checkPostImages() : bool
    {
        if(isset($_FILES[$this->postImagesArrayName])) {
            $arImages = $_FILES[$this->postImagesArrayName];
            $arImagesData = [];
            $countFiles = 0;
            for($i = 0; $i < count($arImages['name']); $i++) {
                // Проверяем на пустоту
//                if (empty($arImages['name'][$i])) {
//                    $this->arErrors[$this->postImagesArrayName][] = "Поле '".$this->arPostValidFields[$this->postImagesArrayName]."' обязательно для заполнения!";
//                    continue;
//                }

                $type = pathinfo($arImages['name'][$i], PATHINFO_EXTENSION); // Получаем тип файла
                 // Проверяем, является ли файл изображением исключительно типов PNG, JPG, JPEG
                if (!empty($type) && !in_array($type, $this->arValidImgFormat)) {
                    $this->arErrors[$this->postImagesArrayName][] = "Файл ".$arImages['name'][$i]." не является изображением одним из следующих типов: ".implode(', ',$this->arValidImgFormat).'.';
                    continue;
                }
                $fileSize = $arImages['size'][$i]; // Получаем размер файла в байтах
                if($fileSize > $this->maxImgSizeBytes) {
                    $this->arErrors[$this->postImagesArrayName][] = "Файл ".$arImages['name'][$i]." превышает максимальный размер 10 МБ.";
                    continue;
                }

                $countFiles++; // Увеличиваем счетчик загруженных файлов
                if($countFiles > $this->maxCountUploadImg) {
                    $this->arErrors[$this->postImagesArrayName][] = "Ошибка! Превышено максимальное число загружаемых изображений (".$this->maxCountUploadImg.").";
                    break;
                }

                $arImagesData[] = [
                    'name' => $arImages['name'][$i],
                    'type' => $arImages['type'][$i],
                    'tmp_name' => $arImages['tmp_name'][$i],
                    'size' => $arImages['size'][$i]
                ];
            }

            if (empty($this->arErrors)) {
                $this->arImgForRecord[$this->postImagesArrayName] = $arImagesData;
                return true;
            }

        } else {
            $this->arErrors[$this->postImagesArrayName][] = "Ошибка! Изображения не были загружены.";
        }

        return false;
    }

    private function createSymbolCode($string) : string
    {
        $string = mb_strtolower($string);
        $code_match = array("'", '"', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}',
            '|', ':', '"', '<', '>', '?', '[', ']', ';', "'", ',', '.', '/', '', '~', '`', '=',"«","»");
        $string = str_replace($code_match, '', $string);
        $arString = explode(' ',$string);
        $string = implode('-',$arString);
        $converter = array(
            'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
            'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
            'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
            'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
            'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
            'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
            'э' => 'e',    'ю' => 'yu',   'я' => 'ya',

            'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
            'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
            'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
            'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
            'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
            'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
            'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
        );

        return strtr($string, $converter);
    }

    private function processErrors(array $arErrorsMessages) : void
    {
        if (!empty($arErrorsMessages)) {
            \CEventLog::Add(array(
                "SEVERITY" => "SECURITY",
                "AUDIT_TYPE_ID" => $this->errorLogTitle,
                "MODULE_ID" => $this->__name,
                "ITEM_ID" => NULL,
                "DESCRIPTION" => $this->errorLogDesc." ".implode('<br>',$arErrorsMessages)
            ));
        }
    }

    private function createNewUserAds() : void
    {
        if (Loader::includeModule("iblock") && defined('ADS_IBLOCK_ID') && !empty($this->arFieldsForRecord)) {
            $iblockClassName = \Bitrix\Iblock\Iblock::wakeUp(ADS_IBLOCK_ID)->getEntityDataClass();
            $obNewElement = $iblockClassName::createObject();
            $obNewElement->setId($obNewElement->sysGetPrimaryAsString());

            foreach ($this->arFieldsForRecord as $propName => $propValue) {
                if (!in_array($propName, $this->arMultipleFields)) {
                    if ($propName === 'CITY') {
                        $obNewElement->set($propName,$propValue);
                    } elseif ($propName === 'REGION') {
                        $obNewElement->setRegion($propValue);
                    } else {
                        $obNewElement->set($propName,$propValue);
                    }
                } else {
                    foreach ($propValue as $value) {
                        $obNewElement->addTo($propName, $value);
                    }
                }
            }


            foreach ($this->arImgForRecord[$this->postImagesArrayName] as $arImage) {
                $arImage['MODULE_ID'] = 'iblock';
                $fileId = \CFile::SaveFile($arImage,'iblock');
                $obNewElement->addTo($this->postImagesArrayName, new PropertyValue($fileId));
            }

            $obRes = $obNewElement->save();

            if ($obRes->isSuccess()) {
                $newAdsId = $obRes->getId();
                if (!empty($newAdsId)) {
                    $arLoadProductArray = Array(
                        "IBLOCK_SECTION_ID" => $this->arFieldsForRecord['IBLOCK_SECTION_ID']
                    );
                    $el = new \CIBlockElement;
                    $el->Update($newAdsId, $arLoadProductArray);
                }
                LocalRedirect($this->successRedirectPath);
            } else {
                $this->processErrors($obRes->getErrorMessages());
            }
        }
    }

    private function updateUserAds(int $adsId) : void
    {
        if (Loader::includeModule("iblock") && defined('ADS_IBLOCK_ID') && !empty($this->arFieldsForRecord)) {
            $iblockClassName = \Bitrix\Iblock\Iblock::wakeUp(ADS_IBLOCK_ID)->getEntityDataClass();
            $obNewElement = $iblockClassName::getByPrimary($adsId, [
                'select' => $this->arItemSelect
            ])->fetchObject();
            foreach ($this->arFieldsForRecord as $propName => $propValue) {
                if (!in_array($propName, $this->arMultipleFields)) {
                    if ($obNewElement->get($propName) != $propValue) {
                        $obNewElement->set($propName,$propValue);
                    }
                } else {
                    $obNewElement->removeAll($propName);
                    foreach ($propValue as $value) {
                        $obNewElement->addTo($propName, $value);
                    }
                }
            }

            $arAllImg = $obNewElement->get($this->postImagesArrayName)->getAll();
            $arCurImg = [];
            foreach ($arAllImg as $obImg) {
                $arCurImg[] = $obImg->getFile()->getFileName();
            }
            $arNewImg = [];
            foreach ($this->arImgForRecord[$this->postImagesArrayName] as $arImg) {
                $arNewImg[] = $arImg['name'];
            }
            $arImgNotDelete = array_intersect($arNewImg, $arCurImg);
            foreach ($arAllImg as $obImg) {
                if (!in_array($obImg->getFile()->getFileName(),$arImgNotDelete)) {
                    $obNewElement->removeFrom($this->postImagesArrayName,$obImg->getFile()->getId());
                    \CFile::Delete($obImg->getFile()->getId());
                }
            }

            foreach ($this->arImgForRecord[$this->postImagesArrayName] as $arImage) {
                if (!in_array($arImage['name'],$arImgNotDelete)) {
                    $arImage['MODULE_ID'] = 'iblock';
                    $fileId = \CFile::SaveFile($arImage,'iblock');
                    $obNewElement->addTo($this->postImagesArrayName, new PropertyValue($fileId));
                }
            }

            $obRes = $obNewElement->save();

            if ($obRes->isSuccess()) {
                LocalRedirect($this->successRedirectPath);
            } else {
                $this->processErrors($obRes->getErrorMessages());
            }
        }
    }

    private function getSectionTreePath(int $sectionId) : ?array
    {
        $cache = Cache::createInstance();
        if ($cache->initCache(360000, "ads_section_tree_".$sectionId)) {
            $arCacheRes = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            $arSectionTree = \CIBlockSection::GetNavChain(ADS_IBLOCK_ID, $sectionId, array('ID','NAME','DEPTH_LEVEL'), true);
            $arCacheRes = [];

            foreach ($arSectionTree as $arSect) {
                $arCacheRes['PATH_NAME'][] = $arSect['NAME'];
                $arCacheRes['TREE'][$arSect['DEPTH_LEVEL']] = $arSect['ID'];
            }

            if (!empty($arCacheRes['PATH_NAME'])) {
                $arCacheRes['PATH_NAME'] = implode(' / ',$arCacheRes['PATH_NAME']);
            }
            $cache->endDataCache($arCacheRes);
        }

        return $arCacheRes ?? NULL;
    }

    private function getEditItem(int $itemId) : array
    {
        if (Loader::includeModule("iblock") && defined('ADS_IBLOCK_ID')) {
            $iblockClassName = \Bitrix\Iblock\Iblock::wakeUp(ADS_IBLOCK_ID)->getEntityDataClass();
            $obElement = $iblockClassName::getByPrimary($itemId, [
                'select' => $this->arItemSelect,
                'filter' => ['OWNER.VALUE' => $this->curUserId]
            ])->fetchObject();

            if (!empty($obElement)) {
                $arItem = [
                    'ID' => $obElement->getId(),
                    'NAME' => $obElement->getName(),
                    'IBLOCK_SECTION_ID' => $obElement->getIblockSectionId(),
                    'DETAIL_TEXT' => $obElement->getDetailText(),
                    'REGION' => $obElement->getRegion()->getValue(),
                    'CITY' => $obElement->getCity()->getValue(),
                    'OWNER_NAME' => $obElement->getOwnerName()->getValue(),
                ];

                if ($arAllPhones = $obElement->getOwnerPhone()->getAll()) {
                    foreach ($arAllPhones as $obPhone) {
                        $arItem['OWNER_PHONE'][] = $obPhone->getValue();
                    }
                }

                if ($arAllImages = $obElement->getImages()->getAll()) {
                    $arImgJson = [];
                    foreach ($arAllImages as $obImg) {
                        if ($obImg->getFile()) {
                            $imgPath = '/upload/' . $obImg->getFile()->getSubdir().'/'.$obImg->getFile()->getFileName();
                        }
                        $arItem['IMAGES'][] = [
                            'NAME' => $obImg->getFile()->getFileName(),
                            'SRC' => $imgPath
                        ];
                        $arImgJson[] = $imgPath;
                    }
                    $arItem['IMAGES_JSON'] = json_encode($arImgJson);
                }

                $arItem['SECTIONS'] = $this->getSectionTreePath($obElement->getIblockSectionId());

                return $arItem;
            }
        }
        return [];
    }

    private function getAdditionalElementSettingsForEdit(int $itemId, int $sectionId, array &$arResult): void
    {
        $propertiesForAllSections = \CIBlockSectionPropertyLink::GetArray(ADS_IBLOCK_ID, 0);
        $propertiesForCurSection = \CIBlockSectionPropertyLink::GetArray(ADS_IBLOCK_ID, $sectionId);
        $specialProps = [];
        $specialPropsId = [];
        foreach ($propertiesForCurSection as $propId => $prop) {
            if (!array_key_exists($propId,$propertiesForAllSections)) {
                $specialPropsId[] = $propId;
                $specialProps[$propId] = $prop;
            }
        }

        $propsInfo = \Bitrix\Iblock\PropertyTable::getList(array(
            'select' => array('ID','NAME','CODE','PROPERTY_TYPE','MULTIPLE'),
            'filter' => array('IBLOCK_ID' => ADS_IBLOCK_ID, 'ID' => $specialPropsId)
        ))->fetchAll();
        $additionalProps["LIST"] = [];
        $additionalProps["SIMPLE"] = [];
        $propCodes = [];
        foreach ($propsInfo as $prop) {
            $propCodes[] = $prop['CODE'];
            if ($prop['PROPERTY_TYPE'] === 'L') {
                $enumValues = \Bitrix\Iblock\PropertyEnumerationTable::getList(array(
                    'select' => array('ID', 'XML_ID', 'VALUE'),
                    'filter' => array('PROPERTY_ID' => $prop['ID'])
                ))->fetchAll();
                $prop['VALUES'] = $enumValues;
                $additionalProps["LIST"][] = [
                    'MULTIPLE' => $prop['MULTIPLE'],
                    'CODE' => $prop['CODE']
                ];
            } else {
                $additionalProps["SIMPLE"][] = $prop['CODE'];
            }

            if (!empty($specialProps[$prop['ID']])) {
                $specialProps[$prop['ID']] = array_merge($specialProps[$prop['ID']],$prop);
            }
        }

        \Bitrix\Main\Loader::includeModule('iblock');
        $iblock = \Bitrix\Iblock\Iblock::wakeUp(ADS_IBLOCK_ID);
        $classArticleName = $iblock->getEntityDataClass();
        $element = $classArticleName::getByPrimary($itemId, array(
            'select' => $propCodes
        ))->fetchObject();
        $elementAddPropsValue = [];
        foreach ($propCodes as $code) {
            if (in_array($code,$additionalProps["SIMPLE"])) {
                if (!empty($element->get($code)) && is_object($element->get($code))) {
                    $elementAddPropsValue[$code] = $element->get($code)->getValue();
                }
            } else {
                if (!empty($element->get($code)) && is_object($element->get($code))) {
                    foreach ($element->get($code)->getAll() as $value) {
                        if (!empty($value->getValue())) {
                            $elementAddPropsValue[$code][$value->getId()] = $value->getValue();
                        }
                    }
                }
            }
        }

        if (!empty($specialProps)) {
            foreach ($specialProps as &$prop) {
                if (!empty($elementAddPropsValue[$prop['CODE']])) {
                    $prop['EDIT_VALUES'] = $elementAddPropsValue[$prop['CODE']];
                }
            }
            unset($prop);
        }

        $arResult['ADDITIONAL_PROPS'] = json_encode($additionalProps);
        $arResult['SPECIAL_PROPS'] = $specialProps;
    }

    private function getAdditionalElementSettings(int $sectionId): void
    {
        $propertiesForAllSections = \CIBlockSectionPropertyLink::GetArray(ADS_IBLOCK_ID, 0);
        $propertiesForCurSection = \CIBlockSectionPropertyLink::GetArray(ADS_IBLOCK_ID, $sectionId);
        $specialProps = [];
        $specialPropsId = [];
        foreach ($propertiesForCurSection as $propId => $prop) {
            if (!array_key_exists($propId,$propertiesForAllSections)) {
                $specialPropsId[] = $propId;
                $specialProps[$propId] = $prop;
            }
        }

        $propsInfo = \Bitrix\Iblock\PropertyTable::getList(array(
            'select' => array('ID','NAME','CODE','PROPERTY_TYPE','MULTIPLE'),
            'filter' => array('IBLOCK_ID' => ADS_IBLOCK_ID, 'ID' => $specialPropsId)
        ))->fetchAll();
        $additionalProps = [];
        foreach ($propsInfo as $prop) {
            if ($prop['PROPERTY_TYPE'] === 'L') {
                $enumValues = \Bitrix\Iblock\PropertyEnumerationTable::getList(array(
                    'select' => array('ID', 'XML_ID', 'VALUE'),
                    'filter' => array('PROPERTY_ID' => $prop['ID'])
                ))->fetchAll();
                $prop['VALUES'] = $enumValues;
                $additionalProps["LIST"][] = [
                    'MULTIPLE' => $prop['MULTIPLE'],
                    'CODE' => $prop['CODE']
                ];
            } else {
                $additionalProps["SIMPLE"][] = $prop['CODE'];
            }

            if (!empty($specialProps[$prop['ID']])) {
                $specialProps[$prop['ID']] = array_merge($specialProps[$prop['ID']],$prop);
            }
        }

        $this->arResult['ADDITIONAL_PROPS'] = json_encode($additionalProps);
        $this->arResult['SPECIAL_PROPS'] = $specialProps;
        ob_end_clean();
        ob_start();
        $this->includeComponentTemplate('section_parameters');
        die();
    }

    private function addAdditionalFields() : void
    {
        if (!empty($_POST['ADDITIONAL_PROPS'])) {
            $additionalProps = json_decode($_POST['ADDITIONAL_PROPS'], true);
            if (!empty($additionalProps['SIMPLE'])) {
                foreach ($additionalProps['SIMPLE'] as $propCode) {
                    if (empty($this->arFieldsForRecord[$propCode])) $this->arFieldsForRecord[$propCode] = $_POST[$propCode];
                }
            }

            if (!empty($additionalProps['LIST'])) {
                foreach ($additionalProps['LIST'] as $prop) {
                    if (empty($this->arFieldsForRecord[$prop['CODE']])) $this->arFieldsForRecord[$prop['CODE']] = $_POST[$prop['CODE']];
                    if ($prop['MULTIPLE'] === 'Y') $this->arMultipleFields[] = $prop['CODE'];
                }
            }
        }
    }

    private function prepareResult() : void
    {
        if (!empty($_GET['item']) && is_int(intval($_GET['item']))) {
            $arResult['ITEM'] = $this->getEditItem($_GET['item']);
            if (!empty($arResult['ITEM']['IBLOCK_SECTION_ID'])) {
                $this->getAdditionalElementSettingsForEdit($arResult['ITEM']['ID'],$arResult['ITEM']['IBLOCK_SECTION_ID'],$arResult);
            }

            if (!empty($arResult['ITEM'])) {
                global $APPLICATION;
                $APPLICATION->SetPageProperty("title", $this->editPageTitle);
            }
        }
        $arResult['USER'] = $this->getUserInfo();
        $arResult['SECTIONS_LVL'] = $this->getSectionsLvlTree();
        $arResult['SELECTS'] = $this->getRegionsAndCitiesProps();
        $this->arResult = $arResult;
    }

    public function executeComponent() : void
    {
        if (!empty($_POST['section_id']) && $_POST['additional_settings'] === 'y') {
            $this->getAdditionalElementSettings($_POST['section_id']);
        }

        $this->prepareResult();
        if ($this->isPostFormData()) {
            if (!empty($_POST['ITEM_ID'])) {
                if ($this->checkPostFields() && $this->checkPostImages()) {
                    $this->addAdditionalFields();
                    $this->updateUserAds($_POST['ITEM_ID']);
                }
            } else {
                if ($this->checkPostFields() && $this->checkPostImages()) {
                    $this->addAdditionalFields();
                    $this->createNewUserAds();
                }
            }
        }
        $this->arResult['ERRORS'] = $this->arErrors;
        $this->includeComponentTemplate();
    }
}