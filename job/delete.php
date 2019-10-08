<?php
require '../db/db.php';
$id = $_GET['id'];
$sql = 'DELETE FROM job WHERE id=:id';
$statement = $connection->prepare($sql);
if ($statement->execute([':id' => $id])) {
  header("Location: http://localhost/Test2/CRUD/job/show.php");
}