<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
$linkSprite = SITE_TEMPLATE_PATH."/html/assets/img/sprites/sprite.svg#referral-link";
?>
<?if (!empty($arResult['REFERRAL_LINK'])):?>
    <div class="referral-program">
        <div class="referral-program__description">Ваша реферальная сылка</div>
        <input type="text"
               name="referral_link"
               class="referral-program__link"
               value="<?=$arResult['REFERRAL_LINK']?>"
               disabled
        >
        <button id="copyReferalLink" class="btn-bg referral-link-btn">Скопировать ссылку
            <svg><use xlink:href="<?=$linkSprite?>"></use></svg>
        </button>
    </div>
<?endif;?>
<div class="description-referral-program">
    <h3 class="title-block referral-program--title"><?=$arResult['REFERRAL_SYSTEM_TITLE']?></h3>
    <?=$arResult['REFERRAL_SYSTEM_DESCRIPTION']?>
</div>
<div class="referral-list">
    <h3 class="title-block referral-program--title">Список рефералов</h3>
    <div class="referral-list__head">
        <div class="referral-calendar" id="calendar">
            с
            <input name="payDateMin"
                   type="text"
                   class="referral-calendar__item"
                   id="AirDatepickerMin"
                   placeholder="25.09.2022"
            >
            по
            <input name="payDateMax"
                   type="text"
                   class="referral-calendar__item"
                   id="AirDatepickerMax"
                   placeholder="27.10.2022"
            >
        </div>
        <div class="btn-bg referral-calendar-btn">Показать</div>
    </div>
    <div class="referral-result">
        <?if (!empty($arResult['REFERRAL_LIST'])):?>
            <ul class="referral-result-list">
                <?foreach ($arResult['REFERRAL_LIST'] as $referral):?>
                    <li class="referral-result-item">
                        <div class="referral-result-item__data"><?=$referral['DATE']?></div>
                        <div class="referral-result-item__user"><?=$referral['NAME']?></div>
                    </li>
                <?endforeach;?>
            </ul>
        <?else:?>
            <div class="referral-result-not">
                В заданный период, не было оплат от рефералов.
            </div>
        <?endif;?>
    </div>
</div>