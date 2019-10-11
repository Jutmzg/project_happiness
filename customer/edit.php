<?php
require '../db/db.php';
$id = $_GET['id'];

$sql = 'SELECT * FROM customer WHERE id=:id';
$statement = $connection->prepare($sql);
$statement->execute([':id' => $id]);
$customers = $statement->fetch(PDO::FETCH_OBJ);

if (
  isset($_POST['name']) &&
  isset($_POST['address'])
) {

  $name = $_POST['name'];
  $address = $_POST['address'];

  $sql = 'UPDATE customer SET name=:name, address=:address WHERE id=:id';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':name' => $name, ':address' => $address,':id' => $id])) {
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
      <h2>Modifier les informations de : <?= $customers->name ?></h2>
      <a href ="/Akkappiness/customer/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>
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
          <input value="<?= utf8_encode($customers->name); ?>" type="text" name="name" id="name" class="form-control" maxlength="50" minlength="2" required>
        </div>
        <div class="form-group">
          <label for="address">Adresse</label>
          <input value="<?= $customers->address; ?>" type="text" name="address" id="address" class="form-control" maxlength="75" minlength="10">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-info">Valider</button>
          <button class="btn btn-info retour"><a href ="/Akkappiness/customer/show.php">Annuler</a></button>

        </div>
      </form>
    </div>
  </div>
</div>
<?php require '../layout/footer.php'; ?>