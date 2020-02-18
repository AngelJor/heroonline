<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('13a59caadb0b5a66bbe0', {
            cluster: 'eu',
            forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
</head>
<body>
<h1>Pusher Test</h1>
<p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
    <button onclick="buttonPush()">Push</button>
</p>
</body>
<script>
    function buttonPush(){
        $.ajax({
            type:"POST",
            url: "http://localhost/heroonline/public/index.php?target=battle&action=pusherTest",
            dataType: "JSON",
            data: 'GoshoOtPochivka'
        });
    }
</script>