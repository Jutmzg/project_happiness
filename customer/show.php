<?php
require '../db/db.php';
$sql = 'SELECT ID,name, address FROM customer WHERE state = 0';
$statement = $connection->prepare($sql);
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<?php require '../layout/header.php'; ?>
<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Clients</h2>
      <a href="/Akkappiness/customer/create.php"><button type="button" class="btn btn-primary"><i class="fas fa-user-plus"></i></button></a>
    </div>
    <div class="card-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Action</th>
          </tr>
        </thead>
        <?php foreach ($customers as $customer) : ?>
          <tr>
            <td data-label="Nom"><?= $customer->name; ?></td>
            <td data-label="Adresse"><?= $customer->address; ?></td>
            <td data-label="Action">
              <a href="edit.php?id=<?= $customer->ID ?>" class="btn btn-info"><i class="fas fa-user-edit fa-xs"></i></a>
              <a onclick="return confirm('Etes vous sur de vouloir effectuer la suppression?')" href="delete.php?id=<?= $customer->ID ?>" class='btn btn-danger'><i class="fas fa-trash-alt"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>
<?php require '../layout/footer.php'; ?>