<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>

<form action="<?=_SERVER_PATH?>champion/addSpell" method="post">
    <?php
        echo 'Select your heal spell <br>';
        foreach ($params['healSpell'] as $allSpellsKey => $allSpells) {
            foreach ($allSpells as $key => $value) {
                echo ' <input type="radio" name="healthSpellId"  value=" ' . $value['spell_id'] . ' ">' . $value['name'] . ' has ' . $value['power'] . ' power. <br>';
            }
        }
        echo 'Select your dmg spell <br>';
        foreach ($params['dmgSpell'] as $allSpellsKey => $allSpells) {
            foreach ($allSpells as $key => $value) {
                echo ' <input type="radio" name="dmgSpellId"  value=" ' . $value['spell_id'] . ' ">' . $value['name'] . ' has ' . $value['power'] . ' power. <br>';
            }
        }
    ?>
    <input type="submit" name= "Select" value= "Select"/>
</form>
</body>
</html>
