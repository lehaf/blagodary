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
?>
<?if (!empty($arResult['ITEMS'])):?>
    <?if (empty($arResult['BLOCKED'])):?>
        <div class="no-ads no-ads--active">
            <h4 class="title-block"><span>Ваши объявления не показываются. Необходимо оформить подписку.</span></h4>
            <a href="/personal/subscription/" class="btn-bg">Подписаться</a>
        </div>
    <?endif;?>
    <div class="loader-container">
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
                            <div class="announcements-data"><?=$arItem['DATE_CREATE']?></div>
                            <button class="edit-ed">
                                <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#pen"></use></svg>
                                <span class="edit-link" data-edit-link="<?=$arItem['EDIT_PAGE_URL']?>">Редактировать объявление</span>
                            </button>
                        </div>
                        <div class="announcements-description__del">
                            <button class="del-ed">
                                <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-cart"></use></svg>
                                <span class="deactivate-btn" data-item-name="<?=$arItem['NAME']?>" data-item-id="<?=$arItem['ID']?>"> Деактивировать</span>
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
    </div>
    <?// Форма деактивации объявления?>
    <div id="popUp-rate" class="popUp popUp-rate">
        <h5 class="popUp__title">Выставить оценку</h5>
        <p class="popUp__subtitle">
            Выберите пользователя из списка ниже, с тем, с кем вы созванивались.
            Список формируется из пользователей, которые на карточке объявления вашего
            товара нажали кнопку “Хочу забрать”:
        </p>
        <span class="modal-cross">
            <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use></svg>
        </span>
        <div class="person-list-container ">
            <ul class="person-list-list"></ul>
        </div>
        <form id="rate-form" action="" class="popUp-form">
            <div class="form-group form-group-rate">
                <label class="popUp-form-label popUp-form-label--rate">Выставить оценку:</label>
                <div class="rating-area">
                    <input type="radio" id="star-50" name="RATING" value="5">
                    <label for="star-50" title="Оценка «5»"></label>
                    <input type="radio" id="star-40" name="RATING" value="4">
                    <label for="star-40" title="Оценка «4»"></label>
                    <input type="radio" id="star-30" name="RATING" value="3">
                    <label for="star-30" title="Оценка «3»"></label>
                    <input type="radio" id="star-20" name="RATING" value="2">
                    <label for="star-20" title="Оценка «2»"></label>
                    <input type="radio" id="star-10" name="RATING" value="1">
                    <label for="star-10" title="Оценка «1»"></label>
                </div>
            </div>
            <div class="form-group">
                <label class="popUp-form-label">Комментарий к оценке:*</label>
                <label>
                    <textarea name="COMMENT" placeholder="Текст сообщения."></textarea>
                </label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-bg popUp-rate-btn">Отправить</button>
            </div>
        </form>
    </div>
<?else:?>
    <?if (empty($arResult['BLOCKED'])):?>
        <div class="no-ads">
            <h4 class="title-block">У вас пока нет объявлений.</h4>
            <a href="/personal/my-ads/add-ads/" class="btn-bg">
                <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use></svg>
                Подать объявление
            </a>
        </div>
    <?endif;?>
<?endif;?>