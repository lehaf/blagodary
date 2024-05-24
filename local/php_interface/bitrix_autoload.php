<?php

CModule::AddAutoloadClasses(
    '',
    array(
        // ключ - имя класса, значение - путь относительно корня сайта к файлу с классом
        'WebCompany\YouWatchBefore' => '/local/php_interface/classes/cookie/YouWatchBefore.php',
        'WebCompany\BePaid' => '/local/php_interface/classes/BePaid.php',
        'WebCompany\Subscription' => '/local/php_interface/classes/Subscription.php',
    )
);
