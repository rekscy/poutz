
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
<?php 
}

if (isset($_GET['action'])&& is_numeric($_GET['action'])){   
    $action= getNameAction($_GET['action']);
    $idAction=$_GET['action'];
    
        if($action=='Aucun'){
            header('Location: index.php?page=boutique');
        }

        
        switch ($idAction){ //GERE LE CONTROLE DES CAS DE 1 A 6
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
        case 6:
        if (isset($_GET['keySec'])&&isset($_GET['guid'])&& is_numeric($_GET['guid'])) {

            $guid= $_GET['guid'];
            $keySecurity= $_GET['keySec'];
            
            $req = $CHARS->prepare("SELECT name FROM characters WHERE guid=$guid");
            $req->execute();
            $d= $req->fetch(PDO::FETCH_OBJ);
            
            $nameHash= sha1($d->name);
            
            if($nameHash!=$keySecurity){ //CONTROLE DU GET du personnage
              header('Location: index.php?page=boutique');
            }
            
            switch ($idAction){ //GERE LES ACTIONS DES CAS DE 1 A 6 
            
                case 1: 
                    $article=1; //changement de nom
                    
                    $guid= $_GET['guid'];
                    
                    addItemPanier($DB, $guid, $article );
                    header('Location: index.php?page=boutique');
                    
                break;   
                case 2:
                    $article=2; //changement de nom & visuel
                    
                    $guid= $_GET['guid'];
                    
                    addItemPanier($DB, $guid, $article );
                    header('Location: index.php?page=boutique');
                    
                break;
                case 3:
                    $article=3; //changement de race
                    
                    $guid= $_GET['guid'];
                    
                    addItemPanier($DB, $guid, $article );
                    header('Location: index.php?page=boutique');
                    
                break;
                case 4:
                    $article=4; //changement de faction
                    
                    $guid= $_GET['guid'];
                    
                    addItemPanier($DB, $guid, $article );
                    header('Location: index.php?page=boutique');
                    
                break;
                case 5:
                     if (isset($_GET['article'])&&  is_numeric($_GET['article'])){
                    $article=$_GET['article']; //changement de faction
                    
                    $guid= $_GET['guid'];
                    
                    addItemPanier($DB, $guid, $article );
                    header('Location: index.php?page=boutique');
                     }
                    
                     $sql="SELECT * FROM `shop_items` WHERE `service`= 5";

                    $req = $DB->prepare($sql);
                    $req->execute();
                    while($d= $req->fetch(PDO::FETCH_OBJ)): ?>
                    
                    <div class="containerArticle">
                        <div class="imgContainer">
                           <img class="imgIcone" src="template/img/boutique/gold.jpg" alt="gold"/> 
                           <img class="cadreIcone" src="template/img/boutique/cadre.png" alt=""/> 
                        </div>
                        <p class="nomArticle"><?php echo $d->label; ?></p>
                        <p class="prixArticle" style="color:gold;"><?php echo $d->prix*$d->facteur; ?> Points R</p>
                        <a class="addArticle" href="<?php echo $_SERVER['REQUEST_URI'] ?>&&article=<?php echo $d->id; ?>">Ajouter au panier</a>
                        
                    </div>
                        
                    <?php   
                    endwhile;
                    $req->closeCursor();

                break;
                case 6: 
                     
                    
                    
                    if (isset($_GET['article'])&&  is_numeric($_GET['article'])){
                    $article=$_GET['article']; //changement de faction
                    
                    $guid= $_GET['guid'];
                    $levelChar = getCharLevel($CHARS,$guid);
                    $palierLevel = floor($levelChar/10)*10;
                                        
                    
                    if($palierLevel==0): $palierLevel=1; endif;
                    if($levelChar<25&&$palierLevel<=20): $palierLevel=1; endif;
                    if($levelChar>=25&&$palierLevel==20): $palierLevel=25; endif;
                    if($levelChar<45&&$palierLevel<=40&&$palierLevel>=25): $palierLevel=25; endif;
                    if($levelChar>=45&&$palierLevel==40): $palierLevel=45; endif;
                    if($levelChar>=60): $palierLevel=$palierLevel; endif;
                    
                    $d= getInformationArticle($DB, $article);
                     
                     if($palierLevel==$d->levelMin){
                         
                         $levelDiff= $levelChar-$palierLevel;
                         $ecartPalier=$d->levelMax-$d->levelMin;
                         $prix= $d->prix;
                         $newPrix= ceil($prix *(($ecartPalier-$levelDiff)/$ecartPalier)*$d->facteur); 
                         
                        addItemPanier($DB, $guid, $article,$newPrix );
                        header('Location: index.php?page=boutique');
                     }else{
                          header('Location: index.php?page=boutique');
                     }
                    
                    

                         }
                    
                        $levelChar = getCharLevel($CHARS,$guid);
                        $palierLevel = floor($levelChar/10)*10;
                        
                    if($palierLevel==0): $palierLevel=1; endif;
                    if($levelChar<25&&$palierLevel<=20): $palierLevel=1; endif;
                    if($levelChar>=25&&$palierLevel==20): $palierLevel=25; endif;
                    if($levelChar<45&&$palierLevel<=40&&$palierLevel>=25): $palierLevel=25; endif;
                    if($levelChar>=45&&$palierLevel==40): $palierLevel=45; endif;
                    if($levelChar>=60): $palierLevel=$palierLevel; endif;
                        if($levelChar<85){
                           
                            $sql="SELECT * FROM `shop_items` WHERE `service`= '6' AND `levelMin`= '$palierLevel'";

                            $req = $DB->prepare($sql);
                            $req->execute();

                            while($d= $req->fetch(PDO::FETCH_OBJ)): 


                            $req1 = $DB->prepare("SELECT COUNT(*)FROM `shop_panier` WHERE `idUser` = '$compte' AND `articleId` = '$d->id' AND `characterGuid` = '$guid' ");
                            $req1->execute();
                            $nbrItemsDispo = $req1->fetchColumn();

                            $req1->closeCursor();
                            if($nbrItemsDispo==0){
                         
                         $levelDiff= $levelChar-$palierLevel;
                         $ecartPalier=$d->levelMax-$d->levelMin;
                         $prix= $d->prix;
                         $newPrix= ceil($prix *(($ecartPalier-$levelDiff)/$ecartPalier)*$d->facteur); 
                                ?>


                            <div class="containerArticle">
                                <div class="imgContainer">
                                   <img class="imgIcone" src="template/img/boutique/level.jpg" alt="level"/> 
                                   <img class="cadreIcone" src="template/img/boutique/cadre.png" alt=""/> 
                                </div>
                                <p class="nomArticle"><?php echo $d->label; ?><br/><span style="font-size: 9px; color: white;"> Vous gagnez <?php echo $ecartPalier-$levelDiff; ?> niveaux </span></p>
                                <p class="prixArticle" style="color:gold;"><?php echo $newPrix; ?> Points R </p>
                                <a class="addArticle" href="<?php echo $_SERVER['REQUEST_URI'] ?>&&article=<?php echo $d->id; ?>">Ajouter au panier</a>

                            </div>
                           <?php }else{ ?>
                            <br/><br/>
                             <span style="color: gold; font-weight: bold;"> Vous avez déja acheté tous les pack disponibles pour votre niveau. 
                                 <br/>Aucun autre article n'est disponible pour ce personnage.</span><br/>
                             <a href="index.php?page=boutique-services&&action=6">Revenir en arrière</a>
                             <br/><br/>
                          <?php }endwhile;
                           $req->closeCursor();
                        }else{ ?>
                            <br/><br/>
                             <span style="color: gold; font-weight: bold;"> Aucun article n'est disponible pour ce personnage.</span><br/>
                             <a href="index.php?page=boutique-services&&action=6">Revenir en arrière</a>
                             <br/><br/>
                          <?php }
                break;
            default : header('Location: index.php?page=boutique');
            }
            }else{ ?>
         <legend><?php echo $action; ?></legend>
         <p>Veuillez choisir un personnage pour poursuivre l'action.</p>
        <?php if($idAction <5): ?> <p style="color: gold;">Cette action vous coutera <?php echo getPrixService($idAction); ?> Points R</p><?php endif;?>
         <?php 
        $req = $CHARS->prepare("SELECT * FROM characters WHERE account=". $_SESSION['id']." ORDER BY totaltime DESC ");
        $req->execute();
        $royaume='Blizz';
        while ($d = $req->fetch(PDO::FETCH_OBJ)) ?> 
         
        <table class="voteTop" style="border:none; text-align: center; width: 550px;" >
            <thead>
            <th width='180'><strong>Nom</strong></th>
            <th width='40'><strong>Niveau</strong></th>
            <th width='40'><strong>Race</strong></th>
            <th width='40'><strong>Classe</strong></th>
            <th width='190'><strong>Guilde</strong></th>
            <th width='100'><strong>Royaume</strong></th>
            <th width='150'><strong>Modifier</strong></th>
            </thead>
            
        <?php
        $req = $CHARS->prepare("SELECT * FROM characters WHERE account=". $_SESSION['id']." ORDER BY totaltime DESC ");
        $req->execute();
        $royaume='Zircon';
        while ($d = $req->fetch(PDO::FETCH_OBJ)) {
        ?>
            
            <tr style=" font-size:12px; color: #FFF;">
                <td> <?php echo $d->name; ?></td>
                <td> <?php echo $d->level; ?></td>
                <td> <?php echo image_race($d->race); ?></td>
                <td> <?php echo image_classe($d->class); ?></td>
                <td> <?php echo getGuild($CHARS,$d->guid); ?></td>
                <td> <?php echo $royaume ?></td>
                <td> <a href="index.php?page=boutique-services&&action=<?php echo $idAction; ?>&&keySec=<?php echo sha1($d->name); ?>&&guid=<?php echo $d->guid ?>">Choisir </a></td>
            </tr>
            
        <?php  } ?>

        </table>
        <?php }

        break;
        case 7:

           break;
            
        }
        
        
}else{
     header('Location: index.php?page=boutique');
} ?>
</fieldset>
</div>