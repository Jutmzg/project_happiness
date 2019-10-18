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

header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-disposition: attachment; filename=enquete_akkappiness.xls");

print $excel;
exit;