<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "LAZY_LOAD_ON" => array(
        "PARENT" => "VISUAL",
        "NAME" => "Включить ленивую загрузку картинок",
        "TYPE" => "LIST",
        "DEFAULT" => 0,
        "VALUES" => [
            'Y',
            'N'
        ]
    ),
    "LAZY_LOAD_START" => array(
        "PARENT" => "VISUAL",
        "NAME" => "С какого элемента начать ленивое отображение",
        "TYPE" => "STRING",
        "DEFAULT" => "0",
    )
);
