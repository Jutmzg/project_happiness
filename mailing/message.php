<?php
require '../db/db.php';
require 'content.php';

mail($to, $subject, $message, $headers);

$from = $from;

$subject = $subject;

$headers = "From: " . strip_tags($_POST['req-email']) . "\r\n";
$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
$headers .= "CC: susan@example.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = $message;

// Sending mail
if(mail($to, $subject, $message, $headers)){
    echo 'Le mail a bien été envoyé !';
} else{
    echo 'Impossible d\'envoyer le mail. Veuillez réessayer.';
}