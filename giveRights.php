<?php
require_once('core/init.php') ;

if (!$user->isLoggedIn()) {
    Redirect::to('indexB.php') ;
}



if (Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $giveRListe = Input::get('giveRight') ;
        $giveRListe = explode(',', $giveRListe) ;
        
        $userB = new user() ; 
        $db = new DB() ;
        foreach ($giveRListe as $userR) {
            if ($userB->find(trim($userR))) {
    //            $userB->update(array('group' => 1)) ; pose des soucis car la fonction update de DB rajoute des quotes
                $db->query("UPDATE `users` SET `group`= 2 WHERE id =" . $userB->data()->id) ;
            }

        }
        
        $deleteRListe = Input::get('deleteRight') ;
        $deleteRListe = explode(',', $deleteRListe) ;
        foreach ($deleteRListe as $userR) {
            if ($userB->find(trim($userR))) {
    //            $userB->update(array('group' => 1)) ; pose des soucis car la fonction update de DB rajoute des quotes
                $db->query("UPDATE `users` SET `group`= 1 WHERE id =" . $userB->data()->id) ;
            }

        }
    }
}

?>

<form action="" method="post">
    <div class="field">
        <label for="giveRight">Listes des pseudos à qui donner les droits d'administration (séparer par une virgule) :</label>
        <input type="text" name="giveRight" id="giveRight" autocomplete="off">
    </div>

    <div class="field">
        <label for="deleteRight">Listes des pseudos à qui supprimer les droits d'administration (séparer par une virgule) :</label>
        <input type="text" name="deleteRight" id="deleteRight" autocomplete="off">
    </div>
    


    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    
        <input type="submit" value="Envoyer">
</form>