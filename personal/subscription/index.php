<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @const string  SITE_TEMPLATE_PATH */

$APPLICATION->SetTitle("Подписка");

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
            <div class="subscription-switch">
                <button class="btn subscription-switch__btn subscription__btn--current active">Активная</button>
                <button class="btn subscription-switch__btn subscription__btn--history">История</button>
            </div>
            <div class="subscription-content">
                <div class="profile-current-subscription active">
                    <div class="subscription-content-active">
                        <div class="no-subscription">
                            <div class="profile-error__message">
                                <h4 class="title-block">
                                <span>У вас нет подписки.<br>
                                Вы не можете просматривать контакты владельцев объявлений и размещать объявления.</span>
                                </h4>
                            </div>
                            <h4 class="title-block">Оформить подписку всего за N рублей в неделю.</h4>
                            <a href="#" class="btn-bg">Оформить подписку</a>
                        </div>
                    </div>
                    <div class="current-subscription p-30">
                        <h4 class="title-block">Текущая подписка действительна до 26.09.2022 16:50 и будет
                            продлена автоматически 27.09.2022 в 16:50</h4>
                        <a href="#" class="btn btn-red">
                            <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-cart"></use></svg>
                            Отменить подписку</a>
                    </div>
                    <div class="subscription-content-active">
                        <div class="no-subscription">
                            <div class="profile-error__message">
                                <h4 class="title-block">
                                    Текущая подписка действительна до 26.09.2022 16:50.
                                </h4>
                            </div>
                            <h4 class="title-block">Оформить подписку всего за N рублей в неделю.</h4>
                            <a href="#" class="btn-bg">Оформить подписку</a>
                        </div>
                    </div>
                    <div class="current-subscription">
                        <div class="profile-error__message">
                            <h4 class="title-block">
                                Текущая Подписка Бесплатная (по реферальной программе) до 26.09.2022 16:50
                            </h4>
                        </div>
                        <h4 class="title-block">Платная подписка будет продлена автоматически 27.09.2022 16:50</h4>
                        <a href="#" class="btn btn-red">
                            <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-cart"></use></svg>
                            Отменить подписку</a>
                    </div>
                </div>
                <div class="history-subscription">
                    <ul class="history-subscription-list">
                        <li class="history-subscription-list__item">
                            <div class="history-subscription-data">26.09.2022 </div>
                            <div class="history-subscription-description">
                                Приобретена подписка на период с 19.04.2022 16:50 по 25.04.2022 16:50
                            </div>
                        </li>
                        <li class="history-subscription-list__item">
                            <div class="history-subscription-data">26.09.2022 </div>
                            <div class="history-subscription-description">
                                <span class="strong">БЕСПЛАТНАЯ ПОДПИСКА</span>, за счет реферальной системы на период  с 19.04.2022 16-50 по 25.04.2022 16:50
                            </div>
                        </li>
                        <li class="history-subscription-list__item">
                            <div class="history-subscription-data">26.09.2022 </div>
                            <div class="history-subscription-description">
                                Приобретена подписка на период с 19.04.2022 16:50 по 25.04.2022 16:50
                            </div>
                        </li>
                        <li class="history-subscription-list__item">
                            <div class="history-subscription-data">26.09.2022 </div>
                            <div class="history-subscription-description">
                                Приобретена подписка на период с 19.04.2022 16:50 по 25.04.2022 16:50
                            </div>
                        </li>
                        <li class="history-subscription-list__item">
                            <div class="history-subscription-data">26.09.2022 </div>
                            <div class="history-subscription-description">
                                Приобретена подписка на период с 19.04.2022 16:50 по 25.04.2022 16:50,
                                пример вывода текста с длинным названием в две или три строки
                            </div>
                        </li>
                        <li class="history-subscription-list__item">
                            <div class="history-subscription-data">26.09.2022 </div>
                            <div class="history-subscription-description">
                                Приобретена подписка на период с 19.04.2022 16:50 по 25.04.2022 16:50
                            </div>
                        </li>
                        <li class="history-subscription-list__item">
                            <div class="history-subscription-data">26.09.2022 </div>
                            <div class="history-subscription-description">
                                Приобретена подписка на период с 19.04.2022 16:50 по 25.04.2022 16:50
                            </div>
                        </li>
                    </ul>
                    <div class="pagination">
                        <div class="pagination-arrow-left">
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-prev"></use>
                            </svg>
                        </div>
                        <ul class="pagination-list">
                            <li class="pagination-list__item"><a href="#">1</a></li>
                            <li class="pagination-list__item active"><a href="#">2</a></li>
                            <li class="pagination-list__item"><a href="#">3</a></li>
                            <li class="pagination-list__item pagination-list__item--more"><a href="#">...</a></li>
                            <li class="pagination-list__item"><a href="#">32</a></li>
                        </ul>
                        <div class="pagination-arrow-right active">
                            <svg>
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#arrow-next"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>