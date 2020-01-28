<?php

class Item
{

    const ARMOR_LEVEL_0 = 0;
    const ARMOR_LEVEL_1 = 1;
    const ARMOR_LEVEL_2 = 2;
    const ARMOR_LEVEL_3 = 3;

    private $name;
    private $type; //DMG; HEALTH, ARMOUR
    private $buff;
    private $price;
    private $id;

//    public function __construct($name, $type, $buff, $price)
//    {
//        $this->name = $name;
//        $this->type = $type;
//        $this->buff = $buff;
//        $this->price = $price;
//    }
    public function __construct($id = null)
    {
        if($id != null){
            $repo = new ItemQuery();
            $itemData = $repo->find($id);
            $this->id = $itemData['item_id'];
            $this->name = $itemData['name'];
            $this->type = $itemData['type'];
            $this->buff = $itemData['buff'];
            $this->price = $itemData['price'];
        }
    }



    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getBuff()
    {
        return $this->buff;
    }

    /**
     * @param mixed $buff
     */
    public function setBuff($buff)
    {
        $this->buff = $buff;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}