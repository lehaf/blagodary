<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @const string  SITE_TEMPLATE_PATH */

$APPLICATION->SetTitle("Реферальная программа");

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
            <div class="referral-program">
                <div class="referral-program__description">Ваша реферальная сылка</div>
                <input type="text"
                       class="referral-program__link"
                       placeholder="site.by/jsevneoiveroivneovnrvevev63424213738AAAAA"
                       value="site.by/jsevneoiveroivneovnrvevev63424213738AAAAA"
                       disabled
                >
                <button class="btn-bg referral-link-btn">Скопировать ссылку
                    <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#referral-link"></use></svg>
                </button>
            </div>
            <div class="description-referral-program">
                <h3 class="title-block referral-program--title">Описание реферальной программы</h3>
                <p>
                    Реферальная программа работает по следующей Логике:
                    Пользователя есть реферальная ссылка, которой он делится среди своего окружения.
                    Если в течении N1 дней, по реферальной ссылке оплатили N2 (кол-во) пользователей,
                    то текущему владельцу реферальной ссылки автоматически начисляется N3 дней доступа
                    к базе контактов и возможности размещения объявлений, сразу после оплаты действующей
                    Подписки (т.е. После того как прошло N3 дней (N3 дней – это доступ к базе контактов и
                    возможности размещения объявлений), с карты автоматически за этот период не списываются
                    деньги, а действует Бесплатная "подписка" по реферальной системе. И пользователю на почту
                    должно прийти уведомление, что за данный период у него будет действовать Бесплатная подписка.
                    После того как Бесплатная "подписка" заканчивается продолжает отрабатывать платная подписка,
                    в случае ее активации.).
                </p>
                <p>
                    А если не было вообще платной подписки,, а условия по реферальной системе были выполнены,
                    как описано выше, то сразу после самого последнего платежа реферала стартует подписка.
                    В этом случае пользователю на почту должно прийти письмо с уведомлением, что стартовала
                    Бесплатная подписка.
                </p>
                <p>
                    Если в течении N1 дней, оплатило меньше пользователей чем N2, то текущие
                    рефералы сгорают.В рефералы пользователь зачисляется единожды только после первой своей оплаты.
                </p>
            </div>
            <div class="referral-list">
                <h3 class="title-block referral-program--title">Список рефералов</h3>
                <div class="referral-list__head">
                    <div class="referral-calendar" id="calendar">
                        с
                        <input type="text" class="referral-calendar__item" id="AirDatepickerMin" placeholder="27.09.2022">
                        по
                        <input type="text" class="referral-calendar__item" id="AirDatepickerMax" placeholder="27.10.2022">
                    </div>
                    <div class="btn-bg referral-calendar-btn">Показать</div>
                </div>
                <div class="referral-result">
                    <ul class="referral-result-list">
                        <li class="referral-result-item">
                            <div class="referral-result-item__data">26.09.2022 </div>
                            <div class="referral-result-item__user">Реферал</div>
                        </li>
                        <li class="referral-result-item">
                            <div class="referral-result-item__data">26.09.2022 </div>
                            <div class="referral-result-item__user">Реферал</div>
                        </li>
                        <li class="referral-result-item">
                            <div class="referral-result-item__data">26.09.2022 </div>
                            <div class="referral-result-item__user">Реферал</div>
                        </li>
                    </ul>
                    <div class="referral-result-not">
                        В заданный период, не было оплат от рефералов.
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>