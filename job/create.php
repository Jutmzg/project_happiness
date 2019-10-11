<?php
require '../db/db.php';
$message = '';

if (
  isset($_POST['name']) 
) {

  $name = $_POST['name'];

  $sql = 'INSERT INTO job(name) VALUES(:name)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':name' => $name])) {
    $message = 'Mission enregistrée';
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php'; ?>
<body>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Ajouter un métier</h2>
      <a href ="/Akkappiness/mission/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>

    </div>
    <div class="card-body p-4">
      <?php if (!empty($message)) : ?>
        <div class="alert alert-success">
          <?= $message; ?>
        </div>
      <?php endif; ?>
      <form method="post">
      <div class="form-group">
          <label for="name">Nom</label>
          <input type="text" name="name" id="name" class="form-control" maxlength="50" minlength="2" required>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-info">Valider</button>
          <button class="btn btn-info retour"><a href ="/Akkappiness/job/show.php">Annuler</a></button>

        </div>
      </form>
    </div>
  </div>
</div>
</body>
<?php require '../layout/footer.php'; ?>
</html>