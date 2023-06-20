<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $USER;
?>

    </div>
</div>
<footer class="footer">
    <div class="footer-top">
        <div class="wrapper">
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "bottom",
                Array(
                    "ROOT_MENU_TYPE" => "top",
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "top",
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
    <div class="footer-content">
        <div class="wrapper">
            <div class="footer-text">
                <? $APPLICATION->IncludeFile(
                '/include/footer-descr.php',
                    Array(),
                    Array(
                    "MODE"      => "text",
                    "NAME"      => "Описание сервиса",
                ));?>
            </div>
            <ul class="social-media">
                <li class="social-media__item">
                    <a href="#">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.08662 8.99996C6.08662 7.39154 7.39093 6.08731 9.00032 6.08731C10.6097 6.08731 11.9147 7.39154 11.9147 8.99996C11.9147 10.6084 10.6097 11.9126 9.00032 11.9126C7.39093 11.9126 6.08662 10.6084 6.08662 8.99996ZM4.51115 8.99996C4.51115 11.4779 6.52095 13.4864 9.00032 13.4864C11.4797 13.4864 13.4895 11.4779 13.4895 8.99996C13.4895 6.52207 11.4797 4.51348 9.00032 4.51348C6.52095 4.51348 4.51115 6.52207 4.51115 8.99996ZM12.6181 4.33559C12.618 4.54296 12.6795 4.74569 12.7947 4.91816C12.9099 5.09063 13.0737 5.22508 13.2654 5.30451C13.457 5.38394 13.668 5.40479 13.8715 5.36442C14.075 5.32404 14.262 5.22426 14.4087 5.07769C14.5555 4.93111 14.6555 4.74433 14.6961 4.54097C14.7366 4.3376 14.7159 4.12678 14.6366 3.93516C14.5573 3.74355 14.4229 3.57975 14.2504 3.46447C14.0779 3.34919 13.8751 3.28762 13.6676 3.28754H13.6672C13.3891 3.28767 13.1224 3.39811 12.9257 3.59462C12.729 3.79113 12.6184 4.05763 12.6181 4.33559V4.33559ZM5.46835 16.1119C4.61599 16.0731 4.15271 15.9312 3.84483 15.8113C3.43666 15.6525 3.14543 15.4634 2.83923 15.1578C2.53303 14.8522 2.3435 14.5614 2.18529 14.1535C2.06527 13.8459 1.9233 13.3828 1.88455 12.5309C1.84217 11.61 1.8337 11.3333 1.8337 9.00003C1.8337 6.66676 1.84286 6.39087 1.88455 5.46913C1.92337 4.61728 2.06639 4.15504 2.18529 3.84658C2.3442 3.43866 2.53345 3.1476 2.83923 2.84159C3.14501 2.53557 3.43596 2.34615 3.84483 2.18804C4.15257 2.06809 4.61599 1.9262 5.46835 1.88748C6.38988 1.84512 6.6667 1.83666 9.00032 1.83666C11.3339 1.83666 11.611 1.84582 12.5333 1.88748C13.3857 1.92627 13.8482 2.06921 14.1569 2.18804C14.565 2.34615 14.8563 2.53599 15.1625 2.84159C15.4687 3.14718 15.6575 3.43866 15.8164 3.84658C15.9364 4.15413 16.0784 4.61728 16.1171 5.46913C16.1595 6.39087 16.168 6.66676 16.168 9.00003C16.168 11.3333 16.1595 11.6092 16.1171 12.5309C16.0783 13.3828 15.9357 13.8458 15.8164 14.1535C15.6575 14.5614 15.4682 14.8525 15.1625 15.1578C14.8567 15.4631 14.565 15.6525 14.1569 15.8113C13.8491 15.9313 13.3857 16.0732 12.5333 16.1119C11.6118 16.1542 11.335 16.1627 9.00032 16.1627C6.66565 16.1627 6.3896 16.1542 5.46835 16.1119V16.1119ZM5.39596 0.315608C4.46527 0.357966 3.8293 0.505452 3.27391 0.721437C2.69872 0.944482 2.2118 1.24372 1.72523 1.72923C1.23865 2.21474 0.940008 2.70214 0.716829 3.27698C0.500714 3.83239 0.353141 4.46763 0.310757 5.39776C0.267674 6.32936 0.257812 6.6272 0.257812 8.99996C0.257812 11.3727 0.267674 11.6706 0.310757 12.6022C0.353141 13.5324 0.500714 14.1675 0.716829 14.7229C0.940008 15.2974 1.23872 15.7854 1.72523 16.2707C2.21173 16.756 2.69872 17.0548 3.27391 17.2785C3.83035 17.4945 4.46527 17.642 5.39596 17.6843C6.32861 17.7267 6.62614 17.7372 9.00032 17.7372C11.3745 17.7372 11.6725 17.7274 12.6047 17.6843C13.5354 17.642 14.171 17.4945 14.7267 17.2785C15.3016 17.0548 15.7888 16.7562 16.2754 16.2707C16.762 15.7852 17.06 15.2974 17.2838 14.7229C17.4999 14.1675 17.6482 13.5323 17.6899 12.6022C17.7323 11.6699 17.7421 11.3727 17.7421 8.99996C17.7421 6.6272 17.7323 6.32936 17.6899 5.39776C17.6475 4.46756 17.4999 3.83204 17.2838 3.27698C17.06 2.70249 16.7612 2.21551 16.2754 1.72923C15.7896 1.24295 15.3016 0.944482 14.7274 0.721437C14.171 0.505452 13.5354 0.357267 12.6054 0.315608C11.6732 0.27325 11.3752 0.262695 9.00102 0.262695C6.62684 0.262695 6.32861 0.272551 5.39596 0.315608Z" fill="url(#paint0_radial_502_434)"></path>
                            <path d="M6.08662 8.99996C6.08662 7.39154 7.39093 6.08731 9.00032 6.08731C10.6097 6.08731 11.9147 7.39154 11.9147 8.99996C11.9147 10.6084 10.6097 11.9126 9.00032 11.9126C7.39093 11.9126 6.08662 10.6084 6.08662 8.99996ZM4.51115 8.99996C4.51115 11.4779 6.52095 13.4864 9.00032 13.4864C11.4797 13.4864 13.4895 11.4779 13.4895 8.99996C13.4895 6.52207 11.4797 4.51348 9.00032 4.51348C6.52095 4.51348 4.51115 6.52207 4.51115 8.99996ZM12.6181 4.33559C12.618 4.54296 12.6795 4.74569 12.7947 4.91816C12.9099 5.09063 13.0737 5.22508 13.2654 5.30451C13.457 5.38394 13.668 5.40479 13.8715 5.36442C14.075 5.32404 14.262 5.22426 14.4087 5.07769C14.5555 4.93111 14.6555 4.74433 14.6961 4.54097C14.7366 4.3376 14.7159 4.12678 14.6366 3.93516C14.5573 3.74355 14.4229 3.57975 14.2504 3.46447C14.0779 3.34919 13.8751 3.28762 13.6676 3.28754H13.6672C13.3891 3.28767 13.1224 3.39811 12.9257 3.59462C12.729 3.79113 12.6184 4.05763 12.6181 4.33559V4.33559ZM5.46835 16.1119C4.61599 16.0731 4.15271 15.9312 3.84483 15.8113C3.43666 15.6525 3.14543 15.4634 2.83923 15.1578C2.53303 14.8522 2.3435 14.5614 2.18529 14.1535C2.06527 13.8459 1.9233 13.3828 1.88455 12.5309C1.84217 11.61 1.8337 11.3333 1.8337 9.00003C1.8337 6.66676 1.84286 6.39087 1.88455 5.46913C1.92337 4.61728 2.06639 4.15504 2.18529 3.84658C2.3442 3.43866 2.53345 3.1476 2.83923 2.84159C3.14501 2.53557 3.43596 2.34615 3.84483 2.18804C4.15257 2.06809 4.61599 1.9262 5.46835 1.88748C6.38988 1.84512 6.6667 1.83666 9.00032 1.83666C11.3339 1.83666 11.611 1.84582 12.5333 1.88748C13.3857 1.92627 13.8482 2.06921 14.1569 2.18804C14.565 2.34615 14.8563 2.53599 15.1625 2.84159C15.4687 3.14718 15.6575 3.43866 15.8164 3.84658C15.9364 4.15413 16.0784 4.61728 16.1171 5.46913C16.1595 6.39087 16.168 6.66676 16.168 9.00003C16.168 11.3333 16.1595 11.6092 16.1171 12.5309C16.0783 13.3828 15.9357 13.8458 15.8164 14.1535C15.6575 14.5614 15.4682 14.8525 15.1625 15.1578C14.8567 15.4631 14.565 15.6525 14.1569 15.8113C13.8491 15.9313 13.3857 16.0732 12.5333 16.1119C11.6118 16.1542 11.335 16.1627 9.00032 16.1627C6.66565 16.1627 6.3896 16.1542 5.46835 16.1119V16.1119ZM5.39596 0.315608C4.46527 0.357966 3.8293 0.505452 3.27391 0.721437C2.69872 0.944482 2.2118 1.24372 1.72523 1.72923C1.23865 2.21474 0.940008 2.70214 0.716829 3.27698C0.500714 3.83239 0.353141 4.46763 0.310757 5.39776C0.267674 6.32936 0.257812 6.6272 0.257812 8.99996C0.257812 11.3727 0.267674 11.6706 0.310757 12.6022C0.353141 13.5324 0.500714 14.1675 0.716829 14.7229C0.940008 15.2974 1.23872 15.7854 1.72523 16.2707C2.21173 16.756 2.69872 17.0548 3.27391 17.2785C3.83035 17.4945 4.46527 17.642 5.39596 17.6843C6.32861 17.7267 6.62614 17.7372 9.00032 17.7372C11.3745 17.7372 11.6725 17.7274 12.6047 17.6843C13.5354 17.642 14.171 17.4945 14.7267 17.2785C15.3016 17.0548 15.7888 16.7562 16.2754 16.2707C16.762 15.7852 17.06 15.2974 17.2838 14.7229C17.4999 14.1675 17.6482 13.5323 17.6899 12.6022C17.7323 11.6699 17.7421 11.3727 17.7421 8.99996C17.7421 6.6272 17.7323 6.32936 17.6899 5.39776C17.6475 4.46756 17.4999 3.83204 17.2838 3.27698C17.06 2.70249 16.7612 2.21551 16.2754 1.72923C15.7896 1.24295 15.3016 0.944482 14.7274 0.721437C14.171 0.505452 13.5354 0.357267 12.6054 0.315608C11.6732 0.27325 11.3752 0.262695 9.00102 0.262695C6.62684 0.262695 6.32861 0.272551 5.39596 0.315608Z" fill="url(#paint1_radial_502_434)"></path>
                            <defs>
                                <radialGradient id="paint0_radial_502_434" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(2.5808 17.8198) scale(22.8252 22.8115)">
                                    <stop offset="0.09" stop-color="#FA8F21"></stop>
                                    <stop offset="0.78" stop-color="#D82D7E"></stop>
                                </radialGradient>
                                <radialGradient id="paint1_radial_502_434" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(10.8617 18.6026) scale(17.9894 17.9786)">
                                    <stop offset="0.64" stop-color="#8C3AAA" stop-opacity="0"></stop>
                                    <stop offset="1" stop-color="#8C3AAA"></stop>
                                </radialGradient>
                            </defs>
                        </svg>
                    </a>
                </li>
                <li class="social-media__item">
                    <a href="#">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#facebook"></use>
                        </svg>
                    </a>
                </li>
                <li class="social-media__item">
                    <a href="#">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#vk"></use>
                        </svg>
                    </a>
                </li>
                <li class="social-media__item">
                    <a href="#">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#tik-tok"></use>
                        </svg>
                    </a>
                </li>
                <li class="social-media__item">
                    <a href="#">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#youtube"></use>
                        </svg>
                    </a>
                </li>
                <li class="social-media__item">
                    <a href="#">
                        <svg>
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#twitter"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>
<div class="substrate"></div>

<div class="category-pop-up">
    <div class="wrapper">
        <? $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "all-menu",
            Array(
                "VIEW_MODE" => "TEXT",
                "SHOW_PARENT_NAME" => "Y",
                "IBLOCK_TYPE" => "products",
                "IBLOCK_ID" => ADS_IBLOCK_ID,
                "SECTION_URL" => "",
                "COUNT_ELEMENTS" => "Y",
                "TOP_DEPTH" => "3",
                "SECTION_FIELDS" => "",
                "SECTION_USER_FIELDS" => "",
                "ADD_SECTIONS_CHAIN" => "Y",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_NOTES" => "Y",
                "CACHE_GROUPS" => "Y",
                "CACHE_FILTER" => "Y",
                "ALL_CATEGORIES_LINK" => "/"
            )
        );?>
    </div>
</div>


<div class="popUp-overlay">
    <div class="popUp-overlay-header">
        <span class="popUp-title">Фильтры</span>
        <span class="popUp-cross">
            <svg>
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
            </svg>
        </span>
    </div>
</div>
<div class="mobile_menu_container">
    <div class="mobile_menu_content">
        <div class="mobile_menu_content__title">
            Категории
            <span class="popUp-cross mobile_menu__cross">
            <svg>
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
            </svg>
        </span>
        </div>
        <ul>
            <li class="category-list__item active"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-1"></use>
                    </svg>
                    Все категории
                </a></li>
            <li class="category-list__item">
                <a href="#" class="parent">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-2"></use>
                    </svg>
                    Бытовая техника</a>
                <ul>
                    <li><a href="#" class="back">Назад
                            <span class="popUp-cross mobile_menu__cross">
            <svg>
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
            </svg>
        </span>
                        </a></li>
                    <li class="category-list__item-active"><a href="#">Все объявления категории</a></li>
                    <li>
                        <div class="menu-subcategory">Комплектующие</div>
                        <div class="menu-subcategory-content">
                            <a href="#">SSD Блоки питания</a>
                            <a href="#">Аккумуляторы</a>
                            <a href="#">Видеокарты</a>
                            <a href="#">Кулеры</a>
                            <a href="#">Материнские платы</a>
                            <a href="#">Оперативная память</a>
                            <a href="#">Оптические приводы</a>
                            <a href="#">Процессоры</a>
                        </div>
                    </li>
                    <li>
                        <div class="menu-subcategory">Компьютеры / системные блоки</div>
                        <div class="menu-subcategory-content">
                            <a href="#">Компьютеры</a>
                            <a href="#">Микрокомпьютеры</a>
                            <a href="#">Моноблоки</a>
                            <a href="#">Мониторы</a>
                        </div>
                    </li>
                    <li>
                        <div class="menu-subcategory">Периферия и аксессуары</div>
                        <div class="menu-subcategory-content">
                            <a href="#">IP-камеры</a>
                            <a href="#">USB Flash</a>
                            <a href="#">USB-хабы</a>
                            <a href="#">Боксы для жестких дисков</a>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="category-list__item">
                <a href="#" class="parent">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-3"></use>
                    </svg>
                    Компьютерная техника
                </a>
                <ul>
                    <li><a href="#" class="back">Назад
                            <span class="popUp-cross mobile_menu__cross">
                             <svg>
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
            </svg>
                        </span>
                        </a></li>
                    <li class="category-list__item-active"><a href="#">Все объявления категории</a></li>
                    <li>
                        <div class="menu-subcategory">Комплектующие</div>
                        <div class="menu-subcategory-content">
                            <a href="#">SSD Блоки питания</a>
                            <a href="#">Аккумуляторы</a>
                            <a href="#">Видеокарты</a>
                            <a href="#">Кулеры</a>
                            <a href="#">Материнские платы</a>
                            <a href="#">Оперативная память</a>
                            <a href="#">Оптические приводы</a>
                            <a href="#">Процессоры</a>
                        </div>
                    </li>
                    <li>
                        <div class="menu-subcategory">Компьютеры / системные блоки</div>
                        <div class="menu-subcategory-content">
                            <a href="#">Компьютеры</a>
                            <a href="#">Микрокомпьютеры</a>
                            <a href="#">Моноблоки</a>
                            <a href="#">Мониторы</a>
                        </div>
                    </li>
                    <li>
                        <div class="menu-subcategory">Периферия и аксессуары</div>
                        <div class="menu-subcategory-content">
                            <a href="#">IP-камеры</a>
                            <a href="#">USB Flash</a>
                            <a href="#">USB-хабы</a>
                            <a href="#">Боксы для жестких дисков</a>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="category-list__item"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-4"></use>
                    </svg>
                    Телефоны и планшеты
                </a></li>
            <li class="category-list__item"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-5"></use>
                    </svg>
                    Электроника
                </a></li>
            <li class="category-list__item"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-6"></use>
                    </svg>
                    Женский гардероб
                </a></li>
            <li class="category-list__item"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-7"></use>
                    </svg>
                    Мужской гардероб
                </a></li>
            <li class="category-list__item"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-8"></use>
                    </svg>
                    Красота и здоровье
                </a></li>
            <li class="category-list__item no-fill"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-9"></use>
                    </svg>
                    Все для детей и мам
                </a></li>
            <li class="category-list__item"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-10"></use>
                    </svg>
                    Мебель
                </a></li>
            <li class="category-list__item"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-11"></use>
                    </svg>
                    Все для дома
                </a></li>
            <li class="category-list__item"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-12"></use>
                    </svg>
                    Ремонт и стройка
                </a></li>
            <li class="category-list__item no-fill"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-13"></use>
                    </svg>
                    Сад и огород</a></li>
            <li class="category-list__item no-fill"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-14"></use>
                    </svg>
                    Хобби, спорт и туризм
                </a></li>
            <li class="category-list__item"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-15"></use>
                    </svg>
                    Свадьба и праздники
                </a></li>
            <li class="category-list__item no-fill"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-16"></use>
                    </svg>
                    Животные
                </a></li>
            <li class="category-list__item"><a href="#">
                    <svg>
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-17"></use>
                    </svg>
                    Прочее
                </a></li>
        </ul>
    </div>
</div>

<div class="mobile_menu_overlay"></div>

<div class="popUp popUp-reset-mail">
    <h3 class="reset-mail__title">Введите E-mail от своего профиля</h3>
    <p class="reset-mail__subtitle">Мы отправим на него ссылку для восстановления пароля</p>
    <form action="#" class="form-reset-mail data-user">
        <div class="form-group">
            <label for="reset-email" class="data-user__label">E-mail*</label>
            <input type="email" name="email" id="reset-email" placeholder="test@gmail.com">
        </div>
        <button class="btn-bg" id="submit-reset-password">Отправить</button>
    </form>
    <span class="modal-cross">
        <svg>
            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup-white"></use>
        </svg>
    </span>
</div>
<?if (!$USER->IsAuthorized()) :?>
    <div class="popUp popUp-login">
        <div class="login-btn-list">
            <button class="login-btn-list__item login-btn active">Вход</button>
            <button class="login-btn-list__item registration-btn">Регистрация</button>
        </div>
        <div class="login-services">
            <span class="login-services__title">Войдите через сервисы:</span>
            <div class="login-services-content">
                <div class="login-services__item"><a href="#"><svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#vk-popup"></use></svg></a></div>
                <div class="login-services__item"><a href="#"><svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#fb"></use></svg></a></div>
                <div class="login-services__item"><a href="#"><svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#google"></use></svg></a></div>
                <div class="login-services__item"><a href="#"><svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#yandex"></use></svg></a></div>
                <div class="login-services__item"><a href="#"><svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#mymir"></use></svg></a></div>
            </div>
        </div>
        <div class="popUp-login-content">
            <div class="login-content active">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.auth.form",
                    "auth",
                    Array(
                        "AUTH_FORGOT_PASSWORD_URL" => "",
                        "AUTH_REGISTER_URL" => "",
                        "AUTH_SUCCESS_URL" => "",
                    ),
                    false
                ); ?>
            </div>
            <div class="registration-content">
                <?$APPLICATION->IncludeComponent(
	"bitrix:main.register", 
	"register", 
                array(
                    "AUTH" => "Y",
                    "REQUIRED_FIELDS" => array(
                    ),
                    "SET_TITLE" => "N",
                    "SHOW_FIELDS" => array(
                    ),
                    "SUCCESS_PAGE" => "",
                    "USER_PROPERTY" => array(
                    ),
                    "USER_PROPERTY_NAME" => "",
                    "USE_BACKURL" => "N",
                    "COMPONENT_TEMPLATE" => "register"
                ),
                false
            );?>
            </div>
        </div>
        <span class="modal-cross">
            <svg>
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup-white"></use>
            </svg>
        </span>
    </div>
<?endif?>
</body>
</html>