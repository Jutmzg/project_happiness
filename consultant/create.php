<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php';

// RECUPERE LES MANAGERS 
$sql = "SELECT id, mail, CONCAT(lastname,' ', firstname) as fullname FROM manager WHERE state = 0 ORDER BY fullname";
$statement = $connection->query($sql);
$statement->execute();
$managers = $statement->fetchAll(PDO::FETCH_OBJ);

// RECUPERE LES POSTES 

$sql2 = 'SELECT * FROM job ORDER BY name';
$statement = $connection->query($sql2);
$statement->execute();
$jobs = $statement->fetchAll(PDO::FETCH_OBJ);

// RECUPERE LES CLIENTS 

$sql = 'SELECT * FROM customer WHERE state = 0 ORDER BY name';
$statement = $connection->query($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);

// LISTE DES CONSULTANTS A SUPPRIMER 

$sql3 = "SELECT id, CONCAT(lastname,' ', firstname) as fullname FROM consultant WHERE state = 0 ORDER BY fullname";
$statement = $connection->query($sql3);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);

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
    $message = '<div class="alert alert-success"><i class="far fa-check-circle"></i> Consultant ajouté</div>';
    $id = $connection->lastInsertId();

  }
  else{
    $message = '<div class="alert alert-danger"><i class="far fa-check-circle"></i> Erreur lors de la saisie du consultant</div>';
  }
}


if (
    isset($_POST['name']) &&
    isset($_POST['customer_id']) &&
    isset($_POST['job']) &&
    isset($_POST['start']) &&
    isset($_POST['stop'])
  ) {

$name = $_POST['name'];
  $customer_id = $_POST['customer_id'];
  $job_id = $_POST['job'];
  $consultant_id = $id;
  $start = date('Y-m-d', strtotime($_POST['start']));
  $stop = date('Y-m-d', strtotime($_POST['stop']));
  $state = 0;
$sql = 'INSERT INTO mission(name, customer_id, job_id, consultant_id, start, stop,state) VALUES(:name, :customer_id, :job_id, :consultant_id, :start, :stop, :state)';
  $statement = $connection->prepare($sql);
  if($statement->execute([':name' => $name, ':customer_id' => $customer_id, ':job_id' => $job_id, ':consultant_id' => $consultant_id, ':start' => $start, ':stop' => $stop, ':state' => $state])) {
    $messageMission = '<div class="alert alert-success"><i class="far fa-check-circle"></i> Mission ajoutée</div>';
  }
  else{
    $messageMission = '<div class="alert alert-danger"><i class="far fa-check-circle"></i> Erreur lors de la saisie de la mission</div>';
  }
}
?>
<body>
  <div class="container">
    <?php if (isset($message)) : ?>
        <?= $message; ?>
        <?php endif; ?>
        <?php if (isset($messageMission)) : ?>
        <?= $messageMission; ?>
        <?php endif; ?>
   
    <div class="boxConsultantMission">
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
          <select name="manager_id" required>
            <option name="choice" id="choice" value="">Sélectionner un manager</option>
            <?php foreach ($managers as $manager) {
              ?>
              <option value="<?= $manager->id ?>" name="manager" id="manager"><?= utf8_encode($manager->fullname) ?></option>
            <?php } ?>
          </select>
        </div>

        <!-- MISSION -->
        <div id="slide">Créer une mission <i class="fas fa-sort-down fa-x"></i></div>
        <div id="panel">
        <div class="input-box">
        <input value="<?php $cons; ?>" type="text" placeholder="Nom" name="name" id="name" maxlength="50" minlength="2" readonly>
      </div>

      <!-- <div class="input-box">

        <select id="consultant" name="consultant_id">
          <option name="choice" id="choice" value="">Sélectionner un consultant</option>
          <?php foreach ($consultants as $consultant) {
            $cons = substr($consultant->fullname, 0, 4);
            $selected = $row->id == $consultant->id ? 'selected' : ''; ?>
            <?= "<option value='$consultant->id' data-value='$cons' name='consultant_id' id='consultant' $selected>" ?><?= $consultant->fullname ?></option>
          <?php } ?>
        </select>
      </div> -->

      <div class="input-box">
        <select id="customer" name="customer_id">
          <option name="choice" id="choice" value="">Sélectionner un client</option>
          <?php foreach ($customers as $customer) {
            ?>
            <option value="<?= $customer->id ?>" data-value="<?= $customer->name ?>" name="customer" id="customer"><?= $customer->name ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="input-box">
        <select name="job">
          <option name="choice" id="choice" value="">Sélectionner un poste</option>
          <?php foreach ($jobs as $job) {
            ?>
            <option value="<?= $job->id ?>" name="job" id="job"><?= $job->name ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="input-box">
        <input type="text" placeholder="Début de la mission" name="start" id="start" value="" class="datepicker">
      </div>

      <div class="input-box">
        <input type="text" placeholder="Fin de la mission" name="stop" id="stop" value="" class="datepicker">
      </div>

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

<script>
    $("#slide").click(function(){
    $("#panel").slideToggle("slow");
    $("i", this).toggleClass("fas fa-sort-down fa-x fas fa-sort-up fa-x");
    });

    $(document).ready(function(fourletters) {
      $("#lastname, #customer").change(function() {
        let selectedItem = $(this).val();
        let FourLetters = document.getElementById('lastname').value.substr(0, 4);
        let customerName = $('option:selected', customer).attr('data-value');

        if (FourLetters === undefined) {
          document.getElementById('name').value = '-' + customerName;
        } else if (customerName === undefined) {
          document.getElementById('name').value = FourLetters.toUpperCase();
        } else {
          document.getElementById('name').value = FourLetters.toUpperCase() + '-' + customerName;
        }
      });
    });
  </script>
</body>


<?php require '../layout/footer.php'; ?>

</html>