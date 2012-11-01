<?php
session_start();

$get_page= null;
$titre= null;
$dir='pages';
$layout='layout';

//Initialisation des sessions
if (!isset($_SESSION['login']))
    $_SESSION['login'] = false;


//Systeme de pagination
if (!isset($_GET["page"])) {
    $_GET["page"] = "accueil";
}
$get_page = $_GET['page'];
$titre = titre_page($get_page);



//Controle si la page est existante
if (!file_exists(CORE.DS.$dir.DS. $get_page . ".php")) {
    $_GET['page'] = "erreur";
}
//Controle entre site et admnistration
if($titre=='Administration' && isset($_SESSION['MaitreJeu'])){

        $dir='adm';
        $_GET["page"]= $get_page;
        $layout='layout_admin';
        if (!file_exists(CORE.DS.$dir.DS. $_GET["page"]. ".php")) {
        $get_page = "erreur";
        }

}

//Controle entre site et boutique
if($titre=='Boutique'){

        $dir='boutique';
        $_GET["page"]= $get_page;
        $layout='layout_boutique';
        if (!file_exists(CORE.DS.$dir.DS. $_GET["page"]. ".php")) {
        $get_page = "erreur";
        }
}
//Controle entre site et gestionnaire de dev
if($titre=='dev'){
    
        $dir='developpement';
        $_GET["page"]= $get_page;
        $layout='layout_dev';
        if (!file_exists(CORE.DS.$dir.DS. $_GET["page"]. ".php")) {
        $get_page = "erreur";
        }
}

//Redirection en cas d'erreur
if ($titre != "erreur") {
    $page = CORE.DS.$dir.DS.$get_page . '.php';
}
//Redirection sans adresse
else {
    $page = CORE.DS.$dir.DS.'news.php';
    $get_page = 'accueil';
    $titre = 'Accueil';
}

ob_start();
require CORE.DS.'includes'.DS.'menu_nav.php'; 
$menuNavSite = ob_get_contents();
ob_end_clean();

//Stoquage du contenu des pages
ob_start();
require CORE.DS.$dir.DS.htmlspecialchars($_GET['page']).".php";
$contenu = ob_get_contents();
ob_end_clean();
?>