<!DOCTYPE html>
<html>
<head>
    <title>Inventory</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_PATH?>View/Style/shop.css">
</head>
<body>
<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-link" href="<?=_SERVER_PATH?>champion/displayChampion">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=_SERVER_PATH?>champion/selectOpponent">Start Battle</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=_SERVER_PATH?>shop/render">Shop</a>
    </li>
    <li class="nav-item log-out">
        <a class="nav-link" href="<?=_SERVER_PATH?>user/logout">Log out</a>
    </li>
</ul>
<div class="top">
    <div class="top-level">
        <table class="lvl">
            <tr>
                <td>Lvl: <?php echo $params["champion"]["lvl"] ?></td>
            </tr>
        </table>
    </div>
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $params["champion"]["xp"]/10?>%">Xp</div>
    </div>
    <div class="top-money">
        <table class="money">
            <tr>
                <td>Money: <?php echo $params["champion"]["money"] ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="content">
    <form class="shop" action="<?=_SERVER_PATH?>champion/selectItem" method="post">
        <table class="myTableBg">
            <?php
            $counter = 1;
            echo "<tr>";
            foreach ($params["item"] as $key => $value){
                foreach($value as $k => $v) {
                    echo self::renderPartial('partial/item.php', $v);
                    if ($counter % 3 == 0) {
                        echo "</tr><tr>";
                    }
                    $counter++;
                }
            }
            ?>
        </table>
        <button type="submit">Select Item</button>
    </form>

    <img class="avatarImg" src="<?php echo $params['mine'] ?>">

</div>
<div class="bottom" style="float: right">
    <table class="stats">
        <tr>
            <th>Health:</th>
            <td><?php echo $params["champion"]["health"] ?></td>
        </tr>
        <tr>
            <th>Strength:</th>
            <td><?php echo $params["champion"]["strength"] ?></td>
        </tr>
        <tr>
            <th>Armour:</th>
            <td><?php echo $params["champion"]["armour"] ?></td>
        </tr>
    </table>
</div>
</body>
</html>