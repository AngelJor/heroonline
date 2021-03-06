<?php


class ItemQuery extends AbstractQuery
{
    private $conn;
    public function getTableName()
    {
        return 'item';
    }

    public function getPrimaryKey()
    {
        return 'item_id';
    }
    public function __construct()
    {
        $this->conn = ConnectionDb::getInstance();
    }
    function create($name,$type,$buff,$price,$path){
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
                INSERT INTO 
                    item(name,type,buff,price,item_icon_path) 
                VALUES
                    (:name, :type, :buff,:price,0,:item_icon_path)
                ');
        $sth->bindParam('name',$name);
        $sth->bindParam('type',$type);
        $sth->bindParam('buff',$buff);
        $sth->bindParam('price',$price);
        $sth->bindParam('item_icon_path',$path);
        $sth->execute();
    }
    function getItem($itemId){
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
                SELECT 
                    * 
                FROM 
                    item 
                WHERE 
                    item_id = :itemId 
                ');
        $sth->bindParam(':itemId',$itemId);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function display(){
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
                SELECT 
                    *
                FROM 
                    item 
                ');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function displayItem($itemId){
        $sth = $this->conn->prepare('
                SELECT
                    *
                FROM
                    item
                WHERE item_id=:itemId
                ');
        $sth->bindParam(':itemId',$itemId);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function addItemForSell($sellerId,$itemId,$price){
        $sth = $this->conn->prepare('
                INSERT INTO
                    item_sell(item_id,user_id,price)
                VALUES
                    (:item_id,:user_id,:price)
                ');
        $sth->bindParam(':item_id',$itemId);
        $sth->bindParam(':user_id',$sellerId);
        $sth->bindParam(':price',$price);
        $sth->execute();
    }
    function displayItemForSale(){
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
                SELECT
                    *
                FROM
                    item_sell
                ');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function getItemByPair($pairId){
        $sth = $this->conn->prepare('
                SELECT
                    *
                FROM
                    item_sell
                WHERE
                    pair_id =:pairId
                ');
        $sth->bindParam(":pairId", $pairId);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function removeItem($pairId){
        $sth = $this->conn->prepare('
            DELETE FROM
                item_sell
            WHERE
                 pair_id=:pair_id
        ');
        $sth->bindParam("pair_id",$pairId);
        $sth->execute();
    }
}