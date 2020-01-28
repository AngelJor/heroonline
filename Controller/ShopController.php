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
        $champ = new Champion($_SESSION["myChampId"]);
        $champVars = $champ->getChampionFields();

        $mineAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($_SESSION["myChampId"]));
        //item things
        $items = Shop::display(); //twa wrushrta masiv ot itemi -> cqlata shibana baza btw
        WebResponse::render("../View/shop.php",array('item'=>$items,'champion'=>$champVars,'mine'=>$mineAvatarPath));
    }
    function render(){
        //chamoion things
        $champ = new Champion($_SESSION["myChampId"]);
        $champVars = $champ->getChampionFields();

        $mineAvatarPath = Champion::getAvatarPath(Champion::getAvatarID($_SESSION["myChampId"]));
        //item things
        $items = Shop::display(); //twa wrushrta masiv ot itemi -> cqlata shibana baza btw
        WebResponse::render("../View/shop.php",array('item'=>$items,'champion'=>$champVars,'mine'=>$mineAvatarPath));
    }
}