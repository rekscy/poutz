<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],levelAccessAdministration) && !isset($_SESSION['Administrateur'])){
        header('Location: index.php');
    }
?>

<div id="titreAdministration">
    <p style =" font-size: 40px; color: #ffebb6;"> ADMINISTRATION<span style =" font-size: 16px; color: #c8c8c8;">GESTION DES STATUTS</span></p>
</div>

<?php if(isset($_GET['StatutsAdd'])||isset($_GET['StatutsDelete'])||isset($_GET['StatutsEdit'])){ 

if(isset($_GET['StatutsDelete']) && ($_GET['StatutsDelete'])){
    
    $req = $DB->prepare("DELETE FROM `statut` WHERE (`id` = :idstatut)");
    if(!is_numeric($_GET['StatutsDelete'])){
        header('Location: index.php?page=gestStatuts');
    }
	$cle = $_GET['StatutsDelete'];
    $req->execute(array('idstatut' => $cle));
	
	$req = $DB->prepare("UPDATE `tickets` set statutId = 0 WHERE (`statutid` = :idstatut)");
    $req->execute(array('idstatut' => $cle));
	
    header('Location: index.php?page=gestStatuts');
}
    
if(isset($_GET['StatutsEdit']) && ($_GET['StatutsEdit'])){
        $idstatut= $_GET['StatutsEdit'];
        if(isset($_POST['statut'])) {
            
		$statut= ucfirst($_POST['statut']);
		$idUser = $_SESSION['id'];
		
		$sql= "UPDATE `statut` SET `statut`=:monstatut WHERE (`id`=$idstatut)";
		$req = $DB->prepare($sql);
		$req->execute(array('monstatut' => $statut));
		
		?>
		<fieldset>   
			<legend> Statut edité avec succés</legend>
			<br/>
			<h2 style="color:green;">Félicitations opération réussie!! </h2>
			 <br/> <br/>
			<a href="index.php?page=gestStatuts">Revenir à la gestion des statuts</a>
		</fieldset>

		<?php 
		
	}
	else
	{
		echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
	}

    $req = $DB->prepare("SELECT * FROM statut WHERE id = :idstatut");
    if(!is_numeric($_GET['StatutsEdit'])){
        header('Location: index.php?page=gestStatuts');
    }
    $req->execute(array('idstatut' => $_GET['StatutsEdit']));
    
    $d = $req->fetch(PDO::FETCH_OBJ); ?>
    
        <form action="index.php?page=gestStatuts&&StatutsEdit=<?php echo $d->id; ?>" method="post" enctype="multipart/form-data">
            <fieldset>   
            <legend> Edition d'un statut</legend>
            <label>Statut</label><br/>
            <input type="text" name="statut" value="<?php echo $d->statut; ?>"/><br/><br/>
            <input type="submit" value="Enregistrer" class="send"/>
            </fieldset> 
        </form>
    
 <?php    
}
 
if((isset($_GET['StatutsAdd'])) &&($_GET['StatutsAdd']==2)) { 
	if(isset($_POST['statut'])){
		$statut=$_POST['statut'];

		$sql = "INSERT INTO `statut` (`statut`) VALUES ( :statut)";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'statut' => ucfirst($_POST['statut'])
		));
		unset ($_POST['statut']);
    }
    ?>
	<fieldset>   
		<legend> Catégorie créée avec succés</legend>
		<br/>
		<h2 style="color:green;">Félicitations, opération réussie!! </h2>
		<br/> <br/>
		<a href="index.php?page=gestStatuts">Revenir à la gestion des catégories</a>
	</fieldset>
	<?php    
}

if((isset($_GET['StatutsAdd'])) &&($_GET['StatutsAdd']==1)){ 
?>
        <form action="index.php?page=gestStatuts&&StatutsAdd=2" method="post">
            <fieldset>   
            <legend> Ajout d'un statut</legend>
                <label>Statut:</label>
                <input type="text" name="statut" value="<?php if(isset($_SESSION['statut'])){ echo $_SESSION['statut'];} ?>"/><br/><br/>
                <input type="submit" value="Poster" class="send"/>
            </fieldset> 
        </form>
<?php }
}
else
{
?>
<fieldset>   
    <legend> Ajouter un statut</legend>
    <a href="index.php?page=gestStatuts&&StatutsAdd=1">Cliquez ici pour ajouter un statut...</a>
</fieldset>
<fieldset>   
    <legend> Liste des statuts</legend>
	 <table class="voteTop" style="border:none; text-align: center;">
		<thead>
			<th width='10'><strong></strong></th>
			<th width='140'><strong>Statut</strong></th>
			<th width='80'><strong>Editer</strong></th>
			<th width='80'><strong>Supprimer</strong></th>
		</thead>
<?php

		$sessionId = $_SESSION['id'];
		$sql= "SELECT * FROM `statut` ORDER BY `statut` LIMIT 0, 50" ;
		$req = $DB->prepare($sql);
		$req->execute();
		
		while ($d = $req->fetch(PDO::FETCH_OBJ)) {
		?>
			<tr style=" font-size:12px; color: #FFF; padding: 2px; height: 40px;">
				<td> <?php echo $d->id; ?></td>
				<td style="color: #FFE7A1; font-weight: bold;"> <strong><?php echo $d->statut; ?></strong></td>
				<?php
				if ($d->system != 1) {
					?>
					<td> <a href="index.php?page=gestStatuts&&StatutsEdit=<?php echo $d->id;?>">Editer</a></td>
					<td> <a href="index.php?page=gestStatuts&&StatutsDelete=<?php echo $d->id;?>">Supprimer</a></td>
					<?php
				}
				else
				{
					?>
					<td> <a href="#"></a></td>
					<td> <a href="#"></a></td>				
					<?php
				}
				?>
			</tr>
		<?php  
		} 
		?>
       </table>
<?php
}
?>
</fieldset>