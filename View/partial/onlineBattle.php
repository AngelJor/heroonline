
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
