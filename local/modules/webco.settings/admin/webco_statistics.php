<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

/** @global object $USER */
/** @global object $APPLICATION */

use Bitrix\Main\Loader;
use WebCompany\ReferralStatistics;

$APPLICATION->SetTitle("Статистика по реферальной системе");

$mid = 'webco.settings';

if(!$USER->IsAdmin() || !\Bitrix\Main\Loader::includeModule($mid)) return;

$statistics = (new ReferralStatistics())->getStatistics();
?>
    <div class="adm-list-table-wrap">
        <table class="adm-list-table" id="tbl_form_list">
            <thead>
            <tr class="adm-list-table-header">
                <?php foreach ($statistics['COLUMNS'] as $colName):?>
                    <td class="adm-list-table-cell adm-list-table-cell-sort">
                        <div class="adm-list-table-cell-inner"><?=$colName?></div>
                    </td>
                <?php endforeach?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($statistics['ROWS'] as $row):?>
                <tr class="adm-list-table-row">
                    <td class="adm-list-table-cell"><?=$row['NAME']?></td>
                    <td class="adm-list-table-cell"><?=$row['COST']?></td>
                    <td class="adm-list-table-cell"><?=$row['FREE']?></td>
                </tr>
            <?php endforeach?>
            </tbody>
        </table>
    </div>
<?php  require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");