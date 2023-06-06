<?php

function pr(mixed $var) : void
{
    echo "<pre>";
    echo "Путь к файлу ".__FILE__."<br>";
    print_r($var);
    echo "<pre>";
}

function sklonen(int $number, array $arVariants) : string
{
    $number = str_replace(' ','',$number);
    $cases = [ 2, 0, 1, 1, 1, 2 ];

    $intNum = abs( (int) strip_tags( $number ) );

    $titleIndex = ( $intNum % 100 > 4 && $intNum % 100 < 20 )
        ? 2
        : $cases[ min( $intNum % 10, 5 ) ];

    return $arVariants[$titleIndex];
}
