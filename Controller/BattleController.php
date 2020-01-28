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
        $battleId = $this->battle->createBattle($hero1Id, $hero2Id);
        WebResponse::render("../View/battle.php",array('battleId' => $battleId,'enemy' => $opponentAvatarPath,'mine' => $mineAvatarPath,'player1'=>$_SESSION["myChampId"],'player2'=> $mine->getBossLvl(),
            'mineHeal'=>$mineHealPower["power"],'mineDmg'=>$mineDmgPower["power"],'enemyHeal'=>$enemyHealPower["power"],'enemyDmg'=>$enemyDmgPower["power"],'mineHealth'=>$mine->getName(),'enemyHealth'=>$enemy->getName(),
            'mineStrength'=>$mine->getStrength(),'enemyStrength'=>$enemy->getStrength(),'mineArmour'=>$mine->getArmourItem(),'enemyArmour'=>$enemy->getArmourItem()));
    }
    function startBattle()
    {
        $championSpellQuery = new ChampionSpellQuery();
        $myId = $_SESSION['myId'] ?? '';
        $opponentId = $_POST['opponent'] ?? '';
        if(empty($myId)
        ||empty($opponentId)
        ){
            echo 'error'; die();
        }
            $mineAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($_SESSION["myChampId"]));
            $opponentAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($_POST["opponent"]));
            $mineHealPower = $championSpellQuery->getChampionSpellPower($_SESSION["myChampId"],"Heal");
            $mineDmgPower = $championSpellQuery->getChampionSpellPower($_SESSION["myChampId"],"Dmg");
            $enemyHealPower = $championSpellQuery->getChampionSpellPower($_POST["opponent"],"Heal");
            $enemyDmgPower = $championSpellQuery->getChampionSpellPower($_POST["opponent"],"Dmg");
            $hero1Id = $_SESSION['myChampId'];
            $hero2Id = $_POST['opponent'];
            $mine = new Champion($hero1Id);
            $enemy = new Champion($hero2Id);
            $battleId = $this->battle->createBattle($hero1Id, $hero2Id);
            WebResponse::render("../View/battle.php",array('battleId' => $battleId,'enemy' => $opponentAvatarPath,'mine' => $mineAvatarPath,'player1'=>$_SESSION["myChampId"],'player2'=> $_POST["opponent"],
                'mineHeal'=>$mineHealPower["power"],'mineDmg'=>$mineDmgPower["power"],'enemyHeal'=>$enemyHealPower["power"],'enemyDmg'=>$enemyDmgPower["power"],'mineHealth'=>$mine->getName(),'enemyHealth'=>$enemy->getName(),
                'mineStrength'=>$mine->getStrength(),'enemyStrength'=>$enemy->getStrength(),'mineArmour'=>$mine->getArmourItem(),'enemyArmour'=>$enemy->getArmourItem()));
    }
    function liveBattle(){
        WebResponse::render("../WebSocket/liveBattle.php", array('Session' => $_SESSION));
    }
    function attack()
    {
        $battleId = (int)$_POST['battleId'];
        if (empty($battleId)){
            echo 'error'; die();
        }
        $attacker = new Champion($this->battle->getAttackerId($battleId));
        $defender = new Champion($this->battle->getDefenderId($battleId));

        $result['round'][] = $this->battle->battle($attacker, $defender, $_POST['Attack']);

        if (! isset(current($result['round'])['battleOver'])) {
            $result['round'][] = $this->battle->battle($defender, $attacker, AIChampion::chooseAttackWay());
        }
        WebResponse::renderWithJson($result);
    }
}