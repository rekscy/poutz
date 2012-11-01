<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],levelAccessAdministration) && !isset($_SESSION['Administrateur'])){
        header('Location: index.php');
    }
?>

<div id="titreAdministration">
    <p style =" font-size: 40px; color: #ffebb6;"> ADMINISTRATION<span style =" font-size: 16px; color: #c8c8c8;">GESTION DES FAMILLES</span></p>
</div>

<?php if(isset($_GET['famillesAdd'])||isset($_GET['famillesDelete'])||isset($_GET['famillesEdit'])){ 

if(isset($_GET['famillesDelete']) && ($_GET['famillesDelete'])){
    
    $req = $DB->prepare("DELETE FROM `famille` WHERE (`id` = :idfamille)");
    if(!is_numeric($_GET['famillesDelete'])){
        header('Location: index.php?page=gestFamilles');
    }
	$cle = $_GET['famillesDelete'];
    $req->execute(array('idfamille' => $cle));
	
	$req = $DB->prepare("UPDATE `projets` set familleId = 0 WHERE (`familleId` = :idfamille)");
    $req->execute(array('idfamille' => $cle));
	
    header('Location: index.php?page=gestFamilles');
}
    
if(isset($_GET['famillesEdit']) && ($_GET['famillesEdit'])){
        $idfamille= $_GET['famillesEdit'];
        if(isset($_POST['famille'])) {
            
            $famille= ucfirst($_POST['famille']);
            $idUser = $_SESSION['id'];
            
            $sql= "UPDATE `famille` SET `famille`=:famille WHERE (`id`=$idfamille)";
            $req = $DB->prepare($sql);
            $req->execute(array('famille' => $famille));
            
            ?>
            <fieldset>   
                <legend> Famille editée avec succés</legend>
                <br/>
                <h2 style="color:green;">Félicitations opération réussie!! </h2>
                 <br/> <br/>
                <a href="index.php?page=gestFamilles">Revenir à la gestion des familles</a>
            </fieldset>

            <?php 
            
        }else{
                 echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
                }

    $req = $DB->prepare("SELECT * FROM famille WHERE id = :idfamille");
    if(!is_numeric($_GET['famillesEdit'])){
        header('Location: index.php?page=gestFamilles');
    }
    $req->execute(array('idfamille' => $_GET['famillesEdit']));
    
    $d = $req->fetch(PDO::FETCH_OBJ); ?>
    
        <form action="index.php?page=gestFamilles&&famillesEdit=<?php echo $d->id; ?>" method="post" enctype="multipart/form-data">
            <fieldset>   
            <legend> Edition d'une famille</legend>
            <label>Famille</label><br/>
            <input type="text" name="famille" value="<?php echo $d->famille; ?>"/><br/><br/>
            <input type="submit" value="Enregistrer" class="send"/>
            </fieldset> 
        </form>
    
 <?php    
}
 
if((isset($_GET['famillesAdd'])) &&($_GET['famillesAdd']==2)) { 
	if(isset($_POST['famille'])){
		$famille=$_POST['famille'];

		$sql = "INSERT INTO `famille` (`famille`) VALUES ( :famille)";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'famille' => ucfirst($_POST['famille'])
		));
		unset ($_POST['famille']);
    }
    ?>
	<fieldset>   
		<legend> Famille créée avec succés</legend>
		<br/>
		<h2 style="color:green;">Félicitations, opération réussie!! </h2>
		<br/> <br/>
		<a href="index.php?page=gestFamilles">Revenir à la gestion des projets</a>
	</fieldset>
	<?php    
}

if((isset($_GET['famillesAdd'])) &&($_GET['famillesAdd']==1)){ 
?>
        <form action="index.php?page=gestFamilles&&famillesAdd=2" method="post">
            <fieldset>   
            <legend> Ajout d'une famille</legend>
                <label>Famille:</label>
                <input type="text" name="famille" value="<?php if(isset($_SESSION['famille'])){ echo $_SESSION['famille'];} ?>"/><br/><br/>
                <input type="submit" value="Poster" class="send"/>
            </fieldset> 
        </form>
<?php }
}
else
{
?>
<fieldset>   
    <legend> Ajouter une famille</legend>
    <a href="index.php?page=gestFamilles&&famillesAdd=1">Cliquez ici pour ajouter une famille...</a>
</fieldset>
<fieldset>   
    <legend> Liste des famille</legend>
	 <table class="voteTop" style="border:none; text-align: center;">
		<thead>
			<th width='10'><strong></strong></th>
			<th width='140'><strong>Famille</strong></th>
			<th width='80'><strong>Editer</strong></th>
			<th width='80'><strong>Supprimer</strong></th>
		</thead>
<?php

		$sessionId = $_SESSION['id'];
		$sql= "SELECT * FROM `famille` ORDER BY `famille` LIMIT 0, 50" ;
		$req = $DB->prepare($sql);
		$req->execute();
		
		while ($d = $req->fetch(PDO::FETCH_OBJ)) {
		?>
			<tr style=" font-size:12px; color: #FFF; padding: 2px; height: 40px;">
				<td> <?php echo $d->id; ?></td>
				<td style="color: #FFE7A1; font-weight: bold;"> <strong><?php echo $d->famille; ?></strong></td>
				<td> <a href="index.php?page=gestFamilles&&famillesEdit=<?php echo $d->id;?>">Editer</a></td>
				<td> <a href="index.php?page=gestFamilles&&famillesDelete=<?php echo $d->id;?>">Supprimer</a></td>
			</tr>
		<?php  
		} 
		?>
       </table>
<?php
}
?>
</fieldset>