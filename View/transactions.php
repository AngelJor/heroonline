<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_PATH?>View/Style/myChampion.css">
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
    <li class="nav-item">
        <a class="nav-link" href="<?=_SERVER_PATH?>champion/chooseBoost">Go on a Mission</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=_SERVER_PATH?>champion/render">Inventory</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=_SERVER_PATH?>shop/renderChampionShop">Offers from other Champions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="https://heroonline.com/heroonline/View/onlineBattle.php">Start Live Battle</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?=_SERVER_PATH?>shop/transactionRender">Buy diamonds</a>
    </li>
</ul>

<script
    src="https://www.paypal.com/sdk/js?client-id=AY3pEJ98GsFoUzuLInwJzKmS3mMyFc0c3BZmoPe6_-XIsTDFRG9vUsrQm0ke9plkUqEf2gOQbm0tJnYA&currency=EUR">
</script>
<div id="paypal-button-container"></div>
<div>
    <table>
        <tr>
            <th>Size</th>
            <th>Quantity</th>
            <th>Price in Euro</th>
            <th>Choose</th>
        </tr>
        <tr>
            <td>Small</td>
            <td>5</td>
            <td>2</td>
            <td><button id="5" type="submit" name="LargePack" value="2">Buy<button</td>
        </tr>
        <tr>
            <td>Medium</td>
            <td>15</td>
            <td>5</td>
            <td><button id="15" type="submit" name="LargePack" value="5">Buy<button</td>
        </tr>
        <tr>
            <td>Large</td>
            <td>50</td>
            <td>18</td>
            <td><button id="50" type="submit" name="LargePack" value="18">Buy<button</td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    document.getElementById("5").onclick = function () {transaction(document.getElementById("5").value,5)};
    document.getElementById("15").onclick = function () {transaction(document.getElementById("15").value,15)};
    document.getElementById("50").onclick = function () {transaction(document.getElementById("50").value,50)};
    function transaction(price,value) {
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: price
                        }
                    }]
                });
            },
            onApprove: function () {
                alert("Transaction is completed");
                $(document).ready(function () {
                    $.ajax({
                        type: "POST",
                        url: "https://heroonline.com/heroonline/public/index.php?target=champion&action=buyDiamonds",
                        dataType: "JSON",
                        data: {diamonds:value}
                    });
                })
            }
        }).render('#paypal-button-container');
    }
</script>
</body>
</html>