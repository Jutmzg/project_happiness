<?php 
require 'vendor/autoload.php';
require 'db/db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$sql = 'SELECT * FROM consultant';
$statement = $connection->prepare($sql);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);

$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0);
$row = 3;
foreach($consultants as $value){
        $spreadsheet->getActiveSheet()->setCellValue('B'.$row, $value->lastname)
            ->setCellValue('C'.$row, utf8_encode($value->firstname))
            ->setCellValue('D'.$row, utf8_encode($value->mail))
            ->setCellValue('F'.$row, utf8_encode($value->state))
            ->setCellValue('G'.$row, utf8_encode($value->manager_id));
        $row++;     
}
$spreadsheet->getActiveSheet()->setCellValue('A1', 'Liste des Consultants')
        ->setCellValue('B2', 'Nom')
        ->setCellValue('C2', 'Prénom')
        ->setCellValue('D2', 'Mail')
        ->setCellValue('F2', 'Statut')
        ->setCellValue('G2', 'Manager');
$spreadsheet->getActiveSheet()->mergeCells('A1:D1');
$spreadsheet->getActiveSheet()->setTitle('Consultant');

$sql = 'SELECT * FROM mission';
$statement = $connection->prepare($sql);
$statement->execute();
$missions = $statement->fetchAll(PDO::FETCH_OBJ);
$spreadsheet->createSheet(1);
$spreadsheet->setActiveSheetIndex(1);
$row = 3;
foreach($missions as $value){
    $spreadsheet->getActiveSheet()->setCellValue('B'.$row, $value->name)
        ->setCellValue('C'.$row, utf8_encode($value->customer_id))
        ->setCellValue('D'.$row, utf8_encode($value->job_id))
        ->setCellValue('E'.$row, utf8_encode($value->consultant_id))
        ->setCellValue('F'.$row, utf8_encode($value->start))
        ->setCellValue('G'.$row, utf8_encode($value->stop))
        ->setCellValue('E'.$row, utf8_encode($value->state));
    $row++;     
}
$spreadsheet->getActiveSheet()->setTitle('Mission');
$spreadsheet->getActiveSheet()->mergeCells('A1:D1');
$spreadsheet->getActiveSheet()->setCellValue('A1', 'Liste des Missions')
        ->setCellValue('B2', 'Nom')
        ->setCellValue('C2', 'Client')
        ->setCellValue('D2', 'Métier')
        ->setCellValue('E2', 'Consultant')
        ->setCellValue('F2', 'Début de la Mission')
        ->setCellValue('G2', 'Fin de la Mission')
        ->setCellValue('E2', 'Statut');

$sql = 'SELECT * FROM customer';
$statement = $connection->prepare($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);
$spreadsheet->createSheet(2);
$spreadsheet->setActiveSheetIndex(2);
$row = 3;
    foreach($customers as $value){
        $spreadsheet->getActiveSheet()
        ->setCellValue('B'.$row,utf8_encode($value->name))
        ->setCellValue('C'.$row, utf8_encode($value->address))
        ->setCellValue('D'.$row, utf8_encode($value->state));
    $row++;     
    }
$spreadsheet->getActiveSheet()->setTitle('Client');
$spreadsheet->getActiveSheet()->mergeCells('A1:D1');
$spreadsheet->getActiveSheet()->setCellValue('A1', 'Liste des Clients')
    ->setCellValue('B2', 'Nom')
    ->setCellValue('C2', 'Adresse')
    ->setCellValue('D2', 'Statut');

$sql = 'SELECT * FROM job';
$statement = $connection->prepare($sql);
$statement->execute();
$jobs = $statement->fetchAll(PDO::FETCH_OBJ);
$spreadsheet->createSheet(3);
$spreadsheet->setActiveSheetIndex(3);
$row = 3;
    foreach($jobs as $value){
        $spreadsheet->getActiveSheet()
            ->setCellValue('B'.$row, utf8_encode(($value->name)));
        $row++;     
    }
$spreadsheet->getActiveSheet()->mergeCells('A1:D1');
$spreadsheet->getActiveSheet()->setTitle('Métier');
$spreadsheet->getActiveSheet()->setCellValue('A1', 'Liste des Métiers')
    ->setCellValue('B2', 'Nom');

header('Content-Type: text/xlsx; charset=UTF-8');
header('Content-Disposition: attachment; filename="Akkappiness.xlsx"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public');
header('Content-Encoding: UTF-8');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>