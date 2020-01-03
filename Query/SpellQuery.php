<?php


class SpellQuery extends AbstractQuery
{
    private $conn;

    /**
     * SpellQuery constructor.
     * @param $conn
     */
    public function __construct()
    {
        $this->conn = ConnectionDb::getInstance();
    }

    function create($name,$type,$power){
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
                INSERT INTO 
                    spell(name,type,power) 
                VALUES
                    (:name, :type, :power)
                ');
        $sth->bindParam('name',$name);
        $sth->bindParam('type',$type);
        $sth->bindParam('power',$power);
        $sth->execute();
    }
    function listSpell($type){
        /** @noinspection SqlResolve */
        $sth = $this->conn->prepare('
                SELECT 
                    * 
                FROM 
                    spell
                WHERE 
                    type =:type
                ');
        $sth->bindParam("type",$type);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getTableName()
    {
        return 'spell';
    }

    function getPrimaryKey()
    {
        return 'spell_id';
    }
}