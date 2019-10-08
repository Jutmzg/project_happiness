<?php
require '../db/db.php';
$sql = 'SELECT * FROM job';
$statement = $connection->prepare($sql);
$statement->execute();
$jobs = $statement->fetchAll(PDO::FETCH_OBJ);

?>
<?php require '../layout/header.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Métiers</h2>
      <a href="/Akkappiness/job/create.php"><button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i></button></a>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Action</th>
          </tr>
        </thead>
        <?php foreach ($jobs as $job) : ?>
          <tr>
            <td data-label="Nom"><?= $job->name; ?></td>
            <td data-label="Action">
              <a href="edit.php?id=<?= $job->ID ?>" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
              <a onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')" href="delete.php?id=<?= $job->ID ?>" class='btn btn-danger'><i class="fas fa-trash-alt"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>
<?php require '../layout/footer.php'; ?>