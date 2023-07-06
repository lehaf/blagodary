<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use WebCompany\YouWatchBefore;

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
/** @global  array $BLOCKED */

global $BLOCKED;
$isAjax = $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
$APPLICATION->AddChainItem('Объявления пользователя','/ads/user/');

if (!empty($_GET['user_id'])) {
    $userId = (int)$_GET['user_id'];
    $arRating = getUserRatingData($userId);
    $userAdsCount = getCountUserAds($userId);
    $arUser = getUserData($userId,['NAME','DATE_REGISTER']);
    $dateRegister = formateRegisterDate($arUser['DATE_REGISTER']);
} else {
//    \CHTTP::setStatus("404 Not Found");
//    LocalRedirect('/404.php');
}
?>

<?if (!empty($arUser) && !empty($arRating)):?>
    <div class="user-data-content">
        <div class="user-data__img">
            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/profile.jpg"
                 title="<?=$arUser['NAME']?>"
                 alt="<?=$arUser['NAME']?>"
            >
        </div>
        <div class="user-data-description">
            <div class="user-data__name"><?=$arUser['NAME']?></div>
            <div class="user-data__rate">
                <div class="card-info-rating">
                    <div class="rating-result-text"><?=$arRating['TOTAL']?></div>
                    <div class="rating-result">
                        <span class="<?=$arRating['TOTAL'] >= 1 ? 'active' : ''?>"></span>
                        <span class="<?=$arRating['TOTAL'] >= 2 ? 'active' : ''?>"></span>
                        <span class="<?=$arRating['TOTAL'] >= 3 ? 'active' : ''?>"></span>
                        <span class="<?=$arRating['TOTAL'] >= 4 ? 'active' : ''?>"></span>
                        <span class="<?=$arRating['TOTAL'] >= 5 ? 'active' : ''?>"></span>
                    </div>
                </div>
                <?if (!empty($arRating['REVIEWS_COUNT'])):?>
                    <div class="total-rating">
                        <span class="total-rating__text">Оценок:</span>
                        <span class="total-rating__num"><?=$arRating['REVIEWS_COUNT']?></span>
                    </div>
                <?endif;?>
            </div>
            <?if (!empty($dateRegister)):?>
                <div class="user-data__time">
                    На сервисе с <span><?=$dateRegister?></span>
                </div>
            <?endif;?>
        </div>
    </div>
<?endif;?>
<div class="page-container user">
    <aside class="aside">
        <div class="aside__item aside__item-btn">
            <button class="btn-bg btn-category btn-category-open">
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#btn-category"></use>
                </svg>
                Категории
            </button>
            <button class="btn-bg btn-category mobile_menu">
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#btn-category"></use>
                </svg>
                Категории
            </button>
            <button class="btn-filter">
                Фильтры
                <svg>
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#filter-btn"></use>
                </svg>
            </button>
        </div>
        <div class="aside__item aside__item-category">
            <?global $arSectFilter;
            $arSectFilter = Array("!UF_MAIN_CATEGORY" => false);
            $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "main-category",
            Array(
            "VIEW_MODE" => "TEXT",
            "SHOW_PARENT_NAME" => "Y",
            "IBLOCK_TYPE" => "products",
            "IBLOCK_ID" => ADS_IBLOCK_ID,
            "SECTION_URL" => "",
            "COUNT_ELEMENTS" => "Y",
            "TOP_DEPTH" => "1",
            "SECTION_FIELDS" => "",
            "SECTION_USER_FIELDS" => "",
            "ADD_SECTIONS_CHAIN" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_NOTES" => "Y",
            "CACHE_GROUPS" => "Y",
            "CACHE_FILTER" => "Y",
            "FILTER_NAME" => "arSectFilter",
            "ALL_CATEGORIES_LINK" => "/ads/"
            )
            );?>
        </div>
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter",
            "filter",
            array(
                "COMPONENT_TEMPLATE" => "",
                "IBLOCK_TYPE" => "products",
                "IBLOCK_ID" => ADS_IBLOCK_ID,
                "FILTER_NAME" => "arrFilter",
                "HIDE_NOT_AVAILABLE" => "N",
                "DISPLAY_ELEMENT_COUNT" => "Y",
                "SEF_MODE" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "N",
                "SAVE_IN_SESSION" => "N",
                "INSTANT_RELOAD" => "Y",
                "PAGER_PARAMS_NAME" => "arrPager",
                "PRICE_CODE" => array(
                    0 => "BASE",
                ),
                "CONVERT_CURRENCY" => "Y",
                "SECTION_TITLE" => "-",
                "SECTION_DESCRIPTION" => "-",
                "POPUP_POSITION" => "left",
                "SEF_RULE" => "/ads/#SECTION_CODE#/filter/#SMART_FILTER_PATH#/",
                "SECTION_CODE_PATH" => "",
                "SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"],
                "CURRENCY_ID" => "RUB",
                "PREFILTER_NAME" => "smartPreFilter",
                "SECTION_CODE" => $_REQUEST["SECTION_CODE"],
                "XML_EXPORT" => "N",
                "TEMPLATE_THEME" => "blue",
                "SECTION_ID" => $_REQUEST["SECTION_ID"]
            ),
            false
        );?>
    </aside>
    <div class="page-content">
        <div class="announcements">
            <div class="announcements-header">
                <h2 class="title-section">
                    <?=!empty($userAdsCount) && $userAdsCount > 0 ? 'Товаров: '.$userAdsCount : 'У пользователя нет объявлений'?>
                </h2>
                <?include_once $_SERVER['DOCUMENT_ROOT'].'/'.SITE_TEMPLATE_PATH.'/include/switcher.php'; /** @var string $typeOfView */?>
            </div>
            <? if ($isAjax) $APPLICATION->RestartBuffer(); ?>
            <?
            global $arFilterAds, $arrFilter;
            $arFilterAds = [
                'INCLUDE_SUBSECTIONS' => 'Y',
                'PROPERTY_OWNER' => $userId,
                ...$arrFilter
            ];

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                $typeOfView,
                array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "PAGE_ELEMENT_COUNT" => $arParams["NEWS_COUNT"],
                    "ELEMENT_SORT_FIELD" => $arParams["SORT_BY1"],
                    "ELEMENT_SORT_ORDER" => $arParams["SORT_BY1"],
                    "ELEMENT_SORT_FIELD2" => $arParams["SORT_BY2"],
                    "ELEMENT_SORT_ORDER2" => $arParams["SORT_ORDER2"],
                    "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                    "MESSAGE_404" => $arParams["MESSAGE_404"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "SHOW_404" => $arParams["SHOW_404"],
                    "FILE_404" => $arParams["FILE_404"],
                    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                    "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                    "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                    "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
                    "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
                    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                    "FILTER_NAME" => 'arFilterAds',
                    "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],
                ),
                false
            );
            ?>
            <?if ($isAjax) die(); ?>
        </div>
        <?
        $obViewedGoods = new YouWatchBefore();
        $arViewedGoodsId = $obViewedGoods->getGoodsFromCookie();
        if (!empty($arViewedGoodsId)) {
            global $arViewedGoodsFilter;
            $arViewedGoodsFilter = ['ID' => $arViewedGoodsId, '!=PROPERTY_OWNER' => $BLOCKED];
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "you-watch-before",
                array(
                    "ACTION_VARIABLE" => "",
                    "ADD_PICT_PROP" => "MORE_PHOTO",
                    "ADD_PROPERTIES_TO_BASKET" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPATIBLE_MODE" => "N",
                    "CONVERT_CURRENCY" => "Y",
                    "CURRENCY_ID" => "RUB",
                    "CUSTOM_FILTER" => "",
                    "DATA_LAYER_NAME" => "dataLayer",
                    "DETAIL_URL" => "",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "id",
                    "ELEMENT_SORT_FIELD2" => "sort",
                    "ELEMENT_SORT_ORDER" => $arViewedGoodsId,
                    "ELEMENT_SORT_ORDER2" => "asc",
                    "ENLARGE_PRODUCT" => "PROP",
                    "ENLARGE_PROP" => "NEWPRODUCT",
                    "FILTER_NAME" => "arViewedGoodsFilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "IBLOCK_ID" => ADS_IBLOCK_ID,
                    "IBLOCK_TYPE" => "products",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "ads",
                    "PAGER_TITLE" => "Ранее смотрели",
                    "PAGE_ELEMENT_COUNT" => "10",
                    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                    "RCM_TYPE" => "personal",
                    "SEF_MODE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SHOW_ALL_WO_SECTION" => "N",
                    "SHOW_CLOSE_POPUP" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "Y",
                    "SHOW_FROM_SECTION" => "N",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "Y",
                    "SLIDER_INTERVAL" => "3000",
                    "SLIDER_PROGRESS" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_ENHANCED_ECOMMERCE" => "Y",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "COMPONENT_TEMPLATE" => "you-watch-before",
                    "DISPLAY_COMPARE" => "N"
                ),
                false
            );
        }
        ?>
    </div>
</div>


<?if (!empty($arRating)):?>
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
                    <div class="rating-result-text"><?=$arRating['TOTAL']?></div>
                    <div class="rating-result">
                        <span class="<?=$arRating['TOTAL'] >= 1 ? 'active' : ''?>"></span>
                        <span class="<?=$arRating['TOTAL'] >= 2 ? 'active' : ''?>"></span>
                        <span class="<?=$arRating['TOTAL'] >= 3 ? 'active' : ''?>"></span>
                        <span class="<?=$arRating['TOTAL'] >= 4 ? 'active' : ''?>"></span>
                        <span class="<?=$arRating['TOTAL'] >= 5 ? 'active' : ''?>"></span>
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
                        <?=$arRating['REVIEWS_COUNT']?>
                    </div>
                </div>
            </div>
            <?if (!empty($arRating['LIST'])):?>
                <div class="grade-list-container">
                    <ul class="grade-list">
                        <?foreach ($arRating['LIST'] as $arUser):?>
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
                        <?endforeach;?>
                    </ul>
                </div>
            <?endif;?>
        </div>
    </div>
<?endif;?>