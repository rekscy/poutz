<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],0) && !isset($_SESSION['Administrateur'])){
       header('Location: index.php');
    }
?>
<div id="projetEnCours">
    <p style =" font-size: 40px; color: #ffebb6;"> DEVELOPPEMENT<span style =" font-size: 16px; color: #c8c8c8;">AVANCEE DU SERVEUR</span></p><hr style="margin-top: -32px;" />
</div>
<fieldset style="background:  #0A0501; border: #080301 1px solid; margin-bottom: 5px; margin-left: 3px; padding: 1px; ">   
<legend>Rolkithan-Zircon (PVP-PVE)</legend>
<?php 

if(isset($_GET['categorie'])&&  is_numeric($_GET['categorie'])){
    
$cat =stripcslashes($_GET['categorie']);

    if(isset($_GET['tache'])&&  is_numeric($_GET['tache'])){

        $tache =stripcslashes($_GET['tache']);
        $sql= "SELECT * FROM `sous-taches` WHERE `categorie`='$cat' && `tache`='$tache'  ORDER BY `id` ASC LIMIT 0, 100" ;
        $req = $DB->prepare($sql);
        $req->execute();
        while ($d = $req->fetch(PDO::FETCH_OBJ)) {

        $prCnt= calculPercent($d->nbrTotalAction, $d->nbrActionTermine);?>
        <style>html body div#mainContent div#blockRight fieldset div<?php echo '#st'.$d->id;?>.ui-progressbar div.ui-progressbar-value{ border: 1px solid #aaaaaa; background: <?php echo getPercentColor($prCnt);?>; color: #222222; font-weight: bold;box-shadow:inner 4px 4px 4px #000; }</style>
            <script>
            $(function() {
                $( "#st<?php echo $d->id;?>" ).progressbar({
                    value: <?php echo $prCnt;?>
                });
            });
            </script>

            <p style="color: #E5EFFD; padding-left: 5px; font-size: 11px;"><?php echo $d->nom;?></p>
            <div  id="st<?php echo $d->id;?>"></div><hr style="margin-bottom: 10px; color:#945522; border: #945522;;"/>

    <?php } echo "<br/><a style='padding:10px; color:gold; font-size:10px; float:right;' href='index.php?page=statusServer&&categorie=$cat'>Revenir en arrière</a>";
    
    }else{

    $sql= "SELECT * FROM `taches` WHERE `categorie`='$cat' ORDER BY `id` ASC LIMIT 0, 100" ;
    $req = $DB->prepare($sql);
    $req->execute();
    
    while ($d = $req->fetch(PDO::FETCH_OBJ)) {

    $prCnt= CalculPourcentAvance($DB, 'tache', $d->id);?>
    <style>html body div#mainContent div#blockRight fieldset div<?php echo '#t'.$d->id;?>.ui-progressbar div.ui-progressbar-value{ border: 1px solid #aaaaaa; background: <?php echo getPercentColor($prCnt);?>; color: #222222; font-weight: bold;box-shadow:inner 4px 4px 4px #000; }</style>
        <script>
        $(function() {
            $( "#t<?php echo $d->id;?>" ).progressbar({
                value: <?php echo $prCnt;?>
            });
        });
        </script>

       <a style="color: orange; padding-left: 5px;" href="index.php?page=statusServer&&categorie=<?php echo $cat;?>&&tache=<?php echo $d->id;?>"><?php echo $d->tache;?>
        <div  id="t<?php echo $d->id;?>"></div></a><hr style="margin-bottom: 10px; color:#945522; border: #945522;;"/>

    <?php }
    echo "<br/><a style='padding:10px; color:gold; font-size:10px; float:right;' href='index.php?page=statusServer'>Revenir en arrière</a>";



}}else{
    
$sql= "SELECT * FROM `categorie` ORDER BY `id` ASC " ;
$req = $DB->prepare($sql);
$req->execute();

while ($d = $req->fetch(PDO::FETCH_OBJ)) {

$prCnt= CalculPourcentAvance($DB, 'categorie', $d->id);?>
<style> html body div#mainContent div#blockRight fieldset div<?php echo '#c'.$d->id;?>.ui-progressbar div.ui-progressbar-value.ui-widget-header { border: 1px solid #aaaaaa; background: <?php echo getPercentColor($prCnt);?>; color: #222222; font-weight: bold;box-shadow:inner 4px 4px 4px #000; }</style>
    <script>
    $(function() {
        $( "#c<?php echo $d->id;?>" ).progressbar({
            value: <?php echo $prCnt;?>
        });
    });
    </script>
    
    <a style="color: orange; padding-left: 5px;" href="index.php?page=statusServer&&categorie=<?php echo $d->id;?>"><?php echo $d->categorie;?>
    <div  id="c<?php echo $d->id;?>"></div></a><hr style="margin-bottom: 10px; color:#945522; border: #945522;;"/>
   
<?php }} ?>

</fieldset>