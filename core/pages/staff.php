<div id="pOnline" class="news">
            <div class="headNews"> 
                <span>L'équipe</span>
            </div>
    <div class="middleNews">
<?php     
if(!isset($_SESSION['name']) && !isset($_SESSION['accountLevel'])){
      header('Location: index.php?page=connexion');
}
        $req1 = $REALM->prepare("SELECT * FROM realmlist WHERE allowedSecurityLevel=0");
        $req1->execute();
        
        $nRoyaumes=$req1->rowcount();
        if($nRoyaumes>0){
        while ($d = $req1->fetch(PDO::FETCH_OBJ)) {
            $royaumeId=$d->id;
            $royaumeName=$d->name;
            $royaumeSecu=$d->allowedSecurityLevel;
            $royaumePopu=$d->population;
            $royaumetype=getTypeKingdom($d->icon);
            

?>
<fieldset>
    <legend><?php echo 'Equipe du royaume '.$royaumeName.' '.$royaumetype?></legend>

<?php 
?>     
             <table class="voteTop" style="border:none">
                <thead>
                <th width='120'><strong>Nom</strong></th>
                <th width='240'><strong>Grade</strong></th>
                <th width='120'><strong>Depuis le:</strong></th>
                <th width='60'><strong>Contacter</strong></th>
                </thead>


<?php

            

            $req = $REALM->prepare("SELECT * FROM account_access ORDER BY rankForSite DESC ");
            $req->execute();
           
            while ($e = $req->fetch(PDO::FETCH_OBJ)) {
        
        $grade= $e->rankForSite;  
        switch ($grade){
        case 1:
            ?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo getMainPerso($CHARS, $DB, $e->id);?></td>
                    <td> <?php echo'Moderateur'; ?></td>
                    <td> <?php echo convertTime(getSignIn($e->id, $DB)); ?></td>
                    <td> <a href="mailto:<?php echo getMail($e->id, $DB); ?>"><img  style="width: 30px; height: 20px; margin: auto;" src="template/img/contact.png" alt=""/></a></td>
                </tr>
            <?php
            break;
        case 2:
            ?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo getMainPerso($CHARS, $DB, $e->id);?></td>
                    <td> <?php echo'Maitre du jeu en teste'; ?></td>
                    <td> <?php echo convertTime(getSignIn($e->id, $DB)); ?></td>
                    <td> <a href="mailto:<?php echo getMail($e->id, $DB); ?>"><img  style="width: 30px; height: 20px; margin: auto;" src="template/img/contact.png" alt=""/></a></td>
                </tr>
            <?php
            break;
        case 3:
            ?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo getMainPerso($CHARS, $DB, $e->id);?></td>
                    <td> <?php echo'Maître du jeu'; ?></td>
                    <td> <?php echo convertTime(getSignIn($e->id, $DB)) ?></td>
                    <td> <a href="mailto:<?php echo getMail($e->id, $DB); ?>"><img  style="width: 30px; height: 20px; margin: auto;" src="template/img/contact.png" alt=""/></a></td>
                </tr>
            <?php
            break;
        case 3.1:
            ?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo getMainPerso($CHARS, $DB, $e->id);?></td>
                    <td> <?php echo'Resp. des maîtres du jeu'; ?></td>
                    <td> <?php echo convertTime(getSignIn($e->id, $DB)) ?></td>
                    <td> <a href="mailto:<?php echo getMail($e->id, $DB); ?>"><img  style="width: 30px; height: 20px; margin: auto;" src="template/img/contact.png" alt=""/></a></td>
                </tr>
            <?php
            break;
        case 4:
            ?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo getMainPerso($CHARS, $DB, $e->id);?></td>
                    <td> <?php echo'Développeur'; ?></td>
                    <td> <?php echo convertTime(getSignIn($e->id, $DB)); ?></td>
                    <td> <a href="mailto:<?php echo getMail($e->id, $DB); ?>"><img  style="width: 30px; height: 20px; margin: auto;" src="template/img/contact.png" alt=""/></a></td>
                </tr>
            <?php
            break;
        case 5:
            ?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo getMainPerso($CHARS, $DB, $e->id);?></td>
                    <td> <?php echo'Administrateur'; ?></td>
                    <td> <?php echo convertTime(getSignIn($e->id, $DB)) ?></td>
                    <td> <a href="mailto:<?php echo getMail($e->id, $DB); ?>"><img  style="width: 30px; height: 20px; margin: auto;" src="template/img/contact.png" alt=""/></a></td>
                </tr>
            <?php
            break;
        case 6:
            ?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo getMainPerso($CHARS, $DB, $e->id);?></td>
                    <td> <?php echo'Administrateur & développeur'; ?></td>
                    <td> <?php echo convertTime(getSignIn($e->id, $DB)) ?></td>
                    <td> <a href="mailto:<?php echo getMail($e->id, $DB); ?>"><img  style="width: 30px; height: 20px; margin: auto;" src="template/img/contact.png" alt=""/></a></td>
                </tr>
            <?php
            break;
        case 7:
            ?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo getMainPerso($CHARS, $DB, $e->id);?></td>
                    <td> <?php echo"<span style='font-size:10px;' >Admin. & Resp. du développement </span>";?></td>
                    <td> <?php echo convertTime(getSignIn($e->id, $DB)) ?></td>
                    <td> <a href="mailto:<?php echo getMail($e->id, $DB); ?>"><img  style="width: 30px; height: 20px; margin: auto;" src="template/img/contact.png" alt=""/></a></td>
                </tr>
            <?php
            break;
        case 8:
            ?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo getMainPerso($CHARS, $DB, $e->id);?></td>
                    <td> <?php echo'Grade en attente'; ?></td>
                    <td> <?php echo convertTime(getSignIn($e->id, $DB)) ?></td>
                    <td> <a href="mailto:<?php echo getMail($e->id, $DB); ?>"><img  style="width: 30px; height: 20px; margin: auto;" src="template/img/contact.png" alt=""/></a></td>
                </tr>
            <?php
            break;
        case 0:
            ?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo getMainPerso($CHARS, $DB, $e->id);?></td>
                    <td> <?php echo'Membre absent'; ?></td>
                    <td> <?php echo convertTime(getSignIn($e->id, $DB)) ?></td>
                    <td> <a href="mailto:<?php echo getMail($e->id, $DB); ?>"><img  style="width: 30px; height: 20px; margin: auto;" src="template/img/contact.png" alt=""/></a></td>
                </tr>
            <?php
            break;

   default:
       
        }
  }?>

        </table>
       </fieldset>
        <?php  }}else{
            echo '
<P><em style="font-size:14px;">Tous les royaumes sont indisponibles!!</em> <br/>Aucun royaume n\'est ouvert au public  pour le moment veuillez réessayer plus tard. <br/>';
        }
        ?>
</div>

</div>
