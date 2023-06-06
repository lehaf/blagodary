<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';


//                <li class="bread-crumbs-list__item"><a href="#">Главная</a></li>
//                <li class="bread-crumbs-list__item"><a href="#">Раздел</a></li>
//                <li class="bread-crumbs-list__item"><a href="#">Страница выбранного товара</a></li>
//                <li class="bread-crumbs-list__item mobile"><a href="#">Выбранный раздел товаров</a></li>


$strReturn .= '<div class="bread-crumbs"><div class="wrapper"><ul class="bread-crumbs-list">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$arrow = ($index > 0? '<i class="fa fa-angle-right"></i>' : '');

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
			<li class="bread-crumbs-list__item">
				'.$arrow.'
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item">
					'.$title.'
				</a>
				<meta itemprop="position" content="'.($index + 1).'" />
			</li>';
	}
	else
	{
		$strReturn .= '<li class="bread-crumbs-list__item"><span>'.$title.'</span></li>';
	}
    $strReturn .= '<li class="bread-crumbs-list__item mobile">Jgf</li>';
}

$strReturn .= '</ul></div></div>';

return $strReturn;
