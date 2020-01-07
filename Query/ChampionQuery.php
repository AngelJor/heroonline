<?php

class ChampionQuery extends AbstractQuery
{
    private $conn;

    /**
     * ChampionQuery constructor.
     * @param $conn
     */
    public function __construct()
    {
        $this->conn = ConnectionDb::getInstance();
    }

    public function getTableName()
    {
        return 'champion';
    }

    public function getPrimaryKey()
    {
        return 'champion_id';
    }

    function create($name, $userId)
    {
            /** @noinspection SqlResolve */
            $sth = $this->conn->prepare('
            INSERT INTO 
                champion(name,health,strength,money,armour_item,xp,lvl,user_id,diamond,facebook_user_id) 
            VALUES 
                (:name, 100, 10, 0,
                 0,0, 1,:id,0,0)
            ');
        $sth->bindParam(':id',$userId);
        $sth->bindParam(':name', $name);
        $sth->execute();
        $_SESSION['myChampId'] = $this->conn->lastInsertId();
    }
    function createFacebookUser($name, $userId)
    {
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
            INSERT INTO 
                champion(name,health,strength,money,armour_item,xp,lvl,user_id,diamond,facebook_user_id) 
            VALUES 
                (:name, 100, 10, 0,
                 0,0, 1,0,0,:id)
            ');
        $sth->bindParam(':id',$userId);
        $sth->bindParam(':name', $name);
        $sth->execute();
        $_SESSION['myChampId'] = $this->conn->lastInsertId();
    }
    function priceForWin($championId , $xp , $money)
    {
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
            UPDATE 
                champion 
            SET 
                money = :money, xp = :xp
            WHERE 
                champion_id = :champion_id
            ');
        $sth->bindParam(':money', $money);
        $sth->bindParam(':xp', $xp);
        $sth->bindParam(':champion_id', $championId);
        $sth->execute();
    }

    public function resetHealth($health,$championId)
    {
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
            UPDATE 
                champion 
            SET 
                health =:health
            WHERE 
                champion_id = :champion_id
            ');
        $sth->bindParam(':champion_id', $championId);
        $sth->bindParam(':health', $health);
        $sth->execute();
    }
    public function lvlUp($newXp,$newLvl,$newStrength,$newHealth,$championId){
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
            UPDATE 
                champion 
            SET 
                lvl = :lvl, xp = :xp, strength = :strength, health =:health
            WHERE 
                champion_id = :id
            ');
        $sth->bindParam(':xp', $newXp);
        $sth->bindParam(':lvl', $newLvl);
        $sth->bindParam(':strength', $newStrength);
        $sth->bindParam(':health', $newHealth);
        $sth->bindParam(':id', $championId);
        $sth->execute();
    }
    public function getAllChampionId(){
        $sth = $this->conn->prepare('
            SELECT 
                champion_id
            FROM
                champion
            
        ');
        $sth->execute();
        $result =  $sth->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }
    public function listChampsForUser($userId){
        $conn = ConnectionDb::getInstance();
        $sth = $conn->prepare('
            SELECT 
                champion_id
            FROM
                champion
            WHERE
                user_id =:userId
        ');
        $sth->bindParam('userId',$userId);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }
    public function listChampsForFacebookUsers($id){
        $conn = ConnectionDb::getInstance();
        $sth = $conn->prepare('
            SELECT 
                champion_id
            FROM
                champion
            WHERE
                facebook_user_id =:userId
        ');
        $sth->bindParam('userId',$id);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }
    public function getUser($championId){
        $conn = ConnectionDb::getInstance();
        $sth = $conn->prepare('
            SELECT 
                user_id
            FROM
                champion
            WHERE
                champion_id =:champion_id
        ');
        $sth->bindParam('champion_id',$championId);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_COLUMN);
        return $result;
    }
    public function setIcon($iconId,$userId,$isFacebookUser){
        if($isFacebookUser == 0) {
            $sth = $this->conn->prepare("
                    UPDATE 
                         champion
                    SET 
                        icon_id =:icon_id 
                    WHERE 
                        user_id=:userId
                    ");
            $sth->bindParam("userId", $userId);
            $sth->bindParam("icon_id", $iconId);
            $sth->execute();
        }
        else{
            $sth = $this->conn->prepare("
                    UPDATE 
                         champion
                    SET 
                        icon_id =:icon_id 
                    WHERE 
                        facebook_user_id=:userId
                    ");
            $sth->bindParam("userId", $userId);
            $sth->bindParam("icon_id", $iconId);
            $sth->execute();
        }
    }
    public function getIcon($user_id){
        $sth = $this->conn->prepare("
                    SELECT 
                         icon_id
                    FROM 
                         champion
                    WHERE 
                        user_id=:user_id
                    ");
        $sth->bindParam("user_id", $user_id);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_COLUMN);
        return $result;
    }
    public function setAvatar($avatarId,$user_id,$isFacebookUser){
        if($isFacebookUser == 0) {
            $sth = $this->conn->prepare("
                    UPDATE 
                         champion
                    SET 
                        avatar_id =:avatar_id 
                    WHERE 
                        user_id=:user_id
                    ");
            $sth->bindParam("user_id", $user_id);
            $sth->bindParam("avatar_id", $avatarId);
            $sth->execute();
        }
        else{
            $sth = $this->conn->prepare("
                    UPDATE 
                         champion
                    SET 
                        avatar_id =:avatar_id 
                    WHERE 
                        facebook_user_id=:user_id
                    ");
            $sth->bindParam("user_id", $user_id);
            $sth->bindParam("avatar_id", $avatarId);
            $sth->execute();
        }
    }
    public function getAvatarId($championId){
        $sth = $this->conn->prepare("
                    SELECT 
                         avatar_id
                    FROM 
                         champion
                    WHERE 
                        champion_id=:champion_id
                    ");
        $sth->bindParam("champion_id", $championId);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_COLUMN);
        return $result;
    }
    public function listChampions(){
        $sth = $this->conn->prepare("
                    SELECT 
                         champion_id
                    FROM 
                         champion
                    ");
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }
    public function buyDiamonds($diamonds,$championId){
        $sth = $this->conn->prepare("
                    UPDATE
                        champion
                    SET
                        diamond=:diamond
                    WHERE
                        champion_id=:champion_id
                    ");
        $sth->bindParam("champion_id",$championId);
        $sth->bindParam("diamond",$diamonds);
        $sth->execute();
    }
}