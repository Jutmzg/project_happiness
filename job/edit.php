<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';

$id = $_GET['id'];
if ($id == "") {
  header('Location: /Akkappiness/job/show.php');
}
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
  if ($statement->execute([':name' => $name, ':id' => $id])) {
    header("Location: show.php");
  }
}
?>
<body>
  <div class="container">

  </div>
  <?php if (!empty($message)) : ?>
    <div class="alert alert-success">
      <?= $message; ?>
    </div>
  <?php endif; ?>
  <div class="box">

    <form method="post">
      <h2>Modifier les informations de : <?= $jobs->name ?></h2>
      <a onclick="goBack()" class="close"><i class="fas fa-times" id="cross"></i></a>

      <div class="input-box">
        <input value="<?= $jobs->name; ?>" type="text" name="name" id="name" maxlength="50" minlength="2" required>
      </div>

      <div class="form-group">
        <div class="input-box">
          <div class="ValAnn">
            <button type="submit" class="btn btn-info">Valider</button>
            <a class="btn btn-info" href="/Akkappiness/job/show.php">Annuler</a>
          </div>
        </div>
      </div>
    </form>
  </div>
  </div>
  </div>
</body>
<?php require '../layout/footer.php'; ?>

</html>