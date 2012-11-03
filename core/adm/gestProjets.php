<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],levelAccessAdministration) && !isset($_SESSION['Administrateur'])){
        header('Location: index.php');
    }
?>

<div id="titreAdministration">
    <p style =" font-size: 40px; color: #ffebb6;"> ADMINISTRATION<span style =" font-size: 16px; color: #c8c8c8;">GESTION DES PROJETS</span></p>
</div>

<?php if(isset($_GET['projetsAdd'])||isset($_GET['projetsDelete'])||isset($_GET['projetsEdit'])){ 

if(isset($_GET['projetsDelete']) && ($_GET['projetsDelete'])){
    
    $req = $DB->prepare("DELETE FROM `projets` WHERE (`id` = :idProjet)");
    if(!is_numeric($_GET['projetsDelete'])){
        header('Location: index.php?page=gestProjets');
    }
    $req->execute(array('idProjet' => $_GET['projetsDelete']));
    header('Location: index.php?page=gestProjets');
}
    
if(isset($_GET['projetsEdit']) && ($_GET['projetsEdit'])){
	$idprojet= $_GET['projetsEdit'];
	if((isset($_POST['projet'])) && (isset($_POST['FamilleProjets']))) {
		
		$projet= ucfirst($_POST['projet']);
		$idUser = $_SESSION['id'];
		$famille= ($_POST['FamilleProjets']);
		$ddebut= ($_POST['datedepart']);
		$dfin= ($_POST['datefin']);
		$statutprojet= ($_POST['StatutProjet']);
		
		$sql= "UPDATE `projets` SET `projet`=:projet, `familleId`=:famille, `date`=now(), `gmId`='$idUser', `datedebut`=:ddebut, `datefin`=:dfin, `idxstatutprojet`=:statutprojet ";
		$sql.="WHERE (`id`=$idprojet)";
		$req = $DB->prepare($sql);
		$req->execute(array('projet' => $projet,'famille' =>$famille,'ddebut' =>$ddebut,'dfin' =>$dfin,'statutprojet' =>$statutprojet));
		
		?>
		<fieldset>   
			<legend> Projet edité avec succés</legend>
			<br/>
			<h2 style="color:green;">Félicitations opération réussie!! </h2>
			 <br/> <br/>
			<a href="index.php?page=gestProjets">Revenir à la gestion des projets</a>
		</fieldset>

		<?php 
		
	}
	else{
		echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
	}

    $req = $DB->prepare("SELECT * FROM projets WHERE id = :idProjet");
    if(!is_numeric($_GET['projetsEdit'])){
        header('Location: index.php?page=gestProjets');
    }
    $req->execute(array('idProjet' => $_GET['projetsEdit']));
    
    $d = $req->fetch(PDO::FETCH_OBJ); ?>
    
        <form action="index.php?page=gestProjets&&projetsEdit=<?php echo $d->id; ?>" method="post" enctype="multipart/form-data">
            <fieldset>   
				<legend> Edition d'un projet</legend>

				<label>Projet</label><br/>
				<input type="text" name="projet" value="<?php echo $d->projet; ?>"/><br/><br/>
				
				<label>Famille:</label>
				<select name="FamilleProjets">
					<?php echo recupliste($DB,'famille',$d->familleId);
					?>
				</select><br/><br/>
				<label>Date de départ:</label>
				<input type="date" name="datedepart" value="<?php echo $d->datedebut;?>"/>
				<br/><br/>

				<label>Date de fin:</label>
				<input type="date" name="datefin" value="<?php echo $d->datefin;?>"/><br/><br/>

				<label>Statut:</label>
				<select name="StatutProjet">
					<?php echo recupliste($DB,'statutprojet',0);?>
				</select><br/><br/>				

			
            <input type="submit" value="Enregistrer" class="send"/>
            </fieldset> 
        </form>
    
 <?php    
}
 
if((isset($_GET['projetsAdd'])) &&($_GET['projetsAdd']==2)) { 
	if(isset($_POST['projet'])){
//		$titre=$_POST['projet'];

		$sql = "INSERT INTO `projets` ( `projet`, `date`, `gmId`,`familleId`,`datedebut`,`datefin`,`idxstatutprojet`) ";
		$sql.= "VALUES ( :projet, now(), :idUser, :idFamille, :ddebut, :dfin,:idstatut)";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'projet' => ucfirst($_POST['projet']),
			'idUser' => $_SESSION['id'],
			'idFamille' => $_POST['FamilleProjets'],
			'ddebut' => $_POST['datedepart'],
			'dfin' => $_POST['datefin'],
			'idstatut' => $_POST['StatutProjet']
		));
		unset ($_POST['projet']);
    }
    ?>
	<fieldset>   
		<legend> Projet crée avec succés</legend>
		<br/>
		<h2 style="color:green;">Félicitations, opération réussie!! </h2>
		<br/> <br/>
		<a href="index.php?page=gestProjets">Revenir à la gestion des projets</a>
	</fieldset>
	<?php    
}

if((isset($_GET['projetsAdd'])) &&($_GET['projetsAdd']==1)){ 
?>
        <form action="index.php?page=gestProjets&&projetsAdd=2" method="post">
            <fieldset>   
				<legend> Ajout d'un projet</legend>

				<label>Projet:</label>
				<input type="text" name="projet" value="<?php if(isset($_SESSION['projet'])){ echo $_SESSION['projet'];} ?>"/><br/><br/>

				<label>Famille:</label>
				<select name="FamilleProjets">
					<?php echo recupliste($DB,'famille',0);?>
				</select><br/><br/>				

				<label>Date de départ:</label>
				<input type="date" name="datedepart"/><br/><br/>

				<label>Date de fin:</label>
				<input type="date" name="datefin"/><br/><br/>

				<label>Statut:</label>
				<select name="StatutProjet">
					<?php echo recupliste($DB,'statutprojet',0);?>
				</select><br/><br/>				
				
				<input type="submit" value="Poster" class="send"/>
            </fieldset> 
        </form>
<?php }
}
else
{
?>
<fieldset>   
    <legend> Ajouter un projet</legend>
    <a href="index.php?page=gestProjets&&projetsAdd=1">Cliquez ici pour ajouter un projet...</a>
</fieldset>
<fieldset>   
    <legend> Liste des projets en cours</legend>
	 <table class="voteTop" style="border:none; text-align: center;">
		<thead>
			<th width='10'><strong></strong></th>
			<th width='240'><strong>Projet</strong></th>
			<th width='80'><strong>Propriétaire</strong></th>
			<th width='100'><strong>Date</strong></th>
			<th width='140'><strong>Famille</strong></th>
			<th width='140'><strong>Statut</strong></th>
			<th width='100'><strong>Début</strong></th>
			<th width='100'><strong>Fin</strong></th>
			<th width='60'><strong>Editer</strong></th>
			<th width='60'><strong>Supp.</strong></th>
		</thead>
<?php

		$sessionId = $_SESSION['id'];
		$sql= "SELECT * FROM `projets` ORDER BY `id` DESC LIMIT 0, 50" ;
		$req = $DB->prepare($sql);
		$req->execute();
		
		while ($d = $req->fetch(PDO::FETCH_OBJ)) {
		?>
			<tr style=" font-size:12px; color: #FFF; padding: 2px; height: 40px;">
				<td> <?php echo $d->id; ?></td>
				<td style="color: #FFE7A1; font-weight: bold;"> <strong><?php echo $d->projet; ?></strong></td>
				<td> <?php 
					echo getMainPerso($CHARS, $DB, $d->gmId);
					?>
				</td>
				<td> <?php echo convertTime_court($d->date); ?></td>
				<td> <?php echo recupobjetliste($DB,$d->familleId,'famille'); ?></td>
				<td> <?php echo recupobjetliste($DB,$d->idxstatutprojet,'statutprojet'); ?></td>
				<td> <?php echo convertTime_court($d->datedebut); ?></td>
				<td> <?php echo convertTime_court($d->datefin); ?></td>
				<td> <a href="index.php?page=gestProjets&&projetsEdit=<?php echo $d->id;?>">Editer</a></td>
				<td> <a href="index.php?page=gestProjets&&projetsDelete=<?php echo $d->id;?>">Supp.</a></td>
			</tr>
		<?php  
		} 
		?>
       </table>
<?php
}
?>
</fieldset>