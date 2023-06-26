<?php

namespace WebCompany;

use Bitrix\Main\Loader;
use Bitrix\Iblock\ORM\PropertyValue;
use Bitrix\Iblock\ElementTable;

class AddElementForm extends \CBitrixComponent
{
    private string $errorLogTitle = 'Ошибка создания объявления!';
    private string $errorLogDesc = "В компоненте webcompany:add.element.form при создании нового объявления возникли следующие ошибки:";
    private array $arNeedsUserInfo = ['ID', 'NAME', 'REGION' => 'PERSONAL_STATE', 'CITY' => 'PERSONAL_CITY'];
    private array $arPostValidFields = [
        'NAME' => 'Название товара',
        'IBLOCK_SECTION_ID' => 'Выбор категории',
        'DETAIL_TEXT' => 'Описание',
        'REGION' => 'Область',
        'CITY' => 'Город / Район'
    ];
    private string $propOwnerCode = 'OWNER';
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
                'filter' => array('PROPERTY_ID' => [REGION_PROP_ID,CITY_PROP_ID]),
                'cache' => array(
                    'ttl' => 360000,
                    'cache_joins' => true
                ),
            ));

            while ($arValue = $obPropRegionValues->fetch()) {
                if (REGION_PROP_ID == $arValue['PROPERTY_ID']) {
                    $arResult['REGION'][$arValue['ID']] = $arValue['VALUE'];
                }

                if (CITY_PROP_ID == $arValue['PROPERTY_ID']) {
                    $arResult['CITY'][$arValue['ID']] = $arValue['VALUE'];
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

    private function checkPostFields() : bool
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
            $arCheckedFields = [];
            foreach ($_POST as $propName => $propValue) {
                if (key_exists($propName, $this->arPostValidFields)) {
                    $fieldValue = htmlspecialchars(trim($propValue));
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
                $type = pathinfo($arImages['name'][$i], PATHINFO_EXTENSION); // Получаем тип файла
                 // Проверяем, является ли файл изображением исключительно типов PNG, JPG, JPEG
                if (!in_array($type, $this->arValidImgFormat)) {
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
                $obNewElement->set($propName,$propValue);
            }

            foreach ($this->arImgForRecord[$this->postImagesArrayName] as $arImage) {
                $arImage['MODULE_ID'] = 'iblock';
                $fileId = \CFile::SaveFile($arImage,'iblock');
                $obNewElement->addTo($this->postImagesArrayName, new PropertyValue($fileId));
            }

            $obRes = $obNewElement->save();

            if ($obRes->isSuccess()) {
                echo json_encode(["OK" => "Элемент успешно добавлен"]);
            } else {
                $this->processErrors($obRes->getErrorMessages());
            }
        }
    }

    private function prepareResult() : void
    {
        $arResult['USER'] = $this->getUserInfo();
        $arResult['SECTIONS_LVL'] = $this->getSectionsLvlTree();
        $arResult['SELECTS'] = $this->getRegionsAndCitiesProps();
        $this->arResult = $arResult;
    }

    public function executeComponent() : void
    {
        $this->prepareResult();
        if ($this->isPostFormData()) {
            if ($this->checkPostFields() && $this->checkPostImages()) {
                $this->createNewUserAds();
            } else {
                echo json_encode($this->arErrors);
            }
        }
        $this->includeComponentTemplate();
    }
}