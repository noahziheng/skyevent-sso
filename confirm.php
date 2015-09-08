<?php
// load the Composer autoload file, which automatically
// loads all the classes required for use by VatsimSSO.
require 'vendor/autoload.php';
require 'config.php';

use Vatsim\OAuth\SSO;
$sso = new SSO($base, $key, $secret, $method, $cert);
// Outside Laravel
$sso->validate(
    $_POST['key'],
    $_POST['secret'],
    $_POST['oauth_verifier'],
    function($user, $request) {
        // At this point we can remove the session data.
        //unset($_SESSION['vatsimauth']);
        //die();
        echo json_encode($user);
    }
);