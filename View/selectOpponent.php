<!DOCTYPE html>
<html>
<head>
    <title>Select opponent</title>
</head>
<body>

<form action="<?=_SERVER_PATH?>battle/startBattle" method="post">
    <p>Please select opponent</p>
    <?php
    foreach ($params['champions'] as $key => $value) {
        $champ = new Champion($value);
        $iconPath = Champion::getIconPath($champ->getIcon());
        echo '
        <img src="'.$iconPath.'" alt="Choose opponent">
        <input type="radio" name="opponent" value="' .$value. '"/>' .$champ->getName(). '<br>'
        ;
    }
    ?>
    <button type="submit" name="Start battle">Fight</button>
</form>
<br>
</body>
</html>