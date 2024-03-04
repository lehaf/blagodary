<?php

/** @global object $APPLICATION */

function OnBuildGlobalMenuHandler(&$aGlobalMenu, &$aModuleMenu) : array
{
    $moduleId = "webco.settings";

    global $APPLICATION;
    $APPLICATION->SetAdditionalCSS("/bitrix/css/".$moduleId."/logo.css");

    return array(
        "global_menu_" . $moduleId => array(
            "menu_id" => $moduleId,
            "text" => 'Управление сайтом',
            "title" => 'Bitcode',
            "sort" => 2000,
            "items_id" => "global_menu_" . $moduleId,
            "help_section" => $moduleId,
            "items" => array(
                array(
                    "text" => 'Настройки',
                    "title" => 'Настройки',
                    'icon' => 'sys_menu_icon',
                    "url" => "/bitrix/admin/webco_site_settings.php",
                    'items_id' => 'cp',
                ),
                array(
                    "text" => 'Статистика',
                    "title" => 'Статистика',
                    'icon' => 'seo_adv_menu_icon',
                    "url" => "/bitrix/admin/webco_statistics.php",
                    'items_id' => 'st',
                )
            )
        )
    );
}

AddEventHandler('main', 'OnBuildGlobalMenu', 'OnBuildGlobalMenuHandler');