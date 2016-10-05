<style>
form {
        width: 400px;
        margin : auto;
        margin-top : 30px;
        border : 2px solid grey;
        padding: 20px;
        padding-bottom: 40px;
    }
    
    label {
        display : inline-block;
        width: 200px;
        margin-right: 30px;
        margin-bottom: 15px;
        
    }

    input[type=text], input[type=password] {
        -webkit-transition: all 0.30s ease-in-out;
        -moz-transition: all 0.30s ease-in-out;
        -ms-transition: all 0.30s ease-in-out;
        -o-transition: all 0.30s ease-in-out;
        border: 1px solid #DDDDDD;
    }
    
    input[type=text]:focus, input[type=password]:focus{
        box-shadow: 0 0 5px rgba(81, 203, 238, 1);
        border: 1px solid rgba(81, 203, 238, 1);
    }
    
    input[type=password].sec:focus {
        box-shadow: 0 0 5px red ;
        border: 1px solid red;
    }
    
    .changeButton {
        float: right;
    }
</style>

<?php
require_once('core/init.php');

$user = new User() ;

if (!$user->isLoggedIn()) {
    Redirect::to('indexB.php') ;
}

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate() ;
        $validation = $validate->check($_POST, array(
            'password_current' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password_new'
            )
        ));
        
        if ($validation->passed()) {
            //change of password
            if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
                echo 'Le mot de passe actuel est erroné.' ;
            } else {
                $salt = Hash::salt(32) ;
                $user->update(array(
                    'password' => Hash::make(Input::get('password_new'), $salt),
                    'salt' => $salt
                ));
                
                Session::flash('home', 'Votre mot de passe a bien été changé.') ;
                Redirect::to('indexB.php') ;
            }
            
        } else {
            foreach($validation->errors() as $error) {
                echo $error . "<br/>";
            }
        }
    }
}

?>

<form action="" method="post">
    <div class="field">
        <label for="password_current">Mot de passe actuel :</label>
        <input type="password" name="password_current" id="password_current">
    </div>
    
    <div class="field">
        <label for="password_new">Nouveau mot de passe :</label>
        <input type="password" name="password_new" id="password_new" class="sec" onkeyup="secure(this.value);">
    </div>
    
    <div class="field">
        <label for="password_new_again">Nouveau mot de passe :</label>
        <input type="password" name="password_new_again" id="password_new_again">
    </div>
    
    <input type="submit" class="changeButton" value="Modifier">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"> 
    
</form>

<script type="text/javascript">
function secure(texte)
{
    var length= texte.length;
    var ele = document.getElementsByClassName("sec")[0];
    if (length >= 6 && length <= 8) {
        ele.style.boxShadow= "0 0 5px orange" ;
        ele.style.borderColor= "orange" ;
    } else if (length > 8) {
        ele.style.boxShadow= "0 0 5px rgba(81, 203, 238, 1)" ;
        ele.style.borderColor= "rgba(81, 203, 238, 1)" ;
    }
}
</script>