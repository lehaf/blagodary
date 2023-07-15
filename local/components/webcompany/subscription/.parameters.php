<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
    "PARAMETERS" => array(
        "PAGE_RECORDS_COUNT" => array(
            "PARENT" => "VISUAL",
            "NAME" => "Кол-во записей на одной странице во вкладке 'История'",
            "TYPE" => "NUMBER",
            "DEFAULT" => 5,
        ),
        "MAX_PAGE_COUNT" => array(
            "PARENT" => "VISUAL",
            "NAME" => "Максимальное кол-во видимых ссылок-страниц",
            "TYPE" => "NUMBER",
            "DEFAULT" => 5,
        ),
    ),
);