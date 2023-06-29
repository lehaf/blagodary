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
	"webcompany:my.ads.list",
	"",
            ); ?>
        </div>
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