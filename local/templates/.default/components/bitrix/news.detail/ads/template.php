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

$curUserId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
$this->setFrameMode(true);
?>
<?php if (!empty($arResult)):?>
    <div class="page-card" id="<?=$this->GetEditAreaID($arResult['ID'])?>">
        <div class="page-card__item page-card__item--slider">
            <div class="card-slider">
                <span data-item="<?=$arResult['ID']?>" class="favorite-card"></span>
                <?php if (!empty($arResult['IMAGES'])):?>
                    <div class="card-slider-main">
                        <?php foreach ($arResult['IMAGES']['BIG_SLIDER'] as $arImg):?>
                            <div class="card-slider__item">
                                <img src="<?=$arImg['src']?>"
                                     alt="<?=$arResult['NAME']?>"
                                     title="<?=$arResult['NAME']?>"
                                >
                            </div>
                        <?php endforeach;?>
                    </div>
                    <?php if (!empty($arResult['IMAGES']['BIG_SLIDER']) && count($arResult['IMAGES']['BIG_SLIDER']) > 1):?>
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
                    <?php endif;?>
                    <?php if (!empty($arResult['IMAGES']['LITTLE_SLIDER']) && count($arResult['IMAGES']['LITTLE_SLIDER']) > 1):?>
                        <div class="card-slider-main-nav">
                            <?php foreach ($arResult['IMAGES']['LITTLE_SLIDER'] as $arImg):?>
                                <div class="card-slider-main-nav__item">
                                    <img src="<?=$arImg['src']?>"
                                         alt="<?=$arResult['NAME']?>"
                                         title="<?=$arResult['NAME']?>"
                                    >
                                </div>
                            <?php endforeach;?>
                        </div>
                    <?php endif;?>
                <?php endif;?>
            </div>
        </div>
        <div class="page-card__item page-card__item--content">
            <div class="card-content">
                <div class="card-content__title">
                    <h2 class="title-section"><?=$arResult['NAME']?></h2>
                    <span data-item="<?=$arResult['ID']?>" class="favorite-card favorite-card--page"></span>
                </div>
                <?php if ($curUserId === $arResult['OWNER']['ID']):?>
                    <a href="/personal/my-ads/add-ads/?item=<?=$arResult['ID']?>" class="edit-card">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#edit-card">
                            </use>
                        </svg>
                        Редактировать объявление
                    </a>
                <?php endif;?>
                <div class="card-info">
                    <?php if (!empty($arResult['OWNER']['ID']) && !empty($arResult['PROPERTIES']['OWNER_NAME']['VALUE'])):?>
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
                                    <?php if (!empty($arResult['RATING']['REVIEWS_COUNT'])):?>
                                        <div class="total-rating">
                                            <span class="total-rating__text">Оценок:</span>
                                            <span class="total-rating__num"><?=$arResult['RATING']['REVIEWS_COUNT']?></span>
                                        </div>
                                    <?php endif;?>
                                    <?php if (!empty($arResult['OWNER']['ADS_COUNT'])):?>
                                        <a href="/ads/user/?user_id=<?=$arResult['OWNER']['ID']?>" class="card-info-announcements">
                                            <span class="card-info-announcements__text">Объявлений:</span>
                                            <span class="card-info-announcements__num"><?=$arResult['OWNER']['ADS_COUNT']?></span>
                                        </a>
                                    <?php endif;?>
                                </div>
                                <?php if (!empty($arResult['PROPERTIES']['OWNER_PHONE']['VALUE']) && $curUserId !== $arResult['OWNER']['ID']):?>
                                    <div class="card-info__phone">
                                        <button data-ads-id="<?=$arResult['ID']?>" class="btn btn-pick-up">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#pick-up">
                                                </use>
                                            </svg>
                                            Хочу забрать
                                        </button>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if (!empty($arResult['PROPERTIES']['REGION']['VALUE']) && !empty($arResult['PROPERTIES']['CITY']['VALUE'])):?>
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
                    <?php endif;?>
                </div>
                <div class="complain <?=!empty($curUserId) ? 'complaint-modal' : 'sign-in-modal'?>">
                    <?php if ($curUserId != $arResult['OWNER']['ID']):?>
                        <span class="complain-warning"></span>
                        <span class="complain__text">Пожаловаться на пользователя</span>
                    <?php endif;?>
                </div>
                <?php if (!empty($arResult['DETAIL_TEXT']) || !empty($arResult['FEATURES'])):?>
                    <div class="card-description">
                        <?php if (!empty($arResult['FEATURES'])):?>
                            <h4 class="card-description__title">Характеристики</h4>
                            <ul class="card-description-list">
                                <?php foreach ($arResult['FEATURES'] as $feature):?>
                                    <li class="card-description-list__item">
                                        <div class="card-description-list__item-name"><?=$feature['NAME']?></div>
                                        <div class="fake-line"></div>
                                        <div class="card-description-list__item-result">
                                            <?=is_array($feature['VALUE']) ? implode(' / ',$feature['VALUE']) : $feature['VALUE']?>
                                        </div>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        <?php endif;?>
                        <?php if (!empty($arResult['DETAIL_TEXT'])):?>
                            <h4 class="card-description__title">Описание</h4>
                            <div class="card-description-text">
                                <p>
                                <?=$arResult['DETAIL_TEXT']?>
                                </p>
                            </div>
                            <div class="card-description-text-btn" >
                                Развернуть описание
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-down"></use>
                                </svg>
                            </div>
                        <?php endif;?>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
<?php endif;?>

<?php if (!empty($arResult['RATING'])):?>
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
            <?php if (!empty($arResult['RATING']['LIST'])):?>
                <div class="grade-list-container">
                    <ul class="grade-list">
                        <?php foreach ($arResult['RATING']['LIST'] as $arUser):?>
                            <li class="grade-list__item">
                                <div class="card-info-rating">
                                    <div class="rating-name-user"><?=$arUser['NAME']?></div>
                                    <div class="rating-result">
                                        <span class="<?=$arUser['RATING'] >= 1 ? 'active' : ''?>"></span>
                                        <span class="<?=$arUser['RATING'] >= 2 ? 'active' : ''?>"></span>
                                        <span class="<?=$arUser['RATING'] >= 3 ? 'active' : ''?>"></span>
                                        <span class="<?=$arUser['RATING'] >= 4 ? 'active' : ''?>"></span>
                                        <span class="<?=$arUser['RATING'] >= 5 ? 'active' : ''?>"></span>
                                    </div>
                                </div>
                                <div class="rating-data"><?=$arUser['DATE']?></div>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            <?php endif;?>
        </div>
    </div>
<?php endif;?>

<div class="popUp popUp-check-user">
    <h5 class="popUp__title" style="color: #ee1d52;"></h5>
    <div class="popUp__description"></div>
    <span class="modal-cross">
        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use></svg>
    </span>
</div>