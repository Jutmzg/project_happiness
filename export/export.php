<?php
require '../connection.php';

$sql = "SELECT CONCAT(co.lastname,' ', co.firstname) as consultant, j.name job, c.name customer, m.name mission, resultat, created_at, e.state 
FROM enquete AS e 
LEFT JOIN mission AS m 
ON m.id=e.mission_id
LEFT JOIN consultant co 
ON m.consultant_id = co.ID
INNER JOIN customer c 
ON m.customer_id = c.ID
INNER JOIN job j 
ON m.job_id = j.ID";
$statement = $connection->prepare($sql);
$statement->execute();
$enquetes = $statement->fetchAll(PDO::FETCH_OBJ);



$excel = "";
$excel .=  "CONSULTANT\tPOSTE\tCLIENT\tMISSION\tRESULTAT\tCREE LE\tENVOYE\n";

foreach($enquetes as $enquete) {
    if($enquete->resultat === '0'){
        $enquete->resultat = "Pas de retour";    
    } elseif ($enquete->resultat === '1'){
        $enquete->resultat = "Bon";   
    } elseif ($enquete->resultat === '2'){
        $enquete->resultat = "Moyen";   
    } elseif ($enquete->resultat === '3'){
        $enquete->resultat = "Mauvais";   
} 

if($enquete->state === '0'){
    $enquete->state = "NON";    
} elseif ($enquete->state === '1'){
    $enquete->state = "OUI";   
}

    $excel .= "$enquete->consultant\t$enquete->job\t$enquete->customer\t$enquete->mission\t$enquete->resultat\t$enquete->created_at\t$enquete->state\n";
}   

header("Content-type: application/vnd.msexcel; charset=utf-16");
header("Content-disposition: attachment; filename=enquete_akkappiness.xls");


print $excel;
exit;
