<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @global object $USER */
/** @const string  SITE_TEMPLATE_PATH */

$APPLICATION->SetTitle("Подать объявление");

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery-2.2.4.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.formstyler.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/air-datepicker.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/jquery.maskedinput.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/slick.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/html/js/main.js");

?>
<div class="page-container">
        <aside class="aside aside-cabinet">
            <div class="profile-menu">
                <div class="menu-authorized">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "personal",
                        Array(
                            "ROOT_MENU_TYPE" => "personal",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "",
                            "USE_EXT" => "N",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "Y",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_TIME" => "360000",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => ""
                        )
                    );?>
                </div>
            </div>
        </aside>
        <div class="page-content page-content--profile">
            <h2 class="title-section"><?=$APPLICATION->ShowTitle()?></h2>
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
            <? global $arFilterAds;
            $arFilterAds = [
                'PROPERTY_OWNER' => $USER->GetId(),
            ];

            $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"my-ads",
                array(
                    "IBLOCK_TYPE" => "products",
                    "IBLOCK_ID" => ADS_IBLOCK_ID,
                    "PAGE_ELEMENT_COUNT" => 10,
                    "ELEMENT_SORT_FIELD" => 'ACTIVE_FROM',
                    "ELEMENT_SORT_ORDER" => 'DESC',
                    "ELEMENT_SORT_FIELD2" => 'SORT',
                    "ELEMENT_SORT_ORDER2" => 'ASC',
                    "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "SET_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "MESSAGE_404" => $arParams["MESSAGE_404"],
                    "SET_STATUS_404" => "N",
                    "SHOW_404" => "N",
                    "FILE_404" => $arParams["FILE_404"],
                    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => 360000,
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_TEMPLATE" => "ads",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_BASE_LINK_ENABLE" => "N",
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
                    "FILTER_NAME" => "arFilterAds",
                    "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],
                    "COMPONENT_TEMPLATE" => "my-ads",
                    "SECTION_ID" => $_REQUEST["SECTION_ID"],
                    "SECTION_CODE" => "",
                    "SECTION_USER_FIELDS" => array(
                        0 => "",
                        1 => "",
                    ),
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "SHOW_ALL_WO_SECTION" => "N",
                    "LINE_ELEMENT_COUNT" => "12",
                    "OFFERS_LIMIT" => "5",
                    "BACKGROUND_IMAGE" => "-",
                    "SEF_MODE" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "SET_BROWSER_TITLE" => "Y",
                    "BROWSER_TITLE" => "-",
                    "SET_META_KEYWORDS" => "Y",
                    "META_KEYWORDS" => "-",
                    "SET_META_DESCRIPTION" => "Y",
                    "META_DESCRIPTION" => "-",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "ACTION_VARIABLE" => "action",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRICE_CODE" => array(
                    ),
                    "USE_PRODUCT_QUANTITY" => "N",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "DISPLAY_COMPARE" => "N",
                    "COMPATIBLE_MODE" => "N",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "N"
                ),
                false
            ); ?>
        </div>
    </div>

    <div class="popUp popUp-rate">
        <h5 class="popUp__title">Выставить оценку</h5>
        <p class="popUp__subtitle">
            Выберите пользователя из списка ниже, с тем, с кем вы созванивались.
            Список формируется из пользователей, которые на карточке объявления вашего
            товара нажали кнопку “Хочу забрать”:
        </p>
        <span class="modal-cross">
            <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use></svg>
        </span>
        <div class="person-list-container ">
            <ul class="person-list-list">
                <li class="grade-list-person">
                    <div class="grade-list-person__name">Олег</div>
                    <div class="grade-list-person__phone">
                        +375 (29) 373-0-03
                    </div>
                    <div class="grade-list-person__phone">
                        +375 (29) 373-0-03
                    </div>
                </li>
                <li class="grade-list-person">
                    <div class="grade-list-person__name">Анна</div>
                    <div class="grade-list-person__phone">
                        +375 (29) 373-0-03
                    </div>
                </li>
                <li class="grade-list-person">
                    <div class="grade-list-person__name">Константин</div>
                    <div class="grade-list-person__phone">
                        +375 (29) 373-0-03
                    </div>
                </li>
                <li class="grade-list-person">
                    <div class="grade-list-person__name">Олег</div>
                    <div class="grade-list-person__phone">
                        +375 (29) 373-0-03
                    </div>
                    <div class="grade-list-person__phone">
                        +375 (29) 373-0-03
                    </div>
                </li>
                <li class="grade-list-person">
                    <div class="grade-list-person__name">Олег</div>
                    <div class="grade-list-person__phone">
                        +375 (29) 373-0-03
                    </div>
                    <div class="grade-list-person__phone">
                        +375 (29) 373-0-03
                    </div>
                </li>
            </ul>
        </div>
        <form action="#" class="popUp-form">
            <div class="form-group form-group-rate">
                <label class="popUp-form-label popUp-form-label--rate">Выставить оценку:</label>
                <div class="rating-area">
                    <input type="radio" id="star-50" name="rating" value="5">
                    <label for="star-50" title="Оценка «5»"></label>
                    <input type="radio" id="star-40" name="rating" value="4">
                    <label for="star-40" title="Оценка «4»"></label>
                    <input type="radio" id="star-30" name="rating" value="3">
                    <label for="star-30" title="Оценка «3»"></label>
                    <input type="radio" id="star-20" name="rating" value="2">
                    <label for="star-20" title="Оценка «2»"></label>
                    <input type="radio" id="star-10" name="rating" value="1">
                    <label for="star-10" title="Оценка «1»"></label>
                </div>
            </div>
            <div class="form-group">
                <label class="popUp-form-label">Комментарий к оценке:*</label>
                <label>
                    <textarea placeholder="Текст сообщения."></textarea>
                </label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-bg popUp-rate-btn">Отправить</button>
            </div>
        </form>
    </div>



    <div class="popUp popUp-review">
        <h5 class="popUp__title">Выставить оценку</h5>
        <span class="modal-cross">
            <svg>
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
            </svg>
        </span>
        <form action="#" class="popUp-form">
            <div class="form-group form-group-rate">
                <label class="popUp-form-label popUp-form-label--rate">Выставить оценку:</label>
                <div class="rating-area">
                    <input type="radio" id="star-5" name="rating" value="5">
                    <label for="star-5" title="Оценка «5»"></label>
                    <input type="radio" id="star-4" name="rating" value="4">
                    <label for="star-4" title="Оценка «4»"></label>
                    <input type="radio" id="star-3" name="rating" value="3">
                    <label for="star-3" title="Оценка «3»"></label>
                    <input type="radio" id="star-2" name="rating" value="2">
                    <label for="star-2" title="Оценка «2»"></label>
                    <input type="radio" id="star-1" name="rating" value="1">
                    <label for="star-1" title="Оценка «1»"></label>
                </div>
            </div>
            <div class="form-group">
                <label class="popUp-form-label">Комментарий к оценке:*</label>
                <label>
                    <textarea placeholder="Текст сообщения."></textarea>
                </label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-bg popUp-complain-btn">Отправить</button>
            </div>
        </form>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>