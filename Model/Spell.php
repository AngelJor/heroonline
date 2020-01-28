<?php


class Spell
{
    private $id;
    private $name;
    private $type;
    private $power;
    private $lvl;
    private $query;

    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $this->query = new SpellQuery();    //query

            $spellData = $this->query->find($id);
            $this->id = $spellData['spell_id'];
            $this->name = $spellData['name'];
            $this->type = $spellData['type'];
            $this->lvl = $spellData['lvl'];
            $this->power = $spellData['power'];
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @return mixed
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    public static function spells($type){
        $query = new SpellQuery();
        return $query->listSpell($type);
    }
    public static function selectSpell($type){
        $spells[] = Spell::spells($type);
        return $spells;
    }
}