<?php
require_once('config.php');
$dsn = "mysql:host=$host;dbname=$bdd";
$username = $username;
$password = $password;
$options = [];
try {
$connection = new PDO($dsn, $username, $password, $options);
return $connection;

} catch(PDOException $e) {
}