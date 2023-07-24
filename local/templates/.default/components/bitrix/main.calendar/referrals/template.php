<?php if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true) die(); ?>

<div class="referral-calendar" id="calendar">
    с
    <input type="text"
           class="referral-calendar__item"
           id="AirDatepickerMin"
           placeholder="27.09.2022"
    >
    <input type="text"
           placeholder="27.10.2022"
           id="<?=$arParams['INPUT_NAME']?>"
           name="<?=$arParams['INPUT_NAME']?>"
           value="<?=$arParams['INPUT_VALUE']?>"
        <?=(Array_Key_Exists("~INPUT_ADDITIONAL_ATTR", $arParams)) ? $arParams["~INPUT_ADDITIONAL_ATTR"] : ""?>
           onclick="BX.calendar({node:this, field:'<?=htmlspecialcharsbx(CUtil::JSEscape($arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]))?>', form: '<?if ($arParams['FORM_NAME'] != ''){echo htmlspecialcharsbx(CUtil::JSEscape($arParams['FORM_NAME']));}?>', bTime: <?=$arParams['SHOW_TIME'] == 'Y' ? 'true' : 'false'?>, currentTime: '<?=(time()+date("Z")+CTimeZone::GetOffset())?>', bHideTime: <?=$arParams['HIDE_TIMEBAR'] == 'Y' ? 'true' : 'false'?>});"
           onmouseover="BX.addClass(this, 'calendar-icon-hover');"
           onmouseout="BX.removeClass(this, 'calendar-icon-hover');"
    >
    по
    <input type="text"
           class="referral-calendar__item"
           id="AirDatepickerMax"
           placeholder="27.10.2022"
    >
    <input type="text"
           placeholder="27.10.2022"
           id="<?=$arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]?>"
           name="<?=$arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]?>"
           value="<?=$arParams['INPUT_VALUE'.($i == 1 ? '_FINISH' : '')]?>"
        <?=(Array_Key_Exists("~INPUT_ADDITIONAL_ATTR", $arParams)) ? $arParams["~INPUT_ADDITIONAL_ATTR"] : ""?>
           onclick="BX.calendar({node:this, field:'<?=htmlspecialcharsbx(CUtil::JSEscape($arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]))?>', form: '<?if ($arParams['FORM_NAME'] != ''){echo htmlspecialcharsbx(CUtil::JSEscape($arParams['FORM_NAME']));}?>', bTime: <?=$arParams['SHOW_TIME'] == 'Y' ? 'true' : 'false'?>, currentTime: '<?=(time()+date("Z")+CTimeZone::GetOffset())?>', bHideTime: <?=$arParams['HIDE_TIMEBAR'] == 'Y' ? 'true' : 'false'?>});"
           onmouseover="BX.addClass(this, 'calendar-icon-hover');"
           onmouseout="BX.removeClass(this, 'calendar-icon-hover');"
    >
</div>
<input type="text"
       placeholder="27.10.2022"
       id="<?=$arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]?>"
       name="<?=$arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]?>"
       value="<?=$arParams['INPUT_VALUE'.($i == 1 ? '_FINISH' : '')]?>"
    <?=(Array_Key_Exists("~INPUT_ADDITIONAL_ATTR", $arParams)) ? $arParams["~INPUT_ADDITIONAL_ATTR"] : ""?>
       onclick="BX.calendar({node:this, field:'<?=htmlspecialcharsbx(CUtil::JSEscape($arParams['INPUT_NAME'.($i == 1 ? '_FINISH' : '')]))?>', form: '<?if ($arParams['FORM_NAME'] != ''){echo htmlspecialcharsbx(CUtil::JSEscape($arParams['FORM_NAME']));}?>', bTime: <?=$arParams['SHOW_TIME'] == 'Y' ? 'true' : 'false'?>, currentTime: '<?=(time()+date("Z")+CTimeZone::GetOffset())?>', bHideTime: <?=$arParams['HIDE_TIMEBAR'] == 'Y' ? 'true' : 'false'?>});"
       onmouseover="BX.addClass(this, 'calendar-icon-hover');"
       onmouseout="BX.removeClass(this, 'calendar-icon-hover');"
>