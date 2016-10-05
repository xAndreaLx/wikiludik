<?php
require_once('core/init.php') ;

if (Input::exists()) {
    $validate = new Validate() ;
    $validation = $validate->check($_POST, array(
        'username' => array(
            'name' => 'Le pseudo',
            'required' => true,
            'min' => 2,
            'max' => 20,
            'unique' => 'users'
        ),
        'password' => array(
            'name' => 'Le mot de passe',
            'required' => true,
            'min' => 6,
        ),
        'password_again' => array(
            'name' => 'Le mot de passe (bis)',
            'matchesName' => 'mot de passe',
            'required' => true,
            'matches' => 'password'
        ),
        'name' => array(
            'name' => 'Le nom',
            'required' => true,
            'min' => 2,
            'max' => 50
        ) 
    ));
    
   if ($validation->passed()) {
        $user = new User() ;
        
        $salt = Hash::salt(32);
        try {
            $user->create(array(
                'username' => Input::get('username'),
                'password' => Hash::make(Input::get('password'), $salt),
                'salt'     => $salt,
                'name'     => Input::get('name'),
                'joined'   => date('Y-m-d H:i:s'),
                'group'    => 1
            ));
            
            Session::flash('home', 'Vous avez été correctement enregistré. Vous pouvez dès à présent vous connercter.') ;
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
?>

<style>
    form {
        width: 370px;
        margin : auto;
        margin-top : 30px;
        border : 2px solid grey;
        padding: 20px;
        padding-bottom: 40px;
    }
    
    label {
        display : inline-block;
        width: 170px;
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



    .registerButton {
        float: right;
    }

    
</style>

<?php require_once("bandeauConnex.php") ; ?>

<form action="" method="POST">
    <div class="field">
        <label for="username">Pseudo :</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'));?>" autocomplete="off">
    </div>
    
    <div class="field">
        <label for="password" >Mot de Passe :</label>
        <input type="password" name="password" id="password" class="sec" onkeyup="secure(this.value);">
    </div>
    
    <div class="field">
        <label for="password_again">Mot de Passe (bis) :</label>
        <input type="password" name="password_again" id="password_again">
    </div>
    
    <div class="field">
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" value="<?php echo escape(Input::get('name'));?>">
    </div>
    
    <input type="submit" class="registerButton" value="register">
</form>

<script type="text/javascript">
function secure(texte)
{
    var length= texte.length;
    var ele = document.getElementsByClassName("sec")[0];
    ele.style.boxShadow= "0 0 5px rgba(255, 0, 0, 1)" ;
    if (length >= 6 && length <= 8) {
        ele.style.boxShadow= "0 0 5px orange" ;
        ele.style.borderColor= "orange" ;
    } else if (length > 8) {
        ele.style.boxShadow= "0 0 5px rgba(81, 203, 238, 1)" ;
        ele.style.borderColor= "rgba(81, 203, 238, 1)" ;
    }
}
</script>