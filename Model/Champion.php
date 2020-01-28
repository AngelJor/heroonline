<?php
class Champion
{

    const BASE_HEALTH_MODIFIER = 100;
    const BASE_DMG_MODIFIER = 10;
    const BASE_SPELL_LEVEL = 1;
    const BASE_SPELL_POWER_MODIFIER = 5;
    const ARMOUR = "Armour";
    const DMG = "Dmg";
    const HEALTH = "Health";
     protected $name;
     protected $health;
     protected $strength;
     protected $money;
     protected $xp;
     protected $lvl;
     protected $id;
     protected $armourItem;
     protected $spellId;
     protected $query;
     protected $iconId;
     protected $diamond;
     protected $bossLvl;

    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $this->query = new ChampionQuery();    //query

            $championData = $this->query->find($id);
            $this->id = $championData['champion_id'];
            $this->name = $championData['name'];
            $this->health = $championData['health'];
            $this->strength = $championData['strength'];
            $this->money = $championData['money'];
            $this->armourItem = $championData['armour_item'];
            $this->xp = $championData['xp'];
            $this->lvl = $championData['lvl'];
            $this->iconId = $championData['icon_id'];
            $this->diamond = $championData['diamond'];
            $this->bossLvl = $championData['boss_lvl'];
        }
    }

    public function getChampionFields()
    {
        $array = [
            "health" => $this->getHealth(),
            "strength" => $this->getStrength(),
            "money" => $this->getMoney(),
            "xp" => $this->getXp(),
            "lvl" => $this->getLvl(),
            "armour" => $this->getArmourItem(),
            "diamond" => $this->getDiamonds(),
            "bossLvl" => $this->getBossLvl()
        ];
        return $array;
    }

    public function getMoney()
    {
        return $this->money;
    }

    public function setMoney($money)
    {
        $this->money = $money;
    }
    public function getIcon()
    {
        return $this->iconId;
    }

    public function getXp()
    {
        return $this->xp;
    }

    public function setXp($xp)
    {
        $this->xp = $xp;
    }

    public function getLvl()
    {
        return $this->lvl;
    }

    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    }


    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function setHealth($health)
    {
        $this->health = $health;
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function setStrength($strength)
    {
        $this->strength = $strength;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    public function addItem(Item $item){

    }

    public function getArmourItem()
    {
        return $this->armourItem;
    }

    public function getDiamonds(){

        return $this->diamond;
    }
    /**
     * @param int $armourItem
     */
    public function setArmourItem($armourItem)
    {
        $this->armourItem = $armourItem;
    }
    public function setNewStats(Item $item){
        $baseHealth = $this->getLvl() * self::BASE_HEALTH_MODIFIER;
        $baseStrength = $this->getLvl() * self::BASE_DMG_MODIFIER;
        switch ($item->getType()){
            case self::HEALTH:
                $buff = $item->getBuff();
                $result = $baseHealth + $buff;
                $this->setHealth($result);
                $this->saveHealthToDb();
                break;
            case self::DMG:
                $result = $baseStrength + $item->getBuff();
                $this->setStrength($result);
                $this->saveDmgToDb();
                break;
            case self::ARMOUR:
                $result = $item->getBuff();
                $this->setArmourItem($result);
                $this->saveArmourToDb();
        }
    }
    public function saveHealthToDb(){
        $updateParams =[
                'health' => $this->getHealth()
            ];
        $this->query->update($this->getId(),$updateParams);
    }
    public function saveDmgToDb(){
        $updateParams =[
            'strength' => $this->getStrength()
        ];
        $this->query->update($this->getId(),$updateParams);
    }
    public function saveArmourToDb(){
        $updateParams =[
            'armour_item' => $this->getArmourItem()
        ];
        $this->query->update($this->getId(),$updateParams);
    }
    public function saveMoneyToDb()
    {
        $updateParams = [
            'money' => $this->getMoney()
        ];
        $this->query->update($this->getId(),$updateParams);
    }
    public function saveXpToDb()
    {
        $updateParams = [
            'xp' => $this->getXp()
        ];
        $this->query->update($this->getId(),$updateParams);
    }
    public static function getBuffs($id)
    {
        $itemQuery = new ItemQuery();
        $champItemQuery = new ChampionItemQuery();

        $buff = [
            self::ARMOUR => 0,
            self::DMG => 0,
            self::HEALTH => 0
        ];
        $items = $champItemQuery->getChampionItemId($id);
        foreach ($items as $iKey => $value) {
            $item = $itemQuery->getItem($value);
            foreach ($item as $key => $itemBuff) {
            $buff[$itemBuff['type']] = $itemBuff['buff'];
            }
        }
        return $buff;
    }
    public static function getAllChampionId(){
        $query = new ChampionQuery();
        return $query->getAllChampionId();
    }
    public function addSpell($spellId){
        $query = new ChampionSpellQuery();
        $spell = new Spell($spellId);
        $query->addSpell($this->id,$spellId,$spell->getType(),$spell->getPower(),self::BASE_SPELL_LEVEL);
    }
    public function lvlUpSpell($spellId){
        $spell = new Spell($spellId);
        $query = new ChampionSpellQuery();
        $newPower = $spell->getPower() + self::BASE_SPELL_POWER_MODIFIER;
        $newLvl = $spell->getLvl() + self::BASE_SPELL_LEVEL;
        $query->lvlUpSpell($this->id,$spellId,$newPower,$newLvl);
    }
    public function getChampionSpells(){
        $query = new ChampionSpellQuery();
        return $query->getSpellsForChampion($this->id);
    }

    public function getMaxHealth(){
        return (int)$this->getLvl() * 100 +
            Champion::getBuffs($this->getId())[Fight::HEALTH_BUFF];
    }
    public static function getAvatarID($championId){
        $query = new ChampionQuery();
        return $query->getAvatarId($championId);
    }
    public static function getAvatarPath($avatarId){
        $query = new AvatarQuery();
        return $query->getAvatarPath($avatarId);
    }
    public static function getIconPath($iconId){
        $query = new IconQuery();
        return $query->getIconPath($iconId);
    }
    public static function listAllChampions(){
        $query = new ChampionQuery();
        return $query->listChampions();
    }
    public function buyDiamonds($diamonds){
        $query = new ChampionQuery();
        $query->buyDiamonds($diamonds + $this->getDiamonds(),$this->getId());
    }

    public function getBossLvl()
    {
        return $this->bossLvl;
    }
}