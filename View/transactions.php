<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
</head>

<body>
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
                        url: "http://localhost/heroonline/public/index.php?target=champion&action=buyDiamonds",
                        dataType: "JSON",
                        data: {diamonds:value},
                    });
                })
            }
        }).render('#paypal-button-container');
    }
</script>
</body>
</html>