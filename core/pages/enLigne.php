<div id="pOnline" class="news">
            <div class="headNews"> 
                <span>Joueurs en ligne</span>
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
            
            //ICI LA FONCTION MULI ROYAUME->
            $req = $CHARS->prepare("SELECT * FROM characters WHERE online=1 ");
            $req->execute();
            
            $nConnect = $req->rowcount();
            
            $PourcentConnect= ceil((100/$royaumePopu)*$nConnect);

?>
<fieldset>
    <legend><?php echo $royaumeName.' est un royaume'. $royaumetype .' il est actuellement occupé à '.$PourcentConnect.'% ';  ?></legend>

<?php 
?>     
             <table class="voteTop" style="border:none">
                <thead>
                <th width='190'><strong>Nom</strong></th>
                <th width='40'><strong>Niveau</strong></th>
                <th width='40'><strong>Race</strong></th>
                <th width='40'><strong>Classe</strong></th>
                <th width='190'><strong>Guilde</strong></th>
                <th width='190'><strong>Royaume</strong></th>
                </thead>


<?php
            $req = $CHARS->prepare("SELECT * FROM `characters` WHERE `online` = '1' AND `level` <= '85'");
            $req->execute();
            $royaume=$royaumeName;

            while ($d = $req->fetch(PDO::FETCH_OBJ)) {
?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo $d->name; ?></td>
                    <td> <?php echo $d->level; ?></td>
                    <td> <?php echo image_race($d->race); ?></td>
                    <td> <?php echo image_classe($d->class); ?></td>
                    <td> <?php echo getGuild($CHARS,$d->guid); ?></td>
                    <td> <?php echo $royaume ?></td>
                </tr>
            <?php  }?>

        </table>
       </fieldset>
        <?php  }}else{
            echo '
<P><em style="font-size:14px;">Tous les royaumes sont indisponibles!!</em> <br/>Aucun royaume n\'est ouvert au public  pour le moment veuillez réessayer plus tard. <br/>';
        }
        ?>
</div>

</div>
