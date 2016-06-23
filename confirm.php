<?php
// load the Composer autoload file, which automatically
// loads all the classes required for use by VatsimSSO.
require 'vendor/autoload.php';
require 'config.php';

session_start();
date_default_timezone_set('PRC');

use Vatsim\OAuth\SSO;
use LeanCloud\LeanObject;
use LeanCloud\CloudException;

LeanCloud\LeanClient::initialize("wkXfBYA7ocAoxOUaaiU4eQQJ-gzGzoHsz", "19cTm44cXsNjBvRnSi0SAn2x", "HMGkULRJXfzXAzfxh8S06g3z");
LeanCloud\LeanClient::useRegion("CN");
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
        $obj = new LeanObject("user");
        $query = $obj->getQuery();
        $query->equalTo('pid',$user->id);
        $result = $query->find();
        if (!$result) {
          $obj->set('pid', $user->id);
        }else{
          $obj = $result[0];
        }
        $obj->set('lastname', $user->name_last);
        $obj->set('firstname' , $user->name_first);
        $obj->set('usergroup' , 0);
        $obj->set("rating", array('short' => $user->rating->short,'long' => $user->rating->long));
        $obj->set('division' , $user->division->code);
        $obj->set('logintoken' , md5(microtime(true)));
        try {
          $obj->save();
          header('Location: http://www.skyevent.tk/#!/userauth/' . $obj->get('logintoken'));
          die();
        } catch (CloudException $ex) {
          die($ex);
        }
    }
);