<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?if (!empty($arParams['AUTH_SERVICES'])):?>
    <span class="login-services__title">Войдите через сервисы:</span>
    <div class="login-services-content">
        <?foreach ($arParams['AUTH_SERVICES'] as $serviceName => $arSocial):?>
            <div class="login-services__item">
                <span onclick="<?=$arSocial['ONCLICK']?>" id="bx_auth_href_<?=$arParams["SUFFIX"]?><?=$arSocial["ID"]?>">
                    <?if ($serviceName === 'VKontakte'):?>
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#vk-popup"></use></svg>
                    <?endif;?>
                    <?if ($serviceName === 'Facebook'):?>
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#fb"></use></svg>
                    <?endif;?>
                    <?if ($serviceName === 'GoogleOAuth'):?>
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#google"></use></svg>
                    <?endif;?>
                    <?if ($serviceName === 'YandexOAuth'):?>
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#yandex"></use></svg>
                    <?endif;?>
                    <?if ($serviceName === 'MailRu2'):?>
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#mymir"></use></svg>
                    <?endif;?>
                </span>
            </div>
        <?endforeach?>
    </div>
<?endif;?>