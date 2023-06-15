<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/** @global object $APPLICATION */
/** @const string  SITE_TEMPLATE_PATH */

$APPLICATION->SetTitle("Мои объявления");

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
                            <img src="assets/img/profile.jpg" alt="img">
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
                            <img src="assets/img/profile.jpg" alt="img">
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
                        <svg><use xlink:href="assets/img/sprites/sprite.svg#error"></use></svg>
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
            <div class="no-ads">
                <h4 class="title-block">У вас пока нет объявлений.</h4>
                <a href="#" class="btn-bg">
                    <svg><use xlink:href="assets/img/sprites/sprite.svg#plus"></use></svg>
                    Подать объявление
                </a>
            </div>
            <div class="no-ads no-ads--active">
                <h4 class="title-block"><span>Ваши объявления не показываются. Необходимо оформить подписку.</span></h4>
                <button class="btn-bg">
                    Подписаться
                </button>
            </div>
            <div class="user-list-ads">
                <a href="#" class="announcements-list__item">
                    <div class="announcements-img announcements-img--profile">
                        <img src="assets/img/announcements-list/item-1.jpg" alt="img">
                    </div>
                    <div class="announcements-description announcements-description-profile">
                        <div class="announcements-description__cart">
                            <h3>ШИНЫ, ДИСКИ на Мерседес оригинал R16 подходят Sprinter, Vito, и другие Ме.
                                Колпаки, R16, б/у. Объявление с длинным названием в две или три строки</h3>
                            <div class="announcements-data">
                                26.09.2022 в 12:02
                            </div>
                            <button class="edit-ed">
                                <svg><use xlink:href="assets/img/sprites/sprite.svg#pen"></use></svg>
                                <span>Редактировать объявление</span>
                            </button>
                        </div>
                        <div class="announcements-description__del">
                            <button class="del-ed">
                                <svg><use xlink:href="assets/img/sprites/sprite.svg#cross-cart"></use></svg>
                                <span> Деактивировать</span>
                            </button>
                            <span class="day-active-cart">Товар будет удален автоматически через N дней</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="announcements-list__item">
                    <div class="announcements-img announcements-img--profile">
                        <img src="assets/img/announcements-list/item-1.jpg" alt="img">
                    </div>
                    <div class="announcements-description announcements-description-profile">
                        <div class="announcements-description__cart">
                            <h3>ШИНЫ, ДИСКИ на Мерседес оригинал R16 подходят Sprinter, Vito, и другие Ме.
                                Колпаки, R16, б/у</h3>
                            <div class="announcements-data">
                                26.09.2022 в 12:02
                            </div>
                            <button class="edit-ed">
                                <svg><use xlink:href="assets/img/sprites/sprite.svg#pen"></use></svg>
                                <span>Редактировать объявление</span>
                            </button>
                        </div>
                        <div class="announcements-description__del">
                            <button class="del-ed">
                                <svg><use xlink:href="assets/img/sprites/sprite.svg#cross-cart"></use></svg>
                                <span> Деактивировать</span>
                            </button>
                            <span class="day-active-cart">Товар будет удален автоматически через N дней</span>
                        </div>
                    </div>
                </a>
                <a href="#" class="announcements-list__item">
                    <div class="announcements-img announcements-img--profile">
                        <img src="assets/img/announcements-list/item-1.jpg" alt="img">
                    </div>
                    <div class="announcements-description announcements-description-profile">
                        <div class="announcements-description__cart">
                            <h3>ШИНЫ, ДИСКИ на Мерседес оригинал R16 подходят Sprinter, Vito, и другие Ме.
                                Колпаки, R16, б/у</h3>
                            <div class="announcements-data">
                                26.09.2022 в 12:02
                            </div>
                            <button class="edit-ed">
                                <svg><use xlink:href="assets/img/sprites/sprite.svg#pen"></use></svg>
                                <span>Редактировать объявление</span>
                            </button>
                        </div>
                        <div class="announcements-description__del">
                            <button class="del-ed">
                                <svg><use xlink:href="assets/img/sprites/sprite.svg#cross-cart"></use></svg>
                                <span> Деактивировать</span>
                            </button>
                            <span class="day-active-cart">Товар будет удален автоматически через N дней</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>