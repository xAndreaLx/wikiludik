<?php require_once('core/init.php') ; ?>

<!DOCTYPE html>
<head>
    <meta charset=utf8 />
    <script src="wysiwyg/wysiwyg.js"></script>

</head>


<?php
$db = new DB() ;
$jeu = $db->get('jeux', array('id', '=', Input::get('num')))->first() ;
?>




<form action="" method='POST'>
	<input type="hidden" name="update" value="1"/>
	<input type="hidden" name="id" value="<?php echo $jeu->id ; ?>" />
	<h2><?php echo $jeu->titre ; ?></h2>
	<label for="resume">Le résumé : </label><br/>
	<textarea name="resume" id="resume" rows='6' style="width:90%" required><?php echo $jeu->resume ; ?></textarea><br />
	<label for="note">Note (entre 1 et 10):</label>
	<input type="text" name="note" id="note" />
	<input type="submit"/>

</form>   


<?php
if (isset($_POST["update"])) {
    if (Input::exists()) {
        try {
            $db->update("jeux", Input::get(num), array(
                'resume' => Input::get('resume'),
            ));
            $db->insert("notesJeux", array(
                'id_jeu' => Input::get(num),
                'id_user' => $user->data()->id,
                'note' => Input::get('note') 
            ));
            Session::flash('jeu', 'Le résumé a bien été modifié.') ;
            Redirect::to('jeu.php?num=' . Input::get('num')) ;
        } catch (Exception $e) {
            die ($e->getMessage()) ;
        }
    }
}
    
    
    
    
    
      


?>



<?php /*
function connexion() {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=wikiludik;charset=utf8', 'xandrealx', '');

    } catch(Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
    }
    return $bdd; 
}

function recupDonnees() {
    if (isset($_GET['num'])) {
        $bdd=connexion() ;
        $req = $bdd->prepare('SELECT * FROM jeux WHERE id = ?');
        $req->execute(array($_GET['num']));
        $donnees = $req->fetch(PDO::FETCH_ASSOC) ; 
        return $donnees ;
    }
}

function afficheForm() {
    $donnees = recupDonnees() ;
    extract($donnees) ;
    
    echo <<<_END
<html>
<head>
<script src="wysiwyg/wysiwyg.js"></script>
</head>
<body onLoad="iFrameOn();">
<form action="" name="myform" id="myform" method="post">
<p>Entry Title: <input name="title" id="title" type="text" size="80" maxlength="80" /></p>
<p>Entry Body:<br>
<div id="wysiwyg_cp" style="padding:8px; width:700px;">
  <input type="button" onClick="iBold()" value="B"> 
  <input type="button" onClick="iUnderline()" value="U">
  <input type="button" onClick="iItalic()" value="I">
  <input type="button" onClick="iFontSize()" value="Text Size">
  <input type="button" onClick="iForeColor()" value="Text Color">
  <input type="button" onClick="iHorizontalRule()" value="HR">
  <input type="button" onClick="iUnorderedList()" value="UL">
  <input type="button" onClick="iOrderedList()" value="OL">
  <input type="button" onClick="iLink()" value="Link">
  <input type="button" onClick="iUnLink()" value="UnLink">
  <input type="button" onClick="iImage()" value="Image">
</div>
<!-- Hide(but keep)your normal textarea and place in the iFrame replacement for it -->
<textarea style="display:none;" name="myTextArea" id="myTextArea" cols="100" rows="14"></textarea>
<iframe name="richTextField" id="richTextField" style="border:#000000 1px solid; width:700px; height:300px;"></iframe>
<!-- End replacing your normal textarea -->
</p>
<br /><br /><input name="myBtn" type="button" value="Submit Data" onClick="javascript:submit_form();"/>
</form>   
_END;

    	echo  <<<_END
<form action="" method='POST'>
	<input type="hidden" name="update" value="1"/>
	<input type="hidden" name="id" value="{$id}" />
	<h2>{$titre}</h2>
	<label for="resume">Le résumé : </label><br/>
	<textarea name="resume" id="resume" rows='6' style="width:90%">{$resume}</textarea><br />
	<input type="submit"/>
</form> 
_END;
}

function appliqueModif() {
    extract($_POST) ;
    $bdd = connexion() ;
    $req = $bdd->prepare('UPDATE jeux SET resume = ? WHERE id = ?') ;
    $req->execute(array($resume, $id)) ;
}

if (!isset($_POST['update'])) {
    afficheForm() ;
} else {
    appliqueModif() ; 
    header ('Location: jeu.php?num='.$_POST['id']) ;
} */

?>