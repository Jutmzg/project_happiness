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
$column = 'A';
$row = 7;
foreach($consultants as $c)
        {   
          
            $sheet
                ->setCellValue($column . $row, 'test');
                
        }
$sheet->setTitle('Consultant');

$worksheet2 = $spreadsheet->createSheet();
$worksheet2->setTitle('Mission');

$worksheet3 = $spreadsheet->createSheet();
$worksheet3->setTitle('Client');

$worksheet4 = $spreadsheet->createSheet();
$worksheet4->setTitle('Enquête');
/* /**  Loop through all the remaining files in the list  **/
//foreach($inputFileNames as $sheet => $inputFileName) {
    /**  Increment the worksheet index pointer for the Reader  **/
    //$reader->setSheetIndex($sheet+1);
    /**  Load the current file into a new worksheet in Spreadsheet  **/
    //$reader->loadIntoExisting($inputFileName,$spreadsheet);
    /**  Set the worksheet title (to the filename that we've loaded)  **/
    //$spreadsheet->getActiveSheet()
        //->setTitle(pathinfo($inputFileName,PATHINFO_BASENAME));*/

// Redirect output to a client
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Akkappiness.xlsx"');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>