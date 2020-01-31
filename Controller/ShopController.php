<?php


class ShopController
{
    private $shop;


    /**
     * ShopController constructor.
     * @param $shop
     */
    public function __construct()
    {
        $this->shop = new Shop();
    }


    function buy(){
        $item = (int)$_POST['item'] ?? '';
        $myChampId = (int)$_SESSION['myChampId'] ?? '';

        if(empty($item)
        ||empty($myChampId)
        ){
            echo 'error'; die();
        }
        $this->shop->buy($myChampId,$item);
        self:$this->render();
    }
    function buyFromOtherChampion(){
        $query = new ItemQuery();
        $item = new Item($query->getItemByPair($_POST["pair"])[0]["item_id"]);
        $champ = new Champion($query->getItemByPair($_POST["pair"])[0]["user_id"]);

        $this->shop->buy($_SESSION['myChampId'],$item->getId());
        $champ->setMoney($champ->getMoney() + $item->getPrice() * 0.75);
        $champ->saveMoneyToDb();
        var_dump($champ->getMoney());
        $query->removeItem($_POST['pair']);

        $this->renderChampionShop();
    }
    function  render(){
        //chamoion things
        $champ = new Champion($_SESSION["myChampId"]);
        $champVars = $champ->getChampionFields();

        $mineAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($_SESSION["myChampId"]));
        //item things
        $items = Shop::display(); //twa wrushrta masiv ot itemi -> cqlata shibana baza btw
        WebResponse::render("../View/shop.php",array('item'=>$items,'champion'=>$champVars,'mine'=>$mineAvatarPath));
    }
    function renderChampionShop(){
        $champ = new Champion($_SESSION["myChampId"]);
        $champVars = $champ->getChampionFields();
        $mineAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($_SESSION["myChampId"]));

        $query = new ItemQuery();
        $items = Shop::displayItemForSale();
        $vars = [];
        foreach($items as $key => $value){
            $item[$key] = $query->displayItem($items[$key]["item_id"]);
            $item[$key][0]['price'] = $items[$key]['price'];
            $item[$key][0] += ["pair_id" => $items[$key]['pair_id']];
            $vars += $item;
        }
        WebResponse::render("../View/ChampionTrading.php",array('item'=>$vars,'champion'=>$champVars,'mine'=>$mineAvatarPath));
    }
}