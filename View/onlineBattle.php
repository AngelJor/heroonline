<html>
<head>

</head>

<body>
    <p>zdr kp ks</p>
</body>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('13a59caadb0b5a66bbe0', {
        cluster: 'eu',
        forceTLS: true
    });
    var queue = pusher.subscribe('queue');


    queue.bind('battle', function(data) {
        alert(JSON.stringify(data));
    });
</script>
</html>