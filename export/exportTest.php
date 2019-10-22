<?php
require '../connection.php';

$sql = 'SELECT m.name as mission, resultat, created_at, e.state AS state FROM enquete AS e LEFT JOIN mission AS m ON m.id=e.mission_id';
$statement = $connection->prepare($sql);
$statement->execute();
$enquetes = $statement->fetchAll(PDO::FETCH_ASSOC);

/* $enquete[0]['resultat'] = 'Pas de retour';
$enquete[1]['resultat'] = 'Bon';
$enquete[2]['resultat'] = 'Moyen';
$enquete[3]['resultat'] = 'Mauvais'; */


$excel = "";
$excel .=  "MISSION\tRESULTAT\tCREE LE\tENVOYE\n";

foreach($enquetes as $enquete) {
    switch ($enquete) {
        case 0:
            $answer = 'Pas de réponse';
            break;
        case 1:
            $answer = 'Bien';
            break;
        case 2:
            $answer = 'Moyen';
            break;
        case 3:
            $answer = 'Mauvais';
            break;
    }    
        $excel .= "$enquete[mission]\t$enquete[resultat]\t$enquete[created_at]\t$enquete[state]\n";
        $answer = ''; 
}   

header("Content-type: application/vnd.msexcel; charset=utf-16");
header("Content-disposition: attachment; filename=enquete_akkappiness.xls");


print $excel;
exit;