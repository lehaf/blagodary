<?php

namespace WebCompany;

use Bitrix\Main\Entity;

class WReferralsTable extends Entity\DataManager
{
    private const TABLE_NAME = 'w_referrals';

    public static function getTableName()
    {
        return self::TABLE_NAME;
    }

    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', ['primary' => true, 'autocomplete' => true,]),
            new Entity\IntegerField('USER_ID', ['required' => true]),
            new Entity\IntegerField('REFERRAL',['required' => true]),
            new Entity\DateTimeField('PAYDATE', ['default_value' => new \Bitrix\Main\Type\DateTime(),]),
        ];
    }
}