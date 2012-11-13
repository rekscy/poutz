<?php

//Informations DB local
$host_db = 'localhost';
$user_db = 'root';
$pass_db = "";
$port_db = '3306';


// Affiche les erreurs
 ini_set('display_errors', 1);

//Informations distantes de serveur jeux
$host_db = 'localhost';
$port_db = '3306';


//Informations distantes de serveur jeux
$host_db_dist = 'localhost';




//Informations users
$user_db = 'rol_site';
$pass_db = "C1@GasS678syf7@d98@swW@m";
//


//Informations Emulateur
$realmd = 'rol_realm';
$characters = 'rol_char';
$world = 'rol_world';
$site = 'rol_site';

//config Rexy
//$realmd = 'dev_auth';
//$characters = 'dev_char';
//$world = 'arkdb';
//$site = 'dev_rolsite';

//Config Gaal
//$realmd = 'rol_realm';
//$characters = 'rol_char';
//$world = 'rol_world';
//$site = 'rol_site';

try {
    
 //$DB = new PDO('mysql:host=' . $host_db . ';port=' . $port_db . ';dbname=' . $site, $user_db, $pass_db, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

//Serveur
 $DB = new PDO('mysql:host=' . $host_db . ';port=' . $port_db . ';dbname=' . $site, $user_db, $pass_db, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (Exception $e) {
    
//    echo $e->getMessage();
    die("<div style='background: #030303; width: 100% height: 100%;';> <h4 style='color:orange;'>Site indisponible !!!</h1> </hr></div> <p color='#030303'>Le site est momentainement hors ligne, il est tres probable que ce soit du a une maintenance. Nous vous prions de nous en excuser.<br /> Veuillez s'il vous plait repasser plus tard.  </p> ");
}


//CHARGEMENT DE LA CONFIG

$req= $DB->query("SELECT * FROM config"); 
foreach ($req->fetchAll(PDO::FETCH_OBJ)as $array) {

//créé la liste des config du serveur
define($array->name,$array->value);
 }




?>
