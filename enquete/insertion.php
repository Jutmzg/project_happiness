<?php

require '../db/db.php';
if (isset($_POST['done'])) {

    $name = $_POST['name'];
    var_dump($name);

    $sql = 'INSERT INTO job(name) VALUES(:name)';
    $statement = $connection->prepare($sql);
    $statement->execute([':name' => $name]);
    exit;
}
/* if (isset($_POST['display'])) {
    $sql = "SELECT * FROM job";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $jobs = $statement->fetchAll(PDO::FETCH_OBJ);
    foreach ($jobs as $job) { ?>
        <p><?= $job->name?></p>
  <?php  } ?>
    <?php exit;
}


*/

/* $names = ["jean", "pierre"];

foreach($names as $name){
    $sql = 'INSERT INTO job(name) VALUES(:name)';
  $statement = $connection->prepare($sql);
  if($statement->execute([':name' => $name])) {
    header('Location: ../home/index.php');
  }
} */
