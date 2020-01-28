<?php


class UserController
{
    public function register() {
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $name = $_POST['name'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email)
            || empty($username)
            || empty($password)
            || empty($name)
        ) {
            echo 'error'; die();
        }

        User::register($name,$email,$username,$password);
        UserController::renderSelectIcon();
    }
    public function selectIcon(){
        $_SESSION["myIcon"] = ($_POST["icon"]);
        WebResponse::render("../View/createChampion.php");
    }
    public function login(){
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        if(empty($username)
        ||empty($password)
        ){
            echo 'error'; die();
        }
        User::login($username,$password);
        UserController::renderSelectChampion();
    }
    public function loginWithFacebook(){
        User::loginWithFacebook($_POST['facebookId']);
        $_SESSION['isFacebookUser'] = $_POST['isFacebookUser'];
    }
    public static function renderSelectChampion(){
        if ($_SESSION['isFacebookUser'] == 1){
            $champions = User::listFacebookChampions($_SESSION['myId']);
        }else{
            $champions = User::listUserChampions($_SESSION['myId']);
        }
        WebResponse::render("../View/selectChampion.php", array('champions'=>$champions));
    }
    public function selectChampion(){
        $champion = $_POST['champion'] ?? '';
        $myId = $_SESSION['myId'] ?? '';

        if (empty($champion)
            ||empty($myId)
        ){
            echo 'error'; die();
        }

        $_SESSION['myChampId'] = $champion;

        ChampionController::displayChampion();
    }
    public function logout(){
        unset($_SESSION['myId']);
        unset($_SESSION['myChampId']);

        WebResponse::render("..\View\home.php");
    }
    public function createChampion(){
        $name = $_POST['name'] ?? '';
        $myId = $_SESSION['myId'] ?? '';
        $isFacebookUser = $_SESSION['isFacebookUser'] ?? '';
        if(empty($name)
            ||empty($myId)
        ){
            echo 'error'; die();
        }
        elseif (empty($isFacebookUser)){
            User::createChampion($name,$myId,0);
        }
        else{
            User::createChampion($name,$myId,1);
        }
        $avatar = new AvatarQuery();
        WebResponse::render("../View/selectAvatar.php", array('avatars'=>$avatar->display()));

    }
    public function selectAvatar(){
        $healSpell = Spell::selectSpell("Heal");
        $dmgSpell = Spell::selectSpell("Dmg");
        User::selectAvatar($_POST["avatar"],$_SESSION["myId"],$_SESSION['isFacebookUser']);
        User::selectIcon($_SESSION["myIcon"],$_SESSION['myId'],$_SESSION['isFacebookUser']);
        $_SESSION["myAvatar"] = ($_POST["avatar"]);
        WebResponse::render("../View/selectSpell.php", array('healSpell'=>$healSpell, 'dmgSpell'=>$dmgSpell));
    }

    public function facebookRegister(){
        User::facebookRegister($_POST["FacebookName"],$_POST["facebookId"]);
        $_SESSION['isFacebookUser'] = $_POST['isFacebookUser'];
    }
    public static function renderSelectIcon(){
        $icons = new IconQuery();
        WebResponse::render("../View/selectIcon.php",array('icons'=>$icons->display()));
    }
}