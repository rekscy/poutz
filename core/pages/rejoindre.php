<div id="NousRejoindre" class="news">
            <div class="headNews"> 
                <span>Nous rejoindre</span>
            </div>
    <div class="middleNews">

<!--       <img src="template/img/nousRejoindre.jpg" alt="" style="float: right"/>-->
       <p  class="contentForme"><br/>Rejoindre notre communauté c'est posible pour tous, pour ce faire il vous suffis de creer un compte
            <a href="index.php?page=inscription"> <font><em>ici</em></font></a> ainsi que telecharger le jeu sur le site officiel.<br/><br/>

            Bien pour  commencer, il vous faut un jeu World of Warcraft en version 4.1.0 (ou 4.0.6)!
            Si vous n'avez pas encore le jeu à cette version, vous pouvez le télécharger avec le downloader officiel.<br/><br/>

            Une fois que vous aurez le client World of Warcraft, vous pouvez télécharger le <a href="http://download.rolkithan.fr/Rolkithan-WoW.exe" > patch Rolkithan-project </a>qui vous sera utile pour le lancement du jeu!
            Veuillez donc le placer dans  le dossier où se trouve votre jeu, dans le même dossier que le WoW.exe .<br/><br/>

            La prochaine étape consiste à modifier le realmlist de votre jeu.
            Votre fichier realmlist.wtf à modifier se trouve dans le dossier Data/fr de votre jeu. Ouvrez le avec votre bloc-note et remplacez son contenu par:<br/>
            <font color="#d3d3d3"><em> 
<?php
$query= $DB->query("SELECT value FROM config WHERE name='realmlist'");
$d=$query->fetch();
$realmlist=$d[0]; 

echo $realmlist;
?>
            
            </em></font>
            <br/>
            <br/>

            Une fois que c'est fait, vous n'avez plus qu'à lancer votre jeu en cliquant sur votre Rolkitan-WoW.exe!<br/><br/>

            N'hésitez pas à, créer un raccourci pour votre bureau.<br/><br/><br/><br/><br/><br/>

            <font color="#b2180c">Attention:</font> Si vous lancez le jeu avec le WoW.exe ou l'ancien raccourci, vous ne pourrez pas rejoindre les serveurs de Rolkithan-Project !<br/><br/>
       
            
       </p>
            
    </div>
</div>