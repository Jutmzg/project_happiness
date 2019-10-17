<?php
require '../connection.php';
$id = $_GET['id'];
if($id == ""){
  header('Location: /Akkappiness/mission/show.php');
}
$sql = 'UPDATE mission SET state = 1 WHERE id=:id';
$statement = $connection->prepare($sql);
if ($statement->execute([':id' => $id])) {
  header("Location: show.php");
}