<?php


class Fight 
{
    const BATTLE_STATE_ACTIVE = 1;
    const ATTACK  = "Attack";
    const SPELL  = "dmgSpell";
    const HEAL  = "Heal";
    const HEALTH_BUFF = 'Health';
    const SPELL_HEAL = 'Heal';
    const SPELL_DMG = 'Dmg';
    const SPELL_POWER = 'power';
    const HEALTH_MULTIPLIER = 100;
    public static $armorLevelToDmg = [
        Item::ARMOR_LEVEL_0 => 1,
        Item::ARMOR_LEVEL_1 => 0.95,
        Item::ARMOR_LEVEL_2 => 0.90,
        Item::ARMOR_LEVEL_3 => 0.85,
    ];

    function createBattle($myChampId,$opponentId){
        $battleQuery = new BattleQuery();

        if(rand(0,1000) > 500) {
            $attacker = new Champion($myChampId);
            $defender = new Champion($opponentId);
        }
        else{
            $attacker = new Champion($opponentId);
            $defender = new Champion($myChampId);
        }
        $battleQuery->create($attacker->getId(), $defender->getId());
    }
    function battle(Champion $attacker, Champion $defender,$attackWay)
    {
        $roundQuery = new RoundQuery();
        $battleQuery = new BattleQuery();
        $championQuery = new ChampionQuery();
        $championSpellQuery = new ChampionSpellQuery();
        $battleId = $battleQuery->getId($attacker->getId(),$defender->getId());
        $power[] =  $championSpellQuery->getChampionSpellPower($attacker->getId(),self::SPELL_DMG);
        $heal[] = $championSpellQuery->getChampionSpellPower($attacker->getId(),self::SPELL_HEAL);
        switch ($attackWay){
            case self::ATTACK:
                if($attacker->getId() == $_SESSION["myChampId"]) {
                    $defender->setHealth($defender->getHealth() - self::$armorLevelToDmg[$defender->getArmourItem()] * ($attacker->getStrength() + $_SESSION["dmgBuff"]));
                    $roundQuery->create($battleId, $attacker->getId(), $defender->getId(), $defender->getHealth(), $attacker->getStrength(), 0);
                }
                else{
                    $defender->setHealth($defender->getHealth() - self::$armorLevelToDmg[$defender->getArmourItem()] * ($attacker->getStrength()));
                    $roundQuery->create($battleId, $attacker->getId(), $defender->getId(), $defender->getHealth(), $attacker->getStrength(), 0);
                }
                break;
            case self::SPELL:
                $defender->setHealth($defender->getHealth() - $power[0][self::SPELL_POWER]);
                $roundQuery->create($battleId,$attacker->getId(),$defender->getId(),$defender->getHealth(),$power[0][self::SPELL_POWER],0);
                break;
            case self::HEAL:
                $newHealth = min($attacker->getMaxHealth(), $attacker->getHealth() + $heal[0][self::SPELL_POWER]);
                $attacker->setHealth($newHealth );
                $attacker->saveHealthToDb();
                $roundQuery->create($battleId,$attacker->getId(),$defender->getId(),$defender->getHealth(),0,$heal[0][self::SPELL_POWER]);
                break;
        }
        $array = [
            'AttackerMaxHealth' => $attacker->getMaxHealth(),
            'DefenderMaxHealth' =>(int)$defender->getLvl() * 100 +
                Champion::getBuffs($defender->getId())[self::HEALTH_BUFF],
            'AttackerHealth' => (int)$attacker->getHealth(),
            'Attacker' => (int)$battleQuery->getAttacker($battleId),
            'Defender' => (int)$battleQuery->getDefender($battleId),
            'AttackerName' => $attacker->getName(),
            'DefenderName' => $defender->getName(),
            'DefenderHealthLeft' => (int)$defender->getHealth(),
            'HealingDone' => (int)$heal[0][self::SPELL_POWER],
            'DmgDealt' => (int)$attacker->getStrength(),
            'SpellDmgDone' => (int)$power[0][self::SPELL_POWER],
            'Move' => $attackWay
        ];
        if($attacker->getId() == $_SESSION["myChampId"]){
            $array["DmgDealt"] = $attacker->getStrength() + $_SESSION["dmgBuff"];
        }
        $defender->saveHealthToDb();
        $battleQuery->update($defender->getId(),$attacker->getId());

        if($defender->getHealth() > 0 && $attacker->getHealth() > 0) {
            $array['msgChampOnTurn'] =  "It`s {$battleQuery->getAttacker($battleId)} on turn<br>";
            $array['msgChooseMove'] =  "Choose your next move<br>";
            return $array;
        }

        elseif ($defender->getHealth() <= 0 || $attacker->getHealth() <= 0) {
            $array['battleOver'] = "Battle is over";
            $battleQuery->setState(0);

            $attacker->setHealth($attacker->getMaxHealth());
            $attacker->saveHealthToDb();

            $defender->setHealth($defender->getMaxHealth());
            $defender->saveHealthToDb();


            $championId = $attacker->getId();
            if($championId > 10) {
                if($defender->getId() <= 10){
                    $attacker->defeatingBoss();
                    $xpResult = $attacker->getXp() + (10 * $defender->getId());
                    $moneyResult = $attacker->getMoney() + (100 * $defender->getId());
                    $championQuery->priceForWin($championId, $xpResult, $moneyResult);
                }
                else {
                    $xpResult = 0;
                    $moneyResult = 0;

                    switch ($attacker->getLvl()) {
                        case $attacker->getLvl() > $defender->getLvl():
                            $xpResult = $attacker->getXp() + 50;
                            $moneyResult = $attacker->getMoney() + 50;
                            break;
                        case $attacker->getLvl() == $defender->getLvl():
                            $xpResult = $attacker->getXp() + 100;
                            $moneyResult = $attacker->getMoney() + 100;
                            break;
                        case $attacker->getLvl() < $defender->getLvl():
                            $xpResult = $attacker->getXp() + 150;
                            $moneyResult = $attacker->getMoney() + 150;
                            break;
                    }

                    $championQuery->priceForWin($championId, $xpResult, $moneyResult);
                    if ($attacker->getXp() >= 1000) {
                        $championQuery->lvlUp(0,
                            $attacker->getLvl() + 1,
                            $attacker->getStrength() + Champion::BASE_DMG_MODIFIER,
                            $attacker->getMaxHealth() + Champion::BASE_HEALTH_MODIFIER,
                            $attacker->getId());
                    }
                }
            }
        }
        return $array;
    }

    function getAttackerId($battleId){
        $battleQuery = new BattleQuery();
        return $battleQuery->getAttacker($battleId);
    }

    function getDefenderId($battleId){
        $battleQuery = new BattleQuery();
        return $battleQuery->getDefender($battleId);
    }
}