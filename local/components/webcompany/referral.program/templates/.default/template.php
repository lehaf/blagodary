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
    <h3 class="title-block referral-program--title">Описание реферальной программы</h3>
    <p>
        Реферальная программа работает по следующей Логике:
        Пользователя есть реферальная ссылка, которой он делится среди своего окружения.
        Если в течении N1 дней, по реферальной ссылке оплатили N2 (кол-во) пользователей,
        то текущему владельцу реферальной ссылки автоматически начисляется N3 дней доступа
        к базе контактов и возможности размещения объявлений, сразу после оплаты действующей
        Подписки (т.е. После того как прошло N3 дней (N3 дней – это доступ к базе контактов и
        возможности размещения объявлений), с карты автоматически за этот период не списываются
        деньги, а действует Бесплатная "подписка" по реферальной системе. И пользователю на почту
        должно прийти уведомление, что за данный период у него будет действовать Бесплатная подписка.
        После того как Бесплатная "подписка" заканчивается продолжает отрабатывать платная подписка,
        в случае ее активации.).
    </p>
    <p>
        А если не было вообще платной подписки,, а условия по реферальной системе были выполнены,
        как описано выше, то сразу после самого последнего платежа реферала стартует подписка.
        В этом случае пользователю на почту должно прийти письмо с уведомлением, что стартовала
        Бесплатная подписка.
    </p>
    <p>
        Если в течении N1 дней, оплатило меньше пользователей чем N2, то текущие
        рефералы сгорают.В рефералы пользователь зачисляется единожды только после первой своей оплаты.
    </p>
</div>
<div class="referral-list">
    <h3 class="title-block referral-program--title">Список рефералов</h3>
    <div class="referral-list__head">
        <div class="referral-calendar" id="calendar">
            с
            <input type="text" class="referral-calendar__item" id="AirDatepickerMin" placeholder="27.09.2022">
            по
            <input type="text" class="referral-calendar__item" id="AirDatepickerMax" placeholder="27.10.2022">
        </div>
        <div class="btn-bg referral-calendar-btn">Показать</div>
    </div>
    <div class="referral-result">
        <?if (!empty($arResult['REFERRAL_LIST'])):?>
            <ul class="referral-result-list">
                <?foreach ($arResult['REFERRAL_LIST'] as $referral):?>
                    <li class="referral-result-item">
                        <div class="referral-result-item__data">26.09.2022</div>
                        <div class="referral-result-item__user"><?=$referral?></div>
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
