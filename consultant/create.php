<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php'; 

$message = '';
$sql = "SELECT id, mail, CONCAT(firstname,' ', lastname) as fullname FROM manager WHERE state = 0";
$statement = $connection->query($sql);
$statement->execute();
$managers = $statement->fetchAll(PDO::FETCH_OBJ);
if (
  isset($_POST['lastname']) &&
  isset($_POST['firstname']) &&
  isset($_POST['mail']) &&
  isset($_POST['manager_id'])
) {

  $lastname = $_POST['lastname'];
  $firstname = $_POST['firstname'];
  $mail = $_POST['mail'];
  $manager_id = $_POST['manager_id'];
  $state = 0;

  $sql = 'INSERT INTO consultant(lastname, firstname, mail, state, manager_id) VALUES(:lastname, :firstname, :mail, :state, :manager_id)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':lastname' => $lastname, ':firstname' => $firstname, ':mail' => $mail, ':state' => $state, ':manager_id' => $manager_id])) {
    $message = 'Consultant ajouté';
  }
}
?>


<body>
  <div class="container">
    <div class="card mt-4">
      <div class="card-header">
        <h2>Ajouter un consultant</h2>
        <a href="/Akkappiness/consultant/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>
      </div>
      <div class="card-body p-4">
        <?php if (!empty($message)) : ?>
          <div class="alert alert-success">
            <?= $message; ?>
          </div>
        <?php endif; ?>
        <form method="post">
          <div class="form-group">

            <label for="lastname">Nom</label>
            <input type="text" class="form-control" name="lastname" id="lastname" class="" maxlength="50" minlength="2" placeholder="Nom" required>
          </div>

          <div class="form-group">
            <label for="firstname">Prénom</label>

            <input type="text" class="form-control" name="firstname" id="firstname" class="" maxlength="50" minlength="2" placeholder="Prénom" required>
          </div>

          <div class="form-group">
            <label for="email">Email</label>

            <input type="email" class="form-control" name="mail" id="mail" class="" maxlength="50" minlength="5" placeholder="Email" required>
          </div>

          <div class="form-group">
                        <label for="manager">Manager</label>

            <select class="form-control" name="manager_id" class="" required>
              <option name="choice" id="choice" value="">Selectionner un manager</option>
              <?php foreach ($managers as $manager) {
                ?>
                <option value="<?= $manager->id ?>" name="manager" id="manager"><?= utf8_encode($manager->fullname) ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group">
              <button type="submit" class="btn btn-info">Valider</button>
              <button class="btn btn-info retour"><a href="/Akkappiness/consultant/show.php">Annuler</a></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
<?php require '../layout/footer.php'; ?>

</html>