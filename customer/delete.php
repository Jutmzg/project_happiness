<?php
require '../connection.php';
$ids = explode(',', $_GET['id']);

if($id == ""){
  header('Location: /Akkappiness/customer/show.php');
}
foreach($ids as $id){
$sql = 'UPDATE customer SET state = 1 WHERE id=:id';
$statement = $connection->prepare($sql);
if ($statement->execute([':id' => $id])) {
  header("Location: show.php");
}
}