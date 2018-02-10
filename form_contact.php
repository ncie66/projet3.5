<?php 

var_dump('hello');
die();
$errors =[];

if(!array_key_exist('username', $_POST) || $_POST['username'] == ''){
    $errors['username'] = "Vous n'avez pas renseigné votre pseudo";
}

if(!array_key_exist('email', $_POST) || $_POST['email'] == ''){
    $errors['email'] = "Vous n'avez pas renseigné votre adresse mail";
}


if(!array_key_exist('sujet', $_POST) || $_POST['sujet'] == ''){
    $errors['sujet'] = "Message vide";
}

if(!empty($errors)){
    session_start();
    $_SESSION
    header('Location: index.php');
}   
else{
    $sujet = $_POST['sujet'];
    $headers = 'FROM: test@gmail.com';
    
    sendMail($_POST['email'], 'Confirmation de votre compte');
    sendMail('support@myhobbie.fr', 'Formulaire de contact', $sujet, $headers);
}

