<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/PHPMailer/src/Exception.php';
require '../assets/PHPMailer/src/PHPMailer.php';
require '../assets/PHPMailer/src/SMTP.php';
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


    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    
try {
    foreach ($enquetes as $enquete) {
        if(!empty($enquete->mail)){

    $toUser = $enquete->mail;
    $toUserName = $enquete->fullname;
    $id = $enquete->id;
    $mail->isSMTP();
    $mail->Host       = EMAIL_HOST;                        
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = EMAIL_USERNAME;        
    $mail->Password   = EMAIL_PASSWORD;                             
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
    $mail->Port       = EMAIL_PORT;                                    
    $mail->setFrom(EMAIL_USERNAME);
    $mail->addAddress($toUser);     
    $mail->isHTML(true);                                  
    $mail->Subject = 'AKKAPPINESS';
    $mail->SMTPSecure = 'tls';
    $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
        );
// OR use TLS

    $mail->Body    = "
    <h1>Bonjour $toUserName,</h1>
    <p>Dans le cadre de notre campagne d’enquête de satisfaction, merci de nous donner votre niveau de satisfaction de votre mission actuelle.
    En vous remerciant par avance</p>

    <a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/1.php?id=$id'><img src='https://zupimages.net/up/19/42/zk2l.png' alt='bien' width='80' height='80'/></a>
     <a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/2.php?id=$id'><img src='https://zupimages.net/up/19/42/ixon.png' alt='moyen' width='80' height='80'/></a>
     <a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/3.php?id=$id'><img src='https://zupimages.net/up/19/42/m6zb.png' alt='mauvais' width='80' height='80'/></a>
     ";
    
    $mail->send();
    $sql = "UPDATE enquete SET state = 0 WHERE id=:id";
         $statement = $connection->prepare($sql);
         $statement->execute([':id' => $id]);
         $enquete = $statement->fetch(PDO::FETCH_OBJ);
        }
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}