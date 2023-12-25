<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponentTemplate $this */
/** @var PageNavigationComponent $component */

$component = $this->getComponent();
$this->setFrameMode(true);
?>

<div class="pagination">
    <ul class="pagination-list">
        <?php if($arResult["REVERSED_PAGES"] === true):?>
            <?php if ($arResult["CURRENT_PAGE"] < $arResult["PAGE_COUNT"]):?>
                <?php if (($arResult["CURRENT_PAGE"]+1) == $arResult["PAGE_COUNT"]):?>
                    <a class="pagination-arrow-left" href="<?=htmlspecialcharsbx($arResult["URL"])?>">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-prev"></use>
                        </svg>
                    </a>
                <?php else:?>
                    <a class="pagination-arrow-left" href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]+1))?>">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-prev"></use>
                        </svg>
                    </a>
                <?php endif?>
                    <li class="pagination-list__item"><a href="<?=htmlspecialcharsbx($arResult["URL"])?>">1</a></li>
            <?php else:?>
                <li class="pagination-list__item active"><a onclick="return false">1<a/></li>
            <?php endif?>

            <?php
            $page = $arResult["START_PAGE"] - 1;
            while($page >= $arResult["END_PAGE"] + 1):
            ?>
                <?php if ($page == $arResult["CURRENT_PAGE"]):?>
                <li class="pagination-list__item active"><a onclick="return false"><?=($arResult["PAGE_COUNT"] - $page + 1)?></a></li>
            <?php else:?>
                    <li class="pagination-list__item">
                        <a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($page))?>"><?=($arResult["PAGE_COUNT"] - $page + 1)?></a>
                    </li>
            <?php endif?>

                <?php $page--?>
            <?php endwhile?>

            <?php if ($arResult["CURRENT_PAGE"] > 1):?>
                <?php if($arResult["PAGE_COUNT"] > 1):?>
                    <li class="pagination-list__item"><a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate(1))?>"><?=$arResult["PAGE_COUNT"]?></a></li>
                <?php endif?>
                <a class="pagination-arrow-right" href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]-1))?>">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-next"></use>
                    </svg>
                </a>
            <?php else:?>
                <?php if($arResult["PAGE_COUNT"] > 1):?>
                    <li class="pagination-list__item active"><a onclick="return false"><?=$arResult["PAGE_COUNT"]?></a></li>
                <?php endif?>
                <li class="pagination-arrow-right" href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]+1))?>">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-next"></use>
                    </svg>
                </li>
            <?php endif?>

        <?php else:?>

            <?php if ($arResult["CURRENT_PAGE"] > 1):?>
                <?php if ($arResult["CURRENT_PAGE"] > 2):?>
                    <a class="pagination-arrow-left" href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]-1))?>">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-prev"></use>
                        </svg>
                    </a>
                <?php else:?>
                    <a class="pagination-arrow-left" href="<?=htmlspecialcharsbx($arResult["URL"])?>">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-prev"></use>
                        </svg>
                    </a>
                <?php endif?>
                    <li class="pagination-list__item"><a href="<?=htmlspecialcharsbx($arResult["URL"])?>">1</a></li>
            <?php else:?>
                    <li class="pagination-list__item active"><a onclick="return false">1</a></li>
            <?php endif?>

            <?php
            $page = $arResult["START_PAGE"] + 1;
            while($page <= $arResult["END_PAGE"]-1):
            ?>
                <?php if ($page == $arResult["CURRENT_PAGE"]):?>
                <li class="pagination-list__item active"><a onclick="return false"><?=$page?></a></li>
            <?php else:?>
                    <li class="pagination-list__item">
                        <a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($page))?>"><?=$page?></a>
                    </li>
            <?php endif?>
                <?php $page++?>
            <?php endwhile?>

            <?php if($arResult["CURRENT_PAGE"] < $arResult["PAGE_COUNT"]):?>
                <?php if($arResult["PAGE_COUNT"] > 1):?>
                    <li class="pagination-list__item">
                        <a href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["PAGE_COUNT"]))?>"><?=$arResult["PAGE_COUNT"]?></a>
                    </li>
                <?php endif?>
                <a class="pagination-arrow-right" href="<?=htmlspecialcharsbx($component->replaceUrlTemplate($arResult["CURRENT_PAGE"]+1))?>">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-next"></use>
                    </svg>
                </a>
            <?php else:?>
                <?php if($arResult["PAGE_COUNT"] > 1):?>
                    <li class="pagination-list__item active"><a onclick="return false"><?=$arResult["PAGE_COUNT"]?></a></li>
                <?php endif?>

            <?php endif?>
        <?php endif?>
    </ul>
</div>
