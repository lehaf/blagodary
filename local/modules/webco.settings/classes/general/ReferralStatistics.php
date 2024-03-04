<?php

namespace WebCompany;

use Bitrix\Main\Loader;
use WebCompany\WUserSubscriptionTable;

final class ReferralStatistics
{
    private string $mid = 'webco.settings';

    private array $tableColumns = [
        'Временной промежуток',
        'Кол-во платных подписок',
        'Кол-во бесплатных подписок',
    ];

    private array $tableRows = [
        'CUR_MONTH' => [
            'NAME' => 'Текущий месяц',
        ],
        'LAST_THREE_MONTH' => [
            'NAME' => 'Последние 3 месяца',
        ],
        'CUR_YEAR' => [
            'NAME' => 'За год',
        ],
        'ALL' => [
            'NAME' => 'За все время',
        ]
    ];

    public function __construct()
    {
        if (!\Bitrix\Main\Loader::includeModule($this->mid)) die('Модуль '.$this->mid.' не подключен!');
    }

    public function getStatistics() : array
    {

        foreach ($this->tableRows as $key => &$row) {
            $query = [];
            switch ($key) {
                case 'CUR_MONTH':
                    $query['filter'] = ['>DATE_FROM' => date('01.m.Y 00:00:00')];
                    break;
                case 'LAST_THREE_MONTH':
                    $query['filter'] = ['>DATE_FROM' => date('d.m.Y H:i:s',strtotime('first day of -3 months'))];
                    break;
                case 'CUR_YEAR':
                    $query['filter'] = ['>DATE_FROM' => date('01.01.Y H:i:s')];
                    break;
            }

            $query['count_total'] = 1;


            $query['filter']['FREE'] = 'N';
            $row['COST'] = WUserSubscriptionTable::getList($query)->getCount();
            $query['filter']['FREE'] = 'Y';
            $row['FREE'] = WUserSubscriptionTable::getList($query)->getCount();
        }
        unset($row);

        return [
            'COLUMNS' => $this->tableColumns,
            'ROWS' => $this->tableRows,
        ];
    }

}
