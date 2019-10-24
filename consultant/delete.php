<?php require '../connection.php'; 
$ids = explode(',', $_GET['id']);

foreach($ids as $id){
$sql = 'UPDATE consultant SET state = 1 WHERE id=:id';
$statement = $connection->prepare($sql);
  if ($statement->execute([':id' => $id])) {
    header("Location: show.php");
  }
}
