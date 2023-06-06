<?php

function pr(mixed $var) : void
{
    echo "<pre>";
    echo "Путь к файлу ".__FILE__."<br>";
    print_r($var);
    echo "<pre>";
}