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
$this->addExternalCss(SITE_TEMPLATE_PATH.'/html/css/loader.css');
?>
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
    <p class="subtitle">Вам выставлена оценка. Оцените пользователя:</p>
    <div class="ads-ratings">
        <div class="ads-ratings__item">
            <h3 class="ads-ratings-title">
                Короткое название объявления
            </h3>
            <div class="ads-ratings-data">
                <div class="ads-ratings-data__img">
                    <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/profile.jpg" alt="img">
                </div>
                <div class="ads-ratings-data__name">Константин</div>
            </div>
            <div class="ads-ratings-assessment">
                <div class="ads-ratings-assessment__text">
                    Выставил вам следующую оценку:
                </div>
                <div class="ads-ratings-assessment__rate">
                    <div class="rating-result">
                        <span class="active"></span>
                        <span class="active"></span>
                        <span class="active"></span>
                        <span class="active"></span>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="ads-ratings-comment">
                <h5>Комментарий к оценке:</h5>
                <p>Безусловно, понимание сути ресурсосберегающих технологий позволяет оценить
                    значение глубокомысленных рассуждений. Современные технологии достигли такого уровня,
                    что дальнейшее развитие различных форм деятельности предопределяет высокую
                    востребованность своевременного выполнения сверхзадачи. Являясь всего лишь частью
                    общей картины, элементы политического процесса заблокированы в рамках своих
                    собственных рациональных ограничений.
                </p>
            </div>
            <button class="btn-bg ads-ratings-btn">Выставить оценку</button>
        </div>
        <div class="ads-ratings__item">
            <h3 class="ads-ratings-title">
                Длинное название объявления с подробным описанием представленного в объявлении товара,
                которое может включать основные характеристики объявления
            </h3>
            <div class="ads-ratings-data">
                <div class="ads-ratings-data__img">
                    <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/profile.jpg" alt="img">
                </div>
                <div class="ads-ratings-data__name">Константин</div>
            </div>
            <div class="ads-ratings-assessment">
                <div class="ads-ratings-assessment__text">
                    Выставил вам следующую оценку:
                </div>
                <div class="ads-ratings-assessment__rate">
                    <div class="rating-result">
                        <span class="active"></span>
                        <span class="active"></span>
                        <span class="active"></span>
                        <span class="active"></span>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="ads-ratings-comment">
                <h5>Комментарий к оценке:</h5>
                <p>Безусловно, понимание сути ресурсосберегающих технологий позволяет оценить
                    значение глубокомысленных рассуждений. Современные технологии достигли такого уровня,
                    что дальнейшее развитие различных форм деятельности предопределяет высокую
                    востребованность своевременного выполнения сверхзадачи. Являясь всего лишь частью
                    общей картины, элементы политического процесса заблокированы в рамках своих
                    собственных рациональных ограничений.
                </p>
            </div>
            <button class="btn-bg ads-ratings-btn">Выставить оценку</button>
        </div>
    </div>
<?endif;?>