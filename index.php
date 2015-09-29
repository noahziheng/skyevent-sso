<?php
// load the Composer autoload file, which automatically
// loads all the classes required for use by VatsimSSO.
require 'vendor/autoload.php';
require 'config.php';

use Vatsim\OAuth\SSO;
$sso = new SSO($base, $key, $secret, $method, $cert);
// Outside Laravel
$sso->login(
    $return,
    function($key, $secret, $url) {
    	echo json_encode(array($key,$secret,$url));
    }
);