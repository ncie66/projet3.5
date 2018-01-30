<?php
require "php/functions.php";

session_start();

if(!empty($_POST) && !empty($_POST['email'])){

    require_once 'php/database.php';
    require_once 'php/functions.php';

    $req = $pdo->prepare('SELECT * FROM user WHERE email = ? AND confirmed_date is NOT NULL');
    $req->execute([$_POST['email']]);

    $user = $req->fetch();
    
    if($user){
        $reset_password_token	 = str_random(50);

        $pdo->prepare('UPDATE user SET reset_password_token = ?, reset_token_date = NOW() WHERE id= ?')->execute([$reset_password_token, $user->id]);

        $_SESSION['flash']['success'] = "Le rappel de mot de passe vous a bien été envoyé par mail ";

        sendMail($_POST["email"], 'Réinitialisation du mot de passe', "Afin de réinitialisation votre mot de passe, merci de cliquer sur ce lien\n\nhttp://localhost:8888/Projet/reset.php?id={$user->id}&token={$reset_password_token}");

        header('Location: login.php');

        exit();

    }else {
        $_SESSION['flash']['danger'] = "Adresse email inexistante ou incorrect ";
    }
    
}
    require 'php/header.php';
?>


<h1> Mot de passe oublié </h1> 
    
<form class="" id="" action="" method="POST">
    
    <div class="form-group">
        <label> Adresse email  </label>
            <input type="mail" name="email" size="30"/> <br><br>
    </div>

    <button type="submit" class="btn btn-dark">Continuer</button>
    
</form>

<?php require 'php/footer.php'; ?> 

</body>
</html>