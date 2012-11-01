
<div id="content_boutique" style="width: 620px;">
<fieldset>
  <legend>Votre panier</legend>
  
 <?php 
 
  if(isset($_GET['achat'])&& is_numeric($_GET['achat'])){
    $idUser = $_SESSION['id'];
  
    $pointsDisponibles= getShopPoints($idUser, $DB);
    
    $req = $DB->prepare("SELECT * FROM `shop_panier` WHERE `idUser` = '$idUser' ");
    $req->execute();

    while ($d = $req->fetch(PDO::FETCH_OBJ)):
        
        if($pointsDisponibles-$d->prix>0){ //verifie si assez de points
           
           if(!isOnline($CHARS,$d->characterGuid)){
           $pointsDisponibles = $pointsDisponibles-$d->prix; //Débite le prix pour l'item dans la boucle
           
           traitementAchatArticle($DB, $CHARS, $d->articleId, $d->characterGuid); //Traite l'ajout de l'article sur le personnage concerné
           
           enlevePoints($DB, $idUser, $d->prix); //débite le prix de cet Item au joueur
           
           enregistrementDebitHistorique($DB, $d->articleId, $d->prix, $d->characterGuid, 0);//Enregistre l'article dans l'historique d'achat ****0=promo****
           
           deleteArticlePanier($DB, $d->id); //Suprime l'article du panier
           }else{
               $erreur= "<span style='color:red;'>Veuillez déconnecter vos personages du jeu</span>";
           }
        }else{
             header('Location: index.php?page=panier');
        }          
    endwhile;
    if(isset($erreur)){
        
        echo $erreur;
        
    }else{
         header('Location: index.php?page=panier');
    }
    
  }
 
 if(isset($_GET['deleteArticle'])&& is_numeric($_GET['deleteArticle'])){
    $article=$_GET['deleteArticle'];
    
    $req = $DB->prepare("SELECT * FROM `shop_panier` WHERE `id` = '$article' ");
    $req->execute();
    $d = $req->fetch(PDO::FETCH_OBJ);
    
    if($d->idUser==$_SESSION['id']){
        
        deleteArticlePanier($DB, $article);
        header('Location: index.php?page=panier');
        
    }else{
         header('Location: index.php?page=panier');
    } 
 }
 
$compte =  $_SESSION['id'];
$prixTotal= 0;

$req = $DB->prepare("SELECT COUNT(*)FROM `shop_panier` WHERE `idUser` = '$compte' ");
$req->execute();
$nbrAchatsPanier = $req->fetchColumn();

$req->closeCursor();

  if ($nbrAchatsPanier>0){ ?>
 <fieldset style="padding: 3px; background: #190a08;">
    <legend>Contenu</legend>
    <table style=" padding: 5px; width: 500px;  margin: auto;">
        <thead style="color: #FFBD69; font-weight: bold; border-bottom: 1px solid #FFF; ">
            <tr>
                <td></td>
                <td>Nom d'article</td>
                <td>Personnage</td>
                <td>Prix</td>
                <td>Effacer</td>
            </tr>
        </thead>
        <tbody>

    <?php
    $points=  getShopPoints($_SESSION['id'], $DB);
    $compte =  $_SESSION['id'];
    $i= 1;
    
    $req = $DB->prepare("SELECT * FROM `shop_panier` WHERE `idUser` = '$compte' ");
    $req->execute();

    while ($d = $req->fetch(PDO::FETCH_OBJ)): 
        ?>
        <tr style="border: #FFF solid 1px;">
            <td><?php echo $i++; ?></td>
            <td style="font-size: 11px;"><?php $e = getInformationArticle($DB, $d->articleId); ?>
                <span style="color: gold; font-weight: bold; font-size: 12px;"><?php echo getTypeService($DB, $e->type);?></span>
                <?php $e->label;echo $e->label; ?></td>
            
            <td><?php echo getNameGuid($CHARS, $d->characterGuid); ?></td>
            <td><?php echo $d->prix; 
            $prixTotal= $prixTotal + $d->prix;?></td>
            <td><a href="index.php?page=panier&&deleteArticle=<?php echo $d->id; ?>">Supprimer</a></td>
            
            
        </tr>
     <?php endwhile; ?>
        </tbody>
    </table>
</fieldset>
   <fieldset style="padding: 3px; background:  #0f0805;">
    <legend>Achat des articles</legend>
    <div style="width: 300px;  min-height:100px; display: block; float: right; padding: 20px; text-align: right;">
        
        <p><span style="color: #967332;">Prix total de <?php echo $nbrAchatsPanier; ?> article<?php if ($nbrAchatsPanier>1){echo 's';} ?>: </span>
        <?php echo $prixTotal; ?> Points R </p>
        <p><span style="color: #967332;">Nombre de points disponibles: </span>
        <?php echo getShopPoints($_SESSION['id'], $DB); ?> Points R </p>
        
        <hr style="color: #967332;"/>
        
        <?php if(($points-$prixTotal)>0){ ?>
             <p><span style="color: #FFBD69;">Il vous restera:  <?php echo $points-$prixTotal?> Points R</span></p><br/>
             <p><a href="index.php?page=panier&&achat=1"style="font-size: 13px; color: #FFF; ">Effectuer l'achat</a></p>
             <p style="font-size: 9px; color: #e88e00;">*Assurez vous qu'aucun de vos personnages ne soit connecté en jeu au moment de votre achat, dans le cas contraire nous déclinerons toute responsabilité en cas de probléme.</p>
             <p style="font-size: 9px; color: gold">*L'achat des différents articles est iréversible, aucun échange ou remboursement ne sera fait en cas d'erreur de votre part.</p>
             <p style="font-size: 9px;">*Vos ne pouvez acheter qu'une seule amélioaration à la fois sur un même personnage (changement de race, faction etc..), en cas de mauvaise usage nous ne vous rembourserons aucun point.</p>
        <?php } else{ ?>
             <p><span style="color: darkred; font-size: 10px;">Vous n'avez pas asssez de Points R pour finaliser cet achat.</span> 
             <p><a href="index.php?page=achatPoints"style="font-size: 11px; ">Acheter plus de Points R</a></p>
        <?php } ?> 
    </div>
    <div class="clear"></div>
        
    </fieldset>
  
<?php }else{ ?>
    <p> Votre panier est vide pour le moment</p> 
<?php } ?>
    
</fieldset>
</div>