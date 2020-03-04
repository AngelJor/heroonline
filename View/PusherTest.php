
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
</head>

<body>
<script
    src="https://www.paypal.com/sdk/js?client-id=AUPL4FphYZ90AWwgEXNS2R9WP01bdoptBmi09Tvi1wqStX8BXnmV7PzE8RklLyXhoY4AN1JAT7XxWVi2&currency=EUR"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
</script>

<div id="paypal-button-container"></div>

<script>
    paypal.Buttons().render('#paypal-button-container');
    // This function displays Smart Payment Buttons on your web page.
</script>
</body>
<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: price
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Transaction completed by ' + details.payer.name.given_name);
                // Call your server to save the transaction
                $(document).ready(function () {
                    $.ajax({
                        type: "POST",
                        url: "https://heroonline.com/heroonline/public/index.php?target=champion&action=buyDiamonds",
                        dataType: "JSON",
                        data: {diamonds:value}
                    });
                })
            });
        }
    }).render('#paypal-button-container');
</script>