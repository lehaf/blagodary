<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @const string SITE_TEMPLATE_PATH */

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery-2.2.4.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.formstyler.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/air-datepicker.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.maskedinput.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/slick.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/main.js");

$APPLICATION->SetTitle("Все объявления");?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"ads", 
	array(
		"ADD_ELEMENT_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "360000",
		"CACHE_TYPE" => "A",
		"CATEGORY_CODE" => "CATEGORY",
		"CATEGORY_IBLOCK" => array(
		),
		"CATEGORY_ITEMS_COUNT" => "5",
		"CHECK_DATES" => "Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "ads",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "",
			1 => "IMAGES",
			2 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "Y",
		"DISPLAY_AS_RATING" => "rating",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FILE_404" => "",
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"FORUM_ID" => "",
		"GROUP_PERMISSIONS" => array(
			0 => "2",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"IBLOCK_ID" => ADS_IBLOCK_ID,
		"IBLOCK_TYPE" => "products",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "IMAGES",
			2 => "",
		),
		"MAX_VOTE" => "5",
		"MESSAGES_PER_PAGE" => "10",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "12",
		"NUM_DAYS" => "30",
		"NUM_NEWS" => "20",
		"PAGER_BASE_LINK" => "",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_PARAMS_NAME" => "arrPager",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "ads",
		"PAGER_TITLE" => "Объявления",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"POST_FIRST_MESSAGE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"REVIEW_AJAX_POST" => "Y",
		"SEF_FOLDER" => "/ads/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHARE_HANDLERS" => array(
			0 => "delicious",
			1 => "lj",
			2 => "twitter",
		),
		"SHARE_HIDE" => "Y",
		"SHARE_SHORTEN_URL_KEY" => "",
		"SHARE_SHORTEN_URL_LOGIN" => "",
		"SHARE_TEMPLATE" => "",
		"SHOW_404" => "Y",
		"SHOW_LINK_TO_FORUM" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "Y",
		"URL_TEMPLATES_READ" => "",
		"USE_CAPTCHA" => "Y",
		"USE_CATEGORIES" => "Y",
		"USE_FILTER" => "Y",
		"USE_PERMISSIONS" => "Y",
		"USE_RATING" => "Y",
		"USE_REVIEW" => "Y",
		"USE_RSS" => "Y",
		"USE_SEARCH" => "Y",
		"USE_SHARE" => "Y",
		"VOTE_NAMES" => array(
			0 => "0",
			1 => "1",
			2 => "2",
			3 => "3",
			4 => "4",
			5 => "",
		),
		"YANDEX" => "Y",
		"COMPONENT_TEMPLATE" => "ads",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "#SECTION_CODE_PATH#/",
			"detail" => "#ELEMENT_CODE#/",
			"search" => "search/",

		)
	),
	false
);?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>