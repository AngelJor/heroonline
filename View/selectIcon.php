<!DOCTYPE html>
<html>
<head>
    <title>Choose Icon</title>
</head>
<body>

<form action="<?=_SERVER_PATH?>user/selectIcon" method="post">
    <h1>Choose your Champion Icon</h1>
    <?php
    foreach ($params['icons'] as $key => $value) {
        echo '
            <image src="'.$value["path"].'" alt="Choose Icon">
            <input type="radio" name="icon" value="'.$value["icon_id"].'"/>
        ';
    }
    ?>
    <br>
    <button type="submit">Select</button>
</form>
</body>
</html>
