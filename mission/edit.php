<!DOCTYPE html>
<html lang="fr">
<?php require '../layout/header.php'; 

$id = $_GET['id'];
if($id == ""){
  header('Location: /Akkappiness/mission/show.php');
}

$sql = 'SELECT * FROM mission WHERE id=:id';
$statement = $connection->prepare($sql);
$statement->execute([':id' => $id]);
$row = $statement->fetch(PDO::FETCH_OBJ);

$sql = 'SELECT * FROM customer WHERE state = 0 ORDER BY name';
$statement = $connection->query($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);

$sql3 = "SELECT id, CONCAT(lastname,' ', firstname) as fullname FROM consultant WHERE state = 0 ORDER BY fullname";
$statement = $connection->query($sql3);
$statement->execute();
$consultants = $statement->fetchAll(PDO::FETCH_OBJ);

$sql2 = 'SELECT * FROM job ORDER BY name';
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

<body>
  <div class="container">
  <?php if (!empty($message)) : ?>
          <div class="alert alert-success">
            <?= $message; ?>
          </div>
        <?php endif; ?>
        <div class="boxmission">
        
        <form method="post">
        <h2>Modifier la mission : <?= $row->name ?></h2>
        <a onclick="goBack()"><i class="fas fa-times fa-2x" id="cross"></i></a>

                <div class="input-box">
            <input value="<?= $row->name; ?>" type="text" name="name" id="name" maxlength="50" minlength="2" readonly required>
          </div>

          <div class="input-box">
            <select id="consultant" name="consultant_id"required>
              <option name="choice" id="choice" value="">Sélectionner un consultant</option>

              <?php foreach ($consultants as $consultant) { ?>
               <?= $selected = $row->consultant_id == $consultant->id ? 'selected' : ''; ?>
                  <?php $cons = substr($consultant->fullname, 0, 4);?>
                <?= "<option value='$consultant->id' name='consultant' id='consultant' data-value=$cons $selected>"?><?= $consultant->fullname?></option>
            <?php } ?>
            </select>
          </div>

                <div class="input-box">
            <select id="customer" name="customer_id"required>
              <option name="choice" id="choice" value="">Sélectionner un client</option>

              <?php foreach ($customers as $customer) { 
                 $customerName = utf8_encode($customer->name);
                $selected = $row->customer_id == $customer->id ? 'selected' : ''; ?>
                <?= "<option value='$customer->id' name='customer' id='customer' data-value=$customer->name $selected>"?><?=$customer->name?></option>
              <?php } ?>
            </select>
          </div>

                <div class="input-box">
            <select name="job_id"required>
              <option name="choice" id="choice" value="">Sélectionner un poste</option>

              <?php foreach ($jobs as $job) {
                $selected = $row->job_id == $job->id ? 'selected' : ''; ?>
                <?= "<option value='$job->id' $selected>"?><?=$job->name?></option>
            <?php  } ?>
            </select>
          </div>
                <div class="input-box">
            <input type="text" name="start" id="start" value="<?= date('m/d/Y', strtotime($row->start)) ?>" class="datepicker" required>
          </div>

                <div class="input-box">
            <input type="text" class="datepicker" name="stop" id="stop" min="<?= date('m/d/Y', strtotime($row->start)) ?>" value="<?= date('m/d/Y', strtotime($row->stop)) ?>" required>

          </div>
          <div class="form-group">
          <div class="input-box">

          <div class="ValAnn">
            <button type="submit" class="btn btn-info">Valider</button>
            <a class="btn btn-info" href="/Akkappiness/mission/show.php">Annuler</a>
          </div>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function(fourletters) {
      $("#consultant, #customer").change(function() {
        var selectedItem = $(this).val();
        var FourLetters = $('option:selected', consultant).attr('data-value');
        var customerName = $('option:selected', customer).attr('data-value');

        if(customerName === undefined){
        document.getElementById('name').value = FourLetters
        }
        else {
          document.getElementById('name').value = FourLetters + '-' + customerName;
        }
      });
    });
  </script>
</body>
<?php require '../layout/footer.php'; ?>

</html>