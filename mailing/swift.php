<?php
require '../assets/swiftmailer/vendor/autoload.php';
require '../config.php';
require '../layout/header.php';

$sql = "SELECT e.id, CONCAT(c.firstname,' ', c.lastname) as fullname, c.mail, m.name as mission, CONCAT(mana.firstname,' ', mana.lastname) as manager, e.state FROM enquete e
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

echo 'Envoi de mail pour chaque enquête';
foreach ($enquetes as $enquete) {

    $subject = 'Mon premier email avec Swift Mailer';
    $fromEmail = $enquete->mail; // $enquete->mail
    $fromUser = $enquete->fullname; // $enquete->fullname
    $id = $enquete->id; // $enquete->id
    $body = "<!DOCTYPE html>
<html>
<head>
	<title>Akkappiness</title>
</head>
<body>

<h1>Bonjour $fromUser,</h1>
<p>Dans le cadre de notre campagne d’enquête de satisfaction, merci de nous donner votre niveau de satisfaction de votre mission actuelle.
En vous remerciant par avance</p>
  <div>
  
<a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/1.php?id=$id'><img src='https://zupimages.net/up/19/42/zk2l.png' alt='bien' width='80' height='80'/></a>
<a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/2.php?id=$id'><img src='https://zupimages.net/up/19/42/ixon.png' alt='moyen' width='80' height='80'/></a>
<a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/3.php?id=$id'><img src='https://zupimages.net/up/19/42/m6zb.png' alt='mauvais' width='80' height='80'/></a>

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
        ->setBody($body);

    // Send the message
    $result = $mailer->send($message);

}
