<?php

if(isset($_GET['idCategorie']) || isset($_GET['idSousCategorie'])) {
 
    $json = array();
     
    if(isset($_GET['idCategorie'])) {
        // requête qui récupère les régions
        $requete = "SELECT id, nom FROM categories ORDER BY nom";
    } else if(isset($_GET['idSousCategorie'])) {
        $id = htmlentities(intval($_GET['idSousCategorie']));
        // requête qui récupère les départements selon la région
        $requete = "SELECT id, nom FROM taches WHERE categorie = ". $id ." ORDER BY nom";
    }
     
    // connexion à la base de données
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=dev_rolsite', 'root', '');
    } catch(Exception $e) {
        exit('Impossible de se connecter à la base de données.');
    }
    // exécution de la requête
    $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));
     
    // résultats
    while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {
        // je remplis un tableau et mettant l'id en index (que ce soit pour les régions ou les départements)
        $json[$donnees['id']][] = utf8_encode($donnees['nom']);
    }
     
    // envoi du résultat au success
    echo json_encode($json);
}
?>
