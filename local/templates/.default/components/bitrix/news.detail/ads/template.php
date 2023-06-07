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
?>
<?if (!empty($arResult)):?>
    <div class="page-card" id="<?=$this->GetEditAreaID($arResult['ID'])?>">
        <div class="page-card__item page-card__item--slider">
            <div class="card-slider">
                <span class="favorite-card"></span>
                <?if (!empty($arResult['IMAGES'])):?>
                    <div class="card-slider-main">
                        <?foreach ($arResult['IMAGES']['BIG_SLIDER'] as $arImg):?>
                            <div class="card-slider__item">
                                <img src="<?=$arImg['src']?>"
                                     alt="<?=$arResult['NAME']?>"
                                     title="<?=$arResult['NAME']?>"
                                >
                            </div>
                        <?endforeach;?>
                    </div>
                    <div class="card-slider-arrows slider-arrows-container">
                        <div class="card-slider-prev slider-arrow-prev">
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-prev">
                                </use>
                            </svg>
                        </div>
                        <div class="card-slider-next slider-arrow-next">
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-next"></use>
                            </svg>
                        </div>
                    </div>
                    <?if (!empty($arResult['IMAGES']['LITTLE_SLIDER']) && count($arResult['IMAGES']['LITTLE_SLIDER']) > 1):?>
                        <div class="card-slider-main-nav">
                            <?foreach ($arResult['IMAGES']['LITTLE_SLIDER'] as $arImg):?>
                                <div class="card-slider-main-nav__item">
                                    <img src="<?=$arImg['src']?>"
                                         alt="<?=$arResult['NAME']?>"
                                         title="<?=$arResult['NAME']?>"
                                    >
                                </div>
                            <?endforeach;?>
                        </div>
                    <?endif;?>
                <?endif;?>
            </div>
        </div>
        <div class="page-card__item page-card__item--content">
            <div class="card-content">
                <div class="card-content__title">
                    <h2 class="title-section"><?=$arResult['NAME']?></h2>
                    <span class="favorite-card favorite-card--page"></span>
                </div>
                <button class="edit-card">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#edit-card">
                        </use>
                    </svg>
                    Редактировать объявление
                </button>
                <div class="card-info">
                    <div class="card-info__item card-info__item--contact">
                        <div class="card-info__item-container">
                            <h4 class="card-info-title">Контактная информация</h4>
                            <div class="card-info__user">
                                <div class="card-info-person">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#person"></use>
                                    </svg>
                                    Константин
                                </div>
                                <div class="card-info-rating">
                                    <div class="rating-result-text">4,0</div>
                                    <div class="rating-result">
                                        <span class="active"></span>
                                        <span class="active"></span>
                                        <span class="active"></span>
                                        <span class="active"></span>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="total-rating">
                                    <span class="total-rating__text">Оценок:</span>
                                    <span class="total-rating__num">76</span>
                                </div>
                                <a href="#" class="card-info-announcements">
                                    <span class="card-info-announcements__text">Объявлений:</span>
                                    <span class="card-info-announcements__num">2</span>
                                </a>
                            </div>
                            <div class="card-info__phone">
                                <button class="btn-pick-up btn">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#pick-up">
                                        </use>
                                    </svg>
                                    Хочу забрать</button>
                                <ul class="phone-list">
                                    <li class="phone-list__item">
                                        <svg>
                                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#phone-list"></use>
                                        </svg>
                                        <a href="tel:+375296453637">+375 (29) 645-36-37</a>
                                    </li>
                                    <li class="phone-list__item">
                                        <svg>
                                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#phone-list"></use>
                                        </svg>
                                        <a href="tel:+375296453637">+375 (29) 645-36-37</a>
                                    </li>
                                    <li class="phone-list__item">
                                        <svg>
                                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#phone-list"></use>
                                        </svg>
                                        <a href="tel:+375296453637">+375 (29) 645-36-37</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-info__item card-info__item-location">
                        <div class="card-info__item-container">
                            <h4 class="card-info-title">Местоположение</h4>
                            <div class="location-region">
                                <span class="location-region__name">Область:</span>
                                <span class="location-region__data">Гродненская</span>
                            </div>
                            <div class="location-city">
                                <span class="location-city__name">Город / Район:</span>
                                <span class="location-city__data">Партизанский</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="complain">
                            <span class="complain-warning">

                            </span>
                    <span class="complain__text">Пожаловаться на пользователя</span>
                </div>
                <div class="card-description">
                    <h4 class="card-description__title">Характеристики</h4>
                    <ul class="card-description-list">
                        <li class="card-description-list__item">
                            <div class="card-description-list__item-name">Разрешение экрана, пикс</div>
                            <div class="fake-line"></div>
                            <div class="card-description-list__item-result">2280 х 1080</div>
                        </li>
                        <li class="card-description-list__item">
                            <div class="card-description-list__item-name">Оперативная память (RAM), Гб</div>
                            <div class="fake-line"></div>
                            <div class="card-description-list__item-result">32</div>
                        </li>
                        <li class="card-description-list__item">
                            <div class="card-description-list__item-name">Количество SIM-карт</div>
                            <div class="fake-line"></div>
                            <div class="card-description-list__item-result">1</div>
                        </li>
                        <li class="card-description-list__item">
                            <div class="card-description-list__item-name">Операционная система</div>
                            <div class="fake-line"></div>
                            <div class="card-description-list__item-result">Android 8</div>
                        </li>
                        <li class="card-description-list__item">
                            <div class="card-description-list__item-name">Разрешение основной камеры, Мп</div>
                            <div class="fake-line"></div>
                            <div class="card-description-list__item-result">24</div>
                        </li>
                        <li class="card-description-list__item">
                            <div class="card-description-list__item-name">Разрешение фронтальной камеры, Мп</div>
                            <div class="fake-line"></div>
                            <div class="card-description-list__item-result">5</div>
                        </li>
                    </ul>
                    <h4 class="card-description__title">Описание</h4>
                    <div class="card-description-text">
                        <p>Безусловно, понимание сути ресурсосберегающих технологий позволяет оценить значение
                            глубокомысленных рассуждений. Современные технологии достигли такого уровня. </p>
                        <p>Что дальнейшее развитие различных форм деятельности предопределяет высокую
                            востребованность своевременного выполнения сверхзадачи. Являясь всего лишь частью
                            общей картины, элементы политического процесса заблокированы в рамках своих
                            собственных рациональных ограничений.</p>
                        <p>Что дальнейшее развитие различных форм деятельности предопределяет высокую
                            востребованность своевременного выполнения сверхзадачи. Являясь всего лишь
                            частью общей картины, элементы политического процесса заблокированы в рамках
                            своих собственных рациональных ограничений.</p>
                    </div>
                    <div class="card-description-text-btn" >
                        Развернуть описание
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-down"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?endif;?>