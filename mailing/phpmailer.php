
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




try {
    foreach ($enquetes as $enquete) {
        if (!empty($enquete->mail)) {

            $toUser = $enquete->mail;
            $toUserName = $enquete->fullname;
            $id = $enquete->id;
            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = false;
            $mail->Username   = EMAIL_USERNAME;
            // $mail->Password   = EMAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = EMAIL_PORT;
            $mail->setFrom("NoReply@akka.eu");
            $mail->addAddress($toUser);
            $mail->isHTML(true);
            $mail->Subject = 'Enquete de satisfaction';
            $mail->SMTPSecure = 'tls';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $message = MESSAGE;
            $mail->Body    = "
            <div class='container'>
    <table align='center' bgcolor='#294456' border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tbody>
        <tr>
            <td align='center' valign='bottom'>
                <table width='600'>
                    <tbody>
                        <tr>
                            <td align='center' valign='bottom'>
                                <table border='0' cellpadding='0' cellspacing='0' width='580'>
                                    <tbody>                
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align='center' valign='top' style='padding-bottom: 50px;'>
                <table bgcolor='#FFFFFF' border='0' cellpadding='0' cellspacing='0' style='overflow:hidden!important;border-radius:3px' width='580'>
                    <tbody>
                        <tr>
                            <td>
                                <img src='https://www.aacmena.com/Images/Program/6368462727441017906EEEFDC756AAF21BBEF30A936A693830.jpg?width=&amp;t=1452605472977&amp;width=580' style='border:0;max-width:100%!important' width='580'></a>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align='center'>
                                <table width='85%'>
                                    <tbody>
                                        <tr>
                                            <td align='center'>
                                                <h2 style='margin:0!important;font-family:'Open Sans',arial,sans-serif!important;font-size:28px!important;line-height:38px!important;font-weight:200!important;color:#252b33!important'>
                                                Bonjour $toUserName,</h2>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align='center'>
                                <table border='0' cellpadding='0' cellspacing='0' width='78%'>
                                    <tbody>
                                        <tr>
                                            <td align='center' style='font-family:'Open Sans',arial,sans-serif!important;font-size:16px!important;line-height:30px!important;font-weight:400!important;color:#7e8890!important'>
                                            <p>$message</p></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align='center' valign='top'>
                                <table border='0' cellspacing='0'>
                                    <tbody>
                                        <tr padding-top='10px'>
                                        <td margin-bottom='30px'>
                                        <a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/1.php?id=$id'><img src='https://zupimages.net/up/19/42/zk2l.png' alt='bien' width='80' height='80'/></a>
                                        <a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/2.php?id=$id'><img src='https://zupimages.net/up/19/42/ixon.png' alt='moyen' width='80' height='80'/></a>
                                        <a href='http://$_SERVER[HTTP_HOST]/Akkappiness/mailing/3.php?id=$id'><img src='https://zupimages.net/up/19/42/m6zb.png' alt='mauvais' width='80' height='80'/></a>
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                </table>

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
header("Location: /");
