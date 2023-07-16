<?php

namespace WebCompany;



class ReferralProgram extends \CBitrixComponent
{
    private int $userId;
    private int $randomStringLength = 5;
    private string $subscriptionPagePath = '/personal/subscription/';
    private string $referralParam = 'referral';

    public function __construct($component = \null)
    {
        global $USER;
        $this->userId = $USER->GetID();

        parent::__construct($component);
    }

    public function generateRandomString( int $length = 8) : string
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
                'select' => ['UF_REFERRAL_CODE','UF_USER_REFERRALS'],
                'filter' => ['ID' => $this->userId],
                'limit' => 1,
                'cache' => [
                    'ttl' => 360000,
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

            if (!empty($arUser['UF_USER_REFERRALS'])) {
                $userReferrals = \Bitrix\Main\UserTable::getList(array(
                    'select' => ['ID','LOGIN','NAME'],
                    'filter' => ['ID' => $arUser['UF_USER_REFERRALS']],
                    'cache' => [
                        'ttl' => 360000,
                        'cache_joins' => true
                    ]
                ))->fetchAll();

                if (!empty($userReferrals)) {
                    foreach ($userReferrals as $referral) {
                        $this->arResult['REFERRAL_LIST'][] = !empty($referral['NAME']) ?
                            $referral['LOGIN'].' ('.$referral['NAME'].')' : $referral['LOGIN'];
                    }
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