<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php if (!empty($arParams['AUTH_SERVICES'])):?>
    <span class="login-services__title">Войдите через сервисы:</span>
    <div class="login-services-content">
        <?php foreach ($arParams['AUTH_SERVICES'] as $serviceName => $arSocial):?>
            <div class="login-services__item">
                <span onclick="<?=$arSocial['ONCLICK']?>" id="bx_auth_href_<?=$arParams["SUFFIX"]?><?=$arSocial["ID"]?>">
                    <?php if ($serviceName === 'VKontakte'):?>
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#vk-popup"></use></svg>
                    <?php endif;?>
                    <?php if ($serviceName === 'Facebook'):?>
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#fb"></use></svg>
                    <?php endif;?>
                    <?php if ($serviceName === 'GoogleOAuth'):?>
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#google"></use></svg>
                    <?php endif;?>
                    <?php if ($serviceName === 'YandexOAuth'):?>
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#yandex"></use></svg>
                    <?php endif;?>
                    <?php if ($serviceName === 'MailRu2'):?>
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#mymir"></use></svg>
                    <?php endif;?>
                </span>
            </div>
        <?php endforeach?>
    </div>
<?php endif;?>