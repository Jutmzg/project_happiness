<?php
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

foreach ($enquetes as $enquete) {
    if(!empty($enquete->mail)){

     $to      = $enquete->mail;
     $toUser = $enquete->fullname;
     $id = $enquete->id;
     $subject = 'AKKAPPINESS';

     $message = "Bonjour $toUser,";
     $message .= '<p>'.MESSAGE.'</p>';
     $message .= "<a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/1.php?id=$id'><img src='https://zupimages.net/up/19/42/zk2l.png' alt='bien' width='80' height='80'/></a>
     <a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/2.php?id=$id'><img src='https://zupimages.net/up/19/42/ixon.png' alt='moyen' width='80' height='80'/></a>
     <a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/3.php?id=$id'><img src='https://zupimages.net/up/19/42/m6zb.png' alt='mauvais' width='80' height='80'/></a>
     ";





     $headers = "From: EMAIL_USERNAME" . "\r\n" .
     "Reply-To: EMAIL_USERNAME" . "\r\n" ;
     $headers = 'MIME-Version: 1.0' . "\r\n" .
           'Content-type: text/html; charset=utf-8' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

     if(mail($to, $subject, $message, $headers));{
         $sql = "UPDATE enquete SET state = 0 WHERE id=:id";
         $statement = $connection->prepare($sql);
         $statement->execute([':id' => $id]);
         $enquete = $statement->fetch(PDO::FETCH_OBJ);
     }
    }
}
 ?>

