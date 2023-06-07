<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arResult */
/** @const string SITE_TEMPLATE_PATH */

$this->setFrameMode(true);
$this->addExternalCss(SITE_TEMPLATE_PATH . "/assets/components-template/pagination/style.css");


if(!$arResult["NavShowAlways"])
{
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false)) return;
}
?>
<div class="pagination">
    <ul class="pagination-list">
        <?
        $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
        $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
        ?>
        <?
        if($arResult["bDescPageNumbering"] === true):
            $bFirst = true;
            if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
                if($arResult["bSavePage"]):
                    ?>
                    <li class="pagination-list__item">
                        <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"></a>
                    </li>

                <?
                else:
                    if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):
                        ?>
                        <li class="pagination-list__item"><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"></a></li>
                    <?
                    else:
                        ?>
                        <li class="pagination-list__item">
                            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"></a>
                        </li>

                    <?
                    endif;
                endif;

                if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
                    $bFirst = false;
                    if($arResult["bSavePage"]):
                        ?>

                        <li class="pagination-list__item">
                            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">1</a>
                        </li>


                    <?
                    else:
                        ?>
                        <li class="pagination-list__item">
                            <a  href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
                        </li>
                    <?
                    endif;
                    if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):?>

                        <li class="pagination-list__item">
                            <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=intval($arResult["nStartPage"] + ($arResult["NavPageCount"] - $arResult["nStartPage"]) / 2)?>">...</a>
                        </li>


                    <?
                    endif;
                endif;
            endif;
            do
            {
                $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;

                if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                    ?>
                    <li class="pagination-list__item active">
                        <a  href="#"><?=$NavRecordGroupPrint?></a>
                    </li>

                <?
                elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
                    ?>
                    <li class="pagination-list__item">
                        <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" ><?=$NavRecordGroupPrint?></a>
                    </li>
                <?
                else:
                    ?>
                    <li class="pagination-list__item">
                        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" >
                            <?=$NavRecordGroupPrint?>
                        </a>
                    </li>
                <?
                endif;

                $arResult["nStartPage"]--;
                $bFirst = false;
            } while($arResult["nStartPage"] >= $arResult["nEndPage"]);

            if ($arResult["NavPageNomer"] > 1):
                if ($arResult["nEndPage"] > 1):
                    if ($arResult["nEndPage"] > 2):
                        /*?>
                                <span class="modern-page-dots">...</span>
                        <?*/
                        ?>

                        <li class="pagination-list__item paginations__total">
                            <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] / 2)?>">...</a>
                        </li>

                    <?
                    endif;
                    ?>
                    <li class="pagination-list__item">
                        <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=$arResult["NavPageCount"]?></a>
                    </li>

                <?
                endif;

                ?>
                <li class="pagination-list__item">
                    <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><svg class="icon pagination__link-icon" style="width:14px;height:14px;"><use xlink:href="<?=SITE_TEMPLATE_PATH;?>/assets/images/sprite.svg#i-arrow-small"/></svg></a>
                </li>

            <?
            endif;

        else:
            $bFirst = true;

            if ($arResult["NavPageNomer"] > 1):
                if($arResult["bSavePage"]):
                    ?>
                    <li class="pagination-list__item">
                        <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"></a>
                    </li>

                <?
                else:
                    if ($arResult["NavPageNomer"] > 2):
                        ?>
                        <a class="pagination-arrow-left" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-prev"></use>
                            </svg>
                        </a>

                    <?
                    else:
                        ?>
                        <li class="pagination-list__item">
                            <a  href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"></a>
                        </li>

                    <?
                    endif;

                endif;

                if ($arResult["nStartPage"] > 1):
                    $bFirst = false;
                    if($arResult["bSavePage"]):
                        ?>
                        <li class="pagination-list__item">
                            <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a>
                        </li>

                    <?
                    else:
                        ?>
                        <li class="pagination-list__item">
                            <a  href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
                        </li>

                    <?
                    endif;
                    if ($arResult["nStartPage"] > 2):
                        /*?>
                                    <span class="modern-page-dots">...</span>
                        <?*/
                        ?>

                        <li class="pagination-list__item paginations__total">
                            <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nStartPage"] / 2)?>">...</a>
                        </li>

                    <?
                    endif;
                endif;
            endif;

            do
            {
                if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                    ?>
                    <li class="pagination-list__item active">
                        <a  href="#"><?=$arResult["nStartPage"]?></a>
                    </li>
                <?
                elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
                    ?>
                    <li class="pagination-list__item">
                        <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" ><?=$arResult["nStartPage"]?></a>
                    </li>

                <?
                else:
                    ?>

                    <li class="pagination-list__item">
                        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
                        ?> ><?=$arResult["nStartPage"]?></a>
                    </li>



                <?
                endif;
                $arResult["nStartPage"]++;
                $bFirst = false;
            } while($arResult["nStartPage"] <= $arResult["nEndPage"]);

            if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
                if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
                    if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
                        /*?>
                                <span class="modern-page-dots">...</span>
                        <?*/
                        ?>

                        <li class="pagination-list__item">
                            <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)?>">...</a>
                        </li>
                    <?
                    endif;
                    ?>

                    <li class="pagination-list__item">
                        <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a>
                    </li>



                <?
                endif;
                ?>

                <a class="pagination-arrow-right" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-next"></use>
                    </svg>
                </a>
            <?
            endif;
        endif; ?>
    </ul>
</div>