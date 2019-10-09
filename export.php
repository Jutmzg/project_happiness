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
$sheet = $spreadsheet->getActiveSheet();
$row = 3;
foreach($consultants as $value){
        $sheet
            ->setCellValue('B'.$row, $value->lastname)
            ->setCellValue('C'.$row, $value->firstname)
            ->setCellValue('D'.$row, $value->mail)
            ->setCellValue('E'.$row, $value->mission_id)
            ->setCellValue('F'.$row, $value->state)
            ->setCellValue('G'.$row, $value->manager_id);
        $row++;     
}
$sheet->setCellValue('A1', 'Liste des Consultants')
        ->setCellValue('B1', 'Nom')
        ->setCellValue('C1', 'Prénom')
        ->setCellValue('D1', 'Mail')
        ->setCellValue('E1', 'Mission')
        ->setCellValue('F1', 'Statut')
        ->setCellValue('G1', 'Manager');
$sheet->mergeCells('A1:D1');
$sheet->setTitle('Consultant');

$sql = 'SELECT * FROM mission';
$statement = $connection->prepare($sql);
$statement->execute();
$missions = $statement->fetchAll(PDO::FETCH_OBJ);
$spreadsheet->createSheet();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Akkappiness.xlsx"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>

/* /**  Loop through all the remaining files in the list  **/
//foreach($inputFileNames as $sheet => $inputFileName) {
    /**  Increment the worksheet index pointer for the Reader  **/
    //$reader->setSheetIndex($sheet+1);
    /**  Load the current file into a new worksheet in Spreadsheet  **/
    //$reader->loadIntoExisting($inputFileName,$spreadsheet);
    /**  Set the worksheet title (to the filename that we've loaded)  **/
    //$spreadsheet->getActiveSheet()
        //->setTitle(pathinfo($inputFileName,PATHINFO_BASENAME));*/