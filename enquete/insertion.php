<?php

require '../db/db.php';

if (isset($_POST['done'])) {
    $mission_id = $_POST['info'];
   $now = date("Y-m-d H:i:s");

       $sql = 'INSERT INTO enquete(mission_id,created_at) VALUES(:mission_id,:created_at)';
        $statement = $connection->prepare($sql);
        $statement->execute(array(':mission_id' => $mission_id,':created_at' => $now));  
  
        return true;
}
