<?php


class IconQuery{
    public $conn;

    /**
     * IconQuery constructor.
     * @param $conn
     */
    public function __construct()
    {
        $this->conn = ConnectionDb::getInstance();
    }

    public function create($path){
        $sth = $this->conn->prepare('
                INSERT INTO 
                    icon(path) 
                VALUES
                    (:path)
                ');
        $sth->bindParam('path',$path);
        $sth->execute();
    }
    public function display(){
        $sth = $this->conn->prepare('
            SELECT 
                *
            FROM
                icon
        ');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getIconPath($id){
        $sth = $this->conn->prepare('
            SELECT 
                path
            FROM
                icon
            WHERE
                icon_id=:icon_id
        ');
        $sth->bindParam("icon_id",$id);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_COLUMN);
        return $result;
    }
}