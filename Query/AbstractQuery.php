<?php

abstract class AbstractQuery
{
    abstract function getTableName();
    abstract function getPrimaryKey();

    public function select($selectedElement,$Id){
        $query = "
                SELECT 
                    ".$selectedElement."
                FROM "
                    . $this->getTableName(). " 
                WHERE "
                    .$this->getPrimaryKey(). " = :condition";
        $bindParams = [
            'condition' => $Id
        ];
        return $this->executeFetchOne($query, $bindParams);
    }

    public function find($value)
    {
        $query = "
                SELECT
                    * 
                FROM "
                    . $this->getTableName(). " 
                WHERE "
                    .$this->getPrimaryKey(). " = :value;";

        $bindParams = [
            'value' => $value
        ];
        return $this->executeFetchOne($query, $bindParams);
    }
    public function execute($query, $bindParams)
    {
        $conn = ConnectionDb::getInstance();

        /** @noinspection SqlResolve */
        $sth = $conn->prepare($query);

        return $sth->execute($bindParams);

    }
    public function executeFetchOne($query, $bindParams)
    {
        $conn = ConnectionDb::getInstance();

        /** @noinspection SqlResolve */
        $sth = $conn->prepare($query);

        $sth->execute($bindParams);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
    public function update($pkValue, $updateParams){
        $bindParams = [
            'id' => $pkValue
        ];
        $setParams = [];
        foreach ($updateParams as $key => $value){
            $bindParams[$key] = $value;
            $setParams[] = "$key = :$key";
        }

        $arr = implode(",",$setParams);
        $query = "UPDATE "
                    .$this->getTableName().
                 " SET "
                    .$arr.
                " WHERE "
                    .$this->getPrimaryKey(). " = :id";

        return $this->execute($query,$bindParams);
    }
}