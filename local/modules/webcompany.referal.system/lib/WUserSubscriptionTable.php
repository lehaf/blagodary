<?php

namespace WebCompany;

use Bitrix\Main\Entity;

class WUserSubscriptionTable extends Entity\DataManager
{
    private const TABLE_NAME = 'w_user_subscription';

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
            new Entity\StringField('FREE',['default_value' => 'N']),
            new Entity\DateTimeField('DATE_FROM', ['default_value' => new \Bitrix\Main\Type\DateTime(), 'required' => true]),
            new Entity\DateTimeField('DATE_TO', ['default_value' => new \Bitrix\Main\Type\DateTime(), 'required' => true]),
        ];
    }
}