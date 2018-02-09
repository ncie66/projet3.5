<?php 
$errors =[];

if(!array_key_exist('username', $_POST) || $_POST['username'] == ''){
    $errors['username'] = "Vous n'avez pas renseigné votre pseudo";
}

if(!array_key_exist('probleme', $_POST) || $_POST['probleme'] == ''){
    $errors['probleme'] = "Vous n'avez pas renseigné votre problème";
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

    mail('ym66300@gmail.com', 'Formulaire de contact', $sujet, $headers);
}

var_dump($errors):
die();


