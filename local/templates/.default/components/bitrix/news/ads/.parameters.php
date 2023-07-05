<?php
/**
 * ВНИМАНИЕ
 * $arTemplateParameters["SEF_MODE"] массив параметров перезаписывает аналогичный в комплексном компоненте
 */
$arTemplateParameters["SEF_MODE"] = array(
    "section" => array(
        "NAME" => "Страница раздела",
        "DEFAULT" => "#SECTION_CODE_PATH#/",
        "VARIABLES" => array(
            "SECTION_ID",
            "SECTION_CODE",
            "SECTION_CODE_PATH",
        ),
    ),
    "detail" => array(
        "NAME" => 'Детальная страница',
        "DEFAULT" => "#ELEMENT_CODE#/",
        "VARIABLES" => array(
            "ELEMENT_ID",
            "ELEMENT_CODE",
            "SECTION_ID",
            "SECTION_CODE",
            "SECTION_CODE_PATH",
        ),
    ),
    "search" => array(
        "NAME" => 'Поиск',
        "DEFAULT" => "search/",
    ),
    "user" => array(
        "NAME" => 'Страница пользователя',
        "DEFAULT" => "user/",
    ),
);