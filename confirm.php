<?php 

$user_id = $_GET['id'];

$token = $_GET['token'];

require 'php/database.php';

$req = $pdo->prepare('SELECT * FROM user WHERE id = ?');

$req->execute([$user_id]);

$user = $req->fetch();

session_start();

if($user && $user->confirmed_token == $token ){


    $pdo->prepare('UPDATE user SET confirmed_token = NULL, confirmed_date = NOW() WHERE id = ?')->execute([$user_id]);

    $_SESSION['flash']['success'] = "Votre compte a bien été valider";

    $_SESSION['auth'] = $user;

    header('Location: profil.php');

    echo('Votre compte a bien été validé');
} 

else{

    $_SESSION['flash']['danger'] = "Cette confirmation n'est plus valide ou a déjà été validé";

    header("Location: login.php");
}
