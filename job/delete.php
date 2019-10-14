<?php
require 'connection.php';
$id = $_GET['id'];
$sql = 'DELETE FROM job WHERE id=:id';
$statement = $connection->prepare($sql);
if ($statement->execute([':id' => $id])) {
  header("Location: show.php");
}