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
?>
<div class="profile-error">
    <div class="profile-error__message">
        <span class="profile-error-icon">
            <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#error"></use></svg>
        </span>
        <h4 class="title-block">
            Ваша <span>Учетная запись заблокирована</span>. Вы не можете размещать новые объявления.
            Текущие объявления не публикуются для просмотра другим пользователям.
        </h4>
    </div>
    <div class="reason-blocking">
        <h4 class="title-block title-block--reason">Причина блокировки:</h4>
        <p class="profile-error__text profile-error__text--reason">Безусловно, понимание сути ресурсосберегающих технологий
            позволяет оценить значение глубокомысленных рассуждений. Современные технологии достигли
            такого уровня, что дальнейшее развитие различных форм деятельности предопределяет высокую
            востребованность своевременного выполнения сверхзадачи. Являясь всего лишь частью общей
            картины, элементы политического процесса заблокированы в рамках своих собственных
            рациональных ограничений.
        </p>
        <p class="profile-error__text">Для уточнения деталей вы можете связаться с технической поддержкой.</p>
        <button class="btn-bg contact-support">Связаться с поддержкой</button>
    </div>
</div>

