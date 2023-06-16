<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
/** @global string $typeOfView */
$this->setFrameMode(true);
$locationSpritePath = SITE_TEMPLATE_PATH.'/html/assets/img/sprites/sprite.svg#location';
$this->addExternalCss(SITE_TEMPLATE_PATH.'/html/css/loader.css');
$this->addExternalJs(SITE_TEMPLATE_PATH.'/html/js/switcher_view_app.js');
?>
<?if (!empty($arResult['ITEMS'])):?>
    <div class="no-ads no-ads--active">
        <h4 class="title-block"><span>Ваши объявления не показываются. Необходимо оформить подписку.</span></h4>
        <a href="/personal/subscription/" class="btn-bg">Подписаться</a>
    </div>
    <div class="user-list-ads">
        <?foreach ($arResult['ITEMS'] as $arItem):?>
            <?
            // Добавляем эрмитаж
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $arItem["EDIT_LINK_TEXT"]);
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $arItem["DELETE_LINK_TEXT"],
                array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <a id="<?=$this->GetEditAreaID($arItem['ID'])?>" href="<?=$arItem['DETAIL_PAGE_URL']?>" class="announcements-list__item">
                <div class="announcements-img announcements-img--profile">
                    <img src="<?=$arItem['IMG']['src']?>"
                         title="<?=$arItem['NAME']?>"
                         alt="<?=$arItem['NAME']?>"
                    >
                </div>
                <div class="announcements-description announcements-description-profile">
                    <div class="announcements-description__cart">
                        <h3><?=$arItem['NAME']?></h3>
                        <div class="announcements-data"><?=$arItem['TIMESTAMP_X']?></div>
                        <button class="edit-ed">
                            <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#pen"></use></svg>
                            <span>Редактировать объявление</span>
                        </button>
                    </div>
                    <div class="announcements-description__del">
                        <button class="del-ed">
                            <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-cart"></use></svg>
                            <span> Деактивировать</span>
                        </button>
                        <span class="day-active-cart">Товар будет удален автоматически через N дней</span>
                    </div>
                </div>
            </a>
        <?endforeach;?>
        <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
            <br><?=$arResult["NAV_STRING"]?>
        <?endif;?>
    </div>
<?else:?>
    <div class="no-ads">
        <h4 class="title-block">У вас пока нет объявлений.</h4>
        <a href="/personal/my-ads/add-ads/" class="btn-bg">
            <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use></svg>
            Подать объявление
        </a>
    </div>
<?endif;?>