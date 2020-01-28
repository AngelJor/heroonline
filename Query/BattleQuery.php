<?php
class BattleQuery
{
    private $conn;
    /**
     * BattleQuery constructor.
     * @param $conn
     */
    public function __construct()
    {
        $this->conn = $this->conn = ConnectionDb::getInstance();
    }

    function create($attackerId, $defenderId){
        /** @noinspection SqlResolve */
        $sth= $this->conn->prepare('
            INSERT INTO 
                battle_log(battle_state,attacker,defender)                             
            VALUES 
                (:battle_state,:attacker,:defender)
             ');
        $sth->execute([
            'battle_state' => Fight::BATTLE_STATE_ACTIVE,
            'attacker' => $attackerId,
            'defender' => $defenderId
        ]);
    }
    function getId($attackerId,$defenderId){
        /** @noinspection SqlResolve */
        $sth= $this->conn->prepare('
            SELECT 
                battle_id 
            FROM 
                battle_log 
            WHERE 
                battle_state = 1 
                AND (
                        (defender = :defenderId
                        AND 
                            attacker = :attackerId) 
                    OR 
                        (defender = :attackerId
                        AND 
                            attacker = :defenderId)
                )
        ');
        $sth->bindParam(':attackerId',$attackerId);
        $sth->bindParam(':defenderId',$defenderId);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        //var_dump($result);
        foreach ($result as $key => $value) {
            return (int)$result[$key];
        }
    }
    function getAttacker($battleId){
        /** @noinspection SqlResolve */
        $sth= $this->conn->prepare('
            SELECT 
                attacker 
            FROM 
                battle_log 
            WHERE 
                battle_id = :battleId
            ');
        $sth->bindParam(':battleId',$battleId);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        //var_dump($result);
        foreach ($result as $key => $value) {
            return (int)$result[$key];
        }
    }
    function getDefender($battleId){
        /** @noinspection SqlResolve */
        $sth= $this->conn->prepare('
            SELECT
                defender 
            FROM 
                battle_log 
            WHERE 
                battle_id = :battleId
            ');
        $sth->bindParam(':battleId',$battleId);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        //var_dump($result);
        foreach ($result as $key => $value) {
            return (int)$result[$key];
        }
    }
    function update($champion1Id, $champion2Id){
        /** @noinspection SqlResolve */
        $sth= $this->conn->prepare('
            UPDATE
                battle_log 
            SET 
                attacker = :attacker,defender = :defender
            WHERE 
                battle_state = 1
            ');
        $sth->bindParam(':attacker',$champion1Id);
        $sth->bindParam(':defender',$champion2Id);
        $sth->execute();
    }
    function setState($state){
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
            UPDATE 
                battle_log 
            SET 
                battle_state = :state
            ');
        $sth->bindParam(':state', $state);
        $sth->execute();
    }
}