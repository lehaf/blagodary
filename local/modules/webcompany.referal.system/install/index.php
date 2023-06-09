<?php
//подключаем основные классы для работы с модулем
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
class webcompany_referal_system extends CModule
{
    public string $componentNameSpace = 'webcompany';
    public array $arModuleComponents = [
        "subscription"
    ];
    public function __construct()
    {
        $this->MODULE_VERSION = '1.0.0';
        $this->MODULE_VERSION_DATE = '15.06.2023';
        $this->MODULE_ID = 'webcompany.referal.system'; // название модуля
        $this->MODULE_NAME = 'Реферальная система'; //описание модуля
        $this->MODULE_DESCRIPTION = 'Модуль управления реферальной системой на сайте';
        $this->MODULE_GROUP_RIGHTS = 'N';  //используем ли индивидуальную схему распределения прав доступа, мы ставим N, так как не используем ее
        $this->PARTNER_NAME = "webcompany"; //название компании партнера предоставляющей модуль
        $this->PARTNER_URI = 'https://webcompany.by/uslugi/razrabotka-sajtov';//адрес вашего сайта
    }

    public function doInstall()
    {
        CopyDirFiles($_SERVER['DOCUMENT_ROOT']."/local/modules/$this->MODULE_ID/install/components",
            $_SERVER['DOCUMENT_ROOT']."/local/components",
            true,
            true
        );
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function doUninstall()
    {
        foreach ($this->arModuleComponents as $componentName) {
            if (strlen($componentName) > 0) {
                DeleteDirFilesEx("/local/components/".$this->componentNameSpace.'/'.$componentName.'/');
            }
        }
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

}