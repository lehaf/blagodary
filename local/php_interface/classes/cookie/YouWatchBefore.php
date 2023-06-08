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
            if (in_array($goodId,$arGoodsId)) {
                $key = array_search($goodId,$arGoodsId);
                unset($arGoodsId[$key]);
            }
            array_unshift($arGoodsId,$goodId);
            if (count($arGoodsId) > $this->maxGoodCount) {
                $arGoodsId = array_chunk($arGoodsId,$this->maxGoodCount)[0];
            }
            $arJson = json_encode($arGoodsId);
            $cookie = new Cookie($this->cookieName, $arJson,time() + $this->timeExpiration);
            $cookie->setDomain($_SERVER['SERVER_NAME']);
            Application::getInstance()->getContext()->getResponse()->addCookie($cookie);
        } else {
            $arJson = json_encode([$goodId]);
            $cookie = new Cookie($this->cookieName, $arJson,time() + $this->timeExpiration);
            $cookie->setDomain($_SERVER['SERVER_NAME']);
            Application::getInstance()->getContext()->getResponse()->addCookie($cookie);
        }
    }

    public function getGoodsFromCookie() : ?array
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $cookieValue = $request->getCookie($this->cookieName);
        if (!empty($cookieValue)) $arGoodsId = json_decode($cookieValue);
        return $arGoodsId ?? NULL;
    }

}
