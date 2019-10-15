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

$max = ['maxime.vasseur.79@hotmail.fr', 100];
$juliette = ['MAXIME.Vasseur@akka.eu', 200];
$max2 = ['maxime.vasseur.79@hotmail.fr', 200];

$arrayTest = [$max, $juliette, $max2];

foreach($arrayTest as $test)
{
    

$subject = 'Mon premier email avec Swift Mailer';
$fromEmail = $test[0]; // $enquete->mail
$fromUser = $test[0]; // $enquete->fullname
$id = $test[1]; // enquete->id
$body = "<!DOCTYPE html>
<html>
<head>
	<title>Akkappiness</title>
</head>
<body>

<h1>Bonjour, $fromEmail $id</h1>
<p>Dans le cadre de notre campagne d’enquête de satisfaction, merci de nous donner votre niveau de satisfaction de votre mission actuelle.
En vous remerciant par avance</p>
  <div>
  <a href='http://www.example.com/index.html'>Homepage</a>

    <a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/1.php?id=$id' title='Bien'>Bien</a>
    <a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/2.php?id=$id' title='Moyen'>Moyen</a>
    <a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/3.php?id=$id' title='Mauvais'>Mauvais</i></a> 
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
    ->setContentType("text/html")
    ->setBody($body)
    


;

// Send the message
$result = $mailer->send($message);

echo "$fromEmail ok";
}