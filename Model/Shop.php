<?php


class Shop
{
    static function display(){
        $query = new ItemQuery();
        return $query->display();
    }
    function buy($championId, $itemId)
    {
        $item = new Item($itemId);
        $champion = new Champion($championId);
        $itemQuery = new ChampionItemQuery();
        if ($champion->getMoney() >= $item->getPrice()) {
            $champion->setMoney($champion->getMoney() - $item->getPrice());
            $champion->saveMoneyToDb();
            $champion->setNewStats($item);
            $itemQuery->addItem($item->getId(),$champion->getId());
            return 1;
        } else {
            return 0;
        }

    }
}