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

?>
<div class="user-data">
    <div class="wrapper">
        <div class="user-data-content">
            <div class="user-data__img">
                <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/profile.jpg" alt="img">
            </div>
            <div class="user-data-description">
                <div class="user-data__name">Константин</div>
                <div class="user-data__rate">
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
                    <div class="total-rating">
                        <span class="total-rating__text">Оценок:</span>
                        <span class="total-rating__num">76</span>
                    </div>
                </div>
                <div class="user-data__time">
                    На сервисе с <span>октября 2020</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page">
    <div class="wrapper">
        <div class="page-container">
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
                    <ul class="category-list">
                        <li class="category-list__item active"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-1"></use>
                                </svg>
                                Все категории</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-2"></use>
                                </svg>
                                Бытовая техника</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-3"></use>
                                </svg>
                                Компьютерная техника</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-4"></use>
                                </svg>
                                Телефоны и планшеты</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-5"></use>
                                </svg>
                                Электроника</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-6"></use>
                                </svg>
                                Женский гардероб</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-7"></use>
                                </svg>
                                Мужской гардероб</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-8"></use>
                                </svg>
                                Красота и здоровье</a></li>
                        <li class="category-list__item no-fill"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-9"></use>
                                </svg>
                                Все для детей и мам</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-10"></use>
                                </svg>
                                Мебель</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-11"></use>
                                </svg>
                                Все для дома</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-12"></use>
                                </svg>
                                Ремонт и стройка</a></li>
                        <li class="category-list__item no-fill"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-13"></use>
                                </svg>
                                Сад и огород</a></li>
                        <li class="category-list__item no-fill"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-14"></use>
                                </svg>
                                Хобби, спорт и туризм</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-15"></use>
                                </svg>
                                Свадьба и праздники</a></li>
                        <li class="category-list__item no-fill"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-16"></use>
                                </svg>
                                Животные</a></li>
                        <li class="category-list__item"><a href="#">
                                <svg>
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/category.svg#item-17"></use>
                                </svg>
                                Прочее</a></li>
                    </ul>
                </div>
                <div class="aside__item aside__item-form">
                    <div class="aside-form">
                        <form class="aside-form-search" action="#">
                            <div class="form-group-search aside-form__item mobile-input-search">
                                <label for="form-search-mobile">Поиск по товарам</label>
                                <input type="text" placeholder="Искать товары" name="form-search"
                                       class="form-search-input" id="form-search-mobile">
                            </div>
                            <div class="form-group-search form-group-search--select aside-form__item">
                                <label for="selectForm">Область</label>
                                <select name="country" class="custom-select custom-old" id="selectForm">
                                    <option value="minsk" selected>Минск</option>
                                    <option value="brest">Минская область</option>
                                    <option value="grodno">Гродненская область</option>
                                    <option value="gomel">Гомельская область</option>
                                    <option value="mogilev">Могилевская область</option>
                                    <option value="vit">Витебская область</option>
                                </select>
                            </div>
                            <div class="form-group-search form-group-search--select-new aside-form__item">
                                <label for="selectFormNew">Город / Район</label>
                                <select name="city" class="custom-select new-select" data-select="new-list"
                                        id="selectFormNew">
                                </select>
                            </div>
                            <div class="form-group-search aside-form__item">
                                <label for="range-min">Диапазон</label>
                                <div class="form-group-range">
                                    <div class="range__item range-min">
                                        <input type="text" class="range__item-input" placeholder="От" name="range-min"
                                               id="range-min">
                                    </div>
                                    <div class="range__item range-max">
                                        <input type="text" class="range__item-input" placeholder="От" name="range-max">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-search aside-form__item">
                                <label>Выбор из одного варианта</label>
                                <div class="form-group-wrapper">
                                    <div class="form-group__item">
                                        <label for="radio-1">Параметр 1</label>
                                        <input type="radio" id="radio-1" name="radio-btn">
                                    </div>
                                    <div class="form-group__item">
                                        <label for="radio-2">Параметр 2 c длинным названием в 2 строки</label>
                                        <input type="radio" id="radio-2" name="radio-btn">
                                    </div>
                                    <div class="form-group__item">
                                        <label for="radio-3">Параметр 2</label>
                                        <input type="radio" id="radio-3" name="radio-btn">
                                    </div>
                                    <div class="form-group__item">
                                        <label for="radio-4">Параметр 2</label>
                                        <input type="radio" id="radio-4" name="radio-btn">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-search aside-form__item">
                                <label>Множественный выбор</label>
                                <div class="form-group-wrapper checkbox">
                                    <div class="form-group__item">
                                        <label for="checkbox-1" class="label-checkbox">
                                            <input type="checkbox" name="value-1" id="checkbox-1">
                                            <span>Параметр 1</span>
                                        </label>

                                    </div>
                                    <div class="form-group__item checkbox">
                                        <label for="checkbox-2" class="label-checkbox">
                                            <input type="checkbox" name="value-1" id="checkbox-2">
                                            <span>Параметр 2</span>
                                        </label>
                                    </div>
                                    <div class="form-group__item checkbox">
                                        <label for="checkbox-3" class="label-checkbox">
                                            <input type="checkbox" name="value-1" id="checkbox-3">
                                            <span>Параметр 3</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="aside-form__item--btn">
                                <button class="btn-bg btn--main-search">
                                    Найти
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#search-white"></use>
                                    </svg>
                                </button>
                                <button type="reset" class="btn-reset btn-reset--scroll">
                                    <svg>
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-btn"></use>
                                    </svg>
                                    Сбросить фильтры
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>
            <div class="page-content">
                <div class="announcements">
                    <div class="announcements-header">
                        <h2 class="title-section">
                            Товаров: 2
                        </h2>
                        <div class="announcements-switch">
                            <div class="announcements-switch__item switch-list active">
                                <svg width="22" height="18" viewBox="0 0 22 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 8H7C7.26522 8 7.51957 7.89464 7.70711 7.70711C7.89464 7.51957 8 7.26522 8 7V1C8 0.734784 7.89464 0.48043 7.70711 0.292893C7.51957 0.105357 7.26522 0 7 0H1C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1V7C0 7.26522 0.105357 7.51957 0.292893 7.70711C0.48043 7.89464 0.734784 8 1 8ZM2 2H6V6H2V2ZM7 18C7.26522 18 7.51957 17.8946 7.70711 17.7071C7.89464 17.5196 8 17.2652 8 17V11C8 10.7348 7.89464 10.4804 7.70711 10.2929C7.51957 10.1054 7.26522 10 7 10H1C0.734784 10 0.48043 10.1054 0.292893 10.2929C0.105357 10.4804 0 10.7348 0 11V17C0 17.2652 0.105357 17.5196 0.292893 17.7071C0.48043 17.8946 0.734784 18 1 18H7ZM2 12H6V16H2V12ZM21 3H11C10.7348 3 10.4804 3.10536 10.2929 3.29289C10.1054 3.48043 10 3.73478 10 4C10 4.26522 10.1054 4.51957 10.2929 4.70711C10.4804 4.89464 10.7348 5 11 5H21C21.2652 5 21.5196 4.89464 21.7071 4.70711C21.8946 4.51957 22 4.26522 22 4C22 3.73478 21.8946 3.48043 21.7071 3.29289C21.5196 3.10536 21.2652 3 21 3ZM21 13H11C10.7348 13 10.4804 13.1054 10.2929 13.2929C10.1054 13.4804 10 13.7348 10 14C10 14.2652 10.1054 14.5196 10.2929 14.7071C10.4804 14.8946 10.7348 15 11 15H21C21.2652 15 21.5196 14.8946 21.7071 14.7071C21.8946 14.5196 22 14.2652 22 14C22 13.7348 21.8946 13.4804 21.7071 13.2929C21.5196 13.1054 21.2652 13 21 13Z"/>
                                    <path d="M1 8H7C7.26522 8 7.51957 7.89464 7.70711 7.70711C7.89464 7.51957 8 7.26522 8 7V1C8 0.734784 7.89464 0.48043 7.70711 0.292893C7.51957 0.105357 7.26522 0 7 0H1C0.734784 0 0.48043 0.105357 0.292893 0.292893C0.105357 0.48043 0 0.734784 0 1V7C0 7.26522 0.105357 7.51957 0.292893 7.70711C0.48043 7.89464 0.734784 8 1 8ZM2 2H6V6H2V2ZM7 18C7.26522 18 7.51957 17.8946 7.70711 17.7071C7.89464 17.5196 8 17.2652 8 17V11C8 10.7348 7.89464 10.4804 7.70711 10.2929C7.51957 10.1054 7.26522 10 7 10H1C0.734784 10 0.48043 10.1054 0.292893 10.2929C0.105357 10.4804 0 10.7348 0 11V17C0 17.2652 0.105357 17.5196 0.292893 17.7071C0.48043 17.8946 0.734784 18 1 18H7ZM2 12H6V16H2V12ZM21 3H11C10.7348 3 10.4804 3.10536 10.2929 3.29289C10.1054 3.48043 10 3.73478 10 4C10 4.26522 10.1054 4.51957 10.2929 4.70711C10.4804 4.89464 10.7348 5 11 5H21C21.2652 5 21.5196 4.89464 21.7071 4.70711C21.8946 4.51957 22 4.26522 22 4C22 3.73478 21.8946 3.48043 21.7071 3.29289C21.5196 3.10536 21.2652 3 21 3ZM21 13H11C10.7348 13 10.4804 13.1054 10.2929 13.2929C10.1054 13.4804 10 13.7348 10 14C10 14.2652 10.1054 14.5196 10.2929 14.7071C10.4804 14.8946 10.7348 15 11 15H21C21.2652 15 21.5196 14.8946 21.7071 14.7071C21.8946 14.5196 22 14.2652 22 14C22 13.7348 21.8946 13.4804 21.7071 13.2929C21.5196 13.1054 21.2652 13 21 13Z"/>
                                </svg>
                            </div>
                            <div class="announcements-switch__item switch-card">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <mask id="path-1-inside-1_404_2873" fill="white">
                                        <rect width="8" height="8" rx="1" stroke-width="0"/>
                                    </mask>
                                    <rect width="8" height="8" rx="1" stroke-width="4"
                                          mask="url(#path-1-inside-1_404_2873)"/>
                                    <mask id="path-2-inside-2_404_2873" fill="white">
                                        <rect x="10" width="8" height="8" rx="1" stroke-width="0"/>
                                    </mask>
                                    <rect x="10" width="8" height="8" rx="1" stroke-width="4"
                                          mask="url(#path-2-inside-2_404_2873)"/>
                                    <mask id="path-3-inside-3_404_2873" fill="white">
                                        <rect x="10" y="10" width="8" height="8" rx="1" stroke-width="0"/>
                                    </mask>
                                    <rect x="10" y="10" width="8" height="8" rx="1" stroke-width="4"
                                          mask="url(#path-3-inside-3_404_2873)"/>
                                    <mask id="path-4-inside-4_404_2873" fill="white">
                                        <rect y="10" width="8" height="8" rx="1" stroke-width="0"/>
                                    </mask>
                                    <rect y="10" width="8" height="8" rx="1" stroke-width="4"
                                          mask="url(#path-4-inside-4_404_2873)"/>
                                </svg>

                            </div>
                        </div>
                    </div>
                    <div class="announcements-content">
                        <div class="announcements-content__item announcements-content__item--list active">
                            <a href="#" class="announcements-list__item">
                                <div class="announcements-img">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/announcements-list/item-1.jpg" alt="img">
                                </div>
                                <div class="announcements-description">
                                    <div class="announcements-description__head">
                                        <h3>ШИНЫ, ДИСКИ на Мерседес оригинал R16 подходят Sprinter, Vito, и другие Ме.
                                            Колпаки, R16, б/у</h3>
                                        <span class="favorite-card"></span>
                                    </div>
                                    <div class="announcements-description__location">
                                        <div class="location">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#location"></use>
                                            </svg>
                                            Минск, Партизанский район
                                        </div>
                                        <div class="announcements-data">
                                            26.09.2022 в 12:02
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="announcements-list__item">
                                <div class="announcements-img">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/announcements-list/item-2.jpg" alt="img">
                                </div>
                                <div class="announcements-description">
                                    <div class="announcements-description__head">
                                        <h3>Свитер желтый из нейлона (размер S)</h3>
                                        <span class="favorite-card"></span>
                                    </div>
                                    <div class="announcements-description__location">
                                        <div class="location">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#location"></use>
                                            </svg>
                                            Минск, Партизанский район
                                        </div>
                                        <div class="announcements-data">
                                            26.09.2022 в 12:02
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>
                        <div class="announcements-content__item announcements-content__item--card">
                            <a href="#" class="announcements-card__item">
                        <span class="announcements-card__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-3.jpg" alt="alt">
                        </span>
                                <span class="viewed-slider__item-description">
                                  <span class="announcements-card__item--title">Зеркало с люминесцентной подсветкой (120х75 см).</span>

                                    <div class="location">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#location"></use>
                                            </svg>
                                            Минск, Партизанский район
                                        </div>
                                    <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                                <span class="favorite-card">
                            </span>
                            </a>
                            <a href="#" class="announcements-card__item">
                        <span class="announcements-card__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-4.jpg" alt="alt">
                        </span>
                                <span class="viewed-slider__item-description">
                                  <span class="announcements-card__item--title">ШИНЫ, ДИСКИ на Мерседес оригинал R16 подходят Sprinter, Vito, и другие Ме.
Колпаки, R16, б/у )</span>
                                     <div class="location">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#location"></use>
                                            </svg>
                                            Минск, Партизанский район
                                        </div>
                            <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                                <span class="favorite-card">
                            </span>
                            </a>
                            <a href="#" class="announcements-card__item">
                        <span class="announcements-card__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-2.jpg" alt="alt">
                        </span>
                                <span class="viewed-slider__item-description">
                                  <span class="announcements-card__item--title">Свитер желтый из нейлона (размер S)</span>
                             <div class="location">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#location"></use>
                                            </svg>
                                            Минск, Партизанский район
                                        </div>
                                    <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                                <span class="favorite-card">
                            </span>
                            </a>
                            <a href="#" class="announcements-card__item">
                        <span class="announcements-card__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-2.jpg" alt="alt">
                        </span>
                                <span class="viewed-slider__item-description">
                                  <span class="announcements-card__item--title">Свитер желтый из нейлона (размер S)</span>
                             <div class="location">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#location"></use>
                                            </svg>
                                            Минск, Партизанский район
                                        </div>
                                    <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                                <span class="favorite-card">
                            </span>
                            </a>
                            <a href="#" class="announcements-card__item">
                        <span class="announcements-card__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-2.jpg" alt="alt">
                        </span>
                                <span class="viewed-slider__item-description">
                                  <span class="announcements-card__item--title">Свитер желтый из нейлона (размер S)</span>
                             <div class="location">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#location"></use>
                                            </svg>
                                            Минск, Партизанский район
                                        </div>
                                    <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                                <span class="favorite-card">
                            </span>
                            </a>
                            <a href="#" class="announcements-card__item">
                        <span class="announcements-card__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-3.jpg" alt="alt">
                        </span>
                                <span class="viewed-slider__item-description">
                                  <span class="announcements-card__item--title">Зеркало с люминесцентной подсветкой (120х75 см).</span>
                             <div class="location">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#location"></use>
                                            </svg>
                                            Минск, Партизанский район
                                        </div>
                                    <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                                <span class="favorite-card">
                            </span>
                            </a>
                            <a href="#" class="announcements-card__item w-1700">
                        <span class="announcements-card__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-4.jpg" alt="alt">
                        </span>
                                <span class="viewed-slider__item-description">
                                  <span class="announcements-card__item--title">ШИНЫ, ДИСКИ на Мерседес оригинал R16 подходят Sprinter, Vito, и другие Ме.
Колпаки, R16, б/у )</span>
                             <div class="location">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#location"></use>
                                            </svg>
                                            Минск, Партизанский район
                                        </div>
                                    <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                                <span class="favorite-card">
                            </span>
                            </a>
                            <a href="#" class="announcements-card__item w-1700">
                        <span class="announcements-card__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-4.jpg" alt="alt">
                        </span>
                                <span class="viewed-slider__item-description">
                                  <span class="announcements-card__item--title">ШИНЫ, ДИСКИ на Мерседес оригинал R16 подходят Sprinter, Vito, и другие Ме.
Колпаки, R16, б/у )</span>
                            <div class="location">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#location"></use>
                                            </svg>
                                            Минск, Партизанский район
                                        </div>
                            <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                                <span class="favorite-card">
                            </span>
                            </a>
                        </div>
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
                <div class="viewed">
                    <h2 class="title-section">Ранее вы смотрели</h2>
                    <div class="viewed-slider">
                        <a href="https://www.google.com/search?q=dog+img&tbm=isch&ved=2ahUKEwj_j7To9aH8AhWDwgIHHSh6Bn0Q2-cCegQIABAA&oq=dog+img&gs_lcp=CgNpbWcQAzIECCMQJzIECAAQHjIECAAQHjIGCAAQBRAeMgkIABCABBAKEBg6BAgAEEM6BQgAEIAEUIsGWKgNYMcPaABwAHgAgAFeiAGjA5IBATWYAQCgAQGqAQtnd3Mtd2l6LWltZ8ABAQ&sclient=img&ei=AyevY7-CHoOFi-gPqPSZ6Ac&bih=1306&biw=2560#imgrc=u61zC0xCLTOo1M"
                           class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-1.jpg" alt="alt">
                        </span>
                            <span class="viewed-slider__item-description">
                                      <span class="viewed-slider__item-title">Зеркало с люминесцентной подсветкой (120х75 см).  290G - SP20</span>
                                <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                            <span class="favorite-card">
                            </span>
                        </a>
                        <a href="#" class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-2.jpg" alt="alt">
                        </span>
                            <span class="viewed-slider__item-description">
                                  <span class="viewed-slider__item-title">Свитер желтый из нейлона (размер S)</span>
                            <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                            <span class="favorite-card">
                            </span>
                        </a>
                        <a href="#" class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
                            <img src="https://images.unsplash.com/photo-1615751072497-5f5169febe17?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8Y3V0ZSUyMGRvZ3xlbnwwfHwwfHw%3D&w=1000&q=80"
                                 alt="alt">
                        </span>
                            <span class="viewed-slider__item-description">
                                      <span class="viewed-slider__item-title">Зеркало с люминесцентной подсветкой (120х75 см).  290G - SP20</span>
                                <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                            <span class="favorite-card">
                            </span>
                        </a>
                        <a href="#" class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-2.jpg" alt="alt">
                        </span>
                            <span class="viewed-slider__item-description">
                                  <span class="viewed-slider__item-title">Свитер желтый из нейлона (размер S)</span>
                            <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                            <span class="favorite-card">
                            </span>
                        </a>
                        <a href="#" class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-1.jpg" alt="alt">
                        </span>
                            <span class="viewed-slider__item-description">
                                      <span class="viewed-slider__item-title">Зеркало с люминесцентной подсветкой (120х75 см).  290G - SP20</span>
                                <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                            <span class="favorite-card">
                            </span>
                        </a>
                        <a href="#" class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-2.jpg" alt="alt">
                        </span>
                            <span class="viewed-slider__item-description">
                                  <span class="viewed-slider__item-title">Свитер желтый из нейлона (размер S)</span>
                            <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                            <span class="favorite-card">
                            </span>
                        </a>
                        <a href="#" class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-1.jpg" alt="alt">
                        </span>
                            <span class="viewed-slider__item-description">
                                      <span class="viewed-slider__item-title">Зеркало с люминесцентной подсветкой (120х75 см).  290G - SP20</span>
                                <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                            <span class="favorite-card">
                            </span>
                        </a>
                        <a href="#" class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-2.jpg" alt="alt">
                        </span>
                            <span class="viewed-slider__item-description">
                                  <span class="viewed-slider__item-title">Свитер желтый из нейлона (размер S)</span>
                            <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                            <span class="favorite-card">
                            </span>
                        </a>
                        <a href="#" class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-1.jpg" alt="alt">
                        </span>
                            <span class="viewed-slider__item-description">
                                      <span class="viewed-slider__item-title">Зеркало с люминесцентной подсветкой (120х75 см).  290G - SP20</span>
                                <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                            <span class="favorite-card">
                            </span>
                        </a>
                        <a href="#" class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-2.jpg" alt="alt">
                        </span>
                            <span class="viewed-slider__item-description">
                                  <span class="viewed-slider__item-title">Свитер желтый из нейлона (размер S)</span>
                            <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                            <span class="favorite-card">
                            </span>
                        </a>
                        <a href="#" class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
                            <img src="<?=SITE_TEMPLATE_PATH?>/html/assets/img/card/item-1.jpg" alt="alt">
                        </span>
                            <span class="viewed-slider__item-description">
                                      <span class="viewed-slider__item-title">Зеркало с люминесцентной подсветкой (120х75 см).  290G - SP20</span>
                                <span class="viewed-slider__item-data">28.11.2022 в 12:02</span>
                            </span>
                            <span class="favorite-card">
                            </span>
                        </a>
                        <a href="#" class="viewed-slider__item">
                        <span class="viewed-slider__item-img">
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
    </div>
</div>