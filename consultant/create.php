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
        <?php if (!empty($message)) : ?>
          <div class="alert alert-success">
            <?= $message; ?>
          </div>
        <?php endif; ?>
        <div class="box">

        <form method="post">
        <a href="/Akkappiness/consultant/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>

          <div class="input-box">
            <input type="text" name="lastname" id="lastname" class="" maxlength="50" minlength="2" placeholder="Nom" required>
          </div>

          <div class="input-box">
            <input type="text" name="firstname" id="firstname" class="" maxlength="50" minlength="2" placeholder="Prénom" required>
          </div>

          <div class="input-box">
            <input type="email" name="mail" id="mail" class="" maxlength="50" minlength="5" placeholder="Email" required>
          </div>

          <div class="input-box">
            <select name="manager_id" class="" required>
              <option name="choice" id="choice" value="">Selectionner un manager</option>
              <?php foreach ($managers as $manager) {
                ?>
                <option value="<?= $manager->id ?>" name="manager" id="manager"><?= utf8_encode($manager->fullname) ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group">
          <div class="input-box">
            <button type="submit" class="btn btn-info">Valider</button>
            <button class="btn btn-info retour"><a href="/Akkappiness/consultant/show.php">Annuler</a></button>
          </div>
          </div>
        </form>
      </div>
  </div>

</body>
<?php require '../layout/footer.php'; ?>

</html>