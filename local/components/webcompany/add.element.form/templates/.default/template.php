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
        <div class="dropzone__content"></div>
        <?if (!empty($arResult['ERRORS']['IMAGES'])):?>
            <div class="component-errors">
                <ul>
                    <?foreach ($arResult['ERRORS']['IMAGES'] as $errorMessage):?>
                        <li><?=$errorMessage?></li>
                    <?endforeach;?>
                </ul>
            </div>
        <?endif;?>
    </div>
    <div class="product-name">
        <div class="form-group">
            <label for="productName" class="data-user__label">Название товара*</label>
            <input type="text" name="NAME" placeholder="Например, телевизор Horizont" id="productName" required>
        </div>
        <?if (!empty($arResult['ERRORS']['NAME'])):?>
            <div class="component-errors">
                <ul>
                    <?foreach ($arResult['ERRORS']['NAME'] as $errorMessage):?>
                        <li><?=$errorMessage?></li>
                    <?endforeach;?>
                </ul>
            </div>
        <?endif;?>
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
            <?if (!empty($arResult['ERRORS']['IBLOCK_SECTION_ID'])):?>
                <div class="component-errors">
                    <ul>
                        <?foreach ($arResult['ERRORS']['IBLOCK_SECTION_ID'] as $errorMessage):?>
                            <li><?=$errorMessage?></li>
                        <?endforeach;?>
                    </ul>
                </div>
            <?endif;?>
        <?endif;?>
        <div class="category-selection-ready">
            <h3 class="title-block title-block--left">Выбор категории*</h3>
            <div class="category-selection-ready__main" id="category-select"></div>
            <input id="section-id-value" type="hidden" name="IBLOCK_SECTION_ID">
            <div class="btn-bg category-selection-ready-btn">
                <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#pen"></use></svg>
                Изменить подкатегорию</div>
        </div>
        <div class="form-textarea">
            <h3 class="title-block title-block--left mb-20">Описание*:</h3>
            <div class="form-group">
                <label>
                    <textarea name="DETAIL_TEXT" placeholder="Введите описание" id="announcementTextarea" maxlength="4000" required></textarea>
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
            <?if (!empty($arResult['ERRORS']['DETAIL_TEXT'])):?>
                <div class="component-errors">
                    <ul>
                        <?foreach ($arResult['ERRORS']['DETAIL_TEXT'] as $errorMessage):?>
                            <li><?=$errorMessage?></li>
                        <?endforeach;?>
                    </ul>
                </div>
            <?endif;?>
        </div>
        <?if (!empty($arResult['SELECTS'])):?>
            <div class="from-person-location">
                <h3 class="title-block title-block--left">Местоположение:</h3>
                <div class="data-user-container">
                    <div class="form-group">
                        <label for="REGION" class="data-user__label">Область*</label>
                        <select name="REGION" class="custom-select custom-old" id="REGION" required>
                            <?foreach ($arResult['SELECTS']['REGION'] as $key => $regionName):?>
                                <option value="<?=$regionName?>"
                                    <?=!empty($arResult['USER']['REGION']) && $arResult['USER']['REGION'] === $regionName ? "selected" : ($key === 0 ? "selected" : '')?>
                                ><?=$regionName?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                    <?if (!empty($arResult['ERRORS']['REGION'])):?>
                        <div class="component-errors">
                            <ul>
                                <?foreach ($arResult['ERRORS']['REGION'] as $errorMessage):?>
                                    <li><?=$errorMessage?></li>
                                <?endforeach;?>
                            </ul>
                        </div>
                    <?endif;?>
                    <div class="form-group">
                        <label for="CITY" class="data-user__label">Город / Район*</label>
                        <select name="CITY" class="custom-select new-select" id="CITY" required>
                            <?foreach ($arResult['SELECTS']['CITY'] as $key => $cityName):?>
                                <option value="<?=$cityName?>"
                                    <?=!empty($arResult['USER']['CITY']) && $arResult['USER']['CITY'] === $cityName ? "selected" : ($key === 0 ? "selected" : '')?>
                                ><?=$cityName?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                    <?if (!empty($arResult['ERRORS']['CITY'])):?>
                        <div class="component-errors">
                            <ul>
                                <?foreach ($arResult['ERRORS']['CITY'] as $errorMessage):?>
                                    <li><?=$errorMessage?></li>
                                <?endforeach;?>
                            </ul>
                        </div>
                    <?endif;?>
                </div>
            </div>
        <?endif;?>
        <div class="from-person-phone">
            <h3 class="title-block title-block--left">О продавце:</h3>
            <div class="data-user-container data-user-container--tel">
                <div class="form-group">
                    <label for="personName" class="data-user__label">Имя*</label>
                    <input type="text"
                           name="OWNER_NAME"
                           value="<?=!empty($arResult['USER']['NAME']) ? $arResult['USER']['NAME'] : ''?>"
                           placeholder="Введите ваше имя для объявления"
                           id="personName"
                           required
                    >
                </div>
                <?if (!empty($arResult['ERRORS']['OWNER_NAME'])):?>
                    <div class="component-errors">
                        <ul>
                            <?foreach ($arResult['ERRORS']['OWNER_NAME'] as $errorMessage):?>
                                <li><?=$errorMessage?></li>
                            <?endforeach;?>
                        </ul>
                    </div>
                <?endif;?>
                <div class="form-tel-container">
                    <?if (!empty($arResult['USER']['UF_PHONES'])):?>
                        <?foreach ($arResult['USER']['UF_PHONES'] as $phone):?>
                            <div class="form-group form-group--tel">
                                <label for="dataUserTel" class="data-user__label">Контактный телефон*</label>
                                <input type="tel"
                                       name="OWNER_PHONE[]"
                                       placeholder="+375 (xx) xxx-xx-xx"
                                       class="dataUserTel"
                                       id="dataUserTel"
                                       value="<?=$phone?>"
                                       required
                                >
                            </div>
                        <?endforeach;?>
                    <?else:?>
                        <div class="form-group form-group--tel">
                            <label for="dataUserTel" class="data-user__label">Контактный телефон*</label>
                            <input type="tel" name="OWNER_PHONE[]" placeholder="+375 (xx) xxx-xx-xx" class="dataUserTel" id="dataUserTel" required>
                        </div>
                    <?endif;?>
                </div>
                <div class="add-new-phone">
                    <span class="add-new-phone-btn">
                        <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#plus"></use></svg>
                    </span>
                    <div class="add-new-phone-text">Добавить телефон</div>
                </div>
                <?if (!empty($arResult['ERRORS']['OWNER_PHONE'])):?>
                    <div class="component-errors">
                        <ul>
                            <?foreach ($arResult['ERRORS']['OWNER_PHONE'] as $errorMessage):?>
                                <li><?=$errorMessage?></li>
                            <?endforeach;?>
                        </ul>
                    </div>
                <?endif;?>
            </div>
        </div>
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