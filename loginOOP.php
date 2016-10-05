<style>
    form {
        width : 320px ;
        margin: auto ;
        margin-top: 30px;
        border : 2px solid grey;
        padding : 20px;
        padding-bottom : 35px;
    }
    
    label:not(.remember) {
        display: inline-block ;
        width : 130px;
        margin-right: 15px ;
        margin-bottom: 15px;
    }
    
    input[type=text], input[type=password] {
        -webkit-transition: all 0.30s ease-in-out;
        -moz-transition: all 0.30s ease-in-out;
        -ms-transition: all 0.30s ease-in-out;
        -o-transition: all 0.30s ease-in-out;
        border: 1px solid #DDDDDD;
    }
    
    input[type=text]:focus, input[type=password]:focus {
        box-shadow: 0 0 5px rgba(81, 203, 238, 1);
        border: 1px solid rgba(81, 203, 238, 1);
    }
    
    

    .subButton {
        float: right;
    }

    

    
</style>

<?php
require_once('core/init.php');

if (Input::exists()) {
    $validate = new Validate() ;
    $validation = $validate->check($_POST, array(
        'username' => array('required' => true),
        'password' => array('required' => true)
    )) ;
    
    if ($validation->passed()) {
        $user = new User() ;
        
        $remember = (Input::get('remember') === on) ? true : false ;
        
        $login = $user->login(Input::get('username'), Input::get('password'), $remember);
        
        if ($login) {
            Session::flash('home', 'Connexion réussie. Bienvenue ' . escape($user->data()->username) . " ! " ) ;
            Redirect::to('indexB.php') ;
        } else {
            echo '<p>Désolé, la connexion a échoué</p>' ;
        }
        
    } else {
        foreach ($validation->errors() as $error) {
            echo $error . '<br/>' ;
        }
    }
}
?>



<form action="" method="post">
    <div class="field">
        <label for="username">Pseudo :</label>
        <input type="text" name="username" id="username" autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" autocomplete="off">
    </div>
    
    <div class="field">
        <label for="remember" class="remember">
            Se souvenir <input type="checkbox" name="remember" id="remember">
        </label>
    </div>

        <input type="submit" class="subButton" value="login">
</form>