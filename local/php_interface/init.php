<?php
// Подключаем константы
if (file_exists(__DIR__.'/constants.php')) {
    require __DIR__.'/constants.php';
}

// Подключаем функции
if (file_exists(__DIR__.'/function.php')) {
    require __DIR__.'/function.php';
}

// Подключаем загрузчик классов битрикс
if (file_exists(__DIR__.'/bitrix_autoload.php')) {
    require __DIR__.'/bitrix_autoload.php';
}