<!DOCTYPE html>
  <html lang="fr">
  <?php require '../layout/header.php'; 
  
  $id = $_GET['id'];

$sql = "UPDATE enquete SET resultat = 2, state = 0 WHERE id=:id";
  $statement = $connection->prepare($sql);
  $statement->execute([':id' => $id]);
  $enquete = $statement->fetch(PDO::FETCH_OBJ);
  
  if($statement->execute([':id' => $id]));{
    header("Location: success.php");
    }
  ?>
  