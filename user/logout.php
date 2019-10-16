<?php

session_start();

unset($_SESSION['login']);

$_SESSION['flash']['success'] = 'Vous êtes maintenant déconnecté(e)';

session_destroy ();

header ('location: login.php');
?>