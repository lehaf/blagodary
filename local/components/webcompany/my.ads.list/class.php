<?php

namespace WebCompany;

use Bitrix\Main\UserTable;
use Bitrix\Main\Type\DateTime;

class AddElementForm extends \CBitrixComponent
{
    private string $erAdUserWantListTitle = 'Ошибка добавления пользователя в свойство!';
    private string $erAdUserWantListDesc = "В компоненте webcompany:my.ads.list при добавлении в свойство WHO_WANT_TAKE
     нового пользователя возникли следующие ошибки:";
    private string $erCreateRatingSectTitle = 'Ошибка создания раздела для рейтинга!';
    private string $erCreateRatingSectDesc = "В компоненте webcompany:my.ads.list при создании раздела для 
    нового пользователя возникли следующие ошибки:";
    private string $erCreateRatingReviewTitle = 'Ошибка создания элемента отзыва!';
    private string $erCreateRatingReviewDesc = "В компоненте webcompany:my.ads.list при создании элемента для 
    отзыва в инфоблоке 'Рейтинг' возникли следующие ошибки:";
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

    private function getUserInfo(int $userId, array $arSelect) : array
    {
        return UserTable::getList(array(
            'select' => $arSelect,
            'filter' => ['ID' => $userId],
            'limit' => 1,
            'cache' => [
                'ttl' => 360000,
                'cache_joins' => true
            ]
        ))->fetch();
    }

    private function checkUser() : bool
    {
        $arUserInfo = UserTable::getList(array(
            'select' => ['BLOCKED','ADMIN_NOTES','UF_SUBSCRIPTION'],
            'filter' => ['ID' => $this->curUserId],
            'limit' => 1
        ))->fetch();

        if ($arUserInfo['BLOCKED'] === 'Y') {
            $this->arResult['BLOCKED'] = $arUserInfo['BLOCKED'];
            $this->arResult['BLOCKED_TEXT'] = $arUserInfo['ADMIN_NOTES'];
            return false;
        }

        if ($arUserInfo['UF_SUBSCRIPTION'] == true) $this->arResult['ACTIVE_SUBSCRIPTION'] = 'Y';

        return true;
    }

    private function executeAction(string $action) : void
    {
        switch ($action) {
            case 'addUserToWantTakeList':
                if (!empty($_POST['ads_id'])) {
                    $this->addUserToWantTakeList($_POST['ads_id']);
                }
                break;
            case 'getAdsWantTakeListUsers':
                if (!empty($_POST['ads_id'])) {
                    $this->getAdsWantTakeListUsers($_POST['ads_id']);
                }
                break;
            case 'setUserRatingAndDeactivate':
                if (!empty($_POST['ads_id']) && !empty($_POST['ads_name']) &&!empty($_POST['user_id']) && !empty($_POST['RATING']) && !empty($_POST['COMMENT'])) {
                    $this->setUserRating($_POST['user_id'], $_POST['ads_name'], $_POST['RATING'], $_POST['COMMENT']);
                    $this->deactivateAds($_POST['ads_id']);
                    $this->increaseCounter();
                }
                break;
            case 'deactivate':
                if (!empty($_POST['ads_id'])) {
                    $this->deactivateAds($_POST['ads_id']);
                }
                break;
            case 'setUserRating':
                if (!empty($_POST['ads_name']) && !empty($_POST['user_id']) && !empty($_POST['RATING']) && !empty($_POST['COMMENT'])) {
                    $this->setUserRating(
                        $_POST['user_id'],
                        $_POST['ads_name'],
                        $_POST['RATING'],
                        $_POST['COMMENT'],
                        $_POST['review_id']
                    );
                }
                break;
        }
    }

    private function processErrors(array $arErrorsMessages, string $errorTitle, string $errorDesc) : void
    {
        if (!empty($arErrorsMessages) && !empty($errorDesc) && !empty($errorTitle)) {
            \CEventLog::Add(array(
                "SEVERITY" => "SECURITY",
                "AUDIT_TYPE_ID" => $errorTitle,
                "MODULE_ID" => $this->__name,
                "ITEM_ID" => NULL,
                "DESCRIPTION" => $errorDesc." ".implode('<br>',$arErrorsMessages)
            ));
        }
    }

    private function setUserRating(int $userId, string $adsName, int $rating, string $comment, ?int $review_id = NULL) : void
    {
        if (!empty($userId) && !empty($rating) && !empty($comment)) {
            if (\Bitrix\Main\Loader::includeModule('iblock') && defined('RATING_IBLOCK_ID')) {
                // Получаем раздел отзывов пользователя
                $ratingSectionEntity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(RATING_IBLOCK_ID);
                $arSection = $ratingSectionEntity::getList(array(
                    "filter" => array("UF_USER_ID" => $userId),
                    "select" => array("ID"),
                ))->fetch();
                // Если раздела нет - создаем
                if (empty($arSection['ID'])) {
                    $arUserInfo = $this->getUserInfo($userId, ['ID','LOGIN']);
                    $objDateTime = DateTime::createFromTimestamp(time());
                    $newUserSection = $ratingSectionEntity::createObject();
                    $newUserSection->setTimestampX($objDateTime);
                    $newUserSection->setIblockId(RATING_IBLOCK_ID);
                    $newUserSection->setName($arUserInfo['LOGIN']);
                    $newUserSection->setUfUserId($arUserInfo['ID']);
                    $res = $newUserSection->save();
                    if ($res->isSuccess()) {
                        $arSection['ID'] = $res->getId();
                    } else {
                        $this->processErrors($res->getErrorMessages(),$this->erCreateRatingSectTitle,$this->erCreateRatingSectDesc);
                    }
                }
                // Создаем сам отзыв
                $ratingElementsEntity = \Bitrix\Iblock\Iblock::wakeUp(RATING_IBLOCK_ID)->getEntityDataClass();
                $obNewReview = $ratingElementsEntity::createObject();
                if (!empty($obNewReview) && !empty($arSection['ID'])) {
                    $obNewReview->setName(htmlspecialchars($adsName));
                    $obNewReview->setIblockSectionId($arSection['ID']);
                    $obNewReview->setDetailText($comment);
                    $obNewReview->setActive(is_int($review_id));
                    $obNewReview->setUser($this->curUserId);
                    if (0 < $rating && $rating < 6) $obNewReview->setRating($rating);
                    $res = $obNewReview->save();
                    if (!$res->isSuccess()) {
                        $this->processErrors($res->getErrorMessages(),$this->erCreateRatingReviewTitle,$this->erCreateRatingReviewDesc);
                    }
                }
                // Если пришел ответ на отзыв то активируем его
                if (!empty($review_id)) {
                    $obUserReview = $ratingElementsEntity::getByPrimary($review_id)->fetchObject();
                    if (is_object($obUserReview)) {
                        $obUserReview->setActive(true);
                        $obUserReview->save();
                    }
                }
            }
        }
    }

    private function increaseCounter() : void
    {
        if (defined('BANNER_COUNTER_IBLOCK_ID')) {
            if (\Bitrix\Main\Loader::includeModule('iblock')) {
                $adsCounterEntity = \Bitrix\Iblock\Iblock::wakeUp(BANNER_COUNTER_IBLOCK_ID)->getEntityDataClass();
                $counter = $adsCounterEntity::getList(array(
                    'select' => ['ID', 'COUNTER'],
                    'filter' => array('=ACTIVE' => 'Y')
                ))->fetchObject();

                $newCount = 1;
                if ($counter->getCounter()) {
                    $newCount = $counter->getCounter()->getValue() + 1;
                }
                $counter->setCounter($newCount);
                $counter->save();
                $taggedCache = \Bitrix\Main\Application::getInstance()->getTaggedCache();
                $taggedCache->clearByTag('iblock_id_'.BANNER_COUNTER_IBLOCK_ID);
            }
        }
    }

    private function deactivateAds(int $adsId) : void
    {
        if (!empty($adsId) && defined('ADS_IBLOCK_ID')) {
            if (\Bitrix\Main\Loader::includeModule('iblock')) {
                $adsElementsEntity = \Bitrix\Iblock\Iblock::wakeUp(ADS_IBLOCK_ID)->getEntityDataClass();
                $obAds = $adsElementsEntity::getList(array(
                    'filter' => array('=ACTIVE' => 'Y', 'ID' => $adsId)
                ))->fetchObject();
                $obAds->setActive(false);
                $obAds->save();
            }
        }
    }

    private function getAdsWantTakeListUsers(int $adsId) : void
    {
        if (!empty($adsId)) {
            if (\Bitrix\Main\Loader::includeModule('iblock')) {
                $className = \Bitrix\Iblock\Iblock::wakeUp(ADS_IBLOCK_ID)->getEntityDataClass();
                $obAds = $className::getList(array(
                    'select' => array('ID', 'WHO_WANT_TAKE'),
                    'filter' => array('=ACTIVE' => 'Y', 'ID' => $adsId),
                    'cache' => [
                        'ttl' => 360000,
                        'cache_joins' => true
                    ]
                ))->fetchObject();

                ob_end_clean();
                ob_start();
                if ($obAllUsers = $obAds->getWhoWantTake()->getAll()) {
                    $arUsersId = [];
                    foreach ($obAllUsers as $obValue) {
                        if ($this->curUserId == $obValue->getValue()) continue;
                        $arUsersId[] = $obValue->getValue();
                    }
                    $arUsersInfo = UserTable::getList(array(
                        'select' => ['ID', 'NAME','UF_PHONES'],
                        'filter' => ['ID' => $arUsersId],
                    ))->fetchAll();

                    echo json_encode(!empty($arUsersInfo) ? $arUsersInfo : []);
                } else {
                    echo '[]';
                }
                die();
            }
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
                        $this->processErrors($res->getErrorMessages(),$this->erAdUserWantListTitle, $this->erAdUserWantListDesc);
                    }
                }
            }
        }
    }


    private function getUserReviews(int $userId) : bool
    {
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            $ratingSectionEntity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(RATING_IBLOCK_ID);
            $arSection = $ratingSectionEntity::getList(array(
                "filter" => array("UF_USER_ID" => $userId),
                "select" => array("ID"),
                "cache" => [
                    'ttl' => 360000,
                    'cache_joins' => true
                ]
            ))->fetch();


            if (!empty($arSection['ID'])) {
                $ratingElementsEntity = \Bitrix\Iblock\Iblock::wakeUp(RATING_IBLOCK_ID)->getEntityDataClass();
                $obReviews = $ratingElementsEntity::getList(array(
                    'select' => array('ID','NAME','DETAIL_TEXT','USER','RATING'),
                    'filter' => array(
                        'IBLOCK_SECTION_ID' => $arSection['ID'],
                        '=ACTIVE' => 'N',
                    ),
                    "cache" => [
                        'ttl' => 360000,
                        'cache_joins' => true
                    ]
                ))->fetchCollection();
                $arUserId = [];
                $arReviews = [];
                foreach ($obReviews as $obReview) {
                    if ($obReview->getUser()) {
                        $usrId = $obReview->getUser()->getValue();
                        $arUserId[] = $usrId;
                        $arReviews[$usrId] = [
                          'REVIEW_ID' => $obReview->getId(),
                          'NAME' => $obReview->getName(),
                          'RATING' => !empty($obReview->getRating()) ? $obReview->getRating()->getValue() : '',
                          'COMMENT' => $obReview->getDetailText(),
                        ];
                    }
                }

                if (!empty($arUserId)) {
                    $arUsersData = UserTable::getList(array(
                        'select' => ['ID','NAME'],
                        'filter' => ['ID' => $arUserId],
                        "cache" => [
                            'ttl' => 360000,
                            'cache_joins' => true
                        ]
                    ))->fetchAll();

                    foreach ($arUsersData as $arUser) {
                        if (!empty($arReviews[$arUser['ID']])) {
                            $arReviews[$arUser['ID']]['USER_NAME'] = $arUser['NAME'];
                        }
                    }

                    if (!empty($arReviews)) {
                        $this->arResult['REVIEWS'] = $arReviews;
                        return true;
                    }
                }
            }
        }
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
                $allImages = $obItem->getImages()->getAll();
                $picId = 0;
                if (!empty($allImages)) {
                    foreach ($allImages as $imgId) {
                        if ($imgId->getValue() > 0) {
                            $picId = $imgId->getValue();
                            break;
                        }
                    }
                }
                $firstImgId = $picId > 0 ? $picId : NO_PHOTO_IMG_ID;

                $arResizeFirstImg = \CFile::ResizeImageGet(
                    $firstImgId,
                    array("width" => 320, "height" => 220),
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
                    'EDIT_PAGE_URL' => '/personal/my-ads/add-ads/?item='.$obItem->getId(),
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
        if ($this->checkUser()) {
            if ($this->getUserReviews($this->curUserId)) $this->includeComponentTemplate('review');
            if ($this->isPostRequest() && !empty($_POST['action'])) {
                $this->executeAction($_POST['action']);
            }
        } else {
            $this->includeComponentTemplate('blocked');
        }
        $this->prepareResult();
        $this->includeComponentTemplate();
    }

}