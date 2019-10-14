<?php

/*$to = 'jul.bousseau@gmail.com';
$subject = 'test';
$from = 'jul.bousseau@gmail.com';
$headers = "";
$headers = "From: " . strip_tags($_POST['req-email']) . "\r\n";
$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
$headers .= "From: jul.bousseau@gmail.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = 'testez';*/

// Sending mail
if(mail('jul.bousseau@gmail.com', 'test mail', 'test')){
    echo 'Le mail a bien été envoyé !';
} else{
    echo 'Impossible d\'envoyer le mail. Veuillez réessayer.';
}