<?php
require '../db/db.php';
$id = $_GET['id'];

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
  if ($statement->execute([':name' => $name,':id' => $id])) {
    header("Location: show.php");
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<?php require '../layout/header.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Modifier les informations de : <?= $jobs->name ?></h2>
      <a href ="/Akkappiness/mission/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>

    </div>
    <div class="card-body">
      <?php if (!empty($message)) : ?>
        <div class="alert alert-success">
          <?= $message; ?>
        </div>
      <?php endif; ?>
      <form method="post">
        <div class="form-group">
          <label for="name">Nom</label>
          <input value="<?= $jobs->name; ?>" type="text" name="name" id="name" class="form-control" maxlength="50" minlength="2" required>
        </div>
        
        <div class="form-group">
          <button type="submit" class="btn btn-info">Valider</button>
          <button class="btn btn-info retour"><a href ="/Akkappiness/job/show.php">Annuler</a></button>

        </div>
      </form>
    </div>
  </div>
</div>
<?php require '../layout/footer.php'; ?>