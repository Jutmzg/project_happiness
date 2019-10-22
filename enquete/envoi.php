<?php

require '../connection.php';

if (isset($_POST['done'])) {
    $enquete_id = $_POST['info'];

       $sql = 'INSERT INTO enquete(mission_id,created_at) VALUES(:mission_id,:created_at)';
        $statement = $connection->prepare($sql);
        $statement->execute(array(':enquete_id' => $enquete_id));  
  
        return true;
}