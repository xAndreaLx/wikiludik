<!DOCTYPE html>
<head>
    <meta charset=utf8 />
</head>
<?php session_start() ; 
include_once('bandeauConnex.php') ; 
?>


<?php
function connexion() {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=wikiludik;charset=utf8', 'xandrealx', '');

    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
    return $bdd; 
}


function afficheForm() {
    	echo  <<<_END
<form action="" method='POST' enctype="multipart/form-data">
	<input type="hidden" name="update" value="1"/>
	<label for="titre">Titre</label><br />
	<input type="text" name="titre" id="titre" placeholder="Ajoutez le titre" style="width:90%" required/><br />
	<label for="userfile">Image de la boîte</label><br/>
	<input type="file"name="userfile" /><br/>
	<label for="resume">La description</label><br/>
	<textarea name="resume" id="resume" style="width:90%" placeholder="Ajoutez la déscription" required></textarea><br />
	<input type="submit"/>
</form>
_END;
}

function appliqueModif() {
    
    $file = rand(1000,100000)."-".$_FILES['userfile']['name'];
    $file_loc = $_FILES['userfile']['tmp_name'];
    $file_size = $_FILES['userfile']['size'];
    $file_type = $_FILES['userfile']['type'];
    $folder="img/";
    
    
    echo $file_size ;
    move_uploaded_file($file_loc,$folder.$file);
    $bdd = connexion() ;

    $req = $bdd->prepare('INSERT INTO images(file,type,size) VALUES(?, ?, ?)');
    $req->execute(array($file,$file_type,$file_size)) ;
    $last_id_img = $bdd->lastInsertId() ;
    

    extract($_POST) ;
    $req = $bdd->prepare('INSERT INTO jeux (titre, resume, id_image) VALUES (?, ?, ?)') ;
    $req->execute(array(htmlentities($titre), htmlentities($resume), $last_id_img)) ;
    $last_id_jeu = $bdd->lastInsertId() ;
    $req = $bdd->prepare('UPDATE images SET id_jeu = ? WHERE id = ?');
    $req->execute(array($last_id_jeu, $last_id_img)) ;
}

if (!isset($_POST['update'])) {
    afficheForm() ;
} else {
    appliqueModif() ; 
    header ('Location: index.php') ;
} 

?>


<?php
/*
require_once('core/init.php');


if (!$user->isLoggedIn()) {
    Redirect::to('indexB.php') ;
}

if (Input::exists()) {
    if (!isset($_FILES['userfile'])) {
        echo "L'image est requise  <br/>" ;
    }
    $validate = new Validate() ;
    $validation = $validate->check($_POST, array(
        'titre' => array(
            'name' => 'Le titre',
            'required' => true,
            'min' => 2,
            'max' => 50
        ),
        'resume' => array(
            'name' => 'Le résumé',
            'required' => true,
            'min' => 10
        )
    ));
    if ($validation->passed() ) {

        $file = rand(1000,100000)."-".$_FILES['userfile']['name'];
        $file_loc = $_FILES['userfile']['tmp_name'];
        $file_size = $_FILES['userfile']['size'];
        $file_type = $_FILES['userfile']['type'];
        $folder="img/";
        
        move_uploaded_file($file_loc,$folder.$file);

        $req = $bdd->prepare('INSERT INTO images(file,type,size) VALUES(?, ?, ?)');
        $req->execute(array($file,$file_type,$file_size)) ;
        $last_id_img = $bdd->lastInsertId() ;
        
    
        extract($_POST) ;
        $req = $bdd->prepare('INSERT INTO jeux (titre, resume, id_image) VALUES (?, ?, ?)') ;
        $req->execute(array(htmlentities($titre), htmlentities($resume), $last_id_img)) ;
        $last_id_jeu = $bdd->lastInsertId() ;
        $req = $bdd->prepare('UPDATE images SET id_jeu = ? WHERE id = ?');
        $req->execute(array($last_id_jeu, $last_id_img)) ;
        
        try {
            $db->insert('jeux', array(
                'titre' => Input::get('titre'),
                'resume' => Input::get('resume')
            ));
            
            Session::flash('home', 'Your details have been updated.') ;
            Redirect::to('indexB.php') ;
        } catch (Exception $e) {
            die ($e->getMessage()) ;
        }
    } else {
        foreach ($validation->errors() as $error) {
            echo $error, '<br/>' ;
        }
    }


}


echo  <<<_END
<form action="" method='POST'>
	<label for="titre">Titre</label><br />
	<input type="text" name="titre" id="titre" placeholder="Ajoutez le titre" style="width:90%" required/><br />
	<label for="userfile">Image de la boîte</label><br/>
	<input type="file" name="userfile" /><br/>
	<label for="resume">La description</label><br/>
	<textarea name="resume" id="resume" style="width:90%" placeholder="Ajoutez la déscription" required></textarea><br />
	<input type="submit" />
</form>
_END;

*/
?>

<?php
/*
function connexion() {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=wikiludik;charset=utf8', 'xandrealx', '');

    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
    return $bdd; 
}


function afficheForm() {
    	echo  <<<_END
<form action="" method='POST' enctype="multipart/form-data">
	<input type="hidden" name="update" value="1"/>
	<label for="titre">Titre</label><br />
	<input type="text" name="titre" id="titre" placeholder="Ajoutez le titre" style="width:90%" required/><br />
	<label for="userfile">Image de la boîte</label><br/>
	<input type="file"name="userfile" /><br/>
	<label for="resume">La description</label><br/>
	<textarea name="resume" id="resume" style="width:90%" placeholder="Ajoutez la déscription" required></textarea><br />
	<input type="submit" />
</form>
_END;
}

function appliqueModif() {
    
    $file = rand(1000,100000)."-".$_FILES['userfile']['name'];
    $file_loc = $_FILES['userfile']['tmp_name'];
    $file_size = $_FILES['userfile']['size'];
    $file_type = $_FILES['userfile']['type'];
    $folder="img/";
    
    move_uploaded_file($file_loc,$folder.$file);
    $bdd = connexion() ;

    $req = $bdd->prepare('INSERT INTO images(file,type,size) VALUES(?, ?, ?)');
    $req->execute(array($file,$file_type,$file_size)) ;
    $last_id_img = $bdd->lastInsertId() ;
    

    extract($_POST) ;
    $req = $bdd->prepare('INSERT INTO jeux (titre, resume, id_image) VALUES (?, ?, ?)') ;
    $req->execute(array(htmlentities($titre), htmlentities($resume), $last_id_img)) ;
    $last_id_jeu = $bdd->lastInsertId() ;
    $req = $bdd->prepare('UPDATE images SET id_jeu = ? WHERE id = ?');
    $req->execute(array($last_id_jeu, $last_id_img)) ;
}

if (!isset($_POST['update'])) {
    afficheForm() ;
} else {
    appliqueModif() ; 
    header ('Location: index.php') ;
} 
*/
?>