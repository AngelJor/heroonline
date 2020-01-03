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
        $sth->bindParam(':itemId',$itemId);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}