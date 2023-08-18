<?php

/** @global object $USER */
/** @global object $APPLICATION */
/** @var string $mid id модуля*/

use WebCompany\ReferralSystem;

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
pr($settingsRefSys->getSettingValue('ops'));
?>
<?if (!empty($message)):?>
    <div class="adm-info-message-wrap adm-info-message-green">
        <div class="adm-info-message">
            <div class="adm-info-message-title"><?=$message?></div>
            <div class="adm-info-message-icon"></div>
        </div>
    </div>
<?endif;?>
<?$tabControl->Begin();?>
<form method="post" action="<?=$APPLICATION->GetCurPage()?>?mid=<?=urlencode($mid)?>&amp;lang=<?=LANGUAGE_ID?>">
	<?foreach($arAllOptions as $optionGroup => $arTabs):?>
        <?$tabControl->BeginNextTab();?>
        <?foreach ($arTabs['tabGroups'] as $arGroup):?>
            <?if (!empty($arGroup['settings'])):?>
                <?if (!empty($arGroup['groupName'])):?>
                    <tr class="heading"><td colspan="2"><?=$arGroup['groupName']?></td></tr>
                <?endif;?>
                <?foreach ($arGroup['settings'] as $arSetting):?>
                    <tr>
                        <td width="40%" nowrap <?=$arSetting['type'][0] == "textarea" ? 'class="adm-detail-valign-top"' : ''?>>
                            <?if (!empty($arSetting['hint'])):?>
                                <span id="hint_<?=$arSetting['id'];?>"></span>
                                <script type="text/javascript">BX.hint_replace(BX('hint_<?=$arSetting['id'];?>'), '<?=\CUtil::JSEscape($arSetting['hint']);?>');</script>&nbsp;
                            <?endif;?>
                            <label for="<?=$arSetting['id']?>"><?=$arSetting['name']?>:</label>
                        <td width="60%">
                            <?if($arSetting['type'][0]=="checkbox"):?>
                                <input type="checkbox" id="<?=$arSetting['id']?>" name="<?=$arSetting['id']?>" value="Y" <?=$arSetting['value'] == "Y" ? " checked" : ''?>>
                            <?elseif($arSetting['type'][0]=="text"):?>
                                <input type="text" size="<?=$arSetting['type'][1]?>" maxlength="255" value="<?=$arSetting['value']?>" name="<?=$arSetting['id']?>">
                            <?elseif($arSetting['type'][0]=="number"):?>
                                <input type="number" style="width:<?=$arSetting['type'][1]?>em" maxlength="255" value="<?=$arSetting['value']?>" name="<?=$arSetting['id']?>">
                            <?elseif($arSetting['type'][0]=="textarea"):?>
                                <textarea rows="<?=$arSetting['type'][1]?>" cols="<?=$arSetting['type'][2]?>" name="<?=$arSetting['id']?>"><?=$arSetting['value']?></textarea>
                            <?elseif($arSetting['type'][0]=="selectbox"):?>
                                <select name="<?=$arSetting['id']?>">
                                    <?foreach ($arSetting['type'][1] as $key => $value):?>
                                        <option value="<?=$key ?>"<?=($key == $val) ? " selected" : "" ?>><?=$value ?></option>
                                    <?endforeach;?>
                                </select>
                            <?endif?>
                            <?if (!empty($arSetting['explanation'])):?>
                                <div class="adm-info-message-wrap">
                                    <div class="adm-info-message">
                                        <div id="<?=$arSetting['id'];?>"><?=$arSetting['explanation']?></div>
                                    </div>
                                </div>
                            <?endif;?>
                        </td>
                    </tr>
                <?endforeach;?>
            <?endif;?>
        <?endforeach;?>
	<?endforeach?>
	<?$tabControl->Buttons();?>
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
	<?$tabControl->End();?>
</form>