<?php 

session_start(); 

require 'php/functions.php';
require 'php/database.php';

reconnect_cookie();
logged_only();

if(!empty($_POST)){

    if(empty($_POST['password']) || $_POST['password'] != $_POST['confirm_password']){
        $_SESSION['flash']['danger'] = "Les mots de passes ne sont pas identiques";
    }
    else{
        $user_id = $_SESSION['auth']->id;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        require_once 'php/database.php';

        $pdo->prepare('UPDATE user SET password = ? WHERE id = ?')->execute([$password, $user_id]);
        $_SESSION['flash']['success'] = "Mot de passe changé avec success";
    }
}

require 'php/header.php'; 

?> 

<h1><center> Salut <?= $_SESSION['auth']->username; ?>  </center></h1> 

<form action="" method="POST">

    <h2>Modififaction du mot de passe</h2>
    <div class="form-profil">
        <input class="form-control" type="password" name="password" placeholder="Nouveau mot de passe">
    </div><br>
    <div class="form-profil">
        <input class="form-control" type="password" name="confirm_password" placeholder="Confirmation nouveau de mot de passe">
    </div><br>
    <button type="submit" class="btn btn-dark">Confirmer</button>

</form><br>

<div> <a href="profil.php">  Retourner au profil </div>

<?php require 'php/footer.php'; ?> 