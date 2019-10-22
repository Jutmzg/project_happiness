<?php
require '../connection.php';
$ids = explode(',', $_GET['id']);

if($id == ""){
  header('Location: /Akkappiness/job/show.php');
}
foreach($ids as $id){
$sql = 'DELETE FROM job WHERE id=:id';
$statement = $connection->prepare($sql);
if ($statement->execute([':id' => $id])) {
  header("Location: show.php");
}
}