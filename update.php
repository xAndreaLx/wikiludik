<?php
require_once('core/init.php') ;

// $user = new User() ;

if (!$user->isLoggedIn()) {
    Redirect::to('indexB.php') ;
}

if (Input::exists()) {
    $validate = new Validate() ;
    $validation = $validate->check($_POST, array(
        'name' => array(
            'required' => true,
            'min' => 2,
            'max' => 50
        )        
    ));
    
    if ($validation->passed()) {
        try {
            $user->update(array(
                'name' => Input::get('name')
            ));
            
            Session::flash('home', 'Les informations ont bien été mise à jour.') ;
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

<form action="" method="post" >
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo escape($user->data()->name); ?>"/>
        
        <input type="submit" value="Update"/>
    </div>
    
</form>