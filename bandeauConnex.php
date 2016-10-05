<?php require_once('core/init.php') ;?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
</head>

<style>
    #bandeau {
        border-bottom: solid black 2px ;
        padding: 5px;
        margin-bottom: 10px;

    }
    
    #bandeau h2 {
        display: inline ;
        font-family: Arial;
    } 
    #bandeau span {
        float: right;
    }
    
    #bandeau h2 a {
        text-decoration: none;
        color: black;
    }

    
</style>


<div id='bandeau'>
<h2><a href='indexB.php'>WIKILUDIK</a></h2>
<?php

$user = new User() ; 

if ($user->isLoggedIn()) {
    $username = escape($user->data()->username) ;
    echo "<span><a href=\"profile.php?user=" . $username . "\">" . $username . "</a> | <a href='logoutOOP.php'>Déconnexion</a></span>" ; 
   // echo "<span>" . $user->data()->username . " | <a href='logoutOOP.php'>Déconnexion</a></span>" ;
} else {
    echo "<span><a href='loginOOP.php'>Se connecter</a> | <a href='register.php'>S'inscrire</a></span>" ;
}
    /*if (isset($_SESSION['pseudo'])) {
        echo "<span>" . $_SESSION['pseudo'] . " | <a href='logoutOOP.php'>Déconnexion</a></span>" ;
    } else {
        echo "<span><a href='loginOOP.php'>Se connecter</a> | <a href='register.php'>S'inscrire</a></span>" ;
    }*/
?>
</div>