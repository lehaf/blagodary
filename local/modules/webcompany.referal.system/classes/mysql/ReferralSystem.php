<?php

namespace WebCompany;

use \Bitrix\Main\Application;
use Bitrix\Main\Loader;

final class ReferralSystem
{
    private string $tabsTable = 'w_referrals_tabs';
    private array $tabsTableFields = [
        'CODE' => 'TAB_CODE',
        'NAME' => 'TAB_NAME',
        'TITLE' => 'TAB_TITLE',
        'SORT' => 'TAB_SORT',
    ];
    private string $groupsTable = 'w_referrals_groups';
    private array $groupsTableFields = [
        'CODE' => 'GROUP_CODE',
        'NAME' => 'GROUP_NAME',
        'SORT' => 'GROUP_SORT',
    ];
    private string $fieldsTable = 'w_referrals_fields';
    private string $defaultSettingsFilePath = '/local/modules/webcompany.referal.system/.default.php';
    private int $standardSort = 500;
    private object $db;

    public function __construct()
    {
        $this->db = Application::getConnection();
    }

    public function getSettingsTree() : array
    {
        $tabsAlies = '';
        foreach ($this->tabsTableFields as $tabField => $tabAlies) {
            $tabsAlies .= $this->tabsTable.'.'.$tabField.' AS '.$tabAlies.', ';
        }

        $groupsAlies = '';
        foreach ($this->groupsTableFields as $groupField => $groupAlies) {
            $groupsAlies .= $this->groupsTable.'.'.$groupField.' AS '.$groupAlies.', ';
        }
        $groupsAlies = rtrim($groupsAlies,', ');

        $result = $this->db->query(
        "SELECT *, ".$tabsAlies.$groupsAlies." ".
            "FROM $this->tabsTable \r\n".
            "JOIN ".$this->groupsTable." ON ".$this->groupsTable.'.TAB_ID = '.$this->tabsTable.".ID  \r\n".
            "JOIN ".$this->fieldsTable." ON ".$this->fieldsTable.'.GROUP_ID = '.$this->groupsTable.'.ID'
        );

        $resSettings = $result->fetchALl();

        if (!empty($resSettings)) {
            $settings = [];
            $groups = [];
            $sett = [];
            foreach ($resSettings as $setting) {
                $sett[$setting['TAB_CODE']][$setting['GROUP_CODE']][$setting['ID']]= [
                    "id" => $setting['CODE'],
                    "name" => $setting['NAME'],
                    "value" => $setting['VALUE'],
                    "hint" => $setting['HINT'],
                    "explanation" => $setting['EXPLANATION'],
                    'type' => [$setting['TYPE'], $setting['LENGHT'], $setting['HEIGHT']]
                ];

                $groups[$setting['TAB_CODE']][$setting['GROUP_CODE']] = [
                    'groupName' => $setting['GROUP_NAME'],
                    'settings' =>  $sett[$setting['TAB_CODE']][$setting['GROUP_CODE']]
                ];

                $settings[$setting['TAB_CODE']] = [
                    'tabName' => $setting['TAB_NAME'],
                    'tabTitle' => $setting['TAB_TITLE'],
                    'tabGroups' => $groups[$setting['TAB_CODE']]
                ];
            }
        }

        return $settings ?? [];
    }

    public function getSettingValue(string $settingCode) : string
    {
        if (!empty($settingCode)) {
            $result = $this->db->query(
                "SELECT * FROM $this->fieldsTable \r\n".
                "WHERE CODE='".$settingCode."'"
             );

            $resSettings = $result->fetch();
        }

        return $resSettings['VALUE'] ??  '';
    }

    public function getSettingCodes() : array
    {
        $result = $this->db->query(
        "SELECT * FROM $this->fieldsTable \r\n"
        );

        $resSettings = $result->fetchALl();

        if (!empty($resSettings)) {
            $settingCodes = [];
            foreach ($resSettings as $setting) {
                $settingCodes[] = $setting['CODE'];
            }
        }

        return $settingCodes ?? [];
    }

    public function saveNewSettings(array $newSettings) : bool
    {
        if (!empty($newSettings)) {
            foreach ($newSettings as $setting) {
                $sqlFieldsInsert = 'UPDATE '.$this->fieldsTable.' SET VALUE="'.$setting['value'].'" WHERE CODE="'.$setting['code'].'"';
                $this->db->queryExecute($sqlFieldsInsert);
            }
            return true;
        }

        return false;
    }

    public function setDefaultSettings() : bool
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'].$this->defaultSettingsFilePath)) {
            $defaultSettings = require_once $_SERVER['DOCUMENT_ROOT'].$this->defaultSettingsFilePath;
            if (!empty($defaultSettings)) {
                foreach ($defaultSettings as $tabInfo) {
                    if (!empty($tabInfo['tabGroups'])) {
                        foreach ($tabInfo['tabGroups'] as $groupInfo) {
                            if (!empty($groupInfo['settings'])) {
                                foreach ($groupInfo['settings'] as $setting) {
                                    $sqlFieldsInsert = 'UPDATE '.$this->fieldsTable.' SET VALUE="'.$setting['default'].'" WHERE CODE="'.$setting['id'].'"';
                                    $this->db->queryExecute($sqlFieldsInsert);
                                }
                            }
                        }
                    }
                }
                return true;
            }
        }

        return false;
    }

    public function insertDataToTables() : bool
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'].$this->defaultSettingsFilePath)) {
            $defaultSettings = require_once $_SERVER['DOCUMENT_ROOT'].$this->defaultSettingsFilePath;
            if (!empty($defaultSettings)) {
                $sqlTabsInsert = 'INSERT INTO '.$this->tabsTable.' (CODE, NAME, TITLE, SORT) VALUES ';
                $lastTabKey = array_key_last($defaultSettings);
                $sqlGroupsInsert = 'INSERT INTO '.$this->groupsTable.' (TAB_ID, CODE, NAME, SORT) VALUES ';
                $sqlFieldsInsert = 'INSERT INTO '.$this->fieldsTable.' (CODE, GROUP_ID, NAME, VALUE, HINT, EXPLANATION, TYPE, LENGHT, HEIGHT, SORT) VALUES ';
                foreach ($defaultSettings as $tabCode => $tabInfo) {
                    static $tabId = 1;
                    $sqlTabsInsert .= "('$tabCode', '$tabInfo[tabName]', '$tabInfo[tabName]', $this->standardSort)";
                    if ($lastTabKey === $tabCode) {
                        $sqlTabsInsert.= ";\r\n";
                    } else {
                        $sqlTabsInsert.= ', ';
                    }

                    if (!empty($tabInfo['tabGroups'])) {
                        $lastGroupKey = array_key_last($tabInfo['tabGroups']);
                        foreach ($tabInfo['tabGroups'] as $groupCode => $groupInfo) {
                            static $groupId = 1;
                            $sqlGroupsInsert .= "($tabId, '$groupCode', '$groupInfo[groupName]', $this->standardSort)";

                            if ($lastTabKey === $tabCode && $lastGroupKey === $groupCode) {
                                $sqlGroupsInsert.= ";\r\n";
                            } else {
                                $sqlGroupsInsert.= ', ';
                            }

                            if (!empty($groupInfo['settings'])) {
                                $lastFieldKey = array_key_last($groupInfo['settings']);
                                foreach ($groupInfo['settings'] as $key => $fieldInfo) {
                                    $sqlFieldsInsert .= "('$fieldInfo[id]', $groupId, '$fieldInfo[name]', '$fieldInfo[default]', '$fieldInfo[hint]',
                                    '$fieldInfo[explanation]', '".$fieldInfo['type'][0]."', ".($fieldInfo['type'][1] ?? "NULL").", ".
                                        ($fieldInfo['type'][2] ?? "NULL").", $this->standardSort)";

                                    if ($lastTabKey === $tabCode && $lastGroupKey === $groupCode && $lastFieldKey === $key) {
                                        $sqlFieldsInsert.= ';';
                                    } else {
                                        $sqlFieldsInsert.= ', ';
                                    }
                                }
                            }
                            $groupId++;
                        }
                    }
                    $tabId++;
                }
//                $sqlRequest = $sqlTabsInsert.$sqlGroupsInsert.$sqlFieldsInsert;
                $this->db->queryExecute($sqlTabsInsert);
                $this->db->queryExecute($sqlGroupsInsert);
                $this->db->queryExecute($sqlFieldsInsert);
                return true;
            }
        }
        return false;
    }
}
