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
$crossSprite = SITE_TEMPLATE_PATH."/html/assets/img/sprites/sprite.svg#cross-cart";
?>
<div class="subscription-switch">
    <button class="btn subscription-switch__btn subscription__btn--current active">Активная</button>
    <?if (!empty($arResult['ORDER_HISTORY'])):?>
        <button class="btn subscription-switch__btn subscription__btn--history">История</button>
    <?endif;?>
</div>
<div class="subscription-content">
    <div class="profile-current-subscription active">
        <?if ($arResult['SUBSCRIPTION']['ACTIVE'] === true):?>
            <?if ($arResult['SUBSCRIPTION']['FREE'] === true && $arResult['SUBSCRIPTION']['PAID'] === true):?>
                <div class="current-subscription">
                    <div class="profile-error__message">
                        <h4 class="title-block">
                            Текущая Подписка Бесплатная (по реферальной программе) до <?=$arResult['SUBSCRIPTION']['FREE_DATE']?>
                        </h4>
                    </div>
                    <h4 class="title-block">Платная подписка будет продлена автоматически <?=$arResult['SUBSCRIPTION']['DATE']?></h4>
                    <button id="subscriptionAction" data-action="unsubscribe" class="btn btn-red">
                        <svg><use xlink:href="<?=$crossSprite?>"></use></svg>
                        Отменить подписку
                    </button>
                </div>
            <?elseif ($arResult['SUBSCRIPTION']['FREE'] === true && $arResult['SUBSCRIPTION']['PAID'] !== true):?>
                <div class="subscription-content-active">
                    <div class="no-subscription">
                        <div class="profile-error__message">
                            <h4 class="title-block">
                                Текущая Подписка Бесплатная (по реферальной программе) до <?=$arResult['SUBSCRIPTION']['FREE_DATE']?>
                            </h4>
                        </div>
                        <h4 class="title-block">Оформить подписку всего за N рублей в неделю.</h4>
                        <button id="subscriptionAction" data-action="subscribe" class="btn-bg">Оформить подписку</button>
                    </div>
                </div>
            <?else:?>
                <div class="current-subscription p-30">
                    <h4 class="title-block">
                        Текущая подписка действительна до <?=$arResult['SUBSCRIPTION']['DATE']?>
                        <?if ($arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true):?>
                             и будет продлена автоматически <?=$arResult['SUBSCRIPTION']['DATE']?>
                        <?endif;?>
                    </h4>
                    <button id="subscriptionAction"
                            data-action="<?=$arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true ? 'unsubscribe' : 'subscribe'?>"
                            class="<?=$arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true ? 'btn btn-red' : 'btn-bg'?>"
                    >
                        <?if ($arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true):?>
                            <svg><use xlink:href="<?=$crossSprite?>"></use></svg>
                        <?endif;?>
                        <?=$arResult['SUBSCRIPTION']['PAID_CONFIRM'] === true ? 'Отменить подписку' : 'Оформить подписку'?>
                    </button>
                </div>
            <?endif?>
        <?else:?>
            <div class="subscription-content-active">
                <div class="no-subscription">
                    <div class="profile-error__message">
                        <h4 class="title-block">
                            <span>У вас нет подписки.<br>
                            Вы не можете просматривать контакты владельцев объявлений и размещать объявления.</span>
                        </h4>
                    </div>
                    <h4 class="title-block">Оформить подписку всего за N рублей в неделю.</h4>
                    <button id="subscriptionAction" data-action="subscribe" class="btn-bg">Оформить подписку</button>
                </div>
            </div>
        <?endif;?>
    </div>
    <?if (!empty($arResult['ORDER_HISTORY'])):?>
        <div class="history-subscription">
            <ul class="history-subscription-list">
                <li class="history-subscription-list__item">
                    <div class="history-subscription-data">26.09.2022 </div>
                    <div class="history-subscription-description">
                        <span class="strong">БЕСПЛАТНАЯ ПОДПИСКА</span>, за счет реферальной системы на период  с 19.04.2022 16-50 по 25.04.2022 16:50
                    </div>
                </li>
                <?foreach ($arResult['ORDER_HISTORY'] as $orderData):?>
                    <li class="history-subscription-list__item">
                        <div class="history-subscription-data"><?=$orderData['DATE_PAYED']?></div>
                        <div class="history-subscription-description">
                            Приобретена подписка на период с <?=$orderData['DATE_SUBSCRIPTION_FROM']?> по <?=$orderData['DATE_SUBSCRIPTION_TO']?>
                        </div>
                    </li>
                <?endforeach;?>
            </ul>
            <?if (!empty($arResult['ORDER_PAGINATION'])):?>
                <div class="pagination">
                    <?if (!empty($arResult['ORDER_PAGINATION']['LEFT_ARROW_LINK'])):?>
                        <a href="<?=$arResult['ORDER_PAGINATION']['LEFT_ARROW_LINK']?>" class="pagination-arrow-left">
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-prev"></use>
                            </svg>
                        </a>
                    <?endif;?>
                    <ul class="pagination-list">
                        <?foreach ($arResult['ORDER_PAGINATION']['PAGES'] as $pageNumber => $pageLink):?>
                            <li class="pagination-list__item <?=$arResult['ORDER_PAGINATION']['CUR_PAGE'] === $pageNumber ? 'active' : ''?>">
                                <a href="<?=$pageLink?>"><?=$pageNumber?></a>
                            </li>
                        <?endforeach;?>
                    </ul>
                    <?if (!empty($arResult['ORDER_PAGINATION']['RIGHT_ARROW_LINK'])):?>
                        <a href="<?=$arResult['ORDER_PAGINATION']['RIGHT_ARROW_LINK']?>" class="pagination-arrow-right">
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-next"></use>
                            </svg>
                        </a>
                    <?endif;?>
                </div>
            <?endif;?>
        </div>
    <?endif;?>
</div>
