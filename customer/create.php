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
    $message = 'Client enregistré';
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
        <a href="/Akkappiness/customer/show.php"><i class="fas fa-times fa-2x" id="cross"></i></a>

          <div class="input-box">
            <input type="text" placeholder="Nom" name="name" id="name" maxlength="50" minlength="2" required>
          </div>
          <div class="input-box">
            <input type="text" placeholder="Adresse" name="address" id="address" maxlength="75" minlength="10" required>
          </div>

          <div class="form-group">
          <div class="input-box">
            <button type="submit" class="btn btn-info">Valider</button>
            <button class="btn btn-info retour"><a href="/Akkappiness/customer/show.php">Annuler</a></button>

          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
<?php require '../layout/footer.php'; ?>

</html>