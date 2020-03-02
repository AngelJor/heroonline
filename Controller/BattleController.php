<?php

class BattleController
{
    private $battle;

    /**
     * BattleController constructor.
     *
     */
    public function __construct()
    {
        $this->battle = new Fight();
    }
    function bossFight(){
        $battleQuery = new BattleQuery();
        $buffId = empty($_POST['boostId']) ? 0 : $_POST['boostId'];
        $buff = $battleQuery->getFieldsForBuff($buffId);
        $additionalDmg = empty($buff[0]['boost_buff']) ? 0 : $buff[0]['boost_buff'];
        $_SESSION["dmgBuff"] = $additionalDmg;
        if(isset($buff[0]['price'])){
            $shopController = new ShopController();
            $shopController->buyBuff($buff[0]['price']);
        }
        $championSpellQuery = new ChampionSpellQuery();
        $hero1Id = $_SESSION['myChampId'];
        $mine = new Champion($hero1Id);
        $hero2Id = $mine->getBossLvl();
        $enemy = new Champion($hero2Id);
        $mineAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($_SESSION["myChampId"]));
        $opponentAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($mine->getBossLvl()));
        $mineHealPower = $championSpellQuery->getChampionSpellPower($_SESSION["myChampId"],"Heal");
        $mineDmgPower = $championSpellQuery->getChampionSpellPower($_SESSION["myChampId"],"Dmg");
        $enemyHealPower = $championSpellQuery->getChampionSpellPower($mine->getBossLvl(),"Heal");
        $enemyDmgPower = $championSpellQuery->getChampionSpellPower($mine->getBossLvl(),"Dmg");
        $this->battle->createBattle($hero1Id, $hero2Id);
        WebResponse::render("../View/battle.php",array('battleId' => $battleQuery->getId($hero1Id,$hero2Id),'enemy' => $opponentAvatarPath,'mine' => $mineAvatarPath,'player1'=>$_SESSION["myChampId"],'player2'=> $mine->getBossLvl(),
            'mineHeal'=>$mineHealPower["power"],'mineDmg'=>$mineDmgPower["power"],'enemyHeal'=>$enemyHealPower["power"],'enemyDmg'=>$enemyDmgPower["power"],'mineHealth'=>$mine->getName(),'enemyHealth'=>$enemy->getName(),
            'mineStrength'=>$mine->getStrength() + $additionalDmg,'enemyStrength'=>$enemy->getStrength(),'mineArmour'=>$mine->getArmourItem(),'enemyArmour'=>$enemy->getArmourItem()));
    }
    function startBattle(){
        $_SESSION["dmgBuff"] = 0;
        $championSpellQuery = new ChampionSpellQuery();
        $myId = $_SESSION['myChampId'] ?? '';
        $opponentId = $_POST['opponent'] ?? '';
        if(empty($myId)
        ||empty($opponentId)
        ){
            echo 'error'; die();
        }
            $battleQuery = new BattleQuery();
            $mineAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($myId));
            $opponentAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($opponentId));
            $mineHealPower = $championSpellQuery->getChampionSpellPower($myId,"Heal");
            $mineDmgPower = $championSpellQuery->getChampionSpellPower($myId,"Dmg");
            $enemyHealPower = $championSpellQuery->getChampionSpellPower($opponentId,"Heal");
            $enemyDmgPower = $championSpellQuery->getChampionSpellPower($opponentId,"Dmg");
            $hero1Id = $myId;
            $hero2Id = $opponentId;
            $mine = new Champion($hero1Id);
            $enemy = new Champion($hero2Id);
            $this->battle->createBattle($hero1Id, $hero2Id);
            WebResponse::render("../View/battle.php",array('battleId' => $battleQuery->getId($myId,$opponentId),'enemy' => $opponentAvatarPath,
                'mine' => $mineAvatarPath,'player1'=>$myId,
                'player2'=> $opponentId,'mineHeal'=>$mineHealPower["power"],
                'mineDmg'=>$mineDmgPower["power"],
                'enemyHeal'=>$enemyHealPower["power"],'enemyDmg'=>$enemyDmgPower["power"],
                'mineHealth'=>$mine->getName(),'enemyHealth'=>$enemy->getName(),
                'mineStrength'=>$mine->getStrength(),'enemyStrength'=>$enemy->getStrength(),
                'mineArmour'=>$mine->getArmourItem(),'enemyArmour'=>$enemy->getArmourItem()));
    }
    function onlineAttack(){
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
        $battleId = (int)$_POST['battleId'];
        if (empty($battleId)){
            echo 'error'; die();
        }
        $attacker = new Champion($this->battle->getAttackerId($battleId));
        $defender = new Champion($this->battle->getDefenderId($battleId));

        $result['round'][] = $this->battle->battle($attacker, $defender, $_POST['Attack']);

        $pusher->trigger('queue','attack',$result);
    }
    function attack()
    {
        $battleId = (int)$_POST['battleId'];
        if (empty($battleId)){
            echo 'error'; die();
        }
        $attacker = new Champion($this->battle->getAttackerId($battleId));
        $defender = new Champion($this->battle->getDefenderId($battleId));

        if($this->battle->getAttackerId($battleId) == $_SESSION['myChampId']) {

            $result['round'][] = $this->battle->battle($attacker, $defender, $_POST['Attack']);
            if (!isset(current($result['round'])['battleOver'])) {
                $result['round'][] = $this->battle->battle($defender, $attacker, AIChampion::chooseAttackWay());
            }
            WebResponse::renderWithJson($result);
        }
        else{
            $result['round'][] = $this->battle->battle($attacker, $defender, AIChampion::chooseAttackWay());

            if (!isset(current($result['round'])['battleOver'])) {
                $result['round'][] = $this->battle->battle($defender, $attacker, $_POST['Attack']);
            }
            WebResponse::renderWithJson($result);
        }
    }
    function lobbyMembers(){
        $lobbyQuery = new LobbyQuery();
        return $lobbyQuery->usersInLobby();
    }
    function enterBattle(){
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
        $battleQuery = new BattleQuery();
        $lobbyQuery = new LobbyQuery();
        $championSpellQuery = new ChampionSpellQuery();

        $msg = "You have entered a battle";
        $pusher->trigger('queue','battle',$msg);

        $users = $lobbyQuery->getUserId();

        $myId = $_SESSION['myChampId'];
        $mineAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($myId));
        $mineHealPower = $championSpellQuery->getChampionSpellPower($myId,"Heal");
        $mineDmgPower = $championSpellQuery->getChampionSpellPower($myId,"Dmg");
        $mine = new Champion($myId);

        switch($myId){
            case $users[0]['user1_id']:

                $opponentId = (int)$users[1]['user1_id'];

                $opponentAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($opponentId));
                $enemyHealPower = $championSpellQuery->getChampionSpellPower($opponentId,"Heal");
                $enemyDmgPower = $championSpellQuery->getChampionSpellPower($opponentId,"Dmg");
                $enemy = new Champion($opponentId);
                WebResponse::render("../View/partial/onlineBattle.php",array('battleId' => $battleQuery->getId($myId,$opponentId)
                ,'enemy' => $opponentAvatarPath,
                    'mine' => $mineAvatarPath,'player1'=>$myId,
                    'player2'=> $opponentId,'mineHeal'=>$mineHealPower["power"],
                    'mineDmg'=>$mineDmgPower["power"],
                    'enemyHeal'=>$enemyHealPower["power"],'enemyDmg'=>$enemyDmgPower["power"],
                    'mineHealth'=>$mine->getName(),'enemyHealth'=>$enemy->getName(),
                    'mineStrength'=>$mine->getStrength(),'enemyStrength'=>$enemy->getStrength(),
                    'mineArmour'=>$mine->getArmourItem(),'enemyArmour'=>$enemy->getArmourItem()));
                $attackerId = $battleQuery->getAttacker($battleQuery->getId($myId,$opponentId));
                $pusher->trigger('queue','attacker',$attackerId);
                break;
            case $users[1]['user1_id']:

                $opponentId = (int)$users[0]['user1_id'];

                $opponentAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($opponentId));
                $enemyHealPower = $championSpellQuery->getChampionSpellPower($opponentId,"Heal");
                $enemyDmgPower = $championSpellQuery->getChampionSpellPower($opponentId,"Dmg");
                $enemy = new Champion($opponentId);
                WebResponse::render("../View/partial/onlineBattle.php",array('battleId' => $battleQuery->getId($myId,$opponentId),'enemy' => $opponentAvatarPath,
                    'mine' => $mineAvatarPath,'player1'=>$myId,
                    'player2'=> $opponentId,'mineHeal'=>$mineHealPower["power"],
                    'mineDmg'=>$mineDmgPower["power"],
                    'enemyHeal'=>$enemyHealPower["power"],'enemyDmg'=>$enemyDmgPower["power"],
                    'mineHealth'=>$mine->getName(),'enemyHealth'=>$enemy->getName(),
                    'mineStrength'=>$mine->getStrength(),'enemyStrength'=>$enemy->getStrength(),
                    'mineArmour'=>$mine->getArmourItem(),'enemyArmour'=>$enemy->getArmourItem()));
                $attackerId = $battleQuery->getAttacker($battleQuery->getId($myId,$opponentId));
                $pusher->trigger('queue','attacker',$attackerId);
                break;
        }
    }
}