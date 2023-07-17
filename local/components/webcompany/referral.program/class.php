<?php

namespace WebCompany;

use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
use WebCompany\WReferralsTable;
use Bitrix\Main\Loader;

class ReferralProgram extends \CBitrixComponent
{
    private int $userId;
    private int $randomStringLength = 5;
    private string $subscriptionPagePath = '/personal/subscription/';
    private string $referralParam = 'referral';
    private string $cookieName = 'referral_link';

    public function __construct($component = \null)
    {
        global $USER;
        $this->userId = $USER->GetID();
        Loader::includeModule("webcompany.referal.system");
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

    private function getUserReferralsInfo() : void
    {
        if (!empty($this->userId)) {

            $arUser = \Bitrix\Main\UserTable::getList(array(
                'select' => ['UF_REFERRAL_CODE'],
                'filter' => ['ID' => $this->userId],
                'limit' => 1,
                'cache' => [
                    'ttl' => 3600000,
                    'cache_joins' => true
                ]
            ))->fetch();

            if (empty($arUser['UF_REFERRAL_CODE'])) {
                $hashString = md5($this->userId.$this->generateRandomString($this->randomStringLength));
                $user = new \CUser;
                $fields = Array(
                    "UF_REFERRAL_CODE" => $hashString,
                );
                $user->Update($this->userId, $fields);
                $arUser['UF_REFERRAL_CODE'] = $hashString;
            }

            $this->arResult['REFERRAL_LINK'] = $this->getUserReferralLink($arUser['UF_REFERRAL_CODE']);
            $this->setLinkToCookie($this->arResult['REFERRAL_LINK']);


            $userReferralsIds = WReferralsTable::getList([
                'select' => ['ID','REFERRAL','PAYDATE'],
                'filter' => ['USER_ID' => $this->userId],
                'cache' => [
                    'ttl' => 36000,
                    'cache_joins' => true
                ]
            ])->fetchAll();

            if (!empty($userReferralsIds)) {
                $referralsId = [];
                $referralsListInfo = [];
                foreach ($userReferralsIds as $referral) {
                    $referralsId[] = $referral['REFERRAL'];
                    $referralsListInfo[] = [
                        'ID' => $referral['REFERRAL'],
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


                if (!empty($referralsData) && !empty($referralsListInfo)) {
                    $referralUsersData = [];
                    foreach ($referralsData as $refUserData) {
                        $referralUsersData[$refUserData['ID']] = [
                            'NAME' => $refUserData['NAME'],
                            'LOGIN' => $refUserData['LOGIN']
                        ];
                    }

                    foreach ($referralsListInfo as &$referral) {
                        $referral['NAME'] = !empty($referralUsersData[$referral['ID']]['NAME']) ?
                            $referralUsersData[$referral['ID']]['LOGIN'].' ('.$referralUsersData[$referral['ID']]['NAME'].')' : $referralUsersData[$referral['ID']]['LOGIN'];
                    }
                    unset($referral);
                    $this->arResult['REFERRAL_LIST'] = $referralsListInfo;
                }
            }
        }
    }

    public function prepareResult() : void
    {
        $this->getUserReferralsInfo();
    }

    public function executeComponent() : void
    {
        $this->prepareResult();
        if (!empty($_GET[$this->paginationParam]) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') ob_end_clean();
        $this->includeComponentTemplate();
        if (!empty($_GET[$this->paginationParam]) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') die();
    }
}