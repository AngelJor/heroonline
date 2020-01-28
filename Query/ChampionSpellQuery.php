<?php


class ChampionSpellQuery
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

    public function addSpell($championId,$spellId,$type,$power,$lvl){
        $sth = $this->conn->prepare('
            INSERT INTO 
                champion_spell(champion_id, spell_id,type,power,lvl)
            VALUES (:championId,:spellId,:type,:power,:lvl)
        ');
        $sth->bindParam("championId",$championId);
        $sth->bindParam("spellId",$spellId);
        $sth->bindParam("type",$type);
        $sth->bindParam("power",$power);
        $sth->bindParam("lvl",$lvl);
        $sth->execute();
    }
    public  function getChampionSpellPower($championId, $type){
        $sth = $this->conn->prepare('
            SELECT
                power
            FROM   
                champion_spell
            WHERE 
                champion_id =:championId
                AND
                type =:type
        ');
        $sth->bindParam("championId",$championId);
        $sth->bindParam("type",$type);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $key => $value) {
            return $result[$key];
        }
    }
    public function getSpellsForChampion($championId){
        $sth = $this->conn->prepare('
            SELECT
                spell_id
            FROM 
                champion_spell
            WHERE
                champion_id =:championId
        ');
        $sth->bindParam("championId",$championId);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }
    public function lvlUpSpell($championId, $spellId, $newPower,$newLvl){
        $sth = $this->conn->prepare('
            UPDATE
                champion_spell
            SET 
                power =:power , lvl =:lvl
            WHERE
                champion_id =:championId 
                AND 
                spell_id =:spellId
        ');
        $sth->bindParam("championId",$championId);
        $sth->bindParam("spellId",$spellId);
        $sth->bindParam("power",$newPower);
        $sth->bindParam("lvl",$newLvl);
    }

}