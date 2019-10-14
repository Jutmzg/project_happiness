<!DOCTYPE html>
  <html lang="fr">
  <?php require '../layout/header.php'; 
  
  $mission_id = $_GET['mission_id'];

/*   $sql = 'SELECT * FROM enquete WHERE mission_id=:mission_id';
  $statement = $connection->prepare($sql);
  $statement->execute([':mission_id' => $mission_id]);
  $enquete = $statement->fetch(PDO::FETCH_OBJ);
 */
$sql = "UPDATE enquete SET resultat = 2, state = 0 WHERE mission_id=:mission_id";
  $statement = $connection->prepare($sql);
  $statement->execute([':mission_id' => $mission_id]);
  $enquete = $statement->fetch(PDO::FETCH_OBJ);

  if($statement->execute([':mission_id' => $mission_id]));{
  header("Location: success.php");
  }
?>
