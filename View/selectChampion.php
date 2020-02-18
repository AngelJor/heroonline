<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>

<form action="<?=_SERVER_PATH?>user/selectChampion" method="post">
    <?php
        foreach ($params['champions'] as $key => $value) {
            $champ = new Champion($value);
            $iconPath = Champion::getIconPath($champ->getIcon());
            echo '
            <img src="'.$iconPath.'" alt="Choose champion">
            <input type="radio" name="champion" value="' .$value. '"/>' .$champ->getName(). '<br>'
            ;
        }
    ?>
    <input type="submit" name= "Select" value= "Select"/>
</form>
<button onclick="window.location.href = '<?=_SERVER_PATH?>user/renderSelectIcon';">Create new champion</button>
</body>
</html>
