<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],levelAccessAdministration) && !isset($_SESSION['MaitreJeu'])){
        header('Location: index.php');
    }
?>

<div id="titreAdministration">
    <p style =" font-size: 40px; color: #ffebb6;"> ADMINISTRATION<span style =" font-size: 16px; color: #c8c8c8;">GESTION DES RECUPERATIONS</span></p>
</div>

<?php if(isset($_GET['perso'])){ 
    

 $personnage = htmlspecialchars($_GET['perso']);

 $sql=  "SELECT * FROM `recups` WHERE `personnage` = '$personnage'" ;
 $req = $DB->prepare($sql);
 $req->execute();
 $d=$req->fetch(PDO::FETCH_OBJ);
 
 
 
if(isset($_GET['refus'])){ 

if (isset($_POST) && isset($_POST['commentaire'])) {
   $commentaire = $_POST['commentaire'];
   $idGM= $_SESSION['id'];
                $sql1="UPDATE `recups` SET `comment`='$commentaire',`id_GM`='$idGM'  WHERE (`personnage`='$personnage')";
                $req1 = $DB->prepare($sql1);
                $req1->execute();
                
                 header('Location: index.php?page=gestRecups&&perso='. $d->personnage.'&&action=2');
                } else {
            echo '<span class="erreurFormulaire">Ecrire une raison valide</span>';
        }
?> 
    <form action="index.php?page=gestRecups&&perso=<?php echo $d->personnage;?>&&refus=1" method="post">
    <fieldset>   
    <legend> Refus de la recupération</legend>
    <label>Motif:</label>
    <textarea cols="60" rows="8"  name="commentaire" class="champ_message"></textarea>
     <input type="submit" value="Envoyer" class="send"/>
     </fieldset> </form>

  <?php }
 
 
 if(isset($_GET['action'])){ 
     switch ($_GET['action']){
         case 1:
             acceptChar($d->personnage,$DB, $CHARS);
             header('Location: index.php?page=gestRecups&&perso='.$d->personnage); 
             break;
         case 2:
             deleteChar($d->personnage,$CHARS);
             refuseChar($d->personnage,$DB);
              header('Location: index.php?page=gestRecups&&perso='.$d->personnage); 
             break;
         case 3:
             
              $sql1=  "SELECT * FROM `characters` WHERE `name` = '$personnage'" ;
              $req1 = $CHARS->prepare($sql1);
              $req1->execute();
              $b=$req1->fetch(PDO::FETCH_OBJ);
             
              if($b->online==0){
                 deleteChar($d->personnage,$CHARS);
                 acceptChar($d->personnage,$DB, $CHARS);
                 header('Location: index.php?page=gestRecups&&perso='.$d->personnage); 
              }else{
                  header('Location: index.php?page=gestRecups&&perso='.$d->personnage); 
              }
             break;
         case 4:
             transfertChar($d->user_id, $d->personnage, $CHARS,$DB);
             header('Location: index.php?page=gestRecups&&perso='.$d->personnage); 
             break;
         case 6:
             resetChar($d->personnage,$DB);
             header('Location: index.php?page=gestRecups&&perso='.$d->personnage); 
             break;
         
         default:
             return false;
     }
     
 }
 ?>

<fieldset>    
    <legend> Récupération de : <?php echo $d->personnage; ?></legend>
            <div style="width: 200px; min-height: 80px; display: block; float: left;">
            <p><span style="color: #e1c184;">Nom:</span> <?php echo $d->personnage;?></p>
            <p><span style="color: #e1c184;">Niveau:</span><?php echo $d->level; ?></p>
            <p><span style="color: #e1c184;">Temps de jeu:</span><?php echo 'Neuf!' ?></p>
            <p><span style="color: #e1c184;">Argent: </span><?php     echo '10\'000<span style="color:gold;"> PO</span> 00 <span style="color:silver;"> PA</span> 00 <span style="color:#c39640;"> PC</span> '; ?></p>
            <?php echo image_race($d->race); ?>
            <?php echo image_classe($d->classe); ?>
            <a href="index.php?page=gestRecups&&perso=<?php echo $d->personnage ?>">Actualiser la page</a>
             
             </div>
            <div style="width: 280px; min-height: 180px; display: block; float: left;">
            <p Style="color: #e1c184; font-size: 14px;">Statut:  <?php echo statutRecup($d->status);?> </p>
            <p><span style="color: #e1c184;">Métier 1:</span> <?php echo getMetier($d->metier1).' <span style="color: #e1c184;">'.$d->skill1;?></span> /525 </p>
            <p><span style="color: #e1c184;">Métier 2:</span> <?php echo getMetier($d->metier2).' <span style="color: #e1c184;">'.$d->skill2;?></span> /525</p>
            <p><span style="color: #e1c184;">Serveur:</span> <a style="color:orange" href="<?php echo $d->lien;?>"><?php echo $d->lien;?> </a></p>
            <p><span style="color: #e1c184;">Stuff:</span><span style="color: lightskyblue;"> Niveau d'objet <?php echo $d->stuffLevel; ?></span> </p>

            </div>
    
    <?php if($d->status==0):;
    
    
 $sql1=  "SELECT * FROM `characters` WHERE `name` = '$personnage'" ;
 
 $req1 = $CHARS->prepare($sql1);
 $req1->execute();

 $nbrPerso=$req1->rowcount();
 
  $b=$req1->fetch(PDO::FETCH_OBJ);

 if($nbrPerso==1){ 
     
            
    $guidPerso= $b->guid;
    $sql1a="SELECT * FROM `item_instance` WHERE `owner_guid` = '$guidPerso'"; //CONTROLE DE POSTE EFFECTUE
    $req1a = $CHARS->prepare($sql1a);
    $req1a->execute();
    $nbrItems = $req1a->rowcount();
    $req1a->closeCursor();
            ?>
            <p><span style="color: #e1c184;">Stuff:</span><span style="color: lightskyblue;"> Nombre d'items faits <?php echo $nbrItems; ?></span> </p>
     <?php 
     if($b->totaltime==0 && $b->online ==0){
         echo "<p><span class='erreurFormulaire'style='width: 280px; float: right;'>Veuillez aller en jeu vérifier les équipemments dans les sacs. </span></p>";
     }
     if($b->online ==1 && $b->totaltime>0){ ?>
          <p><span class='erreurFormulaire' style='width: 280px; float: right;'>Veuillez deconecter le personnage. </span></p>
    <?php }else{
?>
            <div style="width: 380px; min-height: 80px; display: block; float: left;">
            <?php if($b->online ==0){ ?>
            <p Style="color: #e1c184; font-size: 14px;"> ACTION:<a style="color: red" href="index.php?page=gestRecups&&perso=<?php echo $d->personnage;?>&&action=3"> Refaire le personnage</a> </p>
            <?php }else{ ?>
            <p Style="color: #e1c184; font-size: 14px;"><span class='erreurFormulaire'style='width: 280px; float: right;'>Se déconnecter pour pouvoir creer un personnage</span> <p>
            <?php } ?>
            <?php if($b->online ==0){ //&& $b->totaltime>0  RESTE DE LA CONDITION?>
           <p Style="color: #e1c184; font-size: 14px;"> ACTION:<a style="color: greenyellow" href="index.php?page=gestRecups&&perso=<?php echo $d->personnage;?>&&action=4"> TRANFERER PERSONNAGE VERS COMTPE JOUEUR</a> </p>
           <p Style="color: #e1c184; font-size: 14px;"></p>
           <p Style="color: #e1c184; font-size: 14px;"> ACTION:<a style="color:red" href="index.php?page=gestRecups&&perso=<?php echo $d->personnage;?>&&refus=2"> Refuser & Effacer</a> </p>
            <?php } ?></div>
<?php }


}else{
?>
            <div style="width: 380px; min-height: 80px; display: block; float: left;">
            <p Style="color: #e1c184; font-size: 14px;"> ACTION:<a style="color: greenyellow" href="index.php?page=gestRecups&&perso=<?php echo $d->personnage;?>&&action=1"> Valider --> </a> </p>
            <p Style="color: #e1c184; font-size: 14px;"> ACTION:<a style="color:red" href="index.php?page=gestRecups&&perso=<?php echo $d->personnage;?>&&refus=1"> Refuser -X- </a> </p>
            </div>
    <?php } endif;?>
        <?php if($d->status==1):;?>
            <div style="width: 380px; min-height: 80px; display: block; float: left;">
                <p><span style="color: #e1c184;">Traitée par:</span><span style="color: lightslategray;"> <?php echo getMainPerso($CHARS, $DB, $d->id_GM);?></span> </p>
            </div>
    <?php endif;?>
        <?php if($d->status==2):;?>
            <div style="width: 380px; min-height: 80px; display: block; float: left;">
                <p><span style="color: #e1c184;">Traitée par:</span><span style="color: peru;"> <?php echo getMainPerso($CHARS, $DB, $d->id_GM);?></span> </p>
            <p><span style="color: #e1c184;">Motif:</span><span style="color: lightslategray;"> <?php echo $d->comment;?></span> </p>
            </div>
    <?php endif;?>
</fieldset>   
<fieldset>
  <legend>Screens </legend>
  <div  style="width: 460px; min-height: 80px; display: block; margin: auto;">
  <a class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen1; ?>">
  <img class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen1; ?>" alt="Screen Personnage"/> </a>
  
  <a class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen2; ?>">
  <img class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen2; ?>" alt="Screen Personnage"/> </a>
  
  <a class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen3; ?>">
  <img class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen3; ?>" alt="Screen Personnage"/> </a>
  
  <a class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen4; ?>">
  <img class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen4; ?>" alt="Screen Personnage"/> </a>
  
  <a class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen5; ?>">
  <img class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen5; ?>" alt="Screen Personnage"/> </a>
  
  <a class="zoombox zgallery1"  href="<?php echo "template/img/recuperation/fullsize/".$d->screen6; ?>">
  <img class="mini" src=" <?php echo "template/img/recuperation/min/".$d->screen6; ?>" alt="Screen Personnage"/> </a>

  </div>
</fieldset>
 <fieldset>
<legend>Récupérations de ce même compte </legend>
<?php
$id_user= $d->user_id;
$sql2=  "SELECT * FROM `recups` WHERE `user_id` =$id_user" ;
$req2 = $DB->prepare($sql2);
$req2->execute();


while ($d = $req2->fetch(PDO::FETCH_OBJ))
?>     
             
             
             <table class="voteTop" style="border:none; text-align: center;">
                <thead>
                <th width='10'><strong></strong></th>
                <th width='190'><strong>Nom</strong></th>
                <th width='40'><strong>Niveau</strong></th>
                <th width='40'><strong>Race</strong></th>
                <th width='40'><strong>Classe</strong></th>
                <th width='190'><strong>Statut</strong></th>
                <th width='190'><strong>Royaume</strong></th>
                <th width='190'><strong>Voir détails</strong></th>
                </thead>

<?php
            $req2 = $DB->prepare($sql2);
            $req2->execute();
            while ($d = $req2->fetch(PDO::FETCH_OBJ)) {
?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo $d->id; ?></td>
                    <td> <?php echo $d->personnage; ?></td>
                    <td> <?php echo $d->level; ?></td>
                    <td> <?php echo image_race($d->race); ?></td>
                    <td> <?php echo image_classe($d->classe); ?></td>
                    <td> <?php echo statutRecup($d->status);?></td>
                    <td> <?php echo 'Blizz' ?></td>
                    <?php if($d->status>0){?>
                    <td> <a  style="color:greenyellow;" href="index.php?page=gestRecups&&perso=<?php echo $d->personnage; ?>">Détails</a></td>
                    <?php }else{
                        ?>
                    <td><a  href="index.php?page=gestRecups&&perso=<?php echo $d->personnage;?>">Vérifier</a>
                      <?php  } ?>
                </tr>
            <?php  } ?>

        </table>
 </fieldset>
<?php 

} ?>    



 <fieldset>
     
<?php
    
$sql= " SELECT * from `recups`  ORDER BY status ASC " ;
$req = $DB->prepare($sql);
$req->execute();


while ($d = $req->fetch(PDO::FETCH_OBJ)) 
?>     
             
             
             <table class="voteTop" style="border:none; text-align: center;">
                <thead>
                <th width='10'><strong></strong></th>
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
            $sql=  " SELECT * from `recups`  ORDER BY status ASC " ;
            $req = $DB->prepare($sql);
            $req->execute();
            while ($d = $req->fetch(PDO::FETCH_OBJ)) {
?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo $d->id; ?></td>
                    <td> <?php echo $d->personnage; ?></td>
                    <td> <?php echo $d->level; ?></td>
                    <td> <?php echo image_race($d->race); ?></td>
                    <td> <?php echo image_classe($d->classe); ?></td>
                    <td> <?php echo statutRecup($d->status);?></td>
                    <td> <?php echo 'Blizz' ?></td>
                    <?php if($d->status>0){?>
                    <td> 
                        <?php 
                                                
                         $personnage = $d->personnage;
                         $sql1=  "SELECT * FROM `characters` WHERE `name` = '$personnage'" ;
                         $req1 = $CHARS->prepare($sql1);
                         $req1->execute();

                         $nbrPerso=$req1->rowcount();
                         
                         if($nbrPerso==0){ ?>
                        <a style="color: greenyellow" href="index.php?page=gestRecups&&perso=<?php echo $d->personnage;?>&&action=6"> RESET </a>
                        <?php }else{?>
                        <a  style="color:greenyellow;" href="index.php?page=gestRecups&&perso=<?php echo $d->personnage; ?>">Détails</a>
                    <?php }?>
                    </td> 
                    <?php }else{?>
                    <td> <a  href="index.php?page=gestRecups&&perso=<?php echo $d->personnage; ?>">Vérifier</a></td>
                      <?php  } ?>
                </tr>
            <?php  } ?>

        </table>
 </fieldset>