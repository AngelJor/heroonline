<?php
// Autoload SDK package for composer based installations
require 'vendor/autoload.php';

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AY3pEJ98GsFoUzuLInwJzKmS3mMyFc0c3BZmoPe6_-XIsTDFRG9vUsrQm0ke9plkUqEf2gOQbm0tJnYA',
        'EKnEu0lMAjNYXYUeViXe_TcLR3Xn-6VWfK_IZIejP6E_RcqvL4eZV8Pg2AwQE-OLnsJwDVE5B-IM5abV'
    )
);
