<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

/** @global object $USER */
/** @global object $APPLICATION */

use Bitrix\Main\Loader;
use WebCompany\ReferralSystem;


$APPLICATION->SetTitle('Настройки сайта');

$mid = 'webco.settings';

if(!$USER->IsAdmin() || !\Bitrix\Main\Loader::includeModule($mid)) return;

$settingsRefSys = new ReferralSystem();
$arAllOptions = $settingsRefSys->getSettingsTree();
if (empty($arAllOptions)) {
    $settingsRefSys->insertDataToTables();
    $arAllOptions = $settingsRefSys->getSettingsTree();
}

$arTabSettings = [];
foreach ($arAllOptions as $key => $arTab) {
    $arTabSettings[] = [
        "DIV" => "edit".++$key,
        "TAB" => $arTab['tabName'],
        "TITLE" => $arTab['tabTitle']
    ];
}

$tabControl = new CAdminTabControl("tabControl", $arTabSettings);

if($_SERVER["REQUEST_METHOD"] == "POST" && check_bitrix_sessid()) {
    $settingCodes = $settingsRefSys->getSettingCodes();

    if (!empty($_POST['save'])) {
        $saveSettings = [];
        foreach ($_POST as $key => $value) {
            if (in_array($key,$settingCodes)) {
                if ($key === 'subscriptionPrice' && Loader::IncludeModule('catalog')) {
                    $newElementPrice = \Bitrix\Catalog\PriceTable::getByPrimary(1, [
                            'select' => ['PRICE']
                        ]
                    )->fetchObject();
                    $newElementPrice->setPrice($value);
                    $priceResult = $newElementPrice->save();
                }

                $saveSettings[] = [
                    'code' => $key,
                    'value' => $value
                ];
            }
        }
        $saveRes = $settingsRefSys->saveNewSettings($saveSettings);
        $arAllOptions = $settingsRefSys->getSettingsTree();
        $message = 'Настройки сохранены!';
    }

    if (!empty($_POST['default'])) {
        $saveRes = $settingsRefSys->setDefaultSettings();
        $arAllOptions = $settingsRefSys->getSettingsTree();
        $message = 'Установлены настройки по умолчанию!';
    }

}

?>
<?php if (!empty($message)):?>
    <div class="adm-info-message-wrap adm-info-message-green">
        <div class="adm-info-message">
            <div class="adm-info-message-title"><?=$message?></div>
            <div class="adm-info-message-icon"></div>
        </div>
    </div>
<?php endif;?>
<?php $tabControl->Begin();?>
    <form method="post" action="<?=$APPLICATION->GetCurPage()?>?mid=<?=urlencode($mid)?>&amp;lang=<?=LANGUAGE_ID?>">
        <?php foreach($arAllOptions as $optionGroup => $arTabs):?>
            <?php $tabControl->BeginNextTab();?>
            <?php foreach ($arTabs['tabGroups'] as $arGroup):?>
                <?php if (!empty($arGroup['settings'])):?>
                    <?php if (!empty($arGroup['groupName'])):?>
                        <tr class="heading"><td colspan="2"><?=$arGroup['groupName']?></td></tr>
                    <?php endif;?>
                    <?php foreach ($arGroup['settings'] as $arSetting):?>
                        <tr>
                            <td width="40%" nowrap <?=$arSetting['type'][0] == "textarea" ? 'class="adm-detail-valign-top"' : ''?>>
                                <?php if (!empty($arSetting['hint'])):?>
                                    <span id="hint_<?=$arSetting['id'];?>"></span>
                                    <script type="text/javascript">BX.hint_replace(BX('hint_<?=$arSetting['id'];?>'), '<?=\CUtil::JSEscape($arSetting['hint']);?>');</script>&nbsp;
                                <?php endif;?>
                                <label for="<?=$arSetting['id']?>"><?=$arSetting['name']?>:</label>
                            <td width="60%">
                                <?php if($arSetting['type'][0]=="checkbox"):?>
                                    <input type="checkbox" id="<?=$arSetting['id']?>" name="<?=$arSetting['id']?>" value="Y" <?=$arSetting['value'] == "Y" ? " checked" : ''?>>
                                <?php elseif($arSetting['type'][0]=="text"):?>
                                    <input type="text" size="<?=$arSetting['type'][1]?>" maxlength="255" value="<?=$arSetting['value']?>" name="<?=$arSetting['id']?>">
                                <?php elseif($arSetting['type'][0]=="number"):?>
                                    <input type="number" style="width:<?=$arSetting['type'][1]?>em" maxlength="255" value="<?=$arSetting['value']?>" name="<?=$arSetting['id']?>">
                                <?php elseif($arSetting['type'][0]=="textarea"):?>
                                    <textarea rows="<?=$arSetting['type'][1]?>" cols="<?=$arSetting['type'][2]?>" name="<?=$arSetting['id']?>"><?=$arSetting['value']?></textarea>
                                <?php elseif($arSetting['type'][0]=="selectbox"):?>
                                    <select name="<?=$arSetting['id']?>">
                                        <?php foreach ($arSetting['type'][1] as $key => $value):?>
                                            <option value="<?=$key ?>"<?=($key == $val) ? " selected" : "" ?>><?=$value ?></option>
                                        <?php endforeach;?>
                                    </select>
                                <?php endif?>
                                <?php if (!empty($arSetting['explanation'])):?>
                                    <div class="adm-info-message-wrap">
                                        <div class="adm-info-message">
                                            <div id="<?=$arSetting['id'];?>"><?=$arSetting['explanation']?></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
            <?php endforeach;?>
        <?php endforeach?>
        <?php $tabControl->Buttons();?>
        <input type="submit"
               name="save"
               value="Сохранить"
               title="Сохранить изменения"
               class="adm-btn-save"
        >
        <input type="submit"
               name="default"
               title="<?=GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>"
               OnClick="return confirm('<?=AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>')"
               value="По умолчанию"
        >
        <?=bitrix_sessid_post();?>
        <?php $tabControl->End();?>
    </form>
<?php  require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");