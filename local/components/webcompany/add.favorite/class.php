<?php

namespace WebCompany;

use Bitrix\Main\Application;
use Bitrix\Main\Entity\Query;
use Bitrix\Main\Entity\ExpressionField;

class AddFavorite extends \CBitrixComponent
{
    private string $tableName = 'user_favorite';
    private string $userIdFieldName = 'USER_ID';
    private string $favoriteGoodsFieldName = 'GOODS';
    private ?object $obDbConnection;
    private ?int $curUserId;

    public function __construct($component = \null)
    {
        $obCon = Application::getConnection();
        $this->curUserId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
        if (!empty($obCon) && !empty($this->curUserId)) {
            $this->obDbConnection = $obCon;
            if (!$this->checkExistenceFavoriteTable()) {
                $this->createFavoriteTable();
            }    
        }
        parent::__construct($component);
    }

    private function checkExistenceFavoriteTable() : bool
    {
        return $this->obDbConnection->isTableExists($this->tableName);
    }

    private function createFavoriteTable() : void
    {

        $this->obDbConnection->queryExecute("
            CREATE TABLE $this->tableName (
            ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            USER_ID INT NOT NULL UNIQUE,
            GOODS VARCHAR(1000)
          )
            ");
    }

    private function isUserExistOnTable() : bool
    {
        if (!empty($this->curUserId))
        $res = $this->obDbConnection->query("SELECT ID FROM $this->tableName WHERE $this->userIdFieldName = $this->curUserId")->fetch();
        return !empty($res) ? true : false;
    }

    private function updateFavoriteGood(int $goodId) : void
    {
        $arGoods = [];
        $arGoods[] = $goodId;
        $jsonNewGoods = json_encode($arGoods);
        if (!empty($this->curUserId) && !empty($jsonNewGoods))
        $this->obDbConnection->queryExecute(
            "INSERT INTO $this->tableName ($this->userIdFieldName, $this->favoriteGoodsFieldName)
                 VALUES ($this->curUserId,'$jsonNewGoods')"
        );
    }

    private function addFavoriteGood(int $goodId) : void
    {
        if ($this->isUserExistOnTable()) {
            $arGoods = $this->getFavoriteGoods();
            if (!in_array($goodId,$arGoods)) {
                $arGoods[] = $goodId;
                $jsonNewGoods = json_encode($arGoods);
                if (!empty($jsonNewGoods) && !empty($this->curUserId))
                $this->obDbConnection->queryExecute(
                    "UPDATE $this->tableName 
                         SET  $this->favoriteGoodsFieldName = '$jsonNewGoods' 
                         WHERE $this->userIdFieldName = $this->curUserId"
                );
            }
        } else {
            $this->updateFavoriteGood($goodId);
        }
    }

    private function deleteFavoriteGood(int $goodId) : void
    {
        if ($this->isUserExistOnTable()) {
            $arGoods = $this->getFavoriteGoods();
            if (!empty($arGoods)) {
                $key = array_search($goodId,$arGoods);
                if ($key !== false) {
                    unset($arGoods[$key]);
                    $jsonNewGoods = json_encode(array_values($arGoods));
                    if (!empty($jsonNewGoods) && !empty($this->curUserId))
                    $this->obDbConnection->queryExecute(
                        "UPDATE $this->tableName 
                             SET  $this->favoriteGoodsFieldName = '$jsonNewGoods' 
                             WHERE $this->userIdFieldName = $this->curUserId"
                    );
                }
            }
        }
    }

    private function getFavoriteGoods() : array
    {
        if (!empty($this->curUserId))
        $strJson = $this->obDbConnection->query(
            "SELECT $this->favoriteGoodsFieldName 
                 FROM  $this->tableName 
                 WHERE $this->userIdFieldName = $this->curUserId"
        )->fetch();
        return json_decode($strJson[$this->favoriteGoodsFieldName],true) ?? [];
    }

    public function executeComponent() : void
    {
        if ($this->checkExistenceFavoriteTable()) {
            if ($_POST['favorite'] === 'y' && !empty($_POST['method'])) {
                switch ($_POST['method']) {
                    case 'add':
                        $this->addFavoriteGood($_POST['item_id']);
                        break;
                    case 'delete':
                        $this->deleteFavoriteGood($_POST['item_id']);
                        break;
                    case 'get':
                        ob_end_clean();
                        ob_start();
                        echo json_encode($this->getFavoriteGoods());
                        die();
                        break;
                }
            }
            $this->includeComponentTemplate();
        }
    }
}