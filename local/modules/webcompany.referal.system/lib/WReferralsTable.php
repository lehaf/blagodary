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
            new Entity\ReferenceField(
                'USER',
                'Bitrix\Main\UserTable',
                ['=this.USER_ID' => 'ref.ID'],
                ['join_type' => 'LEFT']
            ),
            new Entity\IntegerField('REFERRAL_ID',['required' => true]),
            new Entity\ReferenceField(
                'REFERRAL',
                'Bitrix\Main\UserTable',
                ['=this.REFERRAL_ID' => 'ref.ID'],
                ['join_type' => 'LEFT']
            ),
            new Entity\DateTimeField('PAYDATE', ['default_value' => new \Bitrix\Main\Type\DateTime(),]),
        ];
    }
}