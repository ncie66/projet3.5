<?php 
require "php/functions.php";
$errors =[];

if(!array_key_exists('username', $_POST) || $_POST['username'] == ''){
    $errors['username'] = "Vous n'avez pas renseigné votre pseudo";
}

if(!array_key_exists('email', $_POST) || $_POST['email'] == '' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $errors['email'] = "Adresse mail non valide";
}

if(!array_key_exists('sujet', $_POST) || $_POST['sujet'] == ''){
    $errors['sujet'] = "Message vide";
}

session_start();

if(!empty($errors)){

    $_SESSION['errors'] = $errors;
    $_SESSION['inputs'] = $_POST;
    header('Location: contact.php');
}

else{
    
    // $_SESSION['success'] = 1;
    // $sujet = $_POST['sujet'];
    // $headers = 'FROM: support@myhobbie.fr';
    // sendMail('ym66300@gmail.com', 'Formulaire de contact', $sujet, $headers);
    // header('Location: contact.php');

    $mailStat = recevedMail( $_POST['email'] , "Formulaire de contact" , $_POST['sujet'] );
    if ($mailStat["statut"]) {
        $_SESSION['success'] = 1;
    } else {
        $_SESSION['success'] = 0;
    }
    header('Location: contact.php');
}
