<?php
require '../db/db.php';
$message = '';


$sql2 = 'SELECT * FROM job';
$statement = $connection->query($sql2);
$statement->execute();
$jobs = $statement->fetchAll(PDO::FETCH_OBJ);

$sql = 'SELECT * FROM customer';
$statement = $connection->query($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);

$sql3 = 'SELECT * FROM consultant';
$statement = $connection->query($sql3);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);


if (
  isset($_POST['name']) &&
  isset($_POST['customer_id']) &&
  isset($_POST['job']) &&
  isset($_POST['consultant_id']) &&
  isset($_POST['start']) &&
  isset($_POST['stop'])
) {
  $name = $_POST['name'];
  $customer_id = $_POST['customer_id'];
  $job_id = $_POST['job'];
  $consultant_id = $_POST['consultant_id'];
  $start = date('Y-m-d', strtotime($_POST['start']));
  $stop = date('Y-m-d', strtotime($_POST['stop']));
  $state = 0;


  $sql = 'INSERT INTO mission(name, customer_id, job_id, consultant_id, start, stop,state) VALUES(:name, :customer_id, :job_id, :consultant_id, :start, :stop, :state)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':name' => $name, ':customer_id' => $customer_id, ':job_id' => $job_id, ':consultant_id' => $consultant_id, ':start' => $start, ':stop' => $stop, ':state' => $state])) {
    $message = 'Mission enregistrée';
  }
}
?>
<?php require '../layout/header.php'; ?>

<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Créer une mission</h2>
      <a href ="/Akkappiness/mission/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>
    </div>
    <div class="card-body">
      <?php if (!empty($message)) : ?>
        <div class="alert alert-success">
          <?= $message; ?>
        </div>
      <?php endif; ?>
      <form method="post" id="monFormulaire">
        <div class="form-group">
          <label for="name">Intitulé</label>
          <input type="text" name="name" id="name" class="form-control" maxlength="50" minlength="2" required>
        </div>
        <div class="form-group">
          <label for="customer">Client</label>
          <select name="customer_id" class="form-control" required>
            <option name="choice" id="choice" value="">Selectionner un client</option>
            <?php foreach ($customers as $customer) {
              ?>
              <option value="<?= $customer->ID ?>" name="customer" id="customer"><?= $customer->name ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="consultant">Consultant</label>
          <select name="consultant_id" class="form-control" required>
            <option name="choice" id="choice" value="">Selectionner un consultant</option>
            <?php foreach ($consultants as $consultant) { ?>
              <option value="<?= $consultant->ID ?>" name="consultant" id="consultant"><?= $consultant->firstname ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="job">Métier</label>
          <select name="job" class="form-control" required>
            <option name="choice" id="choice" value="">Selectionner un métier</option>
            <?php foreach ($jobs as $job) {
              ?>
              <option value="<?= $job->ID ?>" name="job" id="job"><?= $job->name ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="start">Début de mission</label>
          <input type="text" name="start" id="start" value="<?= date('d-m-Y') ?>" class="form-control datepicker" required>
        </div>
        <div class="form-group">
          <label for="stop">Fin de mission</label>
          <input type="text" name="stop" id="stop" value="<?= date('d-m-Y') ?>" class="form-control datepicker" required>
        </div>

        <?php var_dump($start); ?>
        <?php var_dump($stop); ?>


    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-info">Valider</button>
      <button class="btn btn-info retour"><a href ="/Akkappiness/mission/show.php">Annuler</a></button>

    </div>
    </form>
  </div>
</div>
</div>

<?php require '../layout/footer.php'; ?>