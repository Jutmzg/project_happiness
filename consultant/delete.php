<?php require '../connection.php'; 
$id = $_GET['id'];
$sql = 'UPDATE consultant SET state = 1 WHERE id=:id';
$statement = $connection->prepare($sql);
if ($statement->execute([':id' => $id])) {
  header("Location: show.php");
} ?>
