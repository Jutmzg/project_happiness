<?php

function getAllJobs(){
    include 'connection.php';
    $sql2 = 'SELECT * FROM job ORDER BY name';
    $statement = $connection->query($sql2);
    $statement->execute();
    $jobs = $statement->fetchAll(PDO::FETCH_OBJ);
    return $jobs;
}

function managerName(){
    include 'connection.php';
    $sql = 'SELECT firstname, lastname FROM manager';
    $statement = $connection->prepare($sql);
    $statement->execute();
    $statement->fetch(PDO::FETCH_OBJ);
}