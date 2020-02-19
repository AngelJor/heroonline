<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://localhost/heroonline/View/Style/battle.css">
</head>

<body onload="joinQueue()">
<p>zdr</p>
</body>
<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('13a59caadb0b5a66bbe0', {
        cluster: 'eu',
        forceTLS: true
    });
    var queue = pusher.subscribe('queue');

    function joinQueue(){
        $.ajax({
            url: "http://localhost/heroonline/public/index.php?target=champion&action=joinQueue"
        });
    }
    queue.bind('enterBattle',function(){
        $.ajax({
            url: "http://localhost/heroonline/public/index.php?target=battle&action=enterBattle",
            success:function(result){
                $("body").replaceWith(result);
            }
        });
    });
    queue.bind('battle',function(data){
        alert(JSON.stringify(data));
    });
    queue.bind('attack',function(result){
        var isBattleOver = result.round[result.round.length - 1].battleOver;
        if (isBattleOver) {
            alert("Battle is over!");
            $('#Return').css('display','block');
            $('.Moves').css('display','none');
        } else {
            for (var roundNumber in result['round']) {
                var roundData = result['round'][roundNumber];
                if(roundData.Defender == $('.myId').val()){
                    $('.Moves').css('display','block');
                }
                else{
                    $('.Moves').css('display','none');
                }
                switch (roundData.Move) {
                    case "Heal":
                        $('#round-log' + roundNumber).replaceWith('<div id="round-log' + roundNumber + '">' + roundData.AttackerName + " used his heal spell and heal for " + roundData.HealingDone + '</div>');
                        $('#' + roundData.Attacker).css('width', roundData.AttackerHealth / roundData.AttackerMaxHealth * 100 + '%');
                        break;
                    case "dmgSpell":
                        $('#round-log' + roundNumber).replaceWith('<div id="round-log' + roundNumber + '">' + roundData.AttackerName + " used his damage spell and made " + roundData.SpellDmgDone + " and left his opponent with " + roundData.DefenderHealthLeft + '</div>');
                        $('#' + roundData.Defender).css('width',  roundData.DefenderHealthLeft / roundData.DefenderMaxHealth * 100  + '%');
                        break;
                    case "Attack":
                        $('#round-log' + roundNumber).replaceWith('<div id="round-log' + roundNumber + '">' + roundData.AttackerName + " used his basic attack and made " + roundData.DmgDealt + " and left his opponent with " + roundData.DefenderHealthLeft + '</div>');
                        $('#' + roundData.Defender).css('width',  roundData.DefenderHealthLeft / roundData.DefenderMaxHealth * 100  + '%');
                }
            }
        }
    });
    function sendParams(value) {
        $(document).ready(function() {
            var battleId = $(".battleId").val();
            $.ajax({
                type: "POST",
                url: "http://localhost/heroonline/public/index.php?target=battle&action=onlineAttack",
                dataType: "JSON",
                data: {Attack:value,battleId:battleId}
            });
        })
    }
</script>

</html>