<?php


class AIChampion extends Champion
{
    public static function chooseAttackWay(){
        $number = rand(0,1000);

        if($number < 333){
            return Fight::SPELL;
        }
        elseif ($number > 333 && $number < 666){
            return Fight::HEAL;
        }
        elseif ($number > 666){
            return Fight::ATTACK;
        }
        return null;
    }
}