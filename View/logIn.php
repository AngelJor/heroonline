<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../View/Style/login.css">
</head>
<body>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '2373604422952041',
            cookie     : true,
            xfbml      : true,
            version    : 'v5.0'
        });

        FB.AppEvents.logPageView();

    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<form action="../public/index.php?target=user&action=login" method="post">
    <div class="container">
        <h1>Log In</h1>
        <label for = "username">Enter your username:</label>
        <input type="text" placeholder="Enter Username" name="username" value="" required>


        <label for = "password">Enter your password:</label>
        <input type="password" placeholder="Enter Username" name="password" value="" required>

        <button type="submit">Login</button>
    </div>
</form>
</body>
</html>
