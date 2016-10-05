<?php
session_start() ; 

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1', //équivaut à localhost, mais économise le temps du DNS
        'username' => 'xandrealx',
        'password' => '',
        'db' => 'wikiludik'
    ) ,
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);

spl_autoload_register(function($class) {
    require_once('classes/' . $class . '.php') ;
}) ;

//lorsque l'on fera $db = new DB() ; $class = DB

require_once('functions/sanitize.php') ;
require_once('bandeauConnex.php') ;

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name')) ;
    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash)) ;
    
    if ($hashCheck->count()) {
        $user = new User($hashCheck->first()->user_id) ;
        $user->login() ;
    }
}