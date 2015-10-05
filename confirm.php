<?php
// load the Composer autoload file, which automatically
// loads all the classes required for use by VatsimSSO.
require 'vendor/autoload.php';
require 'config.php';

use Vatsim\OAuth\SSO;
$sso = new SSO($base, $key, $secret, $method, $cert);
// Outside Laravel
$session = $_SESSION['vatsimauth'];

$sso->validate(
    $session['key'],
    $session['secret'],
    $_GET['oauth_verifier'],
    function($user, $request) {
        // At this point we can remove the session data.
        unset($_SESSION['vatsimauth']);

        // do something to log the user in on your site using the user id
        var_dump($user);

        // Redirect home
        //header('Location: /');
        //die();
    }
);