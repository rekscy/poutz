<div id="nav">
    <ul id="menu">
        <li>
            <a style="margin-left:15px;">Serveur</a>
            <div class="menu-conteneur-1" style="margin-left:15px;">
                <div class="colonne-1">
                    <ul>
                        <li class=inter-calaire>
                        </li>
                        <?php if(isset($_SESSION['MaitreJeu'])): ?>
                        <li>
                            <a style =" color: greenyellow;" href="index.php?page=admin">Administration</a> 
                        </li>
                        <?php endif; ?>
                        <li>
                            <a href="index.php">Actualités</a>
                        </li>
                        <?php
                        if (!isset($_SESSION['name']) && !isset($_SESSION['accountLevel'])) { ?>
                            <li>
                                <a href="index.php?page=inscription">Inscription</a>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            <a href="index.php?page=statusServer">Informations</a>
                        </li>
                        <li>
                            <a href="index.php?page=rejoindre">Nous rejoindre</a>
                        </li>
                        <li>
                            <a href="index.php?page=staff">Le staff</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>	
        <li>
            <a style="margin-left:35px;">Communauté</a>
            <div class="menu-conteneur-1" style="margin-left:35px;">
                <div class="colonne-1">
                    <ul>
                        <li class=inter-calaire>
                        </li>
                        <li>
                            <a href="index.php?page=votes">Top-votes</a>
                        </li>
                        <li>
                            <a href="http://forum.rolkithan.fr">Forum</a>
                        </li>
                        <li>
                            <a href="index.php?page=gestTickets">Bug Tracker</a>
                        </li>
                        <li>
                            <a href="index.php?page=reglement">Réglement</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li style="margin-left:200px;"></li>
        <li>
            <a>Interactivité</a>
            <div class="menu-conteneur-1">
                <div class="colonne-1">
                    <ul>
                        <li class=inter-calaire>
                        </li>
                        <li>
                            <a href="index.php?page=rankGuild">Ranking de guildes</a>
                        </li>
                        <!--  <li>
                            <a href="index.php?page=rankPvp">Ranking PvP</a>
                        </li>-->
                        <li>
                            <a href="index.php?page=enLigne">Joueurs en ligne</a>
                        </li>
                        <li>
                            <a href="index.php?page=recups">Récupérations</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
        <li>
            <a href="index.php?page=boutique">Boutique</a>
        </li>
    </ul>
</div>
