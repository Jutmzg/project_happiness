<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';

$id = $_GET['id'];
if($id == ""){
  header('Location: /Akkappiness/customer/show.php');
}
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
  if ($statement->execute([':name' => $name, ':address' => $address, ':id' => $id])) {
    header("Location: show.php");
  }
}
?>

<div class="container">
  <?php if (!empty($message)) : ?>
    <div class="alert alert-success">
      <?= $message; ?>
    </div>
  <?php endif; ?>
  <div class="box">

  <form method="post">
  <h2>Modifier les informations de : <?= $customers->name ?></h2>
    <a onclick="goBack()"><i class="fas fa-times fa-2x" id="cross"></i></a>

    <div class="input-box">
      <input value="<?= $customers->name; ?>" type="text" name="name" id="name" placeholder="Nom" maxlength="50" minlength="2" required>
    </div>
    <div class="input-box">
      <input value="<?= $customers->address; ?>" type="text" name="address" id="address" placeholder="Adresse" maxlength="75" minlength="10">
    </div>
    <div class="form-group">
      <div class="input-box">

        <button type="submit" class="btn btn-info">Valider</button>
        <button class="btn btn-info retour"><a onclick="goBack()">Annuler</a></button>
      </div>
    </div>
  </form>
</div>
</div>
</div>
<?php require '../layout/footer.php'; ?>