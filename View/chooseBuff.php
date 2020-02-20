<!DOCTYPE html>
<html>
<head>
    <title>Choose Buff</title>
</head>
<body>

    <form action="<?=_SERVER_PATH?>battle/bossFight" method="post">
    <?php
    echo 'Select your Dmg Buff <br>';
    foreach ($params['buff'] as $allBuffKey => $allBuffs) {
        echo ' <input type="radio" name="boostId"  value=" ' . $allBuffs['boost_id'] . ' ">The boost has ' . $allBuffs['boost_buff'] . ' power. <br>';
    }
    ?>
    <input type="submit" name= "Fight" value= "Select"/>
</form>
</body>
</html>
