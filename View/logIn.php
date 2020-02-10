<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../View/Style/login.css">
    <script type="text/javascript" src="/vendor/facebook/graph-sdk/src/Facebook/autoload.php"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
</head>
<body>
<script>

    function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
        console.log('statusChangeCallback');
        console.log(response);                   // The current login status of the person.
        if (response.status === 'connected') {   // Logged into your webpage and Facebook.
            testAPI();
        }
    }


    function checkLoginState() {               // Called when a person is finished with the Login Button.
        FB.getLoginStatus(function(response) {   // See the onlogin handler
            statusChangeCallback(response);
        });
    }


    window.fbAsyncInit = function() {
        FB.init({
            appId      : '2373604422952041',
            cookie     : true,                     // Enable cookies to allow the server to access the session.
            xfbml      : true,                     // Parse social plugins on this webpage.
            version    : 'v5.0'           // Use this Graph API version for this call.
        });


        FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
            statusChangeCallback(response);        // Returns the login status.
        });
    };


    (function(d, s, id) {                      // Load the SDK asynchronously
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
        FB.api('/me', function(response) {
            sendInfo(response);
        });
    }
    function sendInfo(data) {
        $(document).ready(function () {
            $.ajax({
                type: "POST",
                url: "http://localhost/heroonline/public/index.php?target=user&action=loginWithFacebook",
                dataType: "JSON",
                data: {facebookId:data['id'],isFacebookUser:1}
            });
            window.location.replace("http://localhost/heroonline/public/index.php?target=user&action=renderSelectChampion");
        })
    }

</script>

<form action="../public/index.php?target=user&action=login" method="post">
    <div class="container">
        <h1>Log In</h1>
        <label for = "username">Enter your username:</label>
        <input type="text" placeholder="Enter Username" name="username" value="" required>


        <label for = "password">Enter your password:</label>
        <input type="password" placeholder="Enter Username" name="password" value="" required>

        <button type="submit">Login</button>
        <p>Or Login with facebook.</p>
        <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
        </fb:login-button>
        <div id="status">
        </div>
    </div>
</form>
</body>
</html>
