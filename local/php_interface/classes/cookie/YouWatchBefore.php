<?php

namespace WebCompany;

use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;

class YouWatchBefore
{
    private string $cookieName = 'youWatchBefore';
    private int $timeExpiration = 2678400;
    private int $maxGoodCount = 10;

    public function setCookie(int $goodId) : void
    {
        if ($arGoodsId = $this->getGoodsFromCookie()) {
            $this->checkGoodInCookie($goodId,$arGoodsId);
            $this->setCookieToUser($arGoodsId);
        } else {
            $this->setCookieToUser($goodId);
        }
    }

    public function getGoodsFromCookie() : ?array
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $cookieValue = $request->getCookie($this->cookieName);
        if (!empty($cookieValue)) $arGoodsId = json_decode($cookieValue);
        return $arGoodsId ?? NULL;
    }

    private function checkGoodInCookie(int $goodId, array &$arGoodsId) : void
    {
        if (in_array($goodId,$arGoodsId)) {
            $key = array_search($goodId,$arGoodsId);
            unset($arGoodsId[$key]);
        }
        array_unshift($arGoodsId,$goodId);
        if (count($arGoodsId) > $this->maxGoodCount) {
            $arGoodsId = array_chunk($arGoodsId,$this->maxGoodCount)[0];
        }
    }

    private function setCookieToUser(mixed $arCookieValue) : void
    {
        if (!is_array($arCookieValue)) $arCookieValue = [$arCookieValue];
        $arJson = json_encode($arCookieValue);
        $cookie = new Cookie($this->cookieName, $arJson,time() + $this->timeExpiration);
        $cookie->setDomain($_SERVER['SERVER_NAME']);
        Application::getInstance()->getContext()->getResponse()->addCookie($cookie);
    }
}
