<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php if (!empty($arResult)):?>
    <ul class="top-nav">
        <?php foreach($arResult as $arItem):?>
            <?if (!empty($arItem['SELECTED'])):?>
                <li class="top-nav__link top-nav__link--footer <?=!empty($arItem['SELECTED'])? 'active' : ''?>">
                    <span href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></span>
                </li>
            <?else:?>
                <li class="top-nav__link top-nav__link--footer"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
            <?endif;?>
        <?php endforeach?>
    </ul>
<?php endif?>
