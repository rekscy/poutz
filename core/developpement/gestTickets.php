<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],0) && !isset($_SESSION['Administrateur'])){
       header('Location: index.php');
    }
?>
<div id="titreBugTracker">
    <p style =" font-size: 40px; color: #ffebb6;"> BUGTRACKER<span style =" font-size: 16px; color: #c8c8c8;">GESTION DES TICKETS</span></p><hr style="margin-top: -32px;" />
</div>

<?php if(isset($_GET['ticketsAdd'])||isset($_GET['ticketsDelete'])||isset($_GET['ticketsEdit'])){ 

if(isset($_GET['ticketsDelete']) && ($_GET['ticketsDelete'])){
    
    $req = $DB->prepare("DELETE FROM `tickets` WHERE (`id` = :idtickets)");
    if(!is_numeric($_GET['ticketsDelete'])){
        header('Location: index.php?page=gestTickets');
    }
    $req->execute(array('idtickets' => $_GET['ticketsDelete']));
	$req = $DB->prepare("DELETE FROM `ticketscommentaires` WHERE (`idtickets` = :idtickets)");
    header('Location: index.php?page=gestTickets');
}
    
if(isset($_GET['ticketsEdit']) && ($_GET['ticketsEdit'])){
	$idtickets = $_GET['ticketsEdit'];
	if((isset($_POST['tickets'])) && (isset($_POST['CategorieTickets']))) {
		$tickets= ucfirst($_POST['tickets']);
		$idUser = $_SESSION['id'];
		$categorie= ($_POST['CategorieTickets']);
		$statut= ($_POST['StatutTickets']);
		$commentaire = ($_POST['contentTickets']);
		$numero = ($_POST['numero']) + 1;
		
		// Modification du tickets
		$sql = "UPDATE `tickets` SET `tickets`=:montickets, `categorieId`=$categorie, `statutId`=$statut, `date`=now(), `proprioId`='$idUser' WHERE (`id`=$idtickets)";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'montickets' => $tickets
		));
		// Ajout du commentaire (on ne modifie pas pour garder la traçabilité
		$sql = "INSERT INTO `ticketscommentaires` ( `idtickets`, `numero`,`datecommentaire`, `proprioId`,`commentaire`) VALUES ( :tickets, :numero, now(), :idUser, :commentaire)";
		$req = $DB->prepare($sql);
		echo "*".$sql."*".$commentaire."*";
		$req->execute(array(
			'tickets' => $idtickets,
			'numero' => $numero,
			'idUser' => $_SESSION['id'],
			'commentaire' => $commentaire,
		));

		unset ($_POST['tickets']);
		 ?>
		<fieldset>   
			<legend> Tickets edité avec succés</legend>
			<br/>
			<h2 style="color:green;">Félicitations opération réussie!! </h2>
			 <br/> <br/>
			<a href="index.php?page=gestTickets">Revenir à la gestion des tickets</a>
		</fieldset>

		<?php 
		
	}
	else{
		echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
	}

	$sql = "SELECT * FROM ";
	$sql.= "tickets as t1 ";
	$sql.= "left join ticketscommentaires as t2 on (t1.id = t2.idtickets) ";
	$sql.="WHERE t1.id = :idtickets ";
	$sql.= "ORDER BY numero DESC";
	
    $req = $DB->prepare($sql);
    if(!is_numeric($_GET['ticketsEdit'])){
        header('Location: index.php?page=gestTickets');
    }
    $req->execute(array('idtickets' => $_GET['ticketsEdit']));
	$nbrCommentaire = $req->rowcount();
	$bValide = 1;
	while ($d = $req->fetch(PDO::FETCH_OBJ)) {
		if ($bValide == 1)
		{
			$bValide = 2;
			?>
			<form action="index.php?page=gestTickets&&ticketsEdit=<?php echo $d->id; ?>" method="post" enctype="multipart/form-data">
			<fieldset>   
			<legend> Edition d'un ticket</legend>
			<label>Titre du ticket:</label><br/>
			<input type="text" name="tickets" value="<?php echo $d->tickets; ?>"/><br/><br/>
			<label>Catégorie:</label>
			<select name="CategorieTickets">
				<?php echo recupliste($DB,'categorie',$d->categorieId);?>
			</select><br/><br/>
			<?php 
			if (isset($_SESSION['Administrateur'])): ?>
				<label>Statut:</label>
				<select name="StatutTickets">
					<?php echo recupliste($DB,'statut',$d->statutId);?>
				</select>
				<input type="text" name="numero" style="visibility:hidden" value="<?php echo $d->numero; ?>"/>
				<br/><br/>
			<?php
			endif;
			?>				
			<label>Contenu:</label>
			<textarea cols="80" rows="10" name="contentTickets"><?php echo $d->commentaire; ?></textarea>
			
			<input type="submit" value="Enregistrer" class="send"/>
			<br/><br/>
			<?php
		}
		else
		{
			?>
			<label>Contenu du : <?php echo $d->datecommentaire." par Paulo";?></label>
			<textarea cols="80" rows="10" style="background-color:lightsteelblue;" readonly="readonly" name="contentTickets2"><?php echo $d->commentaire; ?></textarea>
			<?php
		}
	}
	?>
	</fieldset> 
	</form>
	<?php    
}
 
if((isset($_GET['ticketsAdd'])) &&($_GET['ticketsAdd']==2)) { 
	if(isset($_POST['tickets'])){
		$titre=$_POST['tickets'];

		// création de l'entete du ticket
		$sql = "INSERT INTO `tickets` ( `tickets`, `date`, `proprioId`,`categorieId`) VALUES ( :tickets, now(), :idUser, :idCategorie)";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'tickets' => ucfirst($_POST['tickets']),
			'idUser' => $_SESSION['id'],
			'idCategorie' => $_POST['CategorieTickets'],
		));
		
		// récupération de l'id du ticket crée
		$sql = "SELECT id as idtickets FROM `tickets` WHERE `tickets` = :idtickets and `proprioId` = :idUser and `categorieId`= :idCategorie";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'idtickets' => ucfirst($_POST['tickets']),
			'idUser' => $_SESSION['id'],
			'idCategorie' => $_POST['CategorieTickets']
		));
		$d = $req->fetch(PDO::FETCH_OBJ);
		$idticket = $d->idtickets;
		
		// création du premier commentaire
		$sql = "INSERT INTO `ticketscommentaires` ( `idtickets`, `datecommentaire`, `proprioId`,`commentaire`) VALUES ( :tickets, now(), :idUser, :commentaire)";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'tickets' => $idticket,
			'idUser' => $_SESSION['id'],
			'commentaire' => $_POST['contentTickets'],
		));
		unset ($_POST['tickets']);
    }
    ?>
	<fieldset>   
		<legend> Tickets crée avec succés</legend>
		<br/>
		<h2 style="color:green;">Félicitations, opération réussie!! </h2>
		<br/> <br/>
		<a href="index.php?page=gestTickets">Revenir à la gestion des tickets</a>
	</fieldset>
	<?php    
}

if((isset($_GET['ticketsAdd'])) &&($_GET['ticketsAdd']==1)){ 
?>
        <form action="index.php?page=gestTickets&&ticketsAdd=2" method="post">
            <fieldset>   
            <legend> Ajout d'un tickets</legend>
                <label>Titre du ticket:</label>
                <input type="text" name="tickets" value="<?php if(isset($_SESSION['tickets'])){ echo $_SESSION['tickets'];} ?>"/><br/><br/>
				<label>Catégorie:</label>
				<select name="CategorieTickets">
					<?php echo recupliste($DB,'categorie',0);
					?>
				</select><br/><br/>				
                <label>Contenu:</label>
                <textarea cols="80" rows="30"  name="contentTickets"><?php if(isset($_SESSION['contentTickets'])){ echo $_SESSION['contentTickets'];} ?></textarea>
                <input type="submit" value="Poster" class="send"/>
            </fieldset> 
        </form>
<?php }
}
else
{
?>
<fieldset>   
    <legend> Ajouter un tickets</legend>
    <a href="index.php?page=gestTickets&&ticketsAdd=1">Cliquez ici pour ajouter un tickets...</a>
</fieldset>
<fieldset>   
    <legend> Liste des tickets en cours</legend>
	 <table class="voteTop" style="border:none; text-align: center;">
		<thead>
			<th width='10'><strong></strong></th>
			<th width='240'><strong>Tickets</strong></th>
			<th width='80'><strong>Propriétaire</strong></th>
			<th width='80'><strong>Date</strong></th>
			<th width='140'><strong>Catégorie</strong></th>
			<th width='140'><strong>Statut</strong></th>
                        
			<th width='60'><strong>Editer</strong></th>
			<th width='60'><strong>Supp.</strong></th>
		</thead>
<?php
		$sessionId = $_SESSION['id'];
		$sql= "SELECT * FROM `tickets` ORDER BY `id` DESC LIMIT 0, 50" ;
		$req = $DB->prepare($sql);
		$req->execute();
		
		while ($d = $req->fetch(PDO::FETCH_OBJ)) {
		?>
			<tr style=" font-size:12px; color: #FFF; padding: 2px; height: 40px;">
				<td> <?php echo $d->id; ?></td>
				<td style="color: #FFE7A1; font-weight: bold;"> <strong><?php echo $d->tickets; ?></strong></td>
				<td> <?php echo getMainPerso($CHARS, $DB, $d->proprioId); ?></td>
				<td> <?php echo convertTime_court($d->date); ?></td>
				<td> <?php echo recupobjetliste($DB,$d->categorieId,'categorie'); ?></td>
				<td> <?php echo recupobjetliste($DB,$d->statutId,'statut'); ?></td>
				<?php
					if (($d->statutId != 3) && $sessionId == $d->proprioId || (isset($_SESSION['Administrateur']))) {
						?>
						<td> <a href="index.php?page=gestTickets&&ticketsEdit=<?php echo $d->id;?>">Editer</a></td>
						<td> <a href="index.php?page=gestTickets&&ticketsDelete=<?php echo $d->id;?>">Supp.</a></td>
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