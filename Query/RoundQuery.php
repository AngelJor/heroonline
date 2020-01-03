<?php
class RoundQuery {

    private $conn;

    /**
     * RoundQuery constructor.
     * @param $conn
     */
    public function __construct()
    {
        $this->conn = ConnectionDb::getInstance();
    }


    function create($battleId,$attackerId,$defenderId,$defenderHealthLeft,$dmgDealt,$healingDone){
        /** @noinspection SqlResolve */
        $sth= $this->conn->prepare('
                INSERT INTO 
                    round_log(battle_id,attacker_id,defender_id,defender_health_left,dmg_dealt,healing_done)                             
                VALUES
                    (:battle_id,:attacker_id,:defender_id,:defender_health_left,:dmg_dealt,:healingDone)
                ');
        $sth->bindParam(':battle_id',$battleId);
        $sth->bindParam(':attacker_id',$attackerId);
        $sth->bindParam(':defender_id',$defenderId);
        $sth->bindParam(':defender_health_left',$defenderHealthLeft);
        $sth->bindParam(':dmg_dealt',$dmgDealt);
        $sth->bindParam(':healingDone',$healingDone);
        $sth->execute();
    }
    function display($battleId){
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
                SELECT 
                    * 
                FROM 
                    round_log 
                WHERE 
                    battle_id = :battleId
                ');
        $sth->bindParam(':battleId',$battleId);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $key => $value) {
            echo "Hero ".$value['attacker_id']." attacked hero and"
                .$value['defender_id']."  left with "
                .$value['defender_health_left']." dmg dealt was - "
                .$value['dmg_dealt']." The healing was - "
                .$value['healing_done']."<br>";
        }
    }
}