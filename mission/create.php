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
  $start = $_POST['start'];
  $stop = $_POST['stop'];
  $state = 0;


  $sql = 'INSERT INTO mission(name, customer_id, job_id, consultant_id, start, stop,state) VALUES(:name, :customer_id, :job_id, :consultant_id, :start, :stop, :state)';
  $statement = $connection->prepare($sql);
  if ($statement->execute([':name' => $name, ':customer_id' => $customer_id, ':job_id' => $job_id, ':consultant_id' => $consultant_id, ':start' => $start, ':stop' => $stop, ':state' => $state])) {
    $message = 'Mission enregistrée';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
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
          <input type="text" name="start" id="start" value="" class="form-control datepicker" required>
        </div>
        <div class="form-group">
          <label for="stop">Fin de mission</label>
          <input type="text" name="stop" id="stop" value="" class="form-control datepicker" required>
        </div>

        <div class="form-group">
          <label for="test">Début de mission</label>
          <input type="date" name="test" id="test" value="" class="form-control datepicker">
        </div>

    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-info">Valider</button>
      <button class="btn btn-info retour"><a href ="/Akkappiness/mission/show.php">Annuler</a></button>

    </div>
    </form>
  </div>
</div>
</div>

<style>
/* datepicker css */

.ui-datepicker {
    text-align: center;
}

.ui-datepicker-trigger {
    margin: 0 0 0 5px;
    vertical-align: text-top;
}

.ui-datepicker {
    font-family: Open Sans, Arial, sans-serif;
    margin-top: 2px;
    padding: 0 !important;
    border-color: #c9f0f5 !important;
}

.ui-datepicker {
    width: 400px;
}

.openemr-calendar .ui-datepicker {
    width: 191px;
}

.ui-datepicker table {
    width: 400px;
    table-layout: fixed;
    background: #f7f7f7;
}

.openemr-calendar .ui-datepicker table {
    width: 191px;
    table-layout: fixed;
    
}

.ui-datepicker-header {
    background-color: #294456 !important;
    background-image: none !important;
    border-radius: 0;
}

.openemr-calendar .ui-datepicker-header {
    background-color: #e6f7f9 !important;
    border-width: 1px;
    border-color: #c9f0f5;
    border-style: solid;
}

.ui-datepicker-title {
    line-height: 35px !important;
    margin: 0 10px !important;
}

.openemr-calendar .ui-datepicker-title {
    line-height: 20px !important;
}

.ui-datepicker-prev span {
    display: none !important;
}

.ui-datepicker-next {
    text-align: center;
}

.ui-datepicker-next span {
    display: none !important;
}

.ui-datepicker-prev {
    background-color: transparent !important;
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAMCAYAAACulacQAAAAUklEQVQYlXWPwQnAMAwDj9IBOlpH8CjdJLNksuujFIJjC/w6WUioFBcqJ7sGEAD5Y/hpqLRghRv4YQlUjqXI3Kql2MixraGbEhVcDXcFUR/1egEHNuTBpFW0NgAAAABJRU5ErkJggg==') !important;
    height: 12px !important;
    width: 7px !important;
    margin: 14px 12px;
    display: inline-block;
    left: 0 !important;
    top: 0 !important;
}

.openemr-calendar .ui-datepicker-prev {
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAOCAYAAAD9lDaoAAAAuUlEQVQokXXRsUtCYRAA8J8pDQ1CVIgIgtBU2NDiZIuDS4uLf6WDS1O0tLREEE8icBNKS3lTs8/B78XHw3dwcHA/juOuqjzucYJVrQQMcYctvo4OgEFIeMK6iPphCjzjEWLUC3vACx7yRo5uMUIFr5gii1EL41AvMIkBVPGH04DrSLEsIvjEOZq4wi9+iijDR0ANXOMbmxjlcIY2LtANO6YxymGCDs5wg/ciYv+KBJeY4+2A+Y9j4Y47RtUkrNXeDxUAAAAASUVORK5CYII=') !important;
    height: 14px !important;
    width: 9px !important;
    margin: 5px !important;
}

.ui-datepicker-next {
    cursor: pointer;
}

.ui-datepicker-prev {
    cursor: pointer;
}

.ui-datepicker-next {
    background-color: transparent !important;
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAMCAYAAABfnvydAAAAVUlEQVQYlXWQ0Q3AIAhEL07gKI7kKN2kI3Wk1w9to3KQEELucQEECOizhhTQGHFnwOdgobWx0GkZILfYBhXl0STVbPoBarbkL7ozN/F8VBBXh8uJgF5r2hrI4GHUkAAAAABJRU5ErkJggg==') !important;
    height: 12px !important;
    width: 8px !important;
    margin: 14px 12px;
    display: inline-block;
    right: 0 !important;
    top: 0 !important;
}

.openemr-calendar .ui-datepicker-next {
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAOCAYAAAASVl2WAAAAtElEQVQYlXXQsUpCcRQH4I97EQyHa1pgIEE0hBGYL+BjNLRFjxXh4rM4F21BS4S4FAgqQioOngt/RM/6+zi/w4EanlA4MDkecYsO3vG/D8a4Rx03eMMqBQt8oodTXAdalwBm+IpNDVxG3aYEMMU3ujjDBT5SAH9R2cE58mwPFOgneJSCGp7RjLoXTEtQjbCFOV7xCxkqdp9sYxnhpFyb4QFXdh8c4Cc9Ko++OwzjFwfn5FiwBVeuI/K2UCkSAAAAAElFTkSuQmCC') !important;
    height: 14px !important;
    width: 8px !important;
    margin: 5px;
}

.ui-datepicker-month {
    border-radius: 2px;
    width: 110px !important;
    height: 22px;
    font-family: Open Sans !important;
    color: #fff;
    font-size: 14px !important;
    font-weight: 600;
    text-align: left;
    border: none !important;
    margin-right: 17px !important;
    vertical-align: text-top;
}

.openemr-calendar .ui-datepicker-month {
    font-family: Open Sans, Arial, sans-serif;
    color: rgba(34, 34, 34, 0.87);
    font-size: 12px !important;
    font-weight: 700;
    text-align: center;
    transform: scaleX(1.0029)
}

.ui-datepicker-year {
    border-radius: 2px;
    width: 61px !important;
    height: 22px;
    border: none !important;
    font-family: Open Sans !important;
    color: #fff;
    font-size: 14px !important;
    font-weight: 600;
    text-align: left;
    vertical-align: text-top;
}

.openemr-calendar .ui-datepicker-year {
    font-family: Open Sans, Arial, sans-serif;
    color: rgba(34, 34, 34, 0.87);
    font-size: 12px !important;
    font-weight: 700;
    text-align: center;
    transform: scaleX(1.0029)
}

.ui-datepicker-month option,
.ui-datepicker-year option {
    color: #3985a0 !important;
    background-color: #fff !important;
    font-family: Open Sans !important;
    font-size: 14px !important;
    font-weight: 600;
}

.ui-datepicker-month option[selected],
.ui-datepicker-year option[selected] {
    background-color: #e5edf0 !important;
}

.ui-datepicker .ui-state-hover {
    /*background: none !important;*/
    border: 0 !important;
}

.ui-datepicker td {
    vertical-align: top;
    background: #2944560a;
    border: 2px solid #2944560a;
}

.ui-datepicker .ui-state-default {
    border-radius: 2px;
    border-color: #edebeb !important;
/*     background: white !important; */
    width: 24px;
    height: 24px;
    padding: 0 !important;
    line-height: 24px;
    text-align: center !important;
    font-family: Open Sans, Arial, sans-serif;
    color: #707070;
    font-size: 13px;
    font-weight: 400 !important;
    margin: 7px 0 0 4px;
}

.ui-datepicker .ui-state-default.ui-state-highlight{
    border-color: #dcdcdc;
    background-color: #cff3f8 !important;
    color: #3e9aba !important;
}

.openemr-calendar .ui-state-default {
    font-size: 10px;
    margin: 0;
}

.ui-datepicker td {
    width: 33px;
}

.openemr-calendar .ui-datepicker td {
    width: 26px;
}

.openemr-calendar .ui-state-default {
    width: 26px;
    height: 20px;
    line-height: 20px;
}
.ui-state-default.ui-state-hover {
    border-color: #dcdcdc;
    background-color: #cff3f8 !important;
}

.ui-datepicker .ui-state-active {
    border-color: #dcdcdc;
    background-color: #cff3f8 !important;
    color: #3e9aba !important;
} 

.ui-datepicker-calendar thead tr th {
    font-family: Open Sans, Arial, sans-serif;
    font-size: 12px;
    font-weight: 400;
    padding: 0.45em 0.3em !important;
    /*   width: 15px !important; */
}

.openemr-calendar .ui-datepicker-calendar thead tr th {
    font-size: 10px;
}

.ui-datepicker-close {
    display: none;
}

.ui-datepicker thead {
    background-color: #f5f5f5;
}

.openemr-calendar .ui-datepicker thead {
    background: none;
}

.ui-state-default.ui-datepicker-current {
    float: none !important;
    font-family: Open Sans, Arial, sans-serif;
    color: #fff;
    font-size: 14px;
    font-weight: 400;
    text-align: left;
    border-width: 0 !important;
    border: none;
    vertical-align: top;
    margin: 0 !important;
    background-color: transparent !important;
}

.ui-datepicker-buttonpane.ui-widget-content {
    text-align: center;
    background-color: #3e9aba;
    margin: 0 !important;
    height: 28px;
    padding: 0 !important;
}

.openemr-calendar .ui-datepicker-year {
    background-color: transparent;
}

.openemr-calendar .ui-datepicker-month {
    background-color: transparent;
}

.openemr-calendar .ui-state-default {
    border: 0 !important;
}

.openemr-calendar .ui-datepicker-month {
    margin-right: 10px !important;
}


  </style>
<?php require '../layout/footer.php'; ?>