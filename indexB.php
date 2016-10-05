<?php

require_once('core/init.php');

if (Session::exists('home')) {
    echo '<p>' . Session::flash('home') . '</p>' ;
} 

$user = new User() ;

$db = new DB() ; 
$jeux = $db->query("SELECT * FROM jeux")->results() ;
Session::put('jeux', $jeux) ;

if ($db->count()) {
    echo "<h2>Liste des jeux en base de données:</h2><ul>" ;
    foreach ($jeux as $jeu) {
        echo "<li><a href='jeu.php?num=" . $jeu->id . "'>" .  $jeu->titre . "<a></li>";
    }
    echo "</ul>" ;
}

if ($user->isLoggedIn()) {
    
    if ($user->hasPermission('admin')) {
        echo "<p align=right style='margin-right:200px'><a href='ajoutJeu.php'>Ajouter une page</a></p>" ; 

    } 

} else {
    echo '<p>Vous devez vous <a href="loginOOP.php">connecter</a> ou vous <a href="register.php">inscrire</a></p>' ;
}




/*
$user = DB::getInstance()->update('users', 3, array(
    'password' => 'newpassword',
    'name' => 'Dale Barret'
)) ;

if ($user) {
    echo "ok" ;
} else {
    echo "pas ok"; 
}
*/
/*
$user = DB::getInstance()->get('users', array('username', '=', 'billy')) ;

if (!$user->count()) {
    echo 'No user';
} else {
    echo $user->first()->name ; 
}
*/

?>