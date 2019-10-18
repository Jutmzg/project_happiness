<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';
$id = $_GET['id'];
var_dump($id);
$message = '';

$sql2 = 'SELECT * FROM job ORDER BY name';
$statement = $connection->query($sql2);
$statement->execute();
$jobs = $statement->fetchAll(PDO::FETCH_OBJ);

$sql = 'SELECT * FROM customer WHERE state = 0 ORDER BY name';
$statement = $connection->query($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);

$sql3 = "SELECT id, CONCAT(lastname,' ', firstname) as fullname FROM consultant WHERE state = 0 ORDER BY fullname";
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

  $lastname = $_POST['lastname'];
  $firstname = $_POST['firstname'];
  $manager_id = $_POST['manager_id'];
  $sql = 'UPDATE consultant SET lastname=:lastname, firstname=:firstname, manager_id=:manager_id WHERE id=:id';
    $statement = $connection->prepare($sql);
    $statement->execute([':lastname' => $lastname, ':firstname' => $firstname, ':manager_id' => $manager_id, ':id' => $id]);
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
    <div class="boxmission">
      <form method="post" id="monFormulaire">
        <a href="/Akkappiness/mission/show.php"> <i class="fas fa-times fa-2x" id="cross"></i></a>

        <div class="input-box">
          <input type="text" placeholder="Nom" name="name" id="name" maxlength="50" minlength="2" required readonly>
        </div>

        <div class="input-box">
    <select id="consultant" name="consultant_id" required>
      <option name="choice" id="choice" value="">Sélectionner un consultant</option>
      <?php foreach ($consultants as $consultant) { 
                $selected = NULL;
                $selected = "selected=" . $_GET['id'] = $consultant->id;
                echo "\t",'<option value="','"', $selected ,'>', $consultant->fullname,'</option>',"\n";?>
      <?php } ?>
    </select>
  </div>

  <div class="input-box">
        <select id="customer" name="customer_id" required>
          <option name="choice" id="choice" value="">Selectionner un client</option>
          <?php foreach ($customers as $customer) {
            ?>
            <option value="<?= $customer->id ?>" data-value="<?= utf8_encode($customer->name) ?>" name="customer" id="customer"><?= utf8_encode($customer->name) ?></option>
          <?php } ?>
        </select>
    </div>

  <div class="input-box">
    <select name="job" required>
      <option name="choice" id="choice" value="">Selectionner un métier</option>
      <?php foreach ($jobs as $job) {
        ?>
        <option value="<?= $job->id ?>" name="job" id="job"><?= utf8_encode($job->name) ?></option>
      <?php } ?>
    </select>
  </div>

  <div class="input-box">
    <input type="text" placeholder="Début de la mission" name="start" id="start" value="" class="datepicker" required>
  </div>

  <div class="input-box">
    <input type="text" placeholder="Fin de la mission" name="stop" id="stop" value="" class="datepicker" required>
  </div>

  <div class="form-group">
  <div class="input-box">
    <button type="submit" class="btn btn-info">Valider</button>
    <button class="btn btn-info retour"><a href="/Akkappiness/mission/show.php">Annuler</a></button>
  </div>
  </div>
  </form>
  </div>
  <script>
$(document).ready(function(fourletters){
$("#consultant").change(function () {
   var selectedItem = $(this).val();
   var FourLetters= $('option:selected', this).attr('data-value');
   $("#customer").change(function () {
   var selectedItem = $(this).val();
   var customerName= $('option:selected', this).attr('data-value');
   document.getElementById('name').value = FourLetters+'-'+customerName;
  });
  });
});
    </script>
</body>
<?php require '../layout/footer.php'; ?>
</html>