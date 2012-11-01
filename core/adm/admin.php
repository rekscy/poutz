<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],levelAccessAdministration) && !isset($_SESSION['Administrateur'])){
        header('Location: index.php');
    }
?>

<div id="titreAdministration">
    <p style =" font-size: 40px; color: #ffebb6;"> ADMINISTRATION<span style =" font-size: 16px; color: #c8c8c8;">AVANCEE SERVEUR</span></p>
</div>

<?php
if((isset($_GET['projetsAdd'])) &&($_GET['projetsAdd']==2)) { 
	if(isset($_POST['projet'])){
		$titre=$_POST['projet'];

		$sql = "INSERT INTO `projets` ( `projet`, `date`, `gmId`,`familleId`) VALUES ( :projet, now(), :idUser, :idFamille)";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'projet' => ucfirst($_POST['projet']),
			'idUser' => $_SESSION['id'],
			'idFamille' => $_POST['FamilleProjets']
		));
		unset ($_POST['projet']);
    }
?>
<fieldset>   
        <legend> Projet crée avec succés</legend>
        <br/>
        <h2 style="color:green;">Félicitations, opération réussie!! </h2>
        <br/> <br/>
        <a href="index.php?page=admin">Revenir à la gestion des projets</a>
</fieldset>
<?php 
}
if((isset($_GET['projetsAdd'])) &&($_GET['projetsAdd']==1)){ ?>
<form action="index.php?page=admin&&projetsAdd=2" method="post">
    <fieldset>   
    <legend> Ajout d'un projet</legend>
        <label>Tache:</label>
        <input type="text" name="projet" value="<?php if(isset($_SESSION['projet'])){ echo $_SESSION['projet'];} ?>"/><br/><br/>
            <label>Famille:</label>
            <select name="FamilleProjets">
                <?php echo recupliste($DB,'famille',0);?>
             </select><br/><br/>				
        <input type="submit" value="Poster" class="send"/>
    </fieldset> 
</form>
<?php } else{ ?>

<!--ONGLET AJOUTER UN PROJET-->
<fieldset>   
    <legend> Ajouter un projet</legend>
    <a href="index.php?page=gestProjets&&projetsAdd=1">Cliquez ici pour ajouter un projet...</a>
</fieldset>
<fieldset>
    
<!--AVANCEE SERVEUR-->
<legend> Avancée du serveur</legend>
<fieldset style="background:  #0A0501; border: #945522 1px solid; margin-bottom: 5px; margin-left: 3px; padding: 1px; ">   
<legend>Communiqué à toute l'équipe:</legend>
<p style="color:red; font-weight: bold; padding-left: 10px;">Merci de récoleter les informations concernant le jeu.</p>
<?php   
$sql = "SELECT * FROM `sous-taches`";
$req = $DB->prepare($sql);
$req->execute();

$perentTotal = 1;

$d = $req->fetchAll(PDO::FETCH_OBJ);
$nbrResult = count($d);

$prCnt= calculPercent(5000, $nbrResult);?>
<style>html body div#content div#content fieldset fieldset div#serveur.ui-progressbar div.ui-progressbar-value{ border: 1px solid #aaaaaa; background: <?php echo getPercentColor($prCnt);?>; color: #222222; font-weight: bold;box-shadow:inner 4px 4px 4px #000; }</style>

<script>
$(function() {
    $( "#serveur" ).progressbar({
        value: <?php echo $prCnt;?>
    });
});
</script>

<span style="color: orange;font-weight: bold; padding-left: 5px;" >Progression total</span>
<div  id="serveur"></div></a><hr style="margin-bottom: 10px; color:#945522; border: #945522;"/>
</fieldset>


<!--STATISTIQUES DEBUG-->
<fieldset style="background:  #0A0501; border: #080301 1px solid; margin-bottom: 5px; margin-left: 3px; padding: 1px; ">   
<legend>Statistiques du niveau de débogue</legend>
<?php 

if(isset($_GET['categorie'])&&  is_numeric($_GET['categorie'])){
    
$cat =stripcslashes($_GET['categorie']);

    if(isset($_GET['tache'])&&  is_numeric($_GET['tache'])){
        
        $tache =stripcslashes($_GET['tache']);

        if(isset($_GET['sousTache'])&&  is_numeric($_GET['sousTache'])){        // PARTIE DETAIL & EDITION -SOUS-TACHES COMMENCE ICI
            $sousTache =stripcslashes($_GET['sousTache']);
            
        }else{         //PARTIE MENU-SOUS-TACHES COMMENCE ICI
        
        $sql= "SELECT * FROM `sous-taches` WHERE `categorie`='$cat' && `tache`='$tache'  ORDER BY `id` ASC LIMIT 0, 100" ;
        $req = $DB->prepare($sql);
        $req->execute();
        while ($d = $req->fetch(PDO::FETCH_OBJ)) {

        $prCnt= calculPercent($d->nbrTotalAction, $d->nbrActionTermine);?>
        <style>html body div#content div#content fieldset fieldset div<?php echo '#st'.$d->id;?>.ui-progressbar div.ui-progressbar-value{ border: 1px solid #aaaaaa; background: <?php echo getPercentColor($prCnt);?>; color: #222222; font-weight: bold;box-shadow:inner 4px 4px 4px #000; }</style>
            <script>
            $(function() {
                $( "#st<?php echo $d->id;?>" ).progressbar({
                    value: <?php echo $prCnt;?>
                });
            });
            </script>

            <p style="color: #E5EFFD; padding-left: 5px; font-size: 11px;"><?php echo $d->nom;?></p>
            <div  id="st<?php echo $d->id;?>"></div><hr style="margin-bottom: 10px; color:#945522; border: #945522;;"/>

    <?php } echo "<br/><a style='padding:10px; color:gold; font-size:10px; float:right;' href='index.php?page=admin&&categorie=$cat'>Revenir en arrière</a>";
    
        }}else{ //PARTIE MENU-TACHES COMMENCE ICI 
         
       if(isset($_GET['addTache'])&&  is_numeric($_GET['addTache'])){ 
            if(isset($_POST)&&!empty($_POST)){ 
             
                ajouterTache($DB,$_POST['titre'],$cat);
                header("Location: index.php?page=admin&&categorie=$cat");
            }           
            ?>

            <fieldset>   
            <legend> Ajout d'une tache</legend>
                <form action="index.php?page=admin&&categorie=<?php echo $cat;?>&&addTache=1" method="post">
                <label for="titre">Titre de la nouvelle tâche: </label><input type="text" name="titre" value=""/><br/>
                <input type="hidden" name="cat" value="<?php echo $cat; ?>"/><br/>
                <input type="submit" value="Ajouter" class="send"/>
                <form>
            </fieldset> 
        </form>
<?php }else{ ?>
<fieldset style="background:  #0A0501; border: #945522 1px solid; margin-bottom: 5px; margin-left: 0px;margin-bottom: 5px; padding: 3px; ">   
<legend>Ajouter une tache</legend>
    <a style="color: orange; padding-left: 5px; " href="index.php?page=admin&&categorie=<?php echo $cat;?>&&addTache=1">Cliquez ici...</a>
</fieldset>      
<?php }
    $sql= "SELECT * FROM `taches` WHERE `categorie`='$cat' ORDER BY `id` ASC LIMIT 0, 100" ;
    $req = $DB->prepare($sql);
    $req->execute();
    
    while ($d = $req->fetch(PDO::FETCH_OBJ)) {

    $prCnt= CalculPourcentAvance($DB, 'tache', $d->id);?>
    <style>html body div#content div#content fieldset fieldset div<?php echo '#t'.$d->id;?>.ui-progressbar div.ui-progressbar-value{ border: 1px solid #aaaaaa; background: <?php echo getPercentColor($prCnt);?>; color: #222222; font-weight: bold;box-shadow:inner 4px 4px 4px #000; }</style>
        <script>
        $(function() {
            $( "#t<?php echo $d->id;?>" ).progressbar({
                value: <?php echo $prCnt;?>
            });
        });
        </script>

        <?php if(verifPermissionAccess($REALM,$_SESSION['id'],levelAccessAdministration) && isset($_SESSION['Administrateur'])){ ?>
            <a style="color:red; font-size: 9px; float: right;" href="index.php?page=admin&&categorie=<?php echo $cat;?>&&delTache=<?php echo $d->id;?>">Supprimer </a>
            <a style="color:white; font-size: 11px; float: right;">//</a>
            <a style="color:orange; font-size: 9px; float: right;" href="index.php?page=admin&&categorie=<?php echo $cat;?>&&editTache=<?php echo $d->id;?>">Editer </a>
        <?php } ?>   
       <a style="color: orange; padding-left: 5px;" href="index.php?page=admin&&categorie=<?php echo $cat;?>&&tache=<?php echo $d->id;?>"><?php echo $d->tache;?>
       <div  id="t<?php echo $d->id;?>"></div></a> 
     
        <hr style="margin-bottom: 10px; color:#945522; border: #945522;;"/>

    <?php }
    echo "<br/><a style='padding:10px; color:gold; font-size:10px; float:right;' href='index.php?page=admin'>Revenir en arrière</a>";



}}else{ //PARTIE MENU-CATEGORIES COMMENCE ICI
    
$sql= "SELECT * FROM `categorie` ORDER BY `id` ASC " ;
$req = $DB->prepare($sql);
$req->execute();

while ($d = $req->fetch(PDO::FETCH_OBJ)) {

$prCnt= CalculPourcentAvance($DB, 'categorie', $d->id);?>
<style> html body div#content div#content fieldset fieldset div<?php echo '#c'.$d->id;?>.ui-progressbar div.ui-progressbar-value.ui-widget-header { border: 1px solid #aaaaaa; background: <?php echo getPercentColor($prCnt);?>; color: #222222; font-weight: bold;box-shadow:inner 4px 4px 4px #000; }</style>
    <script>
    $(function() {
        $( "#c<?php echo $d->id;?>" ).progressbar({
            value: <?php echo $prCnt;?>
        });
    });
    </script>
    
    <a style="color: orange; padding-left: 5px;" href="index.php?page=admin&&categorie=<?php echo $d->id;?>"><?php echo $d->categorie;?>
    <div  id="c<?php echo $d->id;?>"></div></a><hr style="margin-bottom: 10px; color:#945522; border: #945522;;"/>
   
<?php }} ?>

</fieldset>

<?php } ?>