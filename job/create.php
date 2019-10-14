<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php'; 

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

<body>
<div class="container">
<?php if (!empty($message)) : ?>
        <div class="alert alert-success">
          <?= $message; ?>
        </div>
      <?php endif; ?>
      <div class="box">

      <form method="post">
      <a href ="/Akkappiness/mission/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>

          <div class="input-box">
          <input type="text" name="name" id="name" placeholder="Nom" maxlength="50" minlength="2" required>
        </div>

        <div class="form-group">
          <div class="input-box">
          <button type="submit" class="btn btn-info">Valider</button>
          <button class="btn btn-info retour"><a href ="/Akkappiness/job/show.php">Annuler</a></button>

        </div>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
<?php require '../layout/footer.php'; ?>
</html>