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
$this->setFrameMode(true);
$crossSprite = SITE_TEMPLATE_PATH."/html/assets/img/sprites/sprite.svg#cross-cart";
$this->addExternalCss(SITE_TEMPLATE_PATH.'/html/css/loader.css');
?>
<div class="subscription-switch">
    <button class="btn subscription-switch__btn subscription__btn--current active">Активная</button>
    <?php if (!empty($arResult['ORDER_HISTORY'])):?>
        <button class="btn subscription-switch__btn subscription__btn--history">История</button>
    <?php endif;?>
</div>
<div class="subscription-content">
    <div class="profile-current-subscription active">
        <?php if (!empty($arResult['WARNINGS']) || !empty($arResult['ERRORS'])):?>
            <?php $messages = !empty($arResult['WARNINGS']) ? $arResult['WARNINGS'] : $arResult['ERRORS']?>
            <div class="<?=!empty($arResult['WARNINGS']) ? 'subscription-warning' : 'subscription-errors'?>">
                <ul>
                    <?php foreach ($messages as $message):?>
                        <li><?=$message?></li>
                    <?php endforeach;?>
                </ul>
            </div>
        <?php endif;?>
        <?php if ($arResult['SUBSCRIPTION']['ACTIVE'] === true):?>
            <?php if ($arResult['SUBSCRIPTION']['FREE'] === true && $arResult['SUBSCRIPTION']['PAID'] === true):?>
                <div class="current-subscription">
                    <div class="profile-error__message">
                        <h4 class="title-block">
                            Текущая Подписка Бесплатная (по реферальной программе) до <?=$arResult['SUBSCRIPTION']['FREE_DATE']?>
                        </h4>
                    </div>
                    <?php if ($arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true):?>
                        <h4 class="title-block">Платная подписка будет продлена автоматически <?=$arResult['SUBSCRIPTION']['DATE']?></h4>
                    <?php endif;?>
                    <button id="subscriptionAction"
                            data-action="<?=$arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true ? 'unsubscribe' : 'subscribe'?>"
                            class="<?=$arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true ? 'btn btn-red' : 'btn-bg'?>"
                    >
                        <?php if ($arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true):?>
                            <svg><use xlink:href="<?=$crossSprite?>"></use></svg>
                        <?php endif;?>
                        <?=$arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true ? 'Отменить подписку' : 'Оформить автопродление подписки'?>
                    </button>
                </div>
            <?php elseif ($arResult['SUBSCRIPTION']['FREE'] === true && $arResult['SUBSCRIPTION']['PAID'] !== true):?>
                <div class="subscription-content-active">
                    <div class="no-subscription">
                        <div class="profile-error__message">
                            <h4 class="title-block">
                                Текущая Подписка Бесплатная (по реферальной программе) до <?=$arResult['SUBSCRIPTION']['FREE_DATE']?>
                            </h4>
                        </div>
                        <h4 class="title-block">Оформить подписку всего за <?=$arResult['SUBSCRIPTION_PRICE']?> рублей в неделю.</h4>
                        <button id="subscriptionAction" data-action="subscribe" class="btn-bg">Оформить подписку</button>
                    </div>
                </div>
            <?php else:?>
                <div class="current-subscription p-30">
                    <h4 class="title-block">
                        Текущая подписка действительна до <?=$arResult['SUBSCRIPTION']['DATE']?>
                        <?php if ($arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true):?>
                             и будет продлена автоматически <?=$arResult['SUBSCRIPTION']['DATE']?>
                        <?php endif;?>
                    </h4>
                    <button id="subscriptionAction"
                            data-action="<?=$arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true ? 'unsubscribe' : 'subscribe'?>"
                            class="<?=$arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true ? 'btn btn-red' : 'btn-bg'?>"
                    >
                        <?php if ($arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true):?>
                            <svg><use xlink:href="<?=$crossSprite?>"></use></svg>
                        <?php endif;?>
                        <?=$arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true ? 'Отменить подписку' : 'Оформить автопродление подписки'?>
                    </button>
                </div>
            <?php endif?>
        <?php else:?>
            <div class="subscription-content-active">
                <div class="no-subscription">
                    <div class="profile-error__message">
                        <h4 class="title-block">
                            <span><?=$arResult['NO_SUBSCRIPTION_TEXT']?></span>
                        </h4>
                    </div>
                    <h4 class="title-block">Оформить подписку всего за <?=$arResult['SUBSCRIPTION_PRICE']?> рублей в неделю.</h4>
                    <button id="subscriptionAction" data-action="subscribe" class="btn-bg">Оформить подписку</button>
                </div>
            </div>
        <?php endif;?>
    </div>
    <?php if (!empty($arResult['ORDER_HISTORY'])):?>
        <div class="history-subscription" id="target">
            <div class="loader"></div>
            <ul class="history-subscription-list">
                <?php foreach ($arResult['ORDER_HISTORY'] as $orderData):?>
                    <li class="history-subscription-list__item">
                        <div class="history-subscription-data"><?=$orderData['DATE_PAYED']?></div>
                        <div class="history-subscription-description">
                            <?php if ($orderData['FREE'] === 'Y'):?>
                                <span class="strong">БЕСПЛАТНАЯ ПОДПИСКА</span>, за счет реферальной системы на период c <?=$orderData['DATE_SUBSCRIPTION_FROM']?> по <?=$orderData['DATE_SUBSCRIPTION_TO']?>
                            <?php else:?>
                                Приобретена подписка на период с <?=$orderData['DATE_SUBSCRIPTION_FROM']?> по <?=$orderData['DATE_SUBSCRIPTION_TO']?>
                            <?php endif;?>
                        </div>
                    </li>
                <?php endforeach;?>
            </ul>
            <?php
            global $APPLICATION;
            $APPLICATION->IncludeComponent(
                "bitrix:main.pagenavigation",
                "subscription-history",
                array(
                    "NAV_OBJECT" => $arResult['NAVIGATION_OBJECT'],
                    "SEF_MODE" => "N",
                ),
                false
            );
            ?>
        </div>
    <?php endif;?>
</div>
