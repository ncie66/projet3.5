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

        //config
        // $mail->isSMTP();
        // $mail->Host = "smtp.gmail.com";
        // $mail->Port = 25;

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
       // mail( $email, $subject, $content );
        return [
            "statut" => false,
            "error" => $e
        ];
    }
}

function reconnect_cookie(){

    if(session_status() == PHP_SESSION_NONE ){

        session_start();
    }

    if(isset($_COOKIE['remember']) && !isset($_SESSION['auth']) ){

        require_once 'database.php';

        if(!isset($pdo)){
            global $pdo;
        }

        $remember_token = $_COOKIE['remember'];
        $parts = explode('==', $remember_token);

        $user_id = $parts[0];

        $req = $pdo->prepare('SELECT * FROM user WHERE id = ?');

        $req->execute([$user_id]);

        $user= $req->fetch();

        if($user){
            $expected = $user->id .'//'.$user->remember_token . sha1($user->id . 'projetncie');
            
            if($expected == $remember_token){
                
                $_SESSION['auth'] = $user;

                setcookie('remember', $remember_token, time(), 60 * 60 * 24 * 7);

            }else{
                setcookie('remember', null, -1);
            }

        } else{
            setcookie('remember', null, -1);

        }
    };

}