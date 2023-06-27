<?php

namespace WebCompany;

class AddElementForm extends \CBitrixComponent
{
    private string $errorLogTitle = 'Ошибка создания объявления!';
    private string $errorLogDesc = "В компоненте webcompany:add.element.form при создании нового объявления возникли следующие ошибки:";
    private ?int $curUserId;


    public function __construct($component = \null)
    {
        $this->curUserId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
        parent::__construct($component);
    }

    public function isPostFormData() : bool
    {
        if (!empty($_POST)) return true;
        return false;
    }

    public function getHermitageButtons(int $itemId, int $iblockId) : array
    {
        $arButtons = [];
        if (!empty($itemId) && !empty($iblockId)) {
            $arButtonsData = \CIBlock::GetPanelButtons(
                $iblockId,
                $itemId,
                0,
                array("SECTION_BUTTONS"=>false, "SESSID"=>false)
            );

            $arButtons["EDIT_LINK"] = $arButtonsData["edit"]["edit_element"]["ACTION_URL"];
            $arButtons["DELETE_LINK"] = $arButtonsData["edit"]["delete_element"]["ACTION_URL"];

            $arButtons["EDIT_LINK_TEXT"] = $arButtonsData["edit"]["edit_element"]["TEXT"];
            $arButtons["DELETE_LINK_TEXT"] = $arButtonsData["edit"]["delete_element"]["TEXT"];
        }
        return $arButtons;
    }

    private function prepareUserAdsList() : void
    {
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            $className = \Bitrix\Iblock\Iblock::wakeUp(ADS_IBLOCK_ID)->getEntityDataClass();
            $obCollection = $className::getList(array(
                'order' => array('SORT' => 'ASC'),
                'select' => array('ID', 'CODE', 'NAME', 'DATE_CREATE', 'IMAGES', 'IBLOCK'),
                'filter' => array('=ACTIVE' => 'Y', 'OWNER.VALUE' => $this->curUserId),
                'cache' => array(
                    'ttl' => 360000,
                    'cache_joins' => true
                )
            ))->fetchCollection();

            foreach ($obCollection as $obItem) {
                $arButtons = $this->getHermitageButtons($obItem->getId(),$obItem->getIblock()->getId());
                $arDPU = ['ID' => $obItem->getId(), 'CODE' => $obItem->getCode()];
                $detailPageUrl = \CIBlock::ReplaceDetailUrl($obItem->getIblock()->getDetailPageUrl(), $arDPU, false, 'E');
                $firstImgId = !empty($obItem->getImages()->getAll()[0]) ? $obItem->getImages()->getAll()[0]->getValue() : NO_PHOTO_IMG_ID;
                $arResizeFirstImg = \CFile::ResizeImageGet(
                    $firstImgId,
                    array("width" => 170, "height" => 131),
                    BX_RESIZE_IMAGE_PROPORTIONAL,
                );

                $unixTime = strtotime($obItem->getDateCreate());
                $dateCreate = date('d.m.Y в H:i',$unixTime);

                $this->arResult['ITEMS'][] = [
                    'ID' => $obItem->getId(),
                    'NAME' => $obItem->getName(),
                    'DATE_CREATE' => $dateCreate,
                    'IMG' => $arResizeFirstImg,
                    'DETAIL_PAGE_URL' => $detailPageUrl,
                    ...$arButtons
                ];
            }
        }
    }

    private function prepareResult() : void
    {
        $this->prepareUserAdsList();
    }

    public function executeComponent() : void
    {
        $this->prepareResult();
//        if ($this->isPostFormData()) {
//        }
        $this->includeComponentTemplate();
    }
}