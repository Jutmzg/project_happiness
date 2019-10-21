<?php require '../connection.php'; 
$ids = explode(',', $_GET['id']);

foreach($ids as $id){
$sql = 'DELETE FROM enquete WHERE id=:id';
$statement = $connection->prepare($sql);
if ($statement->execute([':id' => $id])) {
  echo 'ok';
  header("Location: show.php");
}
}


