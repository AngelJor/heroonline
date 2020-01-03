<?php


class User
{
    private $name;
    private $username;
    private $email;
    private $password;
    private $id;
    private $query;

    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $this->query = new UsersQuery();    //query
            $userData = $this->query->find($id);
            $this->name = $userData['name'];
            $this->id = $userData['user_id'];
            $this->username = $userData['username'];
            $this->email = $userData['email'];
            $this->password = $userData['password'];
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
    public static function register($name, $email, $username, $password){
        $query = new UsersQuery();
        $hashedPass = hash('sha256', $password);
        $query->register($name,$email,$username,$hashedPass);
    }
    public static function facebookRegister($name, $facebookId){
        $query = new UsersQuery();
        $hashedId = hash('sha256',$facebookId);
        $query->registerWithFacebook($name,$facebookId);
    }
    public static function login($username,$password){
        $query = new usersQuery();
        return $query->login($username,$password);
    }
    public static function createChampion($championName,$userId,$isFacebookUser){
        $query = new ChampionQuery();
        $query->create($championName, $userId,$isFacebookUser);
    }
    public static function listUserChampions($userId){
        $query = new ChampionQuery();
        return $query->listChampsForUser($userId);
    }
    public static function selectIcon($iconId,$userId){
        $query = new ChampionQuery();
        $query->setIcon($iconId,$userId);
    }
    public static function selectAvatar($avatarId,$userId){
        $query = new ChampionQuery();
        $query->setAvatar($avatarId,$userId);
    }
}