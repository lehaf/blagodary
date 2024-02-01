<?php

namespace WebCompany;

use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
use WebCompany\WReferralsTable;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;

class ReferralProgram extends \CBitrixComponent
{
    private string $moduleName = 'webco.settings';
    private int $userId;
    private int $randomStringLength = 5;
    private string $subscriptionPagePath = '/personal/subscription/';
    private string $referralParam = 'referral';
    private string $cookieName = 'referral_link';

    public function __construct($component = \null)
    {
        global $USER;
        $this->userId = $USER->GetID();
        Loader::includeModule($this->moduleName);
        parent::__construct($component);
    }

    private function setLinkToCookie(string $cookieLink) : void
    {
        $context = Application::getInstance()->getContext();
        if (empty($context->getRequest()->getCookie($this->cookieName))) {
            $cookieLink = new Cookie($this->cookieName, $cookieLink);
            $cookieLink->setDomain($_SERVER['SERVER_NAME']);
            $context->getResponse()->addCookie($cookieLink);
        }
    }

    public function generateRandomString(int $length = 8) : string
    {
        $chars = 'abcdefhiknrstyzABCDEFGHKNQRSTYZ';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    private function getUserReferralLink(string $userReferralCode) : ?string
    {
        if (!empty($userReferralCode)) {
            $referralLink = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$this->subscriptionPagePath
            .'?'.$this->referralParam.'='.$userReferralCode;
        }
        return $referralLink ?? NULL;
    }

    private function getUserReferralCode(int $userId) : void
    {
        $arUser = \Bitrix\Main\UserTable::getList(array(
            'select' => ['ID','UF_REFERRAL_CODE'],
            'filter' => ['ID' => $userId],
            'limit' => 1,
            'cache' => [
                'ttl' => 3600000,
                'cache_joins' => true
            ]
        ))->fetch();

        if (empty($arUser['UF_REFERRAL_CODE'])) {
            $hashString = md5($userId.$this->generateRandomString($this->randomStringLength));
            $user = new \CUser;
            $fields = Array(
                "UF_REFERRAL_CODE" => $hashString,
            );
            $user->Update($userId, $fields);
            $arUser['UF_REFERRAL_CODE'] = $hashString;
        }

        $this->arResult['REFERRAL_LINK'] = $this->getUserReferralLink($arUser['UF_REFERRAL_CODE']);
        $this->setLinkToCookie($this->arResult['REFERRAL_LINK']);
    }

    private function getUserReferralsInfo(?int $timeMin = NULL, ?int $timeMax = NULL) : void
    {
        if (!empty($this->userId)) {
            $this->getUserReferralCode($this->userId);
            $refFilter = ['USER_ID' => $this->userId];

            if (!empty($timeMin)) $refFilter['>PAYDATE'] = DateTime::createFromTimestamp($timeMin);
            if (!empty($timeMax)) $refFilter['<PAYDATE'] = DateTime::createFromTimestamp($timeMax);


            $userReferralsInfo = WReferralsTable::getList([
                'select' => ['ID','REFERRAL_ID','PAYDATE'],
                'filter' => $refFilter,
                'cache' => [
                    'ttl' => 36000,
                    'cache_joins' => true
                ]
            ])->fetchAll();

            if (!empty($userReferralsInfo)) {
                $referralsId = [];
                $referralsList = [];
                foreach ($userReferralsInfo as $referral) {
                    $referralsId[] = $referral['REFERRAL_ID'];
                    $referralsList[] = [
                        'ID' => $referral['REFERRAL_ID'],
                        'DATE' => date('d.m.Y',strtotime($referral['PAYDATE']))
                    ];
                }

                $referralsData = \Bitrix\Main\UserTable::getList(array(
                    'select' => ['ID','LOGIN','NAME'],
                    'filter' => ['ID' => $referralsId],
                    'cache' => [
                        'ttl' => 3600000,
                        'cache_joins' => true
                    ]
                ))->fetchAll();


                if (!empty($referralsData) && !empty($referralsList)) {
                    $referralUsersData = [];
                    foreach ($referralsData as $refUserData) {
                        $referralUsersData[$refUserData['ID']] = [
                            'NAME' => $refUserData['NAME'],
                            'LOGIN' => $refUserData['LOGIN']
                        ];
                    }

                    foreach ($referralsList as &$referral) {
                        $referral['NAME'] = !empty($referralUsersData[$referral['ID']]['NAME']) ?
                            $referralUsersData[$referral['ID']]['LOGIN'].' ('.$referralUsersData[$referral['ID']]['NAME'].')' : $referralUsersData[$referral['ID']]['LOGIN'];
                    }
                    unset($referral);
                    $this->arResult['REFERRAL_LIST'] = $referralsList;
                }
            }
        }
    }

    public function prepareResult() : void
    {
        if (!empty($_POST['payDateMin']) || !empty($_POST['payDateMax'])) {
            $dateMin = strtotime($_POST['payDateMin']);
            $dateMax = strtotime($_POST['payDateMax']);
            $this->getUserReferralsInfo($dateMin,$dateMax);
        } else {
            $this->getUserReferralsInfo();
        }
    }

    public function executeComponent() : void
    {
        $this->prepareResult();
        if ($_POST['component'] === $this->getName() && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') ob_end_clean();
        $this->includeComponentTemplate();
        if ($_POST['component'] === $this->getName() && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') die();
    }
}