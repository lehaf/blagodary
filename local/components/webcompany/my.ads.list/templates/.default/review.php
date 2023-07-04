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
$this->addExternalJs($this->GetFolder().'/review.js');
?>
<?if (!empty($arResult['REVIEWS'])):?>
    <p class="subtitle">Вам выставлена оценка. Оцените пользователя:</p>
    <div class="ads-ratings">
        <?foreach ($arResult['REVIEWS'] as $userId => $arReview):?>
            <div class="ads-ratings__item">
                <h3 class="ads-ratings-title"><?=$arReview['NAME']?></h3>
                <div class="ads-ratings-data">
                    <div class="ads-ratings-data__img">
                        <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/profile.jpg"
                             alt="<?=$arReview['USER_NAME']?>"
                             title="<?=$arReview['USER_NAME']?>"
                        >
                    </div>
                    <div class="ads-ratings-data__name"><?=$arReview['USER_NAME']?></div>
                </div>
                <div class="ads-ratings-assessment">
                    <div class="ads-ratings-assessment__text">
                        Выставил вам следующую оценку:
                    </div>
                    <div class="ads-ratings-assessment__rate">
                        <div class="rating-result">
                            <span class="<?=$arReview['RATING'] >= 1 ? 'active' : ''?>"></span>
                            <span class="<?=$arReview['RATING'] >= 2 ? 'active' : ''?>"></span>
                            <span class="<?=$arReview['RATING'] >= 3 ? 'active' : ''?>"></span>
                            <span class="<?=$arReview['RATING'] >= 4 ? 'active' : ''?>"></span>
                            <span class="<?=$arReview['RATING'] >= 5 ? 'active' : ''?>"></span>
                        </div>
                    </div>
                </div>
                <div class="ads-ratings-comment">
                    <h5>Комментарий к оценке:</h5>
                    <p><?=$arReview['COMMENT']?></p>
                </div>
                <button class="btn-bg ads-ratings-btn"
                        data-item-name="<?=$arReview['NAME']?>"
                        data-user-id="<?=$userId?>"
                        data-review-id="<?=$arReview['REVIEW_ID']?>"
                >Выставить оценку</button>
            </div>
        <?endforeach;?>
    </div>

    <div class="popUp popUp-review">
        <h5 class="popUp__title">Выставить оценку</h5>
        <span class="modal-cross">
            <svg>
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
            </svg>
        </span>
        <form id="popUp-review" action="" class="popUp-form">
            <div class="form-group form-group-rate">
                <label class="popUp-form-label popUp-form-label--rate">Выставить оценку:</label>
                <div class="rating-area">
                    <input type="radio" id="star-5" name="RATING" value="5">
                    <label for="star-5" title="Оценка «5»"></label>
                    <input type="radio" id="star-4" name="RATING" value="4">
                    <label for="star-4" title="Оценка «4»"></label>
                    <input type="radio" id="star-3" name="RATING" value="3">
                    <label for="star-3" title="Оценка «3»"></label>
                    <input type="radio" id="star-2" name="RATING" value="2">
                    <label for="star-2" title="Оценка «2»"></label>
                    <input type="radio" id="star-1" name="RATING" value="1">
                    <label for="star-1" title="Оценка «1»"></label>
                </div>
            </div>
            <div class="form-group">
                <label class="popUp-form-label">Комментарий к оценке:*</label>
                <label>
                    <textarea name="COMMENT" placeholder="Текст сообщения."></textarea>
                </label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-bg popUp-complain-btn">Отправить</button>
            </div>
        </form>
    </div>
<?endif;?>

