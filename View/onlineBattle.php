<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
</head>

<body onload="joinQueue()">
<p>zdr</p>
<div id="container">
    <div id="champion1">

    </div>
    <div id="champion2">

    </div>
</div>
</body>
<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('13a59caadb0b5a66bbe0', {
        cluster: 'eu',
        forceTLS: true
    });
    var queue = pusher.subscribe('queue');
    //tuk sa wsichki pusher triguri

    function joinQueue(){
        $.ajax({
            url: "http://localhost/heroonline/public/index.php?target=champion&action=joinQueue"
        });
    }
    queue.bind('enterBattle',function(){
        $.ajax({
            url: "http://localhost/heroonline/public/index.php?target=battle&action=enterBattle",
            success:function(result){
                //tuk shte izwikwa jquery koeto da replecwa chasti ot nowata stranica a imenno shte replacene loadura s in
                //foto za geroite chrez renderPartial
                alert(result);
            }
        });
    });
    queue.bind('battle',function(data){
        alert(JSON.stringify(data));
    });
</script>

</html>