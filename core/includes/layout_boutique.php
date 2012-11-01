<!DOCTYPE html>
<html>
    <head>
        <title>Rolkithan server 4.0.6 WoW Cataclysm Serveur privé GRATUIT</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="Description" content="Serveur privé francophone du jeu World of Wracraft: Cataclysm, en 4.1.0 avec un émulateur très performant. Propulsé par la team Old-Scool.">
        <meta name="keywords" content="Rolkithan, rolkithan, rolkithan-project, rolk, serveur rolkithan, Bon serveur wow, PVP, Wrath of the lich king,Cataclysme, Cataclisme, francophone, Burning Crusade, wow, warcraft, serveur, server, naxxramas, trinity, mangos, northrend, full,
              sartharion, old-scool, rivage, anciens, malygos, script, world, gratuit, blizzlike, blizlike, rate, warcraft, prives, gratuit, top,
              mmorpg, jeux online, qualite, en ligne, jeu en ligne, francais, francais, belge, canadien, france, serveur prive WoW,
              serveur prive WoW, server, prive, WoW,serveur, prive, WoW World of Warcraft , top WoW, top, site, WoW, Tol Barad, joug, hiver">
        <meta name="Robots" content="all">
        <meta name="Url" content="http://www.rolkithan.fr/">
        <meta name="Version" content="1.1">
        <link href="template/css/boutique.css" rel="stylesheet">
        <link href="template/zoombox/zoombox.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="template/img/icone.png" type="image/png" rel="icon"/>
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>-->
        <script src="template/js/carrousel.js" type="text/javascript"></script>
        <script type="text/javascript" src="template/zoombox/zoombox.js"></script>
        <script src="template/js/navigation.js" type="text/javascript"></script>
    </head>
    <body>
    <?php echo $menuNavSite;?>
    <div id="mainContent">
        <div id="blockLeft">
            <div id="interface_compte">
                <div class="lienProduit">

                    <p>Bonjour <?php echo getMainPerso($CHARS, $DB, $_SESSION['id']);  ?> <br/>
                       Vous disposez de  <?php echo getShopPoints($_SESSION['id'], $DB);  

                       $compte= $_SESSION['id'];
                       $req = $DB->prepare("SELECT COUNT(*)FROM `shop_panier` WHERE `idUser` = '$compte' ");
                        $req->execute();
                        $nbrAchatsPanier = $req->fetchColumn();

                       ?> Points R
                    </p>
                    <p style="color: #ef9137;">Votre panier contient <?php echo $nbrAchatsPanier;  ?> article<?php if($nbrAchatsPanier != 1){ echo 's';}  ?> </p>

                    <a href="index.php?page=votes" >Voter </a><br/>
                    <a href="index.php?page=achatPoints" >Acheter plus de Points R </a><br/>
                    <a href="index.php?page=membre" >Gestion de compte </a><br/>
                    <a href="index.php?page=panier" >Voir mon panier </a><br/>
                    <a href="index.php?page=historiqueAchats" >Historique de mes achats </a><br/>
<!--                        <a href="index.php?page=support-boutique" >Support </a><br/>
                    <a href="index.php?page=faq-boutique" >F.A.Q. </a><br/>-->
                </div>
            </div>
            <div id="interface_service">
                <div class="lienProduit">
                    <a href="index.php?page=boutique-services&&action=1" >Modification du nom </a><br/>
                    <a href="index.php?page=boutique-services&&action=2" >Modification du nom & visuel </a><br/>
                    <a href="index.php?page=boutique-services&&action=3" >Changement de race </a><br/>
                    <a href="index.php?page=boutique-services&&action=4" >Changement de faction </a><br/>
                    <a href="index.php?page=boutique-services&&action=5" >Achat de piéces d’or </a><br/>
                    <a href="index.php?page=boutique-services&&action=6" >Achat de niveaux </a><br/>
<!--                        <a href="index.php?page=boutique-services&&action=7" >Achat d'un personnage 80</a><br/>-->
                </div>
            </div>
            <div id="interface_produit">
                <div id="interface_produit_haut">
                </div>
                <div id="interface_produit_middle">
                    <img style="margin-left: -4px;" src="template/img/bg_int_boutique_categories.png" title="Cette catégorie sera disponible prochainement!" alt="Bientot disponible!"/>
                </div>
                <div id="interface_produit_bottom">
                </div>
            </div>
        </div>
        <div id="blockRight">
            <div id="banniere">
                <div id="caroussel">
                <?php   
                        $sql= "SELECT * from `slides_boutique` ORDER BY id ASC" ;
                        $req = $DB->prepare($sql);
                        $req->execute();

                while ($d = $req->fetch(PDO::FETCH_OBJ)): ?>

                                    <div id=slide<?php echo $d->id; ?> class="slide">
                                        <div class="vision">
                                             <img src="template/img/slide_boutique/<?php echo $d->url; ?>" alt=""/>
                                        </div>
                                   </div>

                <?php endwhile; ?>

                </div>
            </div>
            <div id="boutique_rolkithan">
                <div id="boutique_rolkithan_top">
                </div>
                <div id="boutique_rolkithan_middle">
                    <?php echo $contenu; ?>
                </div>
                <div id="boutique_rolkithan_bottom">
                </div>
            </div> 
        </div> 
        <div id="footer">
        </div>
    </div>
    </body>
</html>