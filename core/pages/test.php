<div id="erreur" class="news">
    <?php header("HTTP/1.0 404 Not Found"); ?>
    <div class="headNews"> 
        <span> Une erreur est sourvenue...</span>
    </div>
    <div class="middleNews">
        <div class="corpNews">
            <?php 
            
            
$query= $DB->query("SELECT value FROM config WHERE name='link3'");
$d=$query->fetch();
$link3=$d[0];
echo  time();
            
            ?>
        </div>
        <div class="footNews">
            <a class="linkNews" href="<?php echo BASE_URL ?>">Revenir à la page d'accueil</a>
        </div>                            
    </div>
</div>