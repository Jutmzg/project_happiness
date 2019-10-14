<?php
require '../db/db.php';

$sql = 'SELECT * FROM user WHERE mail=? AND password=?';
    $statement = $connection->prepare($sql);
    $statement->execute();

$from = $_POST['firstname'] . $_POST['lastname'] . $_POST['login'];
$object = 'Akkappinness : Enquête de satisfaction';


$message = '<html><body>';
$message .= 'Bonjour' . $_POST['firstname'] . $_POST['lastname'] . ',';
$message .= 'Dans le cadre de notre campagne d’enquête de satisfaction, merci de nous donner votre niveau de satisfaction de votre mission actuelle.</br>';
$message .= 'En vous remerciant par avance,';
$message .= "<tr><td><strong>URL To Change (main):</strong> </td><td>" . $_POST['URL-main'] . "</td></tr>";
//$addURLS = $_POST['addURLS'];
//if (($addURLS) != '') {
    //$message .= "<tr><td><strong>URL To Change (additional):</strong> </td><td>" . strip_tags($addURLS) . "</td></tr>";
//}
//$curText = htmlentities($_POST['curText']);           
//if (($curText) != '') {
    //$message .= "<tr><td><strong>CURRENT Content:</strong> </td><td>" . $curText . "</td></tr>";
//}
//$message .= "<tr><td><strong>NEW Content:</strong> </td><td>" . htmlentities($_POST['newText']) . "</td></tr>";
$message .= "</body></html>";