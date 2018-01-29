<?php
require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

function debug($variable){

    echo '<pre>' . print_r($variable, true) . '</pre>';
}

function str_random($length){

    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function logged_only(){
    
    if(!isset($_SESSION['auth'])){

        $_SESSION['flash']['danger'] =" Access refusé";
        header('Location: login.php');
        exit();
    }
}

function sendMail( $email, $subject, $content ){
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {

        //Recipients
        $mail->setFrom('ym66300@gmail.com', 'Yohann');
        $mail->addAddress( $email, 'Client');     // Add a recipiente

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = "<div>" . $content . "</div>";
        $mail->AltBody = $content;

        $mail->send();
        return [
            "statut" => true
        ];
    } catch (Exception $e) {
        return [
            "statut" => false,
            "error" => $e
        ];
    }
}