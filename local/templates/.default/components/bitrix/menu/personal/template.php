<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php if (!empty($arResult)):?>
    <ul class="menu-authorized-list">
        <?php foreach($arResult as $arItem):?>
            <?if (!empty($arItem['SELECTED']) && $arItem['SELECTED'] == 'Y'):?>
                <?if (empty($arItem['PARAMS']['PAGES'])):?>
                    <li class="menu-authorized-list__item">
                        <span href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></span>
                    </li>
                <?else:?>
                    <li class="menu-authorized-list__item">
                        <a class="menu-subcategory active" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                        <?if (!empty($arItem['PARAMS']['PAGES'])):?>
                            <div class="menu-subcategory-content" style="display:block">
                                <?php foreach($arItem['PARAMS']['PAGES'] as $innerPageName => $innerPageLink):?>
                                    <?if (!empty($arItem['ACTIVE_MENU_NAME']) && $innerPageName == $arItem['ACTIVE_MENU_NAME']):?>
                                        <span href="<?=$innerPageLink?>"><?=$innerPageName?></span>
                                    <?else:?>
                                        <a href="<?=$innerPageLink?>"><?=$innerPageName?></a>
                                    <?endif;?>
                                <?php endforeach?>
                            </div>
                        <?endif;?>
                    </li>
                <?endif;?>
            <?else:?>
                <li class="menu-authorized-list__item">
                    <a <?=!empty($arItem['PARAMS']['PAGES']) ? 'class="menu-subcategory"' : ''?>
                            href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                    <?if (!empty($arItem['PARAMS']['PAGES'])):?>
                        <div class="menu-subcategory-content">
                            <?php foreach($arItem['PARAMS']['PAGES'] as $innerPageName => $innerPageLink):?>
                                <a href="<?=$innerPageLink?>"><?=$innerPageName?></a>
                            <?php endforeach?>
                        </div>
                    <?endif;?>
                </li>
            <?endif;?>
        <?php endforeach?>
        <li class="menu-authorized-list__item"><a href="/personal/logout/?logout=y">Выйти</a></li>
    </ul>
<?php endif?>


