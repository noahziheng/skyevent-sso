<?php
// load the Composer autoload file, which automatically
// loads all the classes required for use by VatsimSSO.
require 'vendor/autoload.php';
require 'config.php';

session_start();
date_default_timezone_set('PRC');

use Vatsim\OAuth\SSO;

//$redis = new Redis();
//$redis->connect('redis', 6379);

$sso = new SSO($base, $key, $secret, $method, $cert);
// Outside Laravel
$session = $_SESSION['vatsimauth'];
$sso->validate(
    $session['key'],
    $session['secret'],
    $_GET['oauth_verifier'],
    function($user, $request) {
      unset($_SESSION['vatsimauth']);
      //$redis->set("user-".$user->id, json_encode($user));
      try {
          header('Location: ' . $_SESSION['callback'] . $user->id;
          die();
        } catch (CloudException $ex) {
          die($ex);
        }
    }
);