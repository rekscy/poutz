<?php

//Informations DB local
$host_db = 'localhost';
$user_db = 'root';
$pass_db = "";
$port_db = '3306';


// Affiche les erreurs
// ini_set('display_errors', 1);

//Informations distantes de serveur jeux
$host_db = 'localhost';
$port_db = '3306';


//Informations distantes de serveur jeux
$host_db_dist = 'rolkithan.fr';




//Informations users
//$user_db = 'rol_site';
//$pass_db = "C1@GasS678syf7@d98@swW@m";
//
//$user_db_realm = 'rol_ark';
//$pass_db_realm = "Ce1Pa!";
//
//$user_db_world = 'rol_ark';
//$pass_db_world = "Ce1Pa!";
//
//$user_db_char = 'rol_ark';
//$pass_db_char = "Ce1Pa!";


//Informations Emulateur
//$realmd = 'rol_realm';
//$characters = 'rol_char';
//$world = 'rol_world';
//$site = 'rol_site';

$realmd = 'dev_auth';
$characters = 'dev_char';
$world = 'arkdb';
$site = 'dev_rolSite';

try {
    
//LOCAL
    $REALM = new PDO('mysql:host=' . $host_db . ';port=' . $port_db . ';dbname=' . $realmd, $user_db, $pass_db, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $CHARS = new PDO('mysql:host=' . $host_db . ';port=' . $port_db . ';dbname=' . $characters, $user_db, $pass_db, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $WORLD = new PDO('mysql:host=' . $host_db . ';port=' . $port_db . ';dbname=' . $world, $user_db, $pass_db, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $DB = new PDO('mysql:host=' . $host_db . ';port=' . $port_db . ';dbname=' . $site, $user_db, $pass_db, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

//Serveur
//    $REALM = new PDO('mysql:host=' . $host_db . ';port=' . $port_db . ';dbname=' . $realmd, $user_db_realm, $pass_db_realm, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
//    $CHARS = new PDO('mysql:host=' . $host_db . ';port=' . $port_db . ';dbname=' . $characters, $user_db_char, $pass_db_char, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
//    $WORLD = new PDO('mysql:host=' . $host_db . ';port=' . $port_db . ';dbname=' . $world, $user_db_world, $pass_db_world, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
//    $DB = new PDO('mysql:host=' . $host_db . ';port=' . $port_db . ';dbname=' . $site, $user_db, $pass_db, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
//
//    
    $REALM->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $CHARS->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $WORLD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
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
