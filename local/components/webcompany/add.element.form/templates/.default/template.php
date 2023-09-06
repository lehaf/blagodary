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
    <?if (!empty($arResult['ITEM']['ID'])):?>
        <input name="ITEM_ID" type="hidden" value="<?=$arResult['ITEM']['ID']?>">
    <?endif;?>
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
                Загружено <span class="dropzone_count__loaded"><?=!empty($arResult['ITEM']['IMAGES']) ? count($arResult['ITEM']['IMAGES']) : 0?></span> из 10
            </div>
        </div>
        <div class="dropzone__content" data-edit-img='<?=$arResult['ITEM']['IMAGES_JSON']?>'>
            <?if (!empty($arResult['ITEM']['IMAGES'])):?>
                <?foreach ($arResult['ITEM']['IMAGES'] as $key => $arImg):?>
                    <div class="preview-img">
                        <img src="<?=$arImg['SRC']?>"
                             alt="<?=$arResult['ITEM']['NAME']?>"
                             title="<?=$arResult['ITEM']['NAME']?>"
                        >
                        <span class="preview-remove" data-file="<?=$arImg['SRC']?>">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.33594 7.71732L9.8652 11.2466L10.0066 11.1052L9.86521 11.2466C10.2473 11.6287 10.8669 11.6289 11.2492 11.2466C11.6315 10.8645 11.6315 10.2448 11.2492 9.86258L7.71996 6.33329L11.2492 2.80403C11.2492 2.80402 11.2492 2.80401 11.2492 2.80399C11.6315 2.42184 11.6315 1.80221 11.2492 1.41996C10.8671 1.03765 10.2474 1.03772 9.8652 1.41996L10.0066 1.56138L9.8652 1.41996L6.33594 4.94925L2.80671 1.42C2.42458 1.03766 1.80494 1.0377 1.42268 1.41992L6.33594 7.71732ZM6.33594 7.71732L2.80667 11.2466L2.80663 11.2467C2.42438 11.6287 1.80478 11.6287 1.42265 11.2466L1.42264 11.2466C1.0404 10.8644 1.04033 10.2447 1.42264 9.86258C1.42266 9.86257 1.42267 9.86255 1.42268 9.86254L4.95191 6.33329L1.42264 2.80399C1.0404 2.42175 1.04034 1.80211 1.42264 1.41996L6.33594 7.71732Z" stroke="#8E8E8E" stroke-width="0.4"></path>
                            </svg>
                        </span>
                    </div>
                <?endforeach;?>
            <?endif;?>
        </div>
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
            <input type="text"
                   name="NAME"
                   placeholder="Например, телевизор Horizont"
                   id="productName"
                   value="<?=!empty($arResult['ITEM']['NAME']) ? $arResult['ITEM']['NAME'] : ''?>"
                   required
            >
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
            <div class="category-selection" <?if (!empty($arResult['ITEM']) && !empty($arResult['ITEM']['IBLOCK_SECTION_ID'])):?>style="display: none;"<?endif;?>>
                <div class="category-selection-main">
                    <h3 class="title-block title-block--left">Выбор категории*</h3>
                    <ul class="category-list category-list--selection">
                        <?foreach ($arResult['SECTIONS_LVL'][1] as $sectId => $arSect):?>
                            <li class="category-list__item <?=empty($arResult['ITEM']['SECTIONS']['TREE'][1]) && $sectId === $firstKey ? 'is-active'
                                : ($arResult['ITEM']['SECTIONS']['TREE'][1] == $sectId ? 'is-active'  : '')?>"
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
                            <div class="category-selection-content__item <?=empty($arResult['ITEM']['SECTIONS']['TREE'][1]) && $parentSectId === $firstKey ? 'is-active'
                                : ($arResult['ITEM']['SECTIONS']['TREE'][1] == $parentSectId ? 'is-active'  : '')?>"
                                 data-parent-id="<?=$parentSectId?>"
                                 data-announcement-category="<?=$parentSectId?>"
                            >
                                <ul class="category-selection-list">
                                    <?foreach ($arSections as $arSectLvl2):?>
                                        <li class="category-selection-list__item <?=$arResult['ITEM']['SECTIONS']['TREE'][2] == $arSectLvl2['ID'] ? 'active'  : ''?>"
                                            data-section-id="<?=$arSectLvl2['ID']?>"
                                        ><?=$arSectLvl2['NAME']?></li>
                                    <?endforeach;?>
                                </ul>
                            </div>
                        <?endforeach;?>
                    </div>
                </div>
                <div class="category-selection-subcategory-3" <?if (!empty($arResult['ITEM']['SECTIONS']['TREE'][3])):?>style="display: block"<?endif;?>>
                    <h3 class="title-block title-block--left title-subcategory">Подкатегории третьего уровня</h3>
                    <div class="category-selection-content-3">
                        <?foreach ($arResult['SECTIONS_LVL'][3] as $parentSectId => $arSections):?>
                            <div class="category-selection-content__item <?=empty($arResult['ITEM']['SECTIONS']['TREE'][2]) && $parentSectId === $firstKey ? 'is-active'
                                : ($arResult['ITEM']['SECTIONS']['TREE'][2] == $parentSectId ? 'is-active'  : '')?>"
                                 data-announcement-category="<?=$parentSectId?>"
                                 data-parent-id="<?=$parentSectId?>"
                            >
                                <ul class="category-selection-list">
                                    <?foreach ($arSections as $arSectLvl3):?>
                                        <li class="category-selection-list__item <?=$arResult['ITEM']['SECTIONS']['TREE'][3] == $arSectLvl3['ID'] ? 'active'  : ''?>"
                                            data-section-id="<?=$arSectLvl3['ID']?>"
                                        ><?=$arSectLvl3['NAME']?></li>
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
        <div class="category-selection-ready <?=!empty($arResult['ITEM']) && !empty($arResult['ITEM']['IBLOCK_SECTION_ID']) ? 'active' : ''?>">
            <h3 class="title-block title-block--left">Выбор категории*</h3>
            <div class="category-selection-ready__main" id="category-select">
                <?=!empty($arResult['ITEM']['SECTIONS']['PATH_NAME']) ? $arResult['ITEM']['SECTIONS']['PATH_NAME'] : ''?>
            </div>
            <input id="section-id-value"
                   type="hidden"
                   name="IBLOCK_SECTION_ID"
                   value="<?=!empty($arResult['ITEM']['IBLOCK_SECTION_ID']) ? $arResult['ITEM']['IBLOCK_SECTION_ID'] : ''?>"
            >
            <div class="btn-bg category-selection-ready-btn">
                <svg><use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#pen"></use></svg>
                Изменить подкатегорию</div>
        </div>
        <div class="form-textarea">
            <h3 class="title-block title-block--left mb-20">Описание*:</h3>
            <div class="form-group">
                <label>
                    <textarea name="DETAIL_TEXT"
                              placeholder="Введите описание"
                              id="announcementTextarea"
                              maxlength="4000"
                              required
                    ><?=!empty($arResult['ITEM']['DETAIL_TEXT']) ? $arResult['ITEM']['DETAIL_TEXT'] : ''?></textarea>
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
                            <?foreach ($arResult['SELECTS']['REGION'] as $key => $region):?>
                                <option value="<?=$region['ID']?>"
                                        data-dependency="<?=$region['XML_ID']?>"
                                    <?if (!empty($arResult['ITEM']['REGION'])):?>
                                        <?=$arResult['ITEM']['REGION'] === $key ? "selected" : ($key === 0 ? "selected" : '')?>
                                    <?else:?>
                                        <?=!empty($arResult['USER']['REGION']) && $arResult['USER']['REGION'] === $region['VALUE'] ? "selected" : ($key === 0 ? "selected" : '')?>
                                    <?endif;?>
                                ><?=$region['VALUE']?></option>
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
                            <?foreach ($arResult['SELECTS']['CITY'] as $cityId => $city):?>
                                <option data-dependency="<?=$city['UF_GROUP']?>"
                                        value="<?=$city['UF_XML_ID']?>"
                                    <?if (!empty($arResult['ITEM']['CITY'])):?>
                                        <?=$arResult['ITEM']['CITY'] === $city['UF_XML_ID'] ? "selected" : ''?>
                                    <?else:?>
                                        <?=!empty($arResult['USER']['CITY']) && $arResult['USER']['CITY'] === $city['UF_NAME'] ? "selected" : ''?>
                                    <?endif;?>
                                ><?=$city['UF_NAME']?></option>
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
                           value="<?=!empty($arResult['ITEM']['OWNER_NAME']) ? $arResult['ITEM']['OWNER_NAME'] : $arResult['USER']['NAME']?>"
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
                    <?if (!empty($arResult['ITEM']['OWNER_PHONE'])):?>
                        <?$firstKey = array_key_first($arResult['ITEM']['OWNER_PHONE'])?>
                        <?foreach ($arResult['ITEM']['OWNER_PHONE'] as $key => $phone):?>
                            <div class="form-group form-group--tel">
                                <label for="dataUserTel" class="data-user__label">Контактный телефон*</label>
                                <input type="tel"
                                       name="OWNER_PHONE[]"
                                       placeholder="+375 (xx) xxx-xx-xx"
                                       class="dataUserTel"
                                       id="dataUserTel"
                                       value="<?=$phone?>"
                                       <?=$firstKey === $key ? 'required' : ''?>
                                >
                                <?if ($firstKey !== $key):?>
                                    <span class="remove_phone">
                                        <svg>
                                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
                                        </svg>
                                    </span>
                                <?endif;?>
                            </div>
                        <?endforeach;?>
                    <?else:?>
                        <?if (!empty($arResult['USER']['UF_PHONES'])):?>
                            <?$firstKey = array_key_first($arResult['USER']['UF_PHONES'])?>
                            <?foreach ($arResult['USER']['UF_PHONES'] as $key => $phone):?>
                                <div class="form-group form-group--tel">
                                    <label for="dataUserTel" class="data-user__label">Контактный телефон*</label>
                                    <input type="tel"
                                           name="OWNER_PHONE[]"
                                           placeholder="+375 (xx) xxx-xx-xx"
                                           class="dataUserTel"
                                           id="dataUserTel"
                                           value="<?=$phone?>"
                                           <?=$firstKey === $key ? 'required' : ''?>
                                    >
                                    <?if ($firstKey !== $key):?>
                                        <span class="remove_phone">
                                            <svg>
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/html/assets/img/sprites/sprite.svg#cross-popup"></use>
                                            </svg>
                                        </span>
                                    <?endif;?>
                                </div>
                            <?endforeach;?>
                        <?else:?>
                            <div class="form-group form-group--tel">
                                <label for="dataUserTel" class="data-user__label">Контактный телефон*</label>
                                <input type="tel" name="OWNER_PHONE[]" placeholder="+375 (xx) xxx-xx-xx" class="dataUserTel" id="dataUserTel" required>
                            </div>
                        <?endif;?>
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
            <?=!empty($arResult['ITEM']) ? 'Сохранить объявление' : 'Подать объявление'?>
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