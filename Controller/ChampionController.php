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
        $query = new ChampionItemQuery();
        $item = new Item($query->getItemIdByPair($_POST["pair"])[0]["item_id"]);
        $champ = new Champion($_SESSION['myChampId']);
        $champ->setNewStats($item);
        ChampionController::render();
    }
    static function render(){
        //chamoion things
        $champ = new Champion($_SESSION["myChampId"]);
        $champVars = $champ->getChampionFields();

        $mineAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($_SESSION["myChampId"]));
        //item things
        $query = new ItemQuery();
        $items = $champ->display();
        $itemFields = [];
        foreach($items as $key => $value) {
            $item = $query->displayItem($value["item_id"]);
            $item[0] += ["pair_id" => $value['pair_id']];
            $itemFields[$key] = $item;
        }
        WebResponse::render("../View/inventory.php",array('item'=>$itemFields,'champion'=>$champVars,'mine'=>$mineAvatarPath));
    }
    public function sellItem(){
        $query = new ChampionItemQuery();
        $item = new Item($query->getItemIdByPair($_POST["pair"])[0]["item_id"]);
        $itemQuery = new ItemQuery();
        $championItemQuery = new ChampionItemQuery();
        $itemQuery->addItemForSell($_SESSION["myChampId"],$item->getId(),$query->getItemIdByPair($_POST["pair"])[0]["bought_price"] * 0.75);
        $championItemQuery->removeItem($_POST['pair']);
        ChampionController::render();
    }
    public function joinQueue(){
        require '../vendor/autoload.php';


        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '13a59caadb0b5a66bbe0',
            'f54808eafb8c70e08d74',
            '949833',
            $options
        );

        $lobbyQuery = new LobbyQuery();

        $data['message'] = "You successfully joined a queue";
        $pusher->trigger('queue', 'joinQueue', $data['message']);
        $lobbyQuery->joinLobby($_SESSION["myChampId"]);
        if($lobbyQuery->usersInLobby() == 2){
            $pusher->trigger('queue','enterBattle',[]);
        }
    }
}