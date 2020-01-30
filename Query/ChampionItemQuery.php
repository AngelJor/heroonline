<?php


class ChampionItemQuery
{
    private $conn;

    /**
     * ChampionSpellQuery constructor.
     * @param $conn
     */
    public function __construct()
    {
        $this->conn = ConnectionDb::getInstance();
    }

    public function addItem($itemId,$championId){
        $sth = $this->conn->prepare('
            INSERT INTO 
                champion_item(item_id, champion_id)
            VALUES (:itemId,:championId)
        ');
        $sth->bindParam("itemId",$itemId);
        $sth->bindParam("championId",$championId);
        $sth->execute();
    }
    public  function getChampionItemId($championId){
        $sth = $this->conn->prepare('
            SELECT
                item_id
            FROM   
                champion_item
            WHERE 
                champion_id =:championId
        ');
        $sth->bindParam("championId",$championId);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }
    function displayAllChampionItem($championId){
        $sth = $this->conn->prepare('
                SELECT
                    item_id,pair_id
                FROM
                    champion_item
                WHERE champion_id=:champion_id
                ');
        $sth->bindParam(':champion_id',$championId);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    function removeItem($pairId){
        $sth = $this->conn->prepare('
            DELETE FROM
                champion_item
            WHERE
                 pair_id=:pair_id
        ');
        $sth->bindParam("pair_id",$pairId);
        $sth->execute();
    }
    function getItemIdByPair($pairId){
        $sth = $this->conn->prepare('
                SELECT
                    item_id
                FROM
                    champion_item
                WHERE
                    pair_id=:pair_id
                ');
        $sth->bindParam(':pair_id',$pairId);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}