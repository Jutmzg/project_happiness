<?php
require '../vendor/autoload.php';
require '../config.php'; 

//requete qui récupère toutes les enquetes, leur id et l'adresse mail du consultant

/*  $sql = "SELECT e.id CONCAT(c.firstname,' ', c.lastname) as fullname, c.mail, m.name as mission, CONCAT(mana.firstname,' ', mana.lastname) as manager, e.state FROM enquete e
LEFT JOIN mission m 
ON m.id = e.mission_id
LEFT JOIN consultant c
ON c.id = m.consultant_id
LEFT JOIN manager mana
ON e.mission_id = mana.id 
WHERE e.state = 1";
$statement = $connection->prepare($sql);
$statement->execute();
$enquetes = $statement->fetchAll(PDO::FETCH_OBJ); 

foreach($enquetes as $enquete){

    
} */

$max = ['zertouflex@gmail.com', 100];
$juliette = ['jul.bousseau@gmail.com', 200];

$arrayTest = [$max, $juliette];


foreach($arrayTest as $test)
{
    
$subject = 'Mon premier email avec Swift Mailer';
$fromEmail = $test[0]; // $enquete->mail
$fromUser = 'Toto';
$id = $test[1]; // $enquete->id
$body = "<!DOCTYPE html>
<html>
<head>
	<title>Akkappiness</title>
</head>
<body>

<h1>Bonjour,</h1>
<p>Dans le cadre de notre campagne d’enquête de satisfaction, merci de nous donner votre niveau de satisfaction de votre mission actuelle.
En vous remerciant par avance</p>
  <div>
    <a href='1.php?id=$id' title='Bien'><i class='far fa-smile fa-5x'></i></a>
    <a href='2.php?id=$id' title='Moyen'><i class='far fa-meh fa-5x'></i></a>
    <a href='3.php?id=$id' title='Mauvais'><i class='far fa-frown fa-5x'></i></a> 
  </div>
</div>
</body>
</html>";


$transport = (new Swift_SmtpTransport(EMAIL_HOST, EMAIL_PORT))
    ->setUsername(EMAIL_USERNAME)
    ->setPassword(EMAIL_PASSWORD)
    ->setEncryption(EMAIL_ENCRYPTION) //For Gmail
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message($subject))
    ->setFrom([$fromEmail => $fromUser])
    ->setTo([EMAIL_USERNAME])
    ->setBody($body)
;

// Send the message
$result = $mailer->send($message);
}