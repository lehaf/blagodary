<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

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
<?php $ElementID = $APPLICATION->IncludeComponent(
"bitrix:news.detail",
"ads",
[
    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
    "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
    "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
    "META_KEYWORDS" => $arParams["META_KEYWORDS"],
    "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
    "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
    "SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
    "SET_TITLE" => $arParams["SET_TITLE"],
    "MESSAGE_404" => $arParams["MESSAGE_404"],
    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
    "SHOW_404" => $arParams["SHOW_404"],
    "FILE_404" => $arParams["FILE_404"],
    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
    "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
    "ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
    "DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
    "DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
    "PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
    "PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
    "CHECK_DATES" => $arParams["CHECK_DATES"],
    "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
    "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
    "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
    "USE_SHARE" => $arParams["USE_SHARE"],
    "SHARE_HIDE" => $arParams["SHARE_HIDE"],
    "SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
    "SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
    "SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
    "SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
    "ADD_ELEMENT_CHAIN" => $arParams["ADD_ELEMENT_CHAIN"],
    'STRICT_SECTION_CHECK' => $arParams['STRICT_SECTION_CHECK'],
],
$component,
['HIDE_ICONS' => 'Y']
);?>

<?php
if (!empty($GLOBALS['SECTION_ID'])) {

    global $arAdsFilter;
    $arAdsFilter = [
        'IBLOCK_SECTION_ID' => $GLOBALS['SECTION_ID'],
        '!ID' => $ElementID,
    ];

    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "ads-section",
        array(
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "AJAX_MODE" => "N",
            "IBLOCK_TYPE" => "products",
            "IBLOCK_ID" => ADS_IBLOCK_ID,
            "NEWS_COUNT" => "10",
            "SORT_BY1" => "ACTIVE_FROM",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "SORT",
            "SORT_ORDER2" => "ASC",
            "FILTER_NAME" => "arAdsFilter",
            "FIELD_CODE" => array(
                0 => "ID",
                1 => "DETAIL_PICTURE",
            ),
            "PROPERTY_CODE" => array(
                0 => "IMAGES",
            ),
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "SET_TITLE" => "Y",
            "SET_BROWSER_TITLE" => "Y",
            "SET_META_KEYWORDS" => "Y",
            "SET_META_DESCRIPTION" => "Y",
            "SET_LAST_MODIFIED" => "Y",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "Y",
            "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "INCLUDE_SUBSECTIONS" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "360000",
            "CACHE_FILTER" => "Y",
            "CACHE_GROUPS" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_TITLE" => "Объявления",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => "ads",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "Y",
            "PAGER_BASE_LINK_ENABLE" => "Y",
            "SET_STATUS_404" => "Y",
            "SHOW_404" => "N",
            "MESSAGE_404" => "",
            "PAGER_BASE_LINK" => "",
            "PAGER_PARAMS_NAME" => "arrPager",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "COMPONENT_TEMPLATE" => "ads",
            "STRICT_SECTION_CHECK" => "N"
        ),
        false
    );
}
?>

<div class="viewed viewed--big">
    <div class="wrapper">
        <div class="viewed--big-content">
            <h2 class="title-section">Ранее вы смотрели</h2>
            <div class="viewed-slider viewed-slider--big no-arrow">
                <a href="https://www.google.com/search?q=dog+img&amp;tbm=isch&amp;ved=2ahUKEwj_j7To9aH8AhWDwgIHHSh6Bn0Q2-cCegQIABAA&amp;oq=dog+img&amp;gs_lcp=CgNpbWcQAzIECCMQJzIECAAQHjIECAAQHjIGCAAQBRAeMgkIABCABBAKEBg6BAgAEEM6BQgAEIAEUIsGWKgNYMcPaABwAHgAgAFeiAGjA5IBATWYAQCgAQGqAQtnd3Mtd2l6LWltZ8ABAQ&amp;sclient=img&amp;ei=AyevY7-CHoOFi-gPqPSZ6Ac&amp;bih=1306&amp;biw=2560#imgrc=u61zC0xCLTOo1M" class="viewed-slider__item">
                        <span class="viewed-slider__item-img" style="height: 195.749px;">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-1.jpg" alt="alt">
                        </span>
                    <span class="viewed-slider__item-description">
                                      <span class="viewed-slider__item-title">Зеркало с люминесцентной подсветкой (120х75 см).  290G - SP20</span>
                                <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                    <span class="favorite-card">
                            </span>
                </a>
                <a href="https://www.youtube.com/" class="viewed-slider__item">
                        <span class="viewed-slider__item-img" style="height: 195.749px;">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-2.jpg" alt="alt">
                        </span>
                    <span class="viewed-slider__item-description">
                                  <span class="viewed-slider__item-title">Свитер желтый из нейлона (размер S)</span>
                            <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                    <span class="favorite-card">
                            </span>
                </a>

            </div>
            <div class="viewed-slider-arrows slider-arrows-container">
                <div class="viewed-slider-prev slider-arrow-prev">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-prev">
                        </use>
                    </svg>
                </div>
                <div class="viewed-slider-next slider-arrow-next">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-next"></use>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="popUp popUp-grade">
    <h5 class="popUp__title">Оценка</h5>
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
                <div class="rating-result-text">4,0</div>
                <div class="rating-result">
                    <span class="active"></span>
                    <span class="active"></span>
                    <span class="active"></span>
                    <span class="active"></span>
                    <span></span>
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
                    76
                </div>
            </div>
        </div>
        <div class="grade-list-container">
            <ul class="grade-list">
                <li class="grade-list__item">
                    <div class="card-info-rating">
                        <div class="rating-name-user">Олег</div>
                        <div class="rating-result">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="rating-data">
                        06.12.2022
                    </div>
                </li>
                <li class="grade-list__item">
                    <div class="card-info-rating">
                        <div class="rating-name-user">Константин</div>
                        <div class="rating-result">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="rating-data">
                        06.12.2022
                    </div>
                </li>
                <li class="grade-list__item">
                    <div class="card-info-rating">
                        <div class="rating-name-user">Анна</div>
                        <div class="rating-result">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="rating-data">
                        06.12.2022
                    </div>
                </li>
                <li class="grade-list__item">
                    <div class="card-info-rating">
                        <div class="rating-name-user">Константин</div>
                        <div class="rating-result">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                        </div>
                    </div>
                    <div class="rating-data">
                        06.12.2022
                    </div>
                </li>
                <li class="grade-list__item">
                    <div class="card-info-rating">
                        <div class="rating-name-user">Олег</div>
                        <div class="rating-result">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="rating-data">
                        06.12.2022
                    </div>
                </li>
                <li class="grade-list__item">
                    <div class="card-info-rating">
                        <div class="rating-name-user">Олег</div>
                        <div class="rating-result">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="rating-data">
                        06.12.2022
                    </div>
                </li>
                <li class="grade-list__item">
                    <div class="card-info-rating">
                        <div class="rating-name-user">Олег</div>
                        <div class="rating-result">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="rating-data">
                        06.12.2022
                    </div>
                </li>
                <li class="grade-list__item">
                    <div class="card-info-rating">
                        <div class="rating-name-user">Олег</div>
                        <div class="rating-result">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="rating-data">
                        06.12.2022
                    </div>
                </li>
                <li class="grade-list__item">
                    <div class="card-info-rating">
                        <div class="rating-name-user">Олег</div>
                        <div class="rating-result">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="rating-data">
                        06.12.2022
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>




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