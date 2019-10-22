<?php
require '../connection.php';

$sql = 'SELECT m.name as mission, resultat, created_at, e.state AS state FROM enquete AS e LEFT JOIN mission AS m ON m.id=e.mission_id';
$statement = $connection->prepare($sql);
$statement->execute();
$enquetes = $statement->fetchAll(PDO::FETCH_OBJ);



$excel = "";
$excel .=  "MISSION\tRESULTAT\tCREE LE\tENVOYE\n";

foreach($enquetes as $enquete) {
    if($enquete->resultat === '0'){
        $enquete->resultat = "Pas de retour";    
    } elseif ($enquete->resultat = '1'){
        $enquete->resultat = "Bon";   
    } elseif ($enquete->resultat === '2'){
        $enquete->resultat = "Moyen";   
    } elseif ($enquete->resultat === '3'){
        $enquete->resultat = "Mauvais";   
} 

if($enquete->state === '0'){
    $enquete->state = "PAS ENVOYE";    
} elseif ($enquete->state = '1'){
    $enquete->state = "ENVOYE";   
} 

    $excel .= "$enquete->mission\t$enquete->resultat\t$enquete->created_at\t$enquete->state\n";
}   

header("Content-type: application/vnd.msexcel; charset=utf-16");
header("Content-disposition: attachment; filename=enquete_akkappiness.xls");


print $excel;
exit;