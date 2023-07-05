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
$isUserAuthorized = $USER->IsAuthorized();
$curUserId = $USER->GetId();
$this->setFrameMode(true);
?>
<?if (!empty($arResult)):?>
    <div class="page-card" id="<?=$this->GetEditAreaID($arResult['ID'])?>">
        <div class="page-card__item page-card__item--slider">
            <div class="card-slider">
                <span data-item="<?=$arResult['ID']?>" class="favorite-card"></span>
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
                    <span data-item="<?=$arResult['ID']?>" class="favorite-card favorite-card--page"></span>
                </div>
                <?if ($curUserId === $arResult['OWNER']['ID']):?>
                    <a href="/personal/my-ads/add-ads/?item=<?=$arResult['ID']?>" class="edit-card">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#edit-card">
                            </use>
                        </svg>
                        Редактировать объявление
                    </a>
                <?endif;?>
                <div class="card-info">
                    <?if (!empty($arResult['OWNER']['ID']) && !empty($arResult['PROPERTIES']['OWNER_NAME']['VALUE'])):?>
                        <div class="card-info__item card-info__item--contact">
                            <div class="card-info__item-container">
                                <h4 class="card-info-title">Контактная информация</h4>
                                <div class="card-info__user">
                                    <div class="card-info-person">
                                        <svg>
                                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#person"></use>
                                        </svg>
                                        <?=$arResult['PROPERTIES']['OWNER_NAME']['VALUE']?>
                                    </div>
                                    <?if (!empty($arResult['RATING']['TOTAL'])):?>
                                        <div class="card-info-rating">
                                            <div class="rating-result-text"><?=$arResult['RATING']['TOTAL']?></div>
                                            <div class="rating-result">
                                                <span class="<?=$arResult['RATING']['TOTAL'] >= 1 ? 'active' : ''?>"></span>
                                                <span class="<?=$arResult['RATING']['TOTAL'] >= 2 ? 'active' : ''?>"></span>
                                                <span class="<?=$arResult['RATING']['TOTAL'] >= 3 ? 'active' : ''?>"></span>
                                                <span class="<?=$arResult['RATING']['TOTAL'] >= 4 ? 'active' : ''?>"></span>
                                                <span class="<?=$arResult['RATING']['TOTAL'] >= 5 ? 'active' : ''?>"></span>
                                            </div>
                                        </div>
                                    <?endif;?>
                                    <?if (!empty($arResult['RATING']['REVIEWS_COUNT'])):?>
                                        <div class="total-rating">
                                            <span class="total-rating__text">Оценок:</span>
                                            <span class="total-rating__num"><?=$arResult['RATING']['REVIEWS_COUNT']?></span>
                                        </div>
                                    <?endif;?>
                                    <?if (!empty($arResult['OWNER']['ADS_COUNT'])):?>
                                        <a href="#" class="card-info-announcements">
                                            <span class="card-info-announcements__text">Объявлений:</span>
                                            <span class="card-info-announcements__num"><?=$arResult['OWNER']['ADS_COUNT']?></span>
                                        </a>
                                    <?endif;?>
                                </div>
                                <?if (!empty($arResult['PROPERTIES']['OWNER_PHONE']['VALUE']) && $curUserId !== $arResult['OWNER']['ID']):?>
                                    <div class="card-info__phone">
                                        <button data-ads-id="<?=$arResult['ID']?>"
                                                class="btn btn-pick-up <?=!$isUserAuthorized ? 'sign-in-modal' : ''?>"
                                        >
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#pick-up">
                                                </use>
                                            </svg>
                                            Хочу забрать
                                        </button>
                                        <?if ($isUserAuthorized):?>
                                            <ul class="phone-list">
                                                <?foreach ($arResult['PROPERTIES']['OWNER_PHONE']['VALUE'] as $phone):?>
                                                    <li class="phone-list__item">
                                                        <svg>
                                                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#phone-list"></use>
                                                        </svg>
                                                        <a href="tel:<?=$phone?>"><?=$phone?></a>
                                                    </li>
                                                <?endforeach;?>
                                            </ul>
                                        <?endif;?>
                                    </div>
                                <?endif;?>
                            </div>
                        </div>
                    <?endif;?>
                    <?if (!empty($arResult['PROPERTIES']['REGION']['VALUE']) && !empty($arResult['PROPERTIES']['CITY']['VALUE'])):?>
                        <div class="card-info__item card-info__item-location">
                            <div class="card-info__item-container">
                                <h4 class="card-info-title">Местоположение</h4>
                                <div class="location-region">
                                    <span class="location-region__name">Область:</span>
                                    <span class="location-region__data"><?=$arResult['PROPERTIES']['REGION']['VALUE']?></span>
                                </div>
                                <div class="location-city">
                                    <span class="location-city__name">Город / Район:</span>
                                    <span class="location-city__data"><?=$arResult['PROPERTIES']['CITY']['VALUE']?></span>
                                </div>
                            </div>
                        </div>
                    <?endif;?>
                </div>
                <div class="complain">
                    <span class="complain-warning"></span>
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
                    <?if (!empty($arResult['DETAIL_TEXT'])):?>
                        <h4 class="card-description__title">Описание</h4>
                        <div class="card-description-text">
                            <?=$arResult['DETAIL_TEXT']?>
                        </div>
                        <div class="card-description-text-btn" >
                            Развернуть описание
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-down"></use>
                            </svg>
                        </div>
                    <?endif;?>
                </div>
            </div>
        </div>
    </div>
<?endif;?>

<?if (!empty($arResult['RATING'])):?>
    <div class="popUp popUp-grade">
        <h5 class="popUp__title">Оценки пользователей</h5>
        <span class="modal-cross">
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
                </svg>
            </span>
        <p class="popUp-grade__description">
            Рейтинг пользователя складывается из оценок тех, кто забирает вещи и тех, кто отдает
        </p>
        <div class="popUp-grade-content">
            <div class="popUp-grade-result">
                <div class="card-info-rating">
                    <div class="rating-result-text"><?=$arResult['RATING']['TOTAL']?></div>
                    <div class="rating-result">
                        <span class="<?=$arResult['RATING']['TOTAL'] >= 1 ? 'active' : ''?>"></span>
                        <span class="<?=$arResult['RATING']['TOTAL'] >= 2 ? 'active' : ''?>"></span>
                        <span class="<?=$arResult['RATING']['TOTAL'] >= 3 ? 'active' : ''?>"></span>
                        <span class="<?=$arResult['RATING']['TOTAL'] >= 4 ? 'active' : ''?>"></span>
                        <span class="<?=$arResult['RATING']['TOTAL'] >= 5 ? 'active' : ''?>"></span>
                    </div>
                </div>
                <div class="popUp-grade-result-text">
                    Средняя оценка пользователя
                </div>
                <div class="total-reviews">
                    <div class="total-reviews__text">
                        Всего отзывов:
                    </div>
                    <div class="total-reviews__score">
                        <?=$arResult['RATING']['REVIEWS_COUNT']?>
                    </div>
                </div>
            </div>
            <?if (!empty($arResult['RATING']['LIST'])):?>
                <div class="grade-list-container">
                    <ul class="grade-list">
                        <?foreach ($arResult['RATING']['LIST'] as $arUser):?>
                            <li class="grade-list__item">
                                <div class="card-info-rating">
                                    <div class="rating-name-user"><?=$arUser['NAME']?></div>
                                    <div class="rating-result">
                                        <span class="<?=$arUser['RATTING'] >= 1 ? 'active' : ''?>"></span>
                                        <span class="<?=$arUser['RATTING'] >= 2 ? 'active' : ''?>"></span>
                                        <span class="<?=$arUser['RATTING'] >= 3 ? 'active' : ''?>"></span>
                                        <span class="<?=$arUser['RATTING'] >= 4 ? 'active' : ''?>"></span>
                                        <span class="<?=$arUser['RATTING'] >= 5 ? 'active' : ''?>"></span>
                                    </div>
                                </div>
                                <div class="rating-data"><?=$arUser['DATE']?></div>
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
            <?endif;?>
        </div>
    </div>
<?endif;?>

<div class="popUp popUp-complain">
    <h5 class="popUp__title">Пожаловаться на пользователя</h5>
    <span class="modal-cross">
            <svg>
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
            </svg>
        </span>
    <form action="#" class="complain-form">
        <div class="form-group">
            <label class="complain-form-label">Причина жалобы:</label>
            <div class="form-group-wrapper">
                <div class="form-group__item radio-btn">
                    <label for="value-1">Вариант 1</label>
                    <input type="radio" name="complain" checked id="value-1">
                </div>
                <div class="form-group__item radio-btn">
                    <label for="value-2">Вариант 2 с длинным названием причины жалобы на пользователя
                        в две или три строки</label>
                    <input type="radio" name="complain" id="value-2">
                </div>
                <div class="form-group__item radio-btn">
                    <label for="value-3">Вариант 3</label>
                    <input type="radio" name="complain" id="value-3">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="complain-form-label">Сообщение:</label>
            <label>
                <textarea placeholder="Текст сообщения."></textarea>
            </label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-bg popUp-complain-btn">Отправить</button>
        </div>
    </form>
</div>
