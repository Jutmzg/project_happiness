<?php
require '../connection.php';

$sql = 'SELECT m.name as mission, resultat, created_at, e.state AS state FROM enquete AS e LEFT JOIN mission AS m ON m.id=e.mission_id';
$statement = $connection->prepare($sql);
$statement->execute();
$enquete = $statement->fetchAll(PDO::FETCH_ASSOC);

$excel = "";
$excel .=  "MISSION\tRESULTAT\tCREE LE\tENVOYE\n";

foreach($enquete as $row) {
        $excel .= "$row[mission]\t$row[resultat]\t$row[created_at]\t$row[state]\n";
}

$answer = '';
switch ($row['mission']) {
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

header("Content-type: application/vnd.msexcel; charset=utf-16");
header("Content-disposition: attachment; filename=enquete_akkappiness.xls");


print $excel;
exit;