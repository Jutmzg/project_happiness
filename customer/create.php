<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php'; 

$message = '';

if (
  isset($_POST['name']) &&
  isset($_POST['address'])
) {

  $name = $_POST['name'];
  $address = $_POST['address'];
  $state = 0;

  $sql = 'INSERT INTO customer(name, address, state) VALUES(:name, :address, :state)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':name' => $name, ':address' => $address, ':state' => $state])) {
    $message = 'Mission enregistrée';
  } else {
    $message = 'Erreur de saisie';
  }
}
?>


<body>
  <div class="container">
    <div class="card mt-4">
      <div class="card-header">
        <h2>Ajouter un client</h2>
        <a href="/Akkappiness/customer/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>
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
            <label for="address">Adresse</label>
            <input type="text" name="address" id="address" class="form-control" maxlength="75" minlength="10" required>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-info">Valider</button>
            <button class="btn btn-info retour"><a href="/Akkappiness/customer/show.php">Annuler</a></button>

          </div>
        </form>
      </div>
    </div>
  </div>
</body>
<?php require '../layout/footer.php'; ?>

</html>