<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>

<form action="<?=_SERVER_PATH?>user/selectAvatar" method="post">
    <h1>Choose your Champion Icon</h1>
    <?php
    foreach ($params['avatars'] as $key => $value) {
        echo '
            <image src="'.$value["path"].'" alt="Choose Icon" width=250px height=325px>
            <input type="radio" name="avatar" value="'.$value["avatar_id"].'"/>
        ';
    }
    ?>
    <br>
    <button type="submit">Select</button>
</form>
</body>
</html>
