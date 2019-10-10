<?php
require '../db/db.php';
$message = '';

$sql = 'SELECT * FROM mission WHERE state = 0';
$statement = $connection->query($sql);
$statement->execute();
$missions = $statement->fetchAll(PDO::FETCH_OBJ);

$sql = "SELECT id, mail, CONCAT(firstname,' ', lastname) as fullname FROM manager WHERE state = 0";
$statement = $connection->query($sql);
$statement->execute();
$managers = $statement->fetchAll(PDO::FETCH_OBJ);
if (
  isset($_POST['lastname']) &&
  isset($_POST['firstname']) &&
  isset($_POST['mail']) &&
  isset($_POST['mission_id']) &&
  isset($_POST['manager_id'])
) {

  $lastname = $_POST['lastname'];
  $firstname = $_POST['firstname'];
  $mail = $_POST['mail'];
  if ($_POST['mission_id'] == '') {
    $mission_id = NULL;
  } else {
    $mission_id = $_POST['mission_id'];
  }
  $manager_id = $_POST['manager_id'];
  $state = 0;

  $sql = 'INSERT INTO consultant(lastname, firstname, mail, mission_id, state, manager_id) VALUES(:lastname, :firstname, :mail, :mission_id, :state, :manager_id)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':lastname' => $lastname, ':firstname' => $firstname, ':mail' => $mail, ':mission_id' => $mission_id, ':state' => $state, ':manager_id' => $manager_id])) {
    $message = 'Consultant ajouté';
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
        <h2>Ajouter un consultant</h2>
        <a href="/Akkappiness/consultant/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>
      </div>

      <div class="card-body">
        <?php if (!empty($message)) : ?>
          <div class="alert alert-success">
            <?= $message; ?>
          </div>
        <?php endif; ?>
        <form method="post">
          <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname" class="form-control" maxlength="50" minlength="2" required>
          </div>
          <div class="form-group">
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" id="firstname" class="form-control" maxlength="50" minlength="2" required>
          </div>
          <div class="form-group">
            <label for="mail">Email</label>
            <input type="email" name="mail" id="mail" class="form-control" maxlength="50" minlength="5" required>
          </div>
          <div class="form-group">
            <label for="mission">Mission</label>
            <select name="mission_id" class="form-control">
              <option name="choice" id="choice"></option>
              <?php foreach ($missions as $mission) {
                ?>
                <option value="<?= $mission->ID ?>" name="mission" id="mission"><?= $mission->name ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="manager">Manager</label>
            <select name="manager_id" class="form-control" required>
              <option name="choice" id="choice" value="">Selectionner un manager</option>
              <?php foreach ($managers as $manager) {
                ?>
                <option value="<?= $manager->id ?>" name="manager" id="manager"><?= $manager->fullname ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-info">Valider</button>
            <button class="btn btn-info retour"><a href="/Akkappiness/consultant/show.php">Retour</a></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
<?php require '../layout/footer.php'; ?>
</html>