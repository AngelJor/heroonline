<?php

class LobbyQuery
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

    function joinLobby($userId){
        $sth= $this->conn->prepare('
            INSERT INTO
                lobby(user1_id)
            VALUES
                (:userId)
             ');
        $sth->bindParam(':userId',$userId);
        $sth->execute();
    }
    function usersInLobby(){
        $sth= $this->conn->prepare('
            SELECT COUNT(user1_id)
            FROM
                lobby
             ');
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_COLUMN);
        return $result;
    }
    function exitLobby(){
        $sth= $this->conn->prepare('
            DELETE
            FROM
                lobby
             ');
        $sth->execute();
    }
    function getUserId(){
        $sth= $this->conn->prepare('
            SELECT
                user1_id
            FROM
                lobby
             ');
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}