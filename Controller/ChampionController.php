<?php


class ChampionController
{
    public function addSpell(){
        $healthSellId = (int)$_POST['healthSpellId'] ?? '';
        $dmgSpellId = (int)$_POST['dmgSpellId'] ?? '';
        $championId = $_SESSION['myChampId'] ?? '';

        $champion = new Champion($championId);

        $alreadyHasHealSpell = in_array($healthSellId,$champion->getChampionSpells());
        $alreadyHasDmgSpell = in_array($dmgSpellId,$champion->getChampionSpells());

        if (empty($championId)
        || $alreadyHasHealSpell
        || $alreadyHasDmgSpell
        ){
            echo 'error'; die();
        }

        $champion->addSpell($_POST['healthSpellId']);
        $champion->addSpell($_POST['dmgSpellId']);

        WebResponse::render("..\View\myChampion.php");

    }
    public function updateSpell(){
        $spellId = (int)$_POST['spellId'] ?? '';
        $championId = $_SESSION['myChampId'] ?? '';
        $champion = new Champion($championId);
        if (empty($spellId)
            ||empty($championId)
        ){
            echo 'error'; die();
        }
        $champion->lvlUpSpell($spellId);
    }
    public function selectOpponent(){
        WebResponse::render("..\View\selectOpponent.php",array('champions' => Champion::listAllChampions()));
    }
    public static function displayChampion(){
        $champ = new Champion($_SESSION["myChampId"]);
        $champVars = $champ->getChampionFields();

        $mineAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($_SESSION["myChampId"]));
        WebResponse::render("../View/myChampion.php",array('champion'=>$champVars,'mine'=>$mineAvatarPath));
    }
    public static function buyDiamonds(){

        $champ = new Champion($_SESSION["myChampId"]);
        $champ->buyDiamonds($_POST['diamonds']);
    }
    public function selectItem(){
        $item = new Item($_POST['item']);
        $champ = new Champion($_SESSION['myChampId']);
        $champ->setNewStats($item);
    }
    function render(){
        //chamoion things
        $champ = new Champion($_SESSION["myChampId"]);
        $champVars = $champ->getChampionFields();

        $mineAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($_SESSION["myChampId"]));
        //item things
        $query = new ItemQuery();
        $items = $champ->display(); //twa wrushrta masiv ot itemi -> cqlata shibana baza btw
        $itemFields = [];
        foreach($items as $key => $value){
            $itemFields = $query->displayItem($value["item_id"]);
        }
        WebResponse::render("../View/inventory.php",array('item'=>$itemFields,'champion'=>$champVars,'mine'=>$mineAvatarPath));
    }
}