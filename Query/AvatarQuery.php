<?php


class AvatarQuery{
    private $conn;

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
                    avatar(path) 
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
                avatar
        ');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getAvatarPath($id){
        $sth = $this->conn->prepare('
            SELECT 
                path
            FROM
                avatar
            WHERE
                avatar_id=:avatar_id
        ');
        $sth->bindParam("avatar_id",$id);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_COLUMN);
        return $result;
    }
}