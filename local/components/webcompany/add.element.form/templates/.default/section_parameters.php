<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?php if (!empty($arResult['SPECIAL_PROPS'])):?>
    <h3 class="title-block title-block--left">Дополнительные параметры для выбранной подкатегории:</h3>
    <?php foreach ($arResult['SPECIAL_PROPS'] as $propId => $prop):?>
        <input type="hidden" name="ADDITIONAL_PROPS" id="ADDITIONAL_PROPS" value='<?=$arResult['ADDITIONAL_PROPS']?>'>
        <?php switch ($prop['PROPERTY_TYPE']): case 'S':?>
                <div class="form-group">
                    <label for="productName" class="data-user__label"><?=$prop['NAME']?>:</label>
                    <input type="text"
                           name="<?=$prop['CODE']?>"
                           id="<?=$prop['ID']?>"
                           value="<?=!empty($_POST[$prop['CODE']]) ? $_POST[$prop['CODE']] : $prop['EDIT_VALUES']?>"
                    >
                 </div>
            <?php break;?>
            <?php case 'N':?>
                <div class="form-container" style="margin: 15px 0px">
                    <label for="rangeStart" class="data-user__label data-user__label--range"><?=$prop['NAME']?>:</label>
                    <div class="form-group-wrapper form-group-wrapper--range">
                        <div class="for-group for-group--range">
                            <input type="number"
                                   name="<?=$prop['CODE']?>"
                                   id="<?=$prop['ID']?>"
                                   value="<?=!empty($_POST[$prop['CODE']]) ? $_POST[$prop['CODE']] : $prop['EDIT_VALUES']?>"
                            >
                        </div>
                    </div>
                </div>
            <?php break;?>
            <?php case 'L':?>
                <?php if ($prop['DISPLAY_TYPE'] === 'P' && $prop['MULTIPLE'] === 'N'):?>
                    <div class="form-group">
                        <label for="<?=$prop['CODE']?>" class="data-user__label"><?=$prop['NAME']?>:</label>
                        <select name="<?=$prop['CODE']?>"
                                class="custom-select"
                                id="<?=$prop['CODE']?>"
                        >
                            <?php if (!empty($prop['VALUES'])):?>
                                 <?php foreach ($prop['VALUES'] as $key => $val):?>
                                    <option value="<?=$val['ID']?>" <?=$key === 0 ? 'selected' : ''?>>
                                        <?=$val['VALUE']?>
                                    </option>
                                <?php endforeach;?>
                            <?php endif;?>
                        </select>
                    </div>
                <?php endif;?>
                <?php if ($prop['DISPLAY_TYPE'] === 'K' && $prop['MULTIPLE'] === 'N'):?>
                    <div class="form-group form-group-100">
                        <label class="data-user__label"><?=$prop['NAME']?>:</label>
                        <div class="form-group-wrapper form-group-radio">
                            <?php if (!empty($prop['VALUES'])):?>
                                <?php foreach ($prop['VALUES'] as $key => $val):?>
                                    <div class="form-group__item">
                                        <label for="<?=$prop['CODE'].$key?>"><?=$val['VALUE']?></label>
                                        <input type="radio"
                                               id="<?=$prop['CODE'].$key?>"
                                               name="<?=$prop['CODE']?>"
                                               value="<?=$val['ID']?>"
                                        >
                                    </div>
                                <?php endforeach;?>
                            <?php endif;?>
                        </div>
                    </div>
                <?php endif;?>
                <?php if ($prop['DISPLAY_TYPE'] === 'F' && $prop['MULTIPLE'] === 'Y'):?>
                    <div class="form-group">
                        <label class="data-user__label"><?=$prop['NAME']?>:</label>
                        <div class="form-group-wrapper checkbox">
                            <?php if (!empty($prop['VALUES'])):?>
                                <?php foreach ($prop['VALUES'] as $key => $val):?>
                                    <div class="form-group__item">
                                        <label for="<?=$prop['CODE'].$key?>" class="label-checkbox">
                                            <input type="checkbox"
                                                   name="<?=$prop['CODE']?>[]"
                                                   id="<?=$prop['CODE'].$key?>"
                                                   value="<?=$val['ID']?>"
                                                   <?=!empty($prop['EDIT_VALUES']) && in_array($val['ID'],$prop['EDIT_VALUES']) ?
                                                       'checked' : (!empty($_POST[$prop['CODE']]) && in_array($val['ID'],$_POST[$prop['CODE']]) ? 'checked' : '')?>
                                            >
                                            <span><?=$val['VALUE']?></span>
                                        </label>
                                    </div>
                                <?php endforeach;?>
                            <?php endif;?>
                        </div>
                    </div>
                <?php endif;?>
            <?php break;?>
        <?php endswitch;?>
    <?php endforeach;?>
<?php endif;?>