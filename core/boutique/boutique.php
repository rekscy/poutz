
<div id="content_boutique" style="width: 620px;">
<fieldset>
<?php 

$compte =  $_SESSION['id'];

$req = $DB->prepare("SELECT COUNT(*)FROM `shop_panier` WHERE `idUser` = '$compte' ");
$req->execute();
$nbrAchatsPanier = $req->fetchColumn();

$req->closeCursor();

if ($nbrAchatsPanier>0){ ?> 
    <fieldset style="padding: 3px; background: #190a08;">
    <legend> Panier</legend>
    <p>Votre panier contient actuelment <a href="index.php?page=panier"><?php echo $nbrAchatsPanier; ?> article<?php if ($nbrAchatsPanier>1){echo 's';} ?>  </a></p>
    
    </fieldset>
<?php } ?> 
    
    <fieldset>
        <p>La boutique est actuellement pariellement disponible, vous pouvez utiliser l'intégralité des articles de type service. 
            En ce qui concenrne le reste de la boutique elle est toujours en cours de construction et devrait arriver dans pas longtemps.</p>
        <img style="margin: auto; opacity:0.5;" src="template/img/boutique/construction.png" alt="En construction"/>
    </fieldset>
</fieldset>
</div>