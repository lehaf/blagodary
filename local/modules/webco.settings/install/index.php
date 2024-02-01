<?php

use Bitrix\Main\ModuleManager;

class webco_settings extends CModule
{
    public function __construct()
    {
        $this->MODULE_VERSION = '1.0.0';
        $this->MODULE_VERSION_DATE = '26.01.2024';
        $this->MODULE_ID = 'webco.settings'; // название модуля
        $this->MODULE_NAME = 'webco.settings'; //описание модуля
        $this->MODULE_DESCRIPTION = 'Модуль дополнительных настроек сайта';
        $this->MODULE_GROUP_RIGHTS = 'N';  //используем ли индивидуальную схему распределения прав доступа, мы ставим N, так как не используем ее
        $this->PARTNER_NAME = "webcompany"; //название компании партнера предоставляющей модуль
        $this->PARTNER_URI = 'https://webcompany.by/uslugi/razrabotka-sajtov';//адрес вашего сайта
    }

    private function copyAdminPages() : void
    {
        $adminFolderPath = __DIR__.'/../admin';
        if (is_dir($adminFolderPath)) {
            $filesList = scandir($adminFolderPath);
            if (!empty($filesList) && count($filesList) > 2) {
                foreach ($filesList as $file) {
                    if ($file !== '.' && $file !== '..' && $file !== 'menu.php'
                        && !file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$file)) {

                        copy(
                            $adminFolderPath.'/'.$file,
                            $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$file
                        );
                    }
                }
            }
        }
    }

    private function deleteAdminPages() : void
    {
        $adminFolderPath = __DIR__.'/../admin';
        if (is_dir($adminFolderPath)) {
            $filesList = scandir($adminFolderPath);
            if (!empty($filesList) && count($filesList) > 2) {
                foreach ($filesList as $file) {
                    if ($file !== '.' && $file !== '..' && $file !== 'menu.php'
                        && file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$file)) {

                        unlink($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$file);
                    }
                }
            }
        }
    }

    private function copyAssets() : void
    {
        if (is_dir(__DIR__.'/assets')) {
            $filesList = scandir(__DIR__.'/assets');
            if (!empty($filesList) && count($filesList) > 2) {
                foreach ($filesList as $file) {
                    if ($file !== '.' && $file !== '..' && is_dir(__DIR__.'/assets/'.$file)
                    && is_dir($_SERVER['DOCUMENT_ROOT'].'/bitrix/'.$file)) {
                        $assetDirListFiles = scandir(__DIR__.'/assets/'.$file);
                        if (!empty($assetDirListFiles) && count($assetDirListFiles) > 2) {
                            $moduleFolderExist = is_dir($_SERVER['DOCUMENT_ROOT'].'/bitrix/'.$file.'/'.$this->MODULE_ID);
                            if ($moduleFolderExist === false) mkdir($_SERVER['DOCUMENT_ROOT'].'/bitrix/'.$file.'/'.$this->MODULE_ID);

                            foreach ($assetDirListFiles as $assetFile) {
                                if (is_dir($_SERVER['DOCUMENT_ROOT'].'/bitrix/'.$file.'/'.$this->MODULE_ID) &&
                                !file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/'.$file.'/'.$this->MODULE_ID.'/'.$assetFile)) {
                                    copy(
                                        __DIR__.'/assets/'.$file.'/'.$assetFile,
                                        $_SERVER['DOCUMENT_ROOT'].'/bitrix/'.$file.'/'.$this->MODULE_ID.'/'.$assetFile
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    private function deleteAssets() : void
    {
        if (is_dir(__DIR__.'/assets')) {
            $filesList = scandir(__DIR__.'/assets');
            if (!empty($filesList) && count($filesList) > 2) {
                foreach ($filesList as $file) {
                    if ($file !== '.' && $file !== '..' && is_dir(__DIR__.'/assets/'.$file)
                        && is_dir($_SERVER['DOCUMENT_ROOT'].'/bitrix/'.$file)
                        && is_dir($_SERVER['DOCUMENT_ROOT'].'/bitrix/'.$file.'/'.$this->MODULE_ID)) {

                        $assetDirListFiles = scandir($_SERVER['DOCUMENT_ROOT'].'/bitrix/'.$file.'/'.$this->MODULE_ID);
                        if (!empty($assetDirListFiles) && count($assetDirListFiles) > 2) {
                            foreach ($assetDirListFiles as $assetFile) {
                                if ($assetFile === '.' || $assetFile === '..') continue;
                                unlink($_SERVER['DOCUMENT_ROOT'].'/bitrix/'.$file.'/'.$this->MODULE_ID.'/'.$assetFile);
                            }
                        }
                        rmdir($_SERVER['DOCUMENT_ROOT'].'/bitrix/'.$file.'/'.$this->MODULE_ID);
                    }
                }
            }
        }
    }

    public function doInstall()
    {
        global $DB, $APPLICATION;
        $this->errors = false;

        if (file_exists(__DIR__."/db/mysql/install.sql")) {
            $this->errors = $DB->RunSQLBatch(__DIR__."/db/mysql/install.sql");
        }

        if($this->errors !== false) {
            $APPLICATION->ThrowException(implode("", $this->errors));
            return false;
        }

        $this->copyAssets();
        $this->copyAdminPages();
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function doUninstall()
    {
        global $DB, $APPLICATION;
        $this->errors = false;

        if (file_exists(__DIR__."/db/mysql/uninstall.sql")) {
            $this->errors = $DB->RunSQLBatch(__DIR__."/db/mysql/uninstall.sql");
        }

        if($this->errors !== false) {
            $APPLICATION->ThrowException(implode("", $this->errors));
            return false;
        }

        $this->deleteAssets();
        $this->deleteAdminPages();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

}