<?php
require '../db/db.php';
$sql = "SELECT m.ID, m.name mission,c.name customer, CONCAT(cons.firstname,' ', cons.lastname) as consultant, j.name job, m.start, m.stop, m.state FROM mission m
LEFT JOIN consultant cons ON m.consultant_id = cons.ID
INNER JOIN customer c ON m.customer_id = c.ID
INNER JOIN job j ON m.job_id = j.ID
WHERE m.state = 0";
$statement = $connection->prepare($sql);
$statement->execute();
$mission = $statement->fetchAll(PDO::FETCH_OBJ);

?>
<?php require '../layout/header.php'; ?>

<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Missions</h2>
      <a href="/Akkappiness/mission/create.php"><button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i></button></a>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Mission</th>
              <th>Client</th>
              <th>Consultant</th>
              <th>Poste</th>
              <th>Début de la mission</th>
              <th>Fin de la mission</th>
              <th>Action</th>
            </tr>
          </thead>
          <?php foreach ($mission as $row) : ?>
            <tr>
              <td data-label="Mission"><?= $row->mission; ?></td>
              <td data-label="Client"><?= $row->customer; ?></td>
              <td data-label="Consultant"><?= $row->consultant; ?></td>
              <td data-label="Poste"><?= $row->job; ?></td>
              <td data-label="Début de la mission"><?= date("d/m/Y", strtotime($row->start)); ?></td>
              <td data-label="Fin de la mission"><?= date("d/m/Y", strtotime($row->stop)); ?></td>
              <td data-label="Action">
                <a href="edit.php?id=<?= $row->ID ?>" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
                <a onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')" href="delete.php?id=<?= $row->ID ?>" class='btn btn-danger '><i class="fas fa-trash-alt"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</div>


<?php require '../layout/footer.php'; ?>