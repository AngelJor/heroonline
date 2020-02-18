<!DOCTYPE html>
<html>
<head>
    <title>Battle Area</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_PATH?>View/Style/battle.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
</head>
<body>
<div id="round-log0"></div>
<div id="round-log1">Les`s the battle begin</div>

<div class="progress">
    <div>
        <div id="<?php echo $params['player1'] ?>" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"></div>
    </div>
    <div>
        <div id="<?php echo $params['player2'] ?>" class="progress-bar progress-bar-striped second-progress-bar progress-bar-animated" role="progressbar"></div>
    </div>
</div>

<div class="container">
    <div class="Moves">
        <button id="Attack" class="btn btn-danger" name="Attack" type="submit" value="Attack" >Attack</button>
        <button id="Heal" class="btn btn-success" name="Heal" type="submit" value="Heal">Heal</button>
        <button id="DmgSpell" class="btn btn-warning" name="dmgSpell" type="submit" value="dmgSpell">DmgSpell</button>
        <input class="battleId" hidden name="battleId" value="<?php  echo $params['battleId'] ?>">
    </div>
    <form class="return-form" action="<?=_SERVER_PATH?>champion/displayChampion" method="post">
        <button id="Return" class="btn btn-warning return"  type="submit">Return to main Menu</button>
    </form>
</div>

<div class="battle-area">
    <div>
        <!-- player 1 -->
        <div class="player-avatar">
            <img id="avatar1" src="<?php echo $params['mine'] ?>"> <br>
        </div>
        <table>
            <tr>
                <th>Name:</th>
                <td><?php echo $params['mineHealth'] ?></td>
            </tr>
            <tr>
                <th>Strength:</th>
                <td><?php echo $params['mineStrength'] ?></td>
            </tr>
            <tr>
                <th>Armour:</th>
                <td><?php echo $params['mineArmour'] ?></td>
            </tr>
            <tr>
                <th>Heal Spell power:</th>
                <td><?php echo $params['mineHeal'] ?></td>
            </tr>
            <tr>
                <th>Dmg Spell power:</th>
                <td><?php echo $params['mineDmg'] ?></td>
            </tr>
        </table>
    </div>
    <div>
        <!-- player 2 -->
        <div class="player-avatar">
            <img id="avatar2" src="<?php echo $params['enemy'] ?>"><br>
        </div>
        <table>
            <tr>
                <th>Name:</th>
                <td><?php echo $params['enemyHealth'] ?></td>
            </tr>
            <tr>
                <th>Strength:</th>
                <td><?php echo $params['enemyStrength'] ?></td>
            </tr>
            <tr>
                <th>Armour:</th>
                <td><?php echo $params['enemyArmour'] ?></td>
            </tr>
            <tr>
                <th>Heal Spell power:</th>
                <td><?php echo $params['enemyHeal'] ?></td>
            </tr>
            <tr>
                <th>Dmg Spell power:</th>
                <td><?php echo $params['enemyDmg'] ?></td>
            </tr>
        </table>

    </div>
</div>

</body>

<script type="text/javascript">
    document.getElementById("Attack").onclick = function() {sendParams(document.getElementById("Attack").value)};
    document.getElementById("Heal").onclick = function() {sendParams(document.getElementById("Heal").value)};
    document.getElementById("DmgSpell").onclick = function() {sendParams(document.getElementById("DmgSpell").value)};
    function sendParams(value) {
        $(document).ready(function() {
            var battleId = $(".battleId").val();
            $.ajax({
                type: "POST",
                url: "http://localhost/heroonline/public/index.php?target=battle&action=attack",
                dataType: "JSON",
                data: {Attack:value,battleId:battleId},
                success: function(result) {
                    var isBattleOver = result.round[result.round.length - 1].battleOver;
                    if (isBattleOver) {
                        alert("Battle is over!");
                        $('#Return').css('display','block');
                        $('.Moves').css('display','none');
                    } else {
                        for (var roundNumber in result['round']) {
                            var roundData = result['round'][roundNumber];
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
                }
            });
        })
    }
</script>

</html>