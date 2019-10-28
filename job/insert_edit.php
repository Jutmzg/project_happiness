<?php require '../layout/header.php'; 

$id = $_GET['id'];
if($id == ""){
  header('Location: /Akkappiness/job/show.php');
}
$sql = 'SELECT * FROM job WHERE id=:id';
$statement = $connection->prepare($sql);
$statement->execute([':id' => $id]);
$jobs = $statement->fetch(PDO::FETCH_OBJ);

if (
  isset($_POST['name'])
) {

  $name = $_POST['name'];

  $sql = 'UPDATE job SET name=:name WHERE id=:id';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':name' => $name, ':id' => $id])) {
    header("Location: show.php");
  }
}