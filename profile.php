<?php
require_once('core/init.php') ;

if (!$username = Input::get('user')) {
    Redirect::to('indexB.php') ;
} else {
    $user = new User($username) ;
    if (!$user->exists()) {
        Redirect::to(404) ;
    } else {
        $data = $user->data() ;
    }
?>
    <h3><?php echo escape($data->username); ?></h3>
    <p>Nom entier : <?php echo escape($data->name);?></p>
    
    <ul>
        <li><a href="update.php">Mettre à jour le profil</a></li>
        <li><a href="changepassword.php">Changer le mot de passe</a></li>
        <li><a href="giveRights.php">Gérer les droits des membres</a></li>

    </ul>

<?php
}
?>