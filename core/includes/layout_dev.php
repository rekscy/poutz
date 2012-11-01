<!DOCTYPE html>
<html>
    <head>
        <title>Gestionnaire de développement</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="Description" content="Serveur privé francophone du jeu World of Wracraft: Cataclysm, en 4.1.0 avec un émulateur très performant. Propulsé par la team Old-Scool.">
        <meta name="keywords" content="Rolkithan, rolkithan, rolkithan-project, rolk, serveur rolkithan, Bon serveur wow, PVP, Wrath of the lich king,Cataclysme, Cataclisme, francophone, Burning Crusade, wow, warcraft, serveur, server, naxxramas, trinity, mangos, northrend, full,
              sartharion, old-scool, rivage, anciens, malygos, script, world, gratuit, blizzlike, blizlike, rate, warcraft, prives, gratuit, top,
              mmorpg, jeux online, qualite, en ligne, jeu en ligne, francais, francais, belge, canadien, france, serveur prive WoW,
              serveur prive WoW, server, prive, WoW,serveur, prive, WoW World of Warcraft , top WoW, top, site, WoW, Tol Barad, joug, hiver">
        <meta name="Robots" content="all">
        <meta name="Url" content="http://www.rolkithan.fr/">
        <meta name="Version" content="1.1">
        <link href="template/css/developement.css" rel="stylesheet">
        <link href="template/css/jquery/jquery-ui-1.9.1.custom.css" rel="stylesheet">
        <link href="template/zoombox/zoombox.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="template/img/icone.png" type="image/png" rel="icon"/>
        <script src="template/js/jquery/jquery.js" type="text/javascript"></script>
        <script src="template/js/jquery/jquery-ui-1.9.1.custom.js" type="text/javascript"></script>
        <script src="template/js/carrousel.js" type="text/javascript"></script>
        <script type="text/javascript" src="template/zoombox/zoombox.js"></script>
        <script src="template/js/navigation.js" type="text/javascript"></script>
</head>
    <body>
    <?php echo $menuNavSite;?>
    <div id="mainContent">
        <div id="blockLeft">
        <div id="espaceDev">
            <div id="espaceNavDevUp">                
            </div>
            <div id="espaceNavDevMiddle">
                    <a class="linkNav" href="index.php?page=statusServer" >Avancée du serveur </a><br/>
                    <a class="linkNav" href="index.php?page=projetEnCours" >Projets en cours</a><br/>
                    <a class="linkNav" href="index.php?page=projetFuture" >Projets à venir </a><br/>
                    <a class="linkNav" href="index.php?page=gestTickets" >Bug-Tracker </a><br/>
                    <a class="linkNav" href="index.php?page=devReport">Liste des derniers débugs</a>
                    <a class="linkNav" href="index.php?page=suggestion" >Suggestions</a><br/>
                    <div class="clear"></div>
                </div>
                <div id="interface_produit_bottom">
                </div>
            </div>
            <div id="espaceDev">
                    <div id="espaceDevUp">                
                    </div>
                    <div id="espaceDevMiddle">
                            <?php
                                    $sql="SELECT * FROM dev_report ORDER BY id DESC LIMIT 0,6";   
                                    $req = $DB->prepare($sql);
                                    $req->execute();


                                    while ($d = $req->fetch(PDO::FETCH_OBJ)):
                            ?>

                        <div style=" background:  #0A0501; border: #080301 1px solid; margin-bottom: 3px; margin-left: 3px; padding: 1px; ">
                            <p><span style="color:#ffff00; font-size: 10px;"><?php echo getTypeDebug($d->type); ?></span><a style="font-weight: bold;" href="index.php?page=devReport#Post<?php echo $d->id; ?>"><?php echo $d->titre; ?></a></p>
                            <p style="color: #E5EFFD; padding-left: 5px; font-size: 9px;"><?php echo chaineLimitee($d->content,6); ?></p>
                        </div>

                            <?php endwhile; ?>
                        <a style="float:right; font-size: 9px;" href="index.php?page=devReport">Plus de débugs...</a>
                    </div>
                </div>
            </div>
        <div id="blockRight">
            <?php echo $contenu;?>
        </div>
        <div class="clear"></div>
    </div>
    </body>
</html>