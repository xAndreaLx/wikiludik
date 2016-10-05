<?php require_once('core/init.php') ; ?>

<!DOCTYPE html>
<head>
    <meta charset=utf8 />
    <style>
        img {
            float: left;
            margin: 15px;
        }
    </style>
</head>
<?php

/*function connexion() {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=wikiludik;charset=utf8', 'xandrealx', '');

    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur de connexion : '.$e->getMessage());
    }
    return $bdd; 
}

function affichePage() {
    $bdd = connexion() ;
    if (isset($_GET['num'])) {
        // je recupere d'abord ma ligne de jeu
        $req = $bdd->prepare('SELECT * FROM jeux WHERE id = ?');
        $req->execute(array($_GET['num']));
        $donnees = $req->fetch() ; 
        // puis j'utilise l'id_image de ce jeu pour récupérer son image
        $req = $bdd->prepare('SELECT * FROM images WHERE id = ?') ;
        $req->execute(array($donnees['id_image'])) ;
        $image = $req->fetch() ;
        

        echo "<img src='img/".$image['file']."' alt='image boite du jeu'/>" ;
        echo "<h1>" . $donnees['titre'] . "</h1>" ;
        echo "<p>" . $donnees['resume'] . "</p>" ;
        
        
        echo "<p align=right style='margin-right:200px'><a href='modifResume.php?num=" . $_GET['num'] ."'>Modifier la déscription</a></p>" ; 
    }
}*/

include_once("bandeauConnex.php") ;

if (Input::exists('get')) {
    $db = new DB() ;
    $user = new User() ;
    if ($jeu = $db->get('jeux', array('id', '=', Input::get('num')))->first()) {
        $image = $db->get('images', array('id_jeu', '=', Input::get('num')))->first() ;
        echo "<img src='img/" . $image->file . "' alt='image boite du jeu'/>" ; 
        echo "<h1>" . $jeu->titre . "</h1>" ;
        echo "<p>" . $jeu->resume . "</p>" ;
        $db1 = new DB() ;
        $notes = $db1->query("SELECT * FROM notesJeux WHERE id_jeu=" . $jeu->id)->results() ;
        
        if ($db1->count()) {
            echo "<h2>Liste des notes:</h2><ul>" ;
            
            foreach ($notes as $note) {
                echo "<li>" . $note->note . " par ";
                $user1 = new User() ;
                $user1->find($note->id_user) ;
                echo $user1->data()->username . "</li>";
            }
             echo "</ul>" ;
        } else {
            echo "ce jeu n'est pas encore noté" ; 
        }
        if ($user->hasPermission('admin')) {
            echo "<p align=right style='margin-right:200px'><a href='modifResume.php?num=" . Input::get('num') ."'>Modifier la déscription</a></p>" ; 
        }
    } else {
        Redirect::to('404') ;
    }
} else {
    Redirect::to('404') ;
}



?>