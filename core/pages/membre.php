<div id="membre" class="news">
            <div class="headNews"> 
                <span>Espace membre</span>
            </div>
    <div class="middleNews">
<?php     
if(!isset($_SESSION['name']) && !isset($_SESSION['accountLevel'])){
      header('Location: index.php');
}
?>
        
<fieldset>
<legend>Page Facebook</legend> 

<a href="<?php echo linkFB; ?>" id="pageFB"></a>
</fieldset>

<?php if(isset($_GET['recup'])){ 
    

 $personnage = htmlspecialchars($_GET['recup']);
 
 $sql=  "SELECT * FROM `recups` WHERE `personnage` = '$personnage'" ;
 $req = $DB->prepare($sql);
 $req->execute();
 $d=$req->fetch(PDO::FETCH_OBJ)
         
?>

<fieldset>    
    <legend> Récupération de : <?php echo $d->personnage; ?></legend>
            <div style="width: 200px; min-height: 80px; display: block; float: left;">
            <p><span style="color: #e1c184;">Nom:</span> <?php echo $d->personnage;?></p>
            <p><span style="color: #e1c184;">Niveau:</span><?php echo $d->level;?></p>
            <p><span style="color: #e1c184;">Temps de jeu:</span><?php echo 'Neuf!' ?></p>
            <p><span style="color: #e1c184;">Argent: </span><?php echo  $d->level;?><span style="color:gold;"> PO</span> 00 <span style="color:silver;"> PA</span> 00 <span style="color:#c39640;"> PC</span></p>
            <?php echo image_race($d->race); ?>
            <?php echo image_classe($d->classe); ?>
             </div>
            <div style="width: 280px; min-height: 180px; display: block; float: left;">
            <p Style="color: #e1c184; font-size: 14px;">Statut:  <?php echo statutRecup($d->status);?> </p>
            <p><span style="color: #e1c184;">Métier 1:</span> <?php echo getMetier($d->metier1)?></p>
            <p><span style="color: #e1c184;">Métier 2:</span> <?php echo getMetier($d->metier2)?></p>

            <p><span style="color: #e1c184;">Stuff:</span><span style="color: lightskyblue;"> Niveau d'objet <?php echo $d->stuffLevel; ?></span> </p>

        <?php if($d->status==2):;?>
            <div style="width: 380px; min-height: 80px; display: block; float: left;">
                <p><span style="color: #e1c184;">Traitée par:</span><span style="color: peru;"> <?php echo getMainPerso($CHARS, $DB, $d->id_GM);?></span> </p>
            <p><span style="color: #e1c184;">Motif:</span><span style="color: lightslategray;"> <?php echo $d->comment;?></span> </p>
            </div>
        <?php endif;?>
            

            </div>

    
</fieldset>   
<fieldset>
  <legend>Screens </legend>
  <div  style="width: 460px; min-height: 80px; display: block; margin: auto;">
  <a  class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen1; ?>">
  <img  style ="float:left;" class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen1; ?>" alt="Screen Personnage"/> </a>
  
  <a class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen2; ?>">
  <img  style ="float:left;" class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen2; ?>" alt="Screen Personnage"/> </a>
  
  <a class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen3; ?>">
  <img style ="float:left;" class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen3; ?>" alt="Screen Personnage"/> </a>
  
  <a class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen4; ?>">
  <img style ="float:left;" class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen4; ?>" alt="Screen Personnage"/> </a>
  
  <a class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen5; ?>">
  <img style ="float:left;" class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen5; ?>" alt="Screen Personnage"/> </a>
  
  <a class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen6; ?>">
  <img style ="float:left;" class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen6; ?>" alt="Screen Personnage"/> </a>

  </div>
</fieldset>
        
<?php }else{ ?>   
        
<fieldset>
<legend>Mes récuperations</legend> 

<a id="freeRecup" href="index.php?page=recuperation"> </a>
<?php   
if (verifNbrRecupsMembre($DB,$_SESSION['id'])<1){ // Retourne nombre de recups faites
?> 
    <p>
        Vous n'avez fait aucune demande de récupération pour le moment.
    </p>
<div>
    <a id="recupPayd" href="index.php?page=recups"> </a>
</div>
<?php }else{
    
$sessionId = $_SESSION['id'];
$sql= " SELECT * from `recups` WHERE `user_id` = $sessionId ORDER BY id DESC " ;
$req = $DB->prepare($sql);
$req->execute();


while ($d = $req->fetch(PDO::FETCH_OBJ)) 
?>     
             
             
             <table class="voteTop" style="border:none">
                <thead>
                <th width='190'><strong>Nom</strong></th>
                <th width='40'><strong>Niveau</strong></th>
                <th width='40'><strong>Race</strong></th>
                <th width='40'><strong>Classe</strong></th>
                <th width='190'><strong>Statut</strong></th>
                <th width='190'><strong>Royaume</strong></th>
                <th width='190'><strong>Voir détails</strong></th>
                </thead>


<?php
            $sessionId = $_SESSION['id'];
            $sql= " SELECT * from `recups` WHERE `user_id` = $sessionId ORDER BY id DESC " ;
            $req = $DB->prepare($sql);
            $req->execute();
            while ($d = $req->fetch(PDO::FETCH_OBJ)) {
?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo $d->personnage; ?></td>
                    <td> <?php echo $_SESSION['level']; ?></td>
                    <td> <?php echo image_race($d->race); ?></td>
                    <td> <?php echo image_classe($d->classe); ?></td>
                    <td> <?php echo statutRecup($d->status);?></td>
                    <td> <?php echo 'Blizz' ?></td>
                    <td> <a href="index.php?page=membre&&recup=<?php echo $d->personnage; ?>">Détails </a></td>
                </tr>
            <?php  } ?>

        </table>

<?php } ?> 
 </fieldset>
<?php } ?>   
        
 <fieldset><legend>Compte</legend>
 <?php
 if (isset($_GET['setPass']) && $_GET['setPass']==1) {

     if (isset($_POST['ancPassword']) && isset($_POST['password']) && isset($_POST['password_rep'])) {
         
         if (!empty($_POST['ancPassword']) && !empty($_POST['password']) && !empty($_POST['password_rep'])){
             extract($_POST);
             $passPourVerif =sha1(strtoupper($_SESSION['name']) . ':' . strtoupper($ancPassword));
             
              if (preg_match("#^[a-zA-Z0-9]+$#", $ancPassword)) {
                   if (preg_match("#^[a-zA-Z0-9]+$#", $password)) {
                        if (preg_match("#^[a-zA-Z0-9]+$#", $password_rep)) {
                            if(verifAncienMDP($DB, $passPourVerif, $_SESSION['id'])){
                                if($password==$password_rep){
                                    // FIn du contrôle
                                    
                                     $nouveauMDP =sha1(strtoupper($_SESSION['name']) . ':' . strtoupper($password));
                                    changeMDP($DB, $REALM, $nouveauMDP, $_SESSION['id']);
                                    
                                    
                                    
                                }else{
                                    echo "<span class='erreurFormulaire'  color='red'>Vérifiez à bien répeter le même mot de passe.</span>";
                                }
                            }else{
                                 echo "<span class='erreurFormulaire'  color='red'>Ancien mot de passe incorrect</span>";
                            }
                        }else{
                            echo "<span class='erreurFormulaire'  color='red'>Répétition du nouveau mot contient des caractéres non autorisés</span>";
                        }
                   }else{
                       echo "<span class='erreurFormulaire'  color='red'>Nouveau mot de passe contient des caractéres non autorisés</span>";
                   }
                 }else{
                     echo "<span class='erreurFormulaire'  color='red'>Ancien mot de passe contient des caractéres non autorisés</span>";
                 }
             }else{
             echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
         }    
     }
 ?>
             
             
             
                <fieldset>
                <legend>Mot de passe</legend>
                <form action="index.php?page=membre&&setPass=1" method="post">
                <p>Il est fortement conseillé que le mot de passe soit différent de celui de votre compte de messagerie. Ne le transmettez à personne, un Maître de Jeu ne vous le demandera jamais.</p>
                <br />
                <label class="labelInsc" for="ancPassword">Mot de passe :(actuel)</label>
                <input id="password" class="champInsc" name="ancPassword" type="password" />
                <label class="labelInsc" for="password">Mot de passe :</label>
                <input id="password" class="champInsc" name="password" type="password" />
                <label class="labelInsc" for="password_rep">Répéter mot de passe :</label>
                <input id="password_rep" class="champInsc" name="password_rep" type="password" /><br /><br /><br /><br />
                <input style="margin-top: 100px;  display: block;" class="send" value="Mettre à jour" type="submit" /><br />
                </form>
                <a style='display: block;' href='index.php?page=membre'>Retour au menu compte</a>
                </fieldset>

<?php }else{ ?>
     <p><span style="color: #e1c184;">Nom de compte:</span> <?php echo $_SESSION['name'] ?></p>
     <p><span style="color: #e1c184;">Adresse email:</span> <?php echo $_SESSION['mail'] ?></p>
     <p><span style="color: #e1c184;">Personnage principal:</span> <?php echo getMainPerso($CHARS,$DB, $_SESSION['id']) ?></p>
     <p><span style="color: #e1c184;">Adresse ip:</span> <?php echo $_SERVER['REMOTE_ADDR'] ?></p>
     <p><span style="color: #e1c184;">Temps total de jeu:</span> <?php echo  calculSecondes(getAllPlayedTime($CHARS,$_SESSION['id']))?></p>
     <p><span style="color: #e1c184;">Date d'inscription:</span> <?php echo convertTime(getSignIn($_SESSION['id'], $DB)) ?></p>
     <p><span style="color: #e1c184;">Dernière connection:</span> <?php echo getLastConection($_SESSION['id'], $DB)!=0?  convertTime(getLastConection($_SESSION['id'], $DB)): 'Jamais';  ?></p>
     <p><span style="color: #e1c184;">Nombre de points R:</span> <?php echo getShopPoints($_SESSION['id'], $DB) ?></p>
     <p><span style="color: #e1c184;">Votes ce mois: </span><?php echo getVotePoints($_SESSION['id'], $DB) ?></p>
     <a href="index.php?page=membre&&setPass=1" class="bouttonAchatAmelioration" style="border: solid 1px #c39640; float: right;">Modifier mon mot de passe</a>
<?php } ?>
         </fieldset>
          <fieldset>
             <legend>Mes personnages</legend>
                <br/> 
             
<?php
if (isset($_GET['id'])&&isset($_GET['name'])&&isset($_GET['acc'])) {
    if($_GET['acc']==$_SESSION['id']){
        if(verifCompteGuid($_GET['id'],$_GET['acc'],$CHARS)){
            
            if (isset($_GET['action'])){
                
                if(!isOnline($CHARS,$_GET['id'])){
                // CONCLUSION DU SCRIPT
                customiseCharactere($DB, $CHARS,$_GET['id'], $_GET['acc'], $_GET['name'], $_GET['action']);
                }else{
            echo "<span class='erreurFormulaire'  color='red'>Votre personnage ne doit pas être connecté.</span>";
            echo '<br/>';
            echo "<a style='display: block;' href='index.php?page=membre'>Liste des personnages</a>";
                }
            }else{
                
            $_SESSION['guid']=$_GET['id'];
            
            $req = $CHARS->prepare("SELECT * FROM characters WHERE guid=". $_SESSION['guid']."");
            $req->execute();
            $d = $req->fetch(PDO::FETCH_OBJ);
            ?>
             <div style="width: 200px; min-height: 80px; display: block; float: left;">
            <p><span style="color: #e1c184;">Nom:</span> <?php echo $d->name?></p>
            <p><span style="color: #e1c184;">Niveau:</span><?php echo $d->level; ?></p>
            <p><span style="color: #e1c184;">Guilde:</span><?php echo getGuild($CHARS,$d->guid); ?></p>
            <p><span style="color: #e1c184;">Temps de jeu:</span><?php echo calculSecondes($d->totaltime,$CHARS); ?></p>
            <p><span style="color: #e1c184;">Argent: </span><?php getArgentChar($CHARS,$d->guid); ?></p>
            <?php echo image_race($d->race); ?>
            <?php echo image_classe($d->class); ?>
             </div>
            <br/>
            <div class="clear"></div>
            <br/>
            <br/>
            <a style="display: block;" href="index.php?page=membre">Liste des personnages</a>
           
<?php  } }else{
            header('Location: index.php?page=membre');
        }
        
    }else{
         header('Location: index.php?page=membre');
    }
    
    
}else{
            $req = $CHARS->prepare("SELECT * FROM characters WHERE account=". $_SESSION['id']." ORDER BY totaltime DESC ");
            $req->execute();
            $royaume='Blizz';
            while ($d = $req->fetch(PDO::FETCH_OBJ)) 
?>     
             
             
             <table class="voteTop" style="border:none">
                <thead>
                <th width='190'><strong>Nom</strong></th>
                <th width='40'><strong>Niveau</strong></th>
                <th width='40'><strong>Race</strong></th>
                <th width='40'><strong>Classe</strong></th>
                <th width='190'><strong>Guilde</strong></th>
                <th width='190'><strong>Royaume</strong></th>
                <th width='190'><strong>Modifier</strong></th>
                </thead>


<?php
            $req = $CHARS->prepare("SELECT * FROM characters WHERE account=". $_SESSION['id']." ORDER BY totaltime DESC ");
            $req->execute();
            $royaume='Blizz';
            while ($d = $req->fetch(PDO::FETCH_OBJ)) {
?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo $d->name; ?></td>
                    <td> <?php echo $d->level; ?></td>
                    <td> <?php echo image_race($d->race); ?></td>
                    <td> <?php echo image_classe($d->class); ?></td>
                    <td> <?php echo getGuild($CHARS,$d->guid); ?></td>
                    <td> <?php echo $royaume ?></td>
                    <td> <a href="index.php?page=membre&&name=<?php echo $d->name; ?>&&id=<?php echo $d->guid; ?>&&acc=<?php echo $d->account; ?>">Modifier </a></td>
                </tr>
            <?php  } ?>

        </table>
             <?php  } ?>
       </fieldset>
        
          <fieldset>
             <legend>Mes Filleuls</legend> 
             
 <?php   
 if (isset($_GET['fill']) && isset($_GET['tmp'])&& isset($_GET['name'])) {
     if (!empty($_GET['fill']) && !empty($_GET['tmp'])&& !empty($_GET['name'])) {
         extract($_GET);
            if (is_numeric($fill)) {
               if (preg_match("#^[a-zA-Z0-9]+$#",$tmp)) {
                    if (preg_match("#^[a-zA-Z]+$#", $name)) {
                        if(getAccountLevel($fill, $DB)==1){
                            if($_SESSION['id']== getParrainId($fill, $DB)){
                                $req = $DB->prepare("SELECT signIn FROM users WHERE id=$fill");
                                $req->execute();
                                $d = $req->fetch(PDO::FETCH_OBJ);
                                $date= sha1($d->signIn);
                                if($date==$tmp){
                                    //Fin de controle
                                    
                                    activationParrainage($DB,$fill,$_SESSION['id']);
                                    echo "<span class='validFormulaire' color='green'><strong>Opération effectuée avec succés.</strong> <br/>
                                        Votre compte à été crédité de 400 Points R</span>";
                                }else{
                                     header('Location: index.php?page=membre'); 
                                } 
                            }else{
                                header('Location: index.php?page=membre'); 
                            }                   
                        }else{
                            header('Location: index.php?page=membre');
                        }
                    }else{
                         header('Location: index.php?page=membre');
                    }
               }else{
                   header('Location: index.php?page=membre');
               }
             }else{
                  header('Location: index.php?page=membre');
             }
         }else{
             header('Location: index.php?page=membre');
         }
 } ?>

             <p>Vos pouvez parrainer des personnes en leur donnant votre lien personnel. Ceci permettra non seulement à 
                 ces personnes de gagner 150 points R mais il vos offrira également une somme de 400 points R pour chaque personne parrainée.
                <br/> <br/>Toutefois les points ne seront disponibles que lorsque votre filleuil aura accomplit 3 jours de jeu sur l'ensemble de ces personnages.             </p>
             <p style="color: aquamarine " ><span style="color: dodgerblue">Votre lien de parrainage:</span> http://www.rolkithan.fr/index.php?page=inscription&&par=<?php echo $_SESSION['id']; ?></td> </p>
             <table class="voteTop" style="border:none">
                <thead>
                    <th width='140'><strong>Nom</strong></th>
                    <th width='100'><strong>Personnage</strong></th>
                    <th width='190'><strong>Temps de jeu</strong></th>
                    <th width='50'><strong>Statut</strong></th>
                    <th width='140'><strong>Temps restant</strong></th>
                </thead>
<?php
            $req = $DB->prepare("SELECT * FROM users WHERE idParrain=". $_SESSION['id']." ORDER BY signIn DESC ");
            $req->execute();
            while ($d = $req->fetch(PDO::FETCH_OBJ)) {
?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo $d->name; ?></td>
                    <td> <?php echo getMainPerso($CHARS,$DB,$d->id); ?></td>
                    <td> <?php echo calculSecondes(getAllPlayedTime($CHARS,$d->id))?></td>
                    <td> <?php echo statutParrainage(getAllPlayedTime($CHARS,$d->id)) ?></td>
                    <td> <?php 
                                $req2 = $DB->prepare("SELECT accountLevel FROM users WHERE id=$d->id ");
                                $req2->execute();
                                $d2 = $req2->fetch(PDO::FETCH_OBJ);
                                $accountLevel = $d2->accountLevel;
                                if($accountLevel>1){
                                    echo "<span color='darkorange'><strong>Archivé</strong></span>";
                                }  else {
                                  echo getAllPlayedTime($CHARS,$d->id)>24*3600*3 ? "<a href='index.php?page=membre&&fill=$d->id&&tmp=".sha1(getSignIn($d->id, $DB))."&&name=".getMainPerso($CHARS, $DB, $d->id)." ' >Activer</a>": calculSecondes(24*3600*3-getAllPlayedTime($CHARS,$d->id)); 
                                }?>
                    </td>
                </tr>
            <?php
            } ?>

        </table>
       </fieldset>
</div>

</div>
