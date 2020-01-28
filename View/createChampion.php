<!DOCTYPE html>
<html>
<head>
    <title>Create Champion</title>
    <link rel="stylesheet" type="text/css" href="<?=_SERVER_PATH?>View/Style/createChampion.css">
</head>
<body>

<form action="<?=_SERVER_PATH?>user/createChampion" method="post">
    <label for = "name">Champion Name: </label>
    <input type="text" placeholder="Enter Champion Name" name="name" value="">
    <button type="submit">Create</button>
</form>
</body>
</html>
