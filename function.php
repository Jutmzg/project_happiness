<?php
require_once '../connection.php';

function login(){
    
    $sql = 'SELECT mail FROM user';
    $statement = $connection->prepare($sql);
    $statement->execute();
    $statement->fetch(PDO::FETCH_OBJ);
}

function managerName(){
    $sql = 'SELECT firstname, lastname FROM manager';
    $statement = $connection->prepare($sql);
    $statement->execute();
    $statement->fetch(PDO::FETCH_OBJ);
}