<?php
define("BASE_URL","/");  
define("ROOT_PATH",$_SERVER["DOCUMENT_ROOT"] . "/"); 

// nom du serveur
$host = 'localhost';

// nom de la base données 
$bdd = 'akkappiness';

// identifiant mySQL
$username = 'root';

// mot de passe mySQL
$password = '';

const EMAIL_HOST = 'smtp.live.com'; // http://project.akka.eu 
const EMAIL_PORT = 25;
const EMAIL_USERNAME = 'maxime.vasseur.79@hotmail.fr';
const EMAIL_PASSWORD = '26651bcbf';

 // EDITER LE MESSAGE RECU PAR MAIL
 const MESSAGE = "Dans le cadre de notre campagne d’enquête de satisfaction, merci de nous donner votre niveau de satisfaction de votre mission actuelle.
 En vous remerciant par avance";