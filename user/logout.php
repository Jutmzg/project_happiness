<?php
// On démarre la session
session_start ();


// On détruit notre session
session_destroy ();

echo 'Vous avez été déconnecté';
// On redirige le visiteur vers la page d'accueil
header ('location: user/login.php');
?>