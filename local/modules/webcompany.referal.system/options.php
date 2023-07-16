<?php

/** @global object $USER */
/** @global object $APPLICATION */
/** @var string $mid id модуля*/

if(!$USER->IsAdmin() || !\Bitrix\Main\Loader::includeModule($mid)) return;

$arAllOptions = require_once '.options.settings.php';
$arTabSettings = [];
foreach ($arAllOptions as $key => $arTab) {
    $arTabSettings[] = [
        "DIV" => "edit".++$key,
        "TAB" => $arTab['tabName'],
        "TITLE" => $arTab['tabTitle']
    ];
}
$tabControl = new CAdminTabControl("tabControl", $arTabSettings);

if($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['Update'] || $_POST['Apply'] || $_POST['RestoreDefaults'])>0 && check_bitrix_sessid()) {
	if($_POST['RestoreDefaults'] <> '') {
		$arDefValues = $arDefaultValues['default'];
		foreach($arDefValues as $key=>$value)
		{
			COption::RemoveOption("messageservice", $key);
		}
	} else {
		foreach($arAllOptions as $arOption)
		{
			$name=$arOption[0];
			$val=$_REQUEST[$name];
			if($arOption[3][0]=="checkbox" && $val!="Y")
				$val="N";
			COption::SetOptionString("messageservice", $name, $val, $arOption[1]);
		}
	}
	if($_POST['Update'] <> '' && $_REQUEST["back_url_settings"] <> '')
		LocalRedirect($_REQUEST["back_url_settings"]);
	else
		LocalRedirect($APPLICATION->GetCurPage()."?mid=".urlencode($mid)."&lang=".urlencode(LANGUAGE_ID)."&back_url_settings=".urlencode($_REQUEST["back_url_settings"])."&".$tabControl->ActiveTabParam());
}


$tabControl->Begin();
?>
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
                                <input type="checkbox" id="<?=$arSetting['id']?>" name="<?=$arSetting['id']?>" value="Y" <?=$arSetting['default'] == "Y" ? " checked" : ''?>>
                            <?elseif($arSetting['type'][0]=="text"):?>
                                <input type="text" size="<?=$arSetting['type'][1]?>" maxlength="255" value="<?=$arSetting['default']?>" name="<?=$arSetting['id']?>">
                            <?elseif($arSetting['type'][0]=="number"):?>
                                <input type="number" style="width:<?=$arSetting['type'][1]?>em" maxlength="255" value="<?=$arSetting['default']?>" name="<?=$arSetting['id']?>">
                            <?elseif($arSetting['type'][0]=="textarea"):?>
                                <textarea rows="<?=$arSetting['type'][1]?>" cols="<?=$arSetting['type'][2]?>" name="<?=$arSetting['id']?>"><?=$arSetting['default']?></textarea>
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
           name="Update"
           value="Сохранить"
           title="Сохранить изменения"
           class="adm-btn-save"
    >
	<?if($_REQUEST["back_url_settings"] <> ''):?>
		<input type="button"
               name="Cancel"
               value="<?=GetMessage("MAIN_OPT_CANCEL")?>"
               title="<?=GetMessage("MAIN_OPT_CANCEL_TITLE")?>"
               onclick="window.location='<?=htmlspecialcharsbx(CUtil::addslashes($_REQUEST["back_url_settings"]))?>'"
        >
		<input type="hidden"
               name="back_url_settings"
               value="<?=htmlspecialcharsbx($_REQUEST["back_url_settings"])?>"
        >
	<?endif?>
	<input type="submit"
           name="RestoreDefaults"
           title="<?=GetMessage("MAIN_HINT_RESTORE_DEFAULTS")?>"
           OnClick="return confirm('<?=AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>')"
           value="По умолчанию"
    >
    <?=bitrix_sessid_post();?>
	<?$tabControl->End();?>
</form>