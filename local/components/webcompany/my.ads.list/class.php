<?php

namespace WebCompany;

class AddElementForm extends \CBitrixComponent
{
    private string $errorLogTitle = 'Ошибка добавления пользователя в свойство!';
    private string $errorLogDesc = "В компоненте webcompany:my.ads.list при добавлении в свойство WHO_WANT_TAKE
     нового пользователя возникли следующие ошибки:";
    private ?int $curUserId;


    public function __construct($component = \null)
    {
        $this->curUserId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
        parent::__construct($component);
    }

    public function isPostRequest() : bool
    {
        if (!empty($_POST) && $_POST['component'] === $this->getName()) return true;
        return false;
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

    private function addUserToWantTakeList(int $adsId) : void
    {
        if (!empty($adsId)) {
            if (\Bitrix\Main\Loader::includeModule('iblock')) {
                $className = \Bitrix\Iblock\Iblock::wakeUp(ADS_IBLOCK_ID)->getEntityDataClass();
                $obAds = $className::getList(array(
                    'select' => array('ID', 'WHO_WANT_TAKE'),
                    'filter' => array('=ACTIVE' => 'Y', 'ID' => $adsId),
                    'limit' => 1
                ))->fetchObject();

                if (!empty($this->curUserId)) {
                    if ($obAllUsers = $obAds->getWhoWantTake()->getAll()) {
                        foreach ($obAllUsers as $obValue) {
                            if ($obValue->getValue() == $this->curUserId) exit;
                        }
                    }
                    $obAds->addToWhoWantTake($this->curUserId);
                    $res = $obAds->save();
                    if (!$res->isSuccess()) {
                        $this->processErrors($res->getErrorMessages());
                    }
                }
            }
        }
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
                'order' => array('DATE_CREATE' => 'DESC','ID' => 'ASC'),
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
            if ($this->isPostRequest()) {
                if ($_POST['action'] === 'addUserToWantTakeList' && !empty($_POST['ads_id'])) {
                    $this->addUserToWantTakeList($_POST['ads_id']);
                }
            }
        $this->includeComponentTemplate();
    }
}