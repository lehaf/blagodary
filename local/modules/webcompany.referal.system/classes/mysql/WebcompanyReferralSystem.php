<?php

namespace WebCompany;

use \Bitrix\Main\Application;

final class WebcompanyReferralSystem
{
    private string $tabsTable = 'w_referrals_tabs';
    private string $groupsTable = 'w_referrals_groups';
    private string $fieldsTable = 'w_referrals_fields';
    private string $defaultSettingsFilePath = '/local/modules/webcompany.referal.system/.default.php';
    private int $standardSort = 500;
    private object $db;

    public function __construct()
    {
        $this->db = Application::getConnection();
    }

    public function getSettings()
    {
        $result = $this->db->query(
        "SELECT * FROM $this->tabsTable \r\n".
            "JOIN ".$this->groupsTable." ON ".$this->groupsTable.'.TAB_ID = '.$this->tabsTable.".ID  \r\n".
            "JOIN ".$this->fieldsTable." ON ".$this->fieldsTable.'.GROUP_ID = '.$this->groupsTable.'.ID'
        );
        pr(get_class_methods($result->getResource()));
        while($ar = $result->getResource()->fetch_assoc())
        {
            pr($ar);
        }
    }

    public function setDefaultSettings() : bool
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'].$this->defaultSettingsFilePath)) {
            $defaultSettings = require_once $_SERVER['DOCUMENT_ROOT'].$this->defaultSettingsFilePath;
            if (!empty($defaultSettings)) {
                $sqlTabsInsert = 'INSERT INTO '.$this->tabsTable.' (CODE, NAME, TITLE, SORT) VALUES ';
                $lastTabKey = array_key_last($defaultSettings);
                $sqlGroupsInsert = 'INSERT INTO '.$this->groupsTable.' (TAB_ID, CODE, NAME, SORT) VALUES ';
                $sqlFieldsInsert = 'INSERT INTO '.$this->fieldsTable.' (GROUP_ID, NAME, VALUE, HINT, EXPLANATION, TYPE, LENGHT, HEIGHT, SORT) VALUES ';
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
                                    $sqlFieldsInsert .= "($groupId, '$fieldInfo[name]', '$fieldInfo[default]', '$fieldInfo[hint]',
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
                $sqlRequest = $sqlTabsInsert.$sqlGroupsInsert.$sqlFieldsInsert;
                $this->db->queryExecute($sqlRequest);
                return true;
            }
        }
        return false;
    }
}
