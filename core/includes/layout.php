<!DOCTYPE html>
<html>
    <head>
        <title>Rolkithan Server 4.06 WoW Cataclysm Serveur privé GRATUIT</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="Description" content="Rolkithan est un serveur privé francophone du jeu World of Wracraft: Cataclysm, en version 4.0.6 avec un émulateur très performant et une équipe trés active et compétante.Les Raids blizzLike avec des stratégies sont disponibles.">
        <meta name="keywords" content="Rolkithan, Raids scripés, BlizzLike,Cataclysme, Cataclisme, francophone, Burning Crusade, wow, warcraft, serveur, server, naxxramas, trinity, mangos, northrend, full,
              sartharion, old-scool, rivage, anciens, malygos, script, world, gratuit, blizzlike, blizlike, rate, warcraft, prives, gratuit, top,
              mmorpg, jeux online, qualite, en ligne, jeu en ligne, francais, francais, belge, canadien, france, serveur prive WoW,
              serveur prive WoW, server, prive, WoW,serveur, prive, WoW World of Warcraft , top WoW, top, site, WoW, Tol Barad, joug, hiver,
              maj, dalaran, oeil, cyclone, alterac, t7, t8, t9,t10, t11, t12, stuff, officiel, fun, kikoo, roxx, roxxor, gratos, kaldorei,
              ah honor, Eternity Paradize, eternity, paradize, bhaal, bloody, moon, millenium, férial, nemesis, root, top, renaissance,
              britania, pulse-gaming, darluok, arcmemu, ascent, aspire dev, trinity, core, emu, db, database, kobold, wowemu, silvermoon,
              udb, cheat, ddos, linux, windows, macs, microsoft, google, avast, ebay, idiot, frostmount, itone, navicat, sqlyog, gold,
              seven, murloc,3.3.5, 4.1.0,4.2.0, Skyfire, CTDB, server, semi-blizz, plaisir de jeu, Old-school wow, old-scool, serveur old-school, serveur rates modérés, wow modéré,
              commandes mj, comment faire un serveur, rexy, Trillenium, Dbc, MAps, Vmaps">
        <meta name="Robots" content="all">
        <meta name="Url" content="http://www.rolkithan.fr/">
        <meta name="Version" content="1.1">
        <link href="template/css/default.css" rel="stylesheet">
        <link href="template/img/icone.png" type="image/png" rel="icon"/>
        <link href="template/zoombox/zoombox.css" rel="stylesheet" type="text/css" media="screen" />
<!--        <script id="facebook-jssdk" src="//connect.facebook.net/fr_FR/all.js#xfbml=1"></script>-->
        <script src="template/js/jquery/jquery.js" type="text/javascript"></script>
        
        <script src="template/js/carrousel.js" type="text/javascript"></script>
        <script type="text/javascript" src="template/zoombox/zoombox.js"></script>
    </head>
    <body>
    <?php echo $menuNavSite;?>
    <div id="mainContent">
        <div id="contentUp">
            <div id="contentLeft">
            <!-- Début du Carrousel -->        
            <div id="caroussel" class="formContent">
<?php   
    $sql= " SELECT * from `slides` ORDER BY id ASC " ;
    $req = $DB->prepare($sql);
    $req->execute();

while ($d = $req->fetch(PDO::FETCH_OBJ)): ?>

                <div id=slide<?php echo $d->id; ?> class="slide">
                    <div class="vision">
                         <img src="template/img/slide/<?php echo $d->url; ?>" alt=""/>
                    </div>
                        <div class="titre"><?php echo $d->description; ?></div>
               </div>

<?php endwhile; ?>

            </div>
            <!-- Fin du carrrousel -->
                <div id="slide">

                </div>
                <div id="newsContent">
                    <?php echo $contenu; ?>
                </div>
            </div>
            <div id="contentRight">
                <div id="account">
                    <div id="accountUp">                
                    </div>
                    <div id="accountMiddle">
                        <?php if(isset($_SESSION['name']) && isset($_SESSION['accountLevel'])){ ?>
                            <div class="menuMembre">
                            <p class="simpleContent">Bienvenu <?php echo $_SESSION['name']; ?>! <br/>
                                Vous avez actuellement <?php echo getShopPoints($_SESSION['id'], $DB); ?> points R</p>
                                <div class="linksMembre">

                                    <?php if(isset($_SESSION['MaitreJeu'])): ?>
                                    <a class="bouton" style =" color: greenyellow;" href="index.php?page=admin">Administration</a> 
                                    <?php endif; ?>
                                    <a class="bouton" href="index.php?page=membre">Espace membre</a> 
                                    <a class="bouton" href="index.php?page=achatPoints">Achat de points</a> 
                                    <a class="bouton"href="index.php?page=votes">Voter</a> 
                                    <a class="bouton"href="index.php?page=deconnexion">Déconnexion</a> 
                                </div>
                            </div>    

                      <?php  }else{ ?>
                        <form action="index.php?page=connexion" method="post">
                            <input  style="margin-top: 3px;" class="champ" value="Pseudonyme" onFocus="if (this.value=='Pseudonyme') {this.value=''}" type="text" name="pseudo">
                            <input  class="champ" value="Password" onFocus="if (this.value=='Password') {this.value=''}" type="password" name="pass">

                            <input type="submit" id="send" value=""><a id="signMe" href="index.php?page=inscription"></a>

                        </form>
                      <?php }?>
                    </div>
                </div>
                <div id="status">
                    <div id="statusUp">                
                    </div>
                    <div id="statusMiddle">
                        <form action="index.php" method="post">
                            <span class="textStatut" style="font-size: 12px; margin-left: 13px;">Authentification: <?php  echo serveur_online('rolkithan.fr',3724)==true?"<font color='green'>En ligne</font>":"<font color='darkred'>Hors ligne</font>";?></span>
                            <span class="textStatut" style="font-size: 12px; margin-left: 5px;">Zircon: <?php  echo serveur_online('rolkithan.fr',8085)==true?"<font color='green'>En ligne</font>":"<font color='darkred'>Hors ligne</font>";?></span>


                            <?php $query= $DB->query("SELECT value FROM config WHERE name='realmlist'");
                                                            $d=$query->fetch();
                                                            $realmlist=$d[0]; ?>
                            <input onclick="this.focus(); this.select();"  class="champ" value="<?php echo $realmlist; ?>" type="text" readonly/>
                            <span class="textStatut" style="font-size: 12px;">Serveur TeamSpeak:  <?php  echo serveur_online('rolkithan.fr',10011)==true?"<font color='green'>Online</font>":"<font color='darkred'>Offline</font>";?></span>
                                <?php $query= $DB->query("SELECT value FROM config WHERE name='ts'");
                                $d=$query->fetch();
                                $ts=$d[0]; ?>
                            <input onclick="this.focus(); this.select();"  class="champ" value="<?php echo $ts; ?>" type="text" readonly/>
                        </form>
                    </div>
                </div>
                <div id="trailer">
                    <div id="trailerUp">                
                    </div>
                    <div id="trailerMiddle">
                        <iframe width="276" height="140" src="<?php echo LINK_YOUTUBE;?>" frameborder="0" allowfullscreen></iframe>
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
            <div class="clear"></div>
        </div>
         <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <div id="footer">
    </div>
    </body>
</html>