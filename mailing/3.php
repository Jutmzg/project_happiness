<!DOCTYPE html>
  <html lang="fr">
  <?php require '../layout/header.php'; 
  
  $id = $_GET['id'];

  $sql = "UPDATE enquete SET resultat = 3 WHERE id=:id AND resultat = 0";
  $statement = $connection->prepare($sql);
  $statement->execute([':id' => $id]);
  
  if($statement->rowCount() === 1){
    header("Location: success.php");
    }
  else{
      header("Location: error.php");
    } 
  ?>