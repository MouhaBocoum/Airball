<?php
//in this part of our code we will be sending verification emails to the new user of four website
//we will be sending those emails by using the swiftmailer library
require_once 'vendor/autoload.php';

// Create the Transport
//the transport is an email server that is responsible for forwarding and receiving emails
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465,'ssl'))
  ->setUsername('AirballAthletics@gmail.com')
  ->setPassword('azerty2020')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

function sendVerificationEmail($new_user_email,$token){
    //we call the mailer object inside our function so that we can use it in our function
    global $mailer;
    $body='<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verification Email</title>
    </head>
    <body>
        <div class="email">
            <p>Bonjour,<br>Merci d\'avoir créer un compte sur le site d\'Airball.<br>Afin de vérifier votre compte, veuillez cliquez sur le lien ci dessous.</p>
            <a href="http://localhost:8888/airball/basic_pages/index_airball.php?token=' .$token. '">
            Vérifier votre addresse mail
            </a>
        </div>
    </body>
    </html>';
    // Create a message
    $message = (new Swift_Message('Vérification de votre addresse mail'))
    ->setFrom(['AirballAthletics@gmail.com'])
    ->setTo($new_user_email)
    ->setBody($body,'text/html');
    // Send the message
    $result = $mailer->send($message);
}
function sendPasswordResetLink($userEmail,$token){
    //we call the mailer object inside our function so that we can use it in our function
    global $mailer;
    $body='<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Réinitialisation mot de passe</title>
    </head>
    <body>
        <div class="email">
            <p>Bonjour,<br>Veuillez cliquer sur le lien afin de réinitialiser votre mot de passe</p>
            <a href="http://localhost:8888/airball/basic_pages/index_airball.php?password-token=' .$token. '">
            Réinitialiser votre mot de passe 
            </a>
        </div>
    </body>
    </html>';
    // Create a message
    $message = (new Swift_Message('Réinitialistion mot de passe'))
    ->setFrom(['AirballAthletics@gmail.com'])
    ->setTo($userEmail)
    ->setBody($body,'text/html');
    // Send the message
    $result = $mailer->send($message);
}
function sendVerificationEmailGestio($new_user_email,$token){
    //we call the mailer object inside our function so that we can use it in our function
    global $mailer;
    $body='<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verification Email</title>
    </head>
    <body>
        <div class="email">
            <p>Bonjour,<br>Merci d\'avoir créer un compte sur le site d\'Airball.<br>Afin de vérifier votre compte, veuillez cliquez sur le lien ci dessous.</p>
            <a href="http://localhost:8888/airball/basic_pages/index_airball.php?tokenGestio=' .$token. '">
            Vérifier votre addresse mail
            </a>
        </div>
    </body>
    </html>';
    // Create a message
    $message = (new Swift_Message('Vérification de votre addresse mail'))
    ->setFrom(['AirballAthletics@gmail.com'])
    ->setTo($new_user_email)
    ->setBody($body,'text/html');
    // Send the message
    $result = $mailer->send($message);
}
?>