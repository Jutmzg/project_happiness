<?php
require '../connection.php';

$sql = 'SELECT m.name as mission, resultat, created_at, e.state AS state FROM enquete AS e LEFT JOIN mission AS m ON m.id=e.mission_id';
$statement = $connection->prepare($sql);
$statement->execute();
$enquetes = $statement->fetchAll(PDO::FETCH_OBJ);



$excel = "";
$excel .=  "MISSION\tRESULTAT\tCREE LE\tENVOYE\n";

foreach($enquetes as $enquete) {
    
    $excel .= "$enquete->mission\t$enquete->resultat\t$enquete->created_at\t$enquete->state\n";
    if($enquete->resultat === '0'){
            echo "Pas de retour";
    } elseif ($enquete->resultat === '1'){
            echo "Bon";
    } elseif ($enquete->resultat === '2'){
            echo "Moyen";
    } elseif ($enquete->resultat === '3'){
            echo "Mauvais";
    } 
}   

header("Content-type: application/vnd.msexcel; charset=utf-16");
header("Content-disposition: attachment; filename=enquete_akkappiness.xls");


print $excel;
exit;