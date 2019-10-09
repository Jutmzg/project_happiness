<?php
require '../db/db.php';
$id = $_GET['id'];

$sql = 'SELECT * FROM mission WHERE id=:id';
$statement = $connection->prepare($sql);
$statement->execute([':id' => $id]);
$row = $statement->fetch(PDO::FETCH_OBJ);

$sql = 'SELECT * FROM customer';
$statement = $connection->query($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);

$sql3 = 'SELECT * FROM consultant WHERE state = 0';
$statement = $connection->query($sql3);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);

$sql2 = 'SELECT * FROM job';
$statement = $connection->query($sql2);
$statement->execute();
$jobs = $statement->fetchAll(PDO::FETCH_OBJ);

if (
  isset($_POST['name']) &&
  isset($_POST['customer_id']) &&
  isset($_POST['job_id']) &&
  isset($_POST['start']) &&
  isset($_POST['stop'])
) {

  $name = $_POST['name'];
  $customer_id = $_POST['customer_id'];
  $consultant_id = $_POST['consultant_id'];
  $job_id = $_POST['job_id'];
  $start = date('Y-m-d', strtotime($_POST['start']));
  $stop = date('Y-m-d', strtotime($_POST['stop']));
  $state = 0;


  $sql = 'UPDATE mission SET name=:name, customer_id=:customer_id, consultant_id=:consultant_id, job_id=:job_id, start=:start, stop=:stop, state=:state WHERE id=:id';
  $statement = $connection->prepare($sql);

  if ($statement->execute([':name' => $name, ':customer_id' => $customer_id, ':consultant_id' => $consultant_id, ':job_id' => $job_id, ':start' => $start, ':stop' => $stop, ':state' => $state, ':id' => $id])) {
    header("Location: show.php");
  }
}
?>
<?php require '../layout/header.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Modifier la mission : <?=$row->name?></h2>
      <a href ="/Akkappiness/mission/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>

    </div>
    <div class="card-body">
      <?php if (!empty($message)) : ?>
        <div class="alert alert-success">
          <?= $message; ?>
        </div>
      <?php endif; ?>
      <form method="post">
        <div class="form-group">
          <label for="name">Intitulé</label>
          <input value="<?= $row->name; ?>" type="text" name="name" id="name" class="form-control" maxlength="50" minlength="2" required>
        </div>
        <div class="form-group">
          <label for="customer">Client</label>
          <select name="customer_id" class="form-control" required>
            <option name="choice" id="choice" value="">Selectionner un client</option>
            <?php foreach ($customers as $customer) {
              $selected = $row->customer_id == $customer->ID ? 'selected' : '';
              echo "<option value='$customer->ID' name='customer' id='customer' $selected>$customer->name</option>";
            } ?>
          </select>
        </div>


        <div class="form-group">
          <label for="consultant">Consultant</label>
          <select name="consultant_id" class="form-control" required>
            <option name="choice" id="choice" value="">Selectionner un consultant</option>
            <?php foreach ($consultants as $consultant) {
              $selected = $row->consultant_id == $consultant->ID ? 'selected' : '';

              echo "<option value='$consultant->ID' name='consultant' id='consultant' $selected>$consultant->firstname $consultant->lastname</option>";
            } ?>
          </select>
        </div>
        
        <div class="form-group">
          <label for="job_id">Métier</label>
          <select name="job_id" class="form-control" required>
            <option name="choice" id="choice" value="">Selectionner un métier</option>
            <?php foreach ($jobs as $job) {
              $selected = $row->job_id == $job->ID ? 'selected' : '';
              echo "<option value='$job->ID' $selected>$job->name</option>";
            } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="start">Début de mission</label>
          <input type="text" name="start" id="start" value="<?= date('d/m/Y', strtotime($row->start)) ?>" class="form-control datepicker" required>
        </div>
        <div class="form-group">
          <label for="stop">Fin de mission</label>
          <input type="text" class="form-control datepicker" name="stop" id="stop" min="<?= date('d/m/Y', strtotime($row->start)) ?>" value="<?= date('d/m/Y', strtotime($row->stop)) ?>" required>
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