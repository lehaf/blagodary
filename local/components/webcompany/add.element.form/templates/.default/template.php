<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$standardSpriteImgPath = SITE_TEMPLATE_PATH.'/html/assets/img/sprites/category.svg#item-17';
?>
<form action="" method="POST" class="announcement-form form-block" enctype="multipart/form-data">
    <div class="dropzone">
        <h3 class="title-block title-block--left mobile-center">Фотографии</h3>
        <div class="form-group form-group__file">
            <label for="inputFile">
                <input name="IMAGES[]" type="file" accept="image/*" id="inputFile" multiple>
                <span class="input-file-btn">
                    <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use></svg>
                    Добавить фотографии
                </span>
            </label>
            <span class="drop-info-text">или перетащите сюда</span>
        </div>
        <div class="dropzone__description">
            <p>Используйте реальные фото вашего товара в разных ракурсах. Максимальный размер: 10 МБ.</p>
            <div class="dropzone_count">
                Загружено <span class="dropzone_count__loaded">0</span> из 9
            </div>
        </div>
        <div class="dropzone__content">

        </div>
    </div>
    <div class="product-name">
        <div class="form-group">
            <label for="productName" class="data-user__label">Название товара*</label>
            <input type="text" name="NAME" placeholder="Например, телевизор Horizont" id="productName">
        </div>
    </div>
    <div class="form-wrapper" id="categorySelection">
        <?if (!empty($arResult['SECTIONS_LVL'])):?>
            <?$firstKey = array_key_first($arResult['SECTIONS_LVL'][1])?>
            <div class="category-selection">
                <div class="category-selection-main">
                    <h3 class="title-block title-block--left">Выбор категории*</h3>
                    <ul class="category-list category-list--selection">
                        <?foreach ($arResult['SECTIONS_LVL'][1] as $sectId => $arSect):?>
                            <li class="category-list__item <?=$sectId === $firstKey ? 'is-active' : ''?>"
                                data-section-id="<?=$sectId?>"
                                data-announcement-category="<?=$arSect['ID']?>"
                            >
                                <a href="<?=$arSect['SECTION_PAGE_URL']?>">
                                    <?if (!empty($arSect['PICTURE'])):?>
                                        <img src="<?=$arSect['PICTURE']?>"
                                             height="16"
                                             width="16"
                                             title="<?=$arSect['NAME']?>"
                                             alt="<?=$arSect['NAME']?>"
                                        >
                                    <?else:?>
                                        <svg>
                                            <use xlink:href="<?=$standardSpriteImgPath?>"></use>
                                        </svg>
                                    <?endif;?>
                                    <?=$arSect['NAME']?>
                                </a>
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
                <div class="category-selection-subcategory">
                    <h3 class="title-block title-block--left title-subcategory">Подкатегории второго уровня</h3>
                    <div class="category-selection-content">
                        <?foreach ($arResult['SECTIONS_LVL'][2] as $parentSectId => $arSections):?>
                            <div class="category-selection-content__item <?=$parentSectId === $firstKey ? 'is-active' : ''?>"
                                 data-parent-id="<?=$parentSectId?>"
                                 data-announcement-category="<?=$parentSectId?>"
                            >
                                <ul class="category-selection-list">
                                    <?foreach ($arSections as $arSectLvl2):?>
                                        <li class="category-selection-list__item" data-section-id="<?=$arSectLvl2['ID']?>"><?=$arSectLvl2['NAME']?></li>
                                    <?endforeach;?>
                                </ul>
                            </div>
                        <?endforeach;?>
                    </div>
                </div>
                <div class="category-selection-subcategory-3">
                    <h3 class="title-block title-block--left title-subcategory">Подкатегории третьего уровня</h3>
                    <div class="category-selection-content-3">
                        <?foreach ($arResult['SECTIONS_LVL'][3] as $parentSectId => $arSections):?>
                            <div class="category-selection-content__item"
                                 data-announcement-category="<?=$parentSectId?>"
                                 data-parent-id="<?=$parentSectId?>"
                            >
                                <ul class="category-selection-list">
                                    <?foreach ($arSections as $arSectLvl3):?>
                                        <li class="category-selection-list__item" data-section-id="<?=$arSectLvl2['ID']?>"><?=$arSectLvl3['NAME']?></li>
                                    <?endforeach;?>
                                </ul>
                            </div>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
        <?endif;?>
        <div class="category-selection-ready">
            <h3 class="title-block title-block--left">Выбор категории*</h3>
            <div class="category-selection-ready__main" id="category-select"></div>
            <input id="section-id-value" type="hidden" name="IBLOCK_SECTION_ID">
            <div class="btn-bg category-selection-ready-btn">
                <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#pen"></use></svg>
                Изменить подкатегорию</div>
        </div>
        <!--                <div class="extra-options">-->
        <!--                    <h3 class="title-block title-block--left">Дополнительные параметры для выбранной подкатегории:</h3>-->
        <!--                    <div class="form-group">-->
        <!--                        <label for="extraOptionsSelect" class="data-user__label">Выпадающий список</label>-->
        <!--                        <select name="country" class="custom-select " id="extraOptionsSelect">-->
        <!--                            <option value="1" selected>Параметр 1</option>-->
        <!--                            <option value="2">Параметр 2</option>-->
        <!--                            <option value="3">Параметр 3</option>-->
        <!--                        </select>-->
        <!--                    </div>-->
        <!--                    <div class="form-container">-->
        <!--                        <label for="rangeStart" class="data-user__label data-user__label--range">Диапазон</label>-->
        <!--                        <div class="form-group-wrapper form-group-wrapper--range">-->
        <!--                            <div class="for-group for-group--range">-->
        <!--                                <input type="text" id="rangeStart" placeholder="От">-->
        <!--                            </div>-->
        <!--                            <div class="for-group for-group--range">-->
        <!--                                <input type="text" id="rangeEnd" placeholder="До">-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <div class="form-group form-group-100">-->
        <!--                        <label class="data-user__label">Выбор из одного варианта</label>-->
        <!--                        <div class="form-group-wrapper form-group-radio">-->
        <!--                            <div class="form-group__item">-->
        <!--                                <label for="radio-1">Параметр 1</label>-->
        <!--                                <input type="radio" id="radio-1" name="radio-btn">-->
        <!--                            </div>-->
        <!--                            <div class="form-group__item">-->
        <!--                                <label for="radio-2">Параметр 2 c длинным названием в 2 строки</label>-->
        <!--                                <input type="radio" id="radio-2" name="radio-btn">-->
        <!--                            </div>-->
        <!--                            <div class="form-group__item">-->
        <!--                                <label for="radio-3">Параметр 2</label>-->
        <!--                                <input type="radio" id="radio-3" name="radio-btn">-->
        <!--                            </div>-->
        <!--                            <div class="form-group__item">-->
        <!--                                <label for="radio-4">Параметр 2</label>-->
        <!--                                <input type="radio" id="radio-4" name="radio-btn">-->
        <!--                            </div>-->
        <!--                            <div class="form-group__item">-->
        <!--                                <label for="radio-5">Параметр 1</label>-->
        <!--                                <input type="radio" id="radio-5" name="radio-btn">-->
        <!--                            </div>-->
        <!--                            <div class="form-group__item">-->
        <!--                                <label for="radio-6">Параметр 2 c длинным названием в 2 строки</label>-->
        <!--                                <input type="radio" id="radio-6" name="radio-btn">-->
        <!--                            </div>-->
        <!--                            <div class="form-group__item">-->
        <!--                                <label for="radio-7">Параметр 2</label>-->
        <!--                                <input type="radio" id="radio-7" name="radio-btn">-->
        <!--                            </div>-->
        <!--                            <div class="form-group__item">-->
        <!--                                <label for="radio-8">Параметр 2</label>-->
        <!--                                <input type="radio" id="radio-8" name="radio-btn">-->
        <!--                            </div>-->
        <!--                            <div class="form-group__item">-->
        <!--                                <label for="radio-9">Параметр 2 c длинным названием в 2 строки</label>-->
        <!--                                <input type="radio" id="radio-9" name="radio-btn">-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <div class="form-group">-->
        <!--                        <label class="data-user__label">Множественный выбор</label>-->
        <!--                        <div class="form-group-wrapper checkbox">-->
        <!--                            <div class="form-group__item">-->
        <!--                                <label for="checkbox-1" class="label-checkbox">-->
        <!--                                    <input type="checkbox" name="value-1" id="checkbox-1">-->
        <!--                                    <span>Параметр 1</span>-->
        <!--                                </label>-->
        <!---->
        <!--                            </div>-->
        <!--                            <div class="form-group__item checkbox">-->
        <!--                                <label for="checkbox-2" class="label-checkbox">-->
        <!--                                    <input type="checkbox" name="value-1" id="checkbox-2">-->
        <!--                                    <span>Параметр 2</span>-->
        <!--                                </label>-->
        <!--                            </div>-->
        <!--                            <div class="form-group__item checkbox">-->
        <!--                                <label for="checkbox-3" class="label-checkbox">-->
        <!--                                    <input type="checkbox" name="value-1" id="checkbox-3">-->
        <!--                                    <span>Параметр 3</span>-->
        <!--                                </label>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <div class="form-textarea">
            <h3 class="title-block title-block--left mb-20">Описание*:</h3>
            <div class="form-group">
                <label>
                    <textarea name="DETAIL_TEXT" placeholder="Введите описание" id="announcementTextarea" maxlength="4000"></textarea>
                </label>
                <div class="form-textarea-description">
                    <div class="min-text">Минимально: 20 знаков</div>
                    <div class="result-text">
                        <div class="result-text-value">0</div>
                        из
                        <div class="result-text-max">4000</div>
                        знаков
                    </div>
                </div>
            </div>
        </div>
        <?if (!empty($arResult['SELECTS'])):?>
            <div class="from-person-location">
                <h3 class="title-block title-block--left">Местоположение:</h3>
                <div class="data-user-container">
                    <div class="form-group">
                        <label for="REGION" class="data-user__label">Область*</label>
                        <select name="REGION" class="custom-select custom-old" id="REGION">
                            <?foreach ($arResult['SELECTS']['REGION'] as $key => $regionName):?>
                                <option value="<?=$regionName?>"
                                    <?=!empty($arResult['USER']['REGION']) && $arResult['USER']['REGION'] === $regionName ? "selected" : ($key === 0 ? "selected" : '')?>
                                ><?=$regionName?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="CITY" class="data-user__label">Город / Район*</label>
                        <select name="CITY" class="custom-select new-select" id="CITY">
                            <?foreach ($arResult['SELECTS']['CITY'] as $key => $cityName):?>
                                <option value="<?=$cityName?>"
                                    <?=!empty($arResult['USER']['CITY']) && $arResult['USER']['CITY'] === $cityName ? "selected" : ($key === 0 ? "selected" : '')?>
                                ><?=$cityName?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
        <?endif;?>
        <button type="submit" class="btn btn--form <?=empty($arResult['USER']['NAME']) ? 'btn--no-name-error' : ''?>">
            <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use></svg>
            Подать объявление
        </button>
    </div>
</form>


<div class="popUp popUp-error">
    <div class="popUp-successful-img">
        <svg>
            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#error">
            </use>
        </svg>
    </div>
    <h5 class="popUp-error__title">Не хватает данных для подачи.</h5>
    <p class="popUp-error__description">
        Чтобы подать объявление, заполните недостающие данные: "ИМЯ" в "Настройках" / "Персональные данные"
    </p>
    <a href="/personal/user/" class="btn-bg popUp-error__btn">Перейти к заполнению</a>
    <span class="modal-cross">
        <svg>
            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
        </svg>
    </span>
</div>