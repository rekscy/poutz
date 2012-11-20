<script type="text/javascript" >
  $(document).ready(function() {
    var $categories = $('#categories');
    var $SousCategories = $('#SousCategories');
     
    // chargement des categories
    $.ajax({
        url: 'template/ajax/menuCategories/categories.php',
        data: 'idCategorie', // on envoie $_GET['idCategorie']
        dataType: 'json', // on veut un retour JSON
        success: function(json) {
            $.each(json, function(index, value) { // pour chaque noeud JSON
                // on ajoute l option dans la liste
                $categories.append('<option value="'+ index +'">'+ value +'</option>');
            });
        }
    });
 
    // à la sélection d une catégorie dans la liste
    $categories.on('change', function() {
        var val = $(this).val(); // on récupère la valeur des categories
 
        if(val != '') {
            $SousCategories.empty(); // on vide la liste des sous categories
             
            $.ajax({
                url: 'template/ajax/menuCategories/categories.php',
                data: 'idSousCategorie='+ val, // on envoie $_GET['idSousCategorie']
                dataType: 'json',
                success: function(json) {
                    $.each(json, function(index, value) {
                        $SousCategories.append('<option value="'+ index +'">'+ value +'</option>');
                    });
                }
            });
        }
    });
    });
</script>

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
	if((isset($_POST['tickets'])) && (isset($_POST['categories']))) {
		$tickets= ucfirst($_POST['tickets']);
		$idUser = $_SESSION['id'];
		$categorie= ($_POST['categories']);
		$sousCategorie= ($_POST['SousCategories']);
		$statut= ($_POST['StatutTickets']);
		$commentaire = ($_POST['contentTickets']);
		$numero = ($_POST['numero']) + 1;
		
		// Modification du tickets
		$sql = "UPDATE `tickets` SET `tickets`=:montickets, `categorieId`=$categorie,`tacheId`=$sousCategorie, `statutId`=$statut, `date`=now(), `proprioId`='$idUser' WHERE (`id`=$idtickets)";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'montickets' => $tickets
		));
		// Ajout du commentaire (on ne modifie pas pour garder la traçabilité
		$sql = "INSERT INTO `ticketscommentaires` ( `idtickets`, `numero`,`datecommentaire`, `proprioId`,`commentaire`) VALUES ( :tickets, :numero, now(), :idUser, :commentaire)";
		$req = $DB->prepare($sql);

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
			<select id="categories" name="categories">
                            <option value=" <?php echo $d->categorieId; ?>"><?php echo recupobjetliste($DB, 'categories', 'nom', $d->categorieId, null);  ?></option>
			</select><br/><br/>
			<label>Sous-catégorie:</label>
			<select id="SousCategories" name="SousCategories">
                            <option value=" <?php echo $d->tacheId; ?>"><?php echo recupobjetliste($DB, 'taches', 'nom', $d->tacheId, null);  ?></option>
			</select><br/><br/>
			<?php 
			if (isset($_SESSION['Administrateur'])): ?>
				<label>Statut:</label>
				<select name="StatutTickets">
					<?php echo recupliste($DB,'statut','statut',$d->statutId);?>
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
			
			<div style=" border: 1px saddlebrown solid; margin: 3px; padding: 4px;font-size:10px; line-height: 11px; vertical-align: top; background-color:#28221c; color: #6c3b22;" name="contentTickets2">
                            <p style="font-size: 12px; text-transform: uppercase; color:gold;">Commentaire posté le <?php echo convertTime($d->datecommentaire)." par ". getMainPerso($CHARS, $DB, $d->proprioId);?></p>
                            <hr/>
                            <div style="color:white;"><?php echo $d->commentaire; ?></div>
                        </div>
			<?php
		}
	}
	?>
	</fieldset> 
	</form>
	<?php    
}
 
if((isset($_GET['ticketsAdd'])) &&($_GET['ticketsAdd']==2)) { 
	if(isset($_POST['tickets'])&& isset($_POST['categories']) && isset($_POST['categories']) && !empty($_POST['tickets'])&& !empty($_POST['categories']) && !empty($_POST['categories']) ){
		$titre=$_POST['tickets'];

		// création de l'entete du ticket
		$sql = "INSERT INTO `tickets` ( `tickets`, `date`, `proprioId`,`categorieId`,`tacheId`) VALUES ( :tickets, now(), :idUser, :idCategorie, :tacheId)";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'tickets' => ucfirst($_POST['tickets']),
			'idUser' => $_SESSION['id'],
			'idCategorie' => $_POST['categories'],
			'tacheId' => $_POST['SousCategories'],
		));
		
		// récupération de l'id du ticket crée
		$sql = "SELECT id as idtickets FROM `tickets` WHERE `tickets` = :idtickets and `proprioId` = :idUser and `categorieId`= :idCategorie";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'idtickets' => ucfirst($_POST['tickets']),
			'idUser' => $_SESSION['id'],
			'idCategorie' => $_POST['categories']
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
    
    ?>
	<fieldset>   
		<legend> Tickets crée avec succés</legend>
		<br/>
		<h2 style="color:green;">Félicitations, opération réussie!! </h2>
		<br/> <br/>
		<a href="index.php?page=gestTickets">Revenir à la gestion des tickets</a>
	</fieldset>
	<?php    
}else{
    echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span> <br/><a href='index.php?page=gestTickets'>Revenir à la gestion des tickets</a>";
    
}


}

if((isset($_GET['ticketsAdd'])) &&($_GET['ticketsAdd']==1)){ 
?>
        <form action="index.php?page=gestTickets&&ticketsAdd=2" method="post">
            <fieldset>   
            <legend> Ajout d'un tickets</legend>
                <label>Titre du ticket:</label>
                <input type="text" name="tickets" value="<?php if(isset($_SESSION['tickets'])){ echo $_SESSION['tickets'];} ?>"/><br/><br/>
			<label>Catégorie:</label>
			<select id="categories" name="categories">
                            <option value=""></option>
			</select><br/><br/>
			<label>Sous-catégorie:</label>
			<select id="SousCategories" name="SousCategories">
                            <option value=""></option>
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
    <div id="listeBug">
<?php
		$sessionId = $_SESSION['id'];
		$sql= "SELECT * FROM `tickets` ORDER BY `id` DESC LIMIT 0, 50" ;
		$req = $DB->prepare($sql);
		$req->execute();
		
		while ($d = $req->fetch(PDO::FETCH_OBJ)) {                   // recupobjetliste($DB, $table, $colonne, $valeur, $condition)
		?>
        <div id="bugNum<?php echo $d->id; ?>" class="reportDev">
                <?php 
            if (($d->statutId != 3) && $sessionId == $d->proprioId || (isset($_SESSION['Administrateur']))) {?>
                <div style="float:right; ">    
                <a style="font-size: 9px;" href="index.php?page=gestTickets&&ticketsEdit=<?php echo $d->id;?>">Editer</a> //
                <a style="font-size: 9px; color: red;" href="index.php?page=gestTickets&&ticketsDelete=<?php echo $d->id;?>">Supp.</a>
                </div>
            <?php }?>
            <div style=" background:  #0A0501; border: #080301 1px solid; margin-bottom: 5px; margin-left: 3px; padding: 1px; ">
                <p style="color:orange;">
                    <span style="color:#<?php echo recupobjetliste($DB,'statut','couleur',$d->statutId,null); ?>; font-size: 10px;"><?php echo recupobjetliste($DB,'statut','statut',$d->statutId,null); ?></span>
                    <span style="color:#8b8b8b; font-size: 10px;"><?php echo recupobjetliste($DB,'categories','nom',$d->categorieId,null); ?> ></span>
                    <span style="color:#8b8b8b; font-size: 10px;"><?php echo recupobjetliste($DB,'taches','nom',$d->tacheId,null); ?> ></span>

                    <a href="index.php?page=viewTicket&&ticketId=<?php echo $d->id; ?>"> <?php echo $d->tickets; ?></a>
                </p>
                <p style="color: #E5EFFD; padding-left: 6px; font-size: 10px;"><?php echo chaineLimitee(recupobjetliste($DB,'ticketscommentaires','commentaire',null,array('idtickets'=>$d->id,'numero'=>1 )),30); ?></p>
                
                <p style="color: #E5EFFD; padding-left: 6px; font-size: 10px;">Reporté par <span style="color: #FFBD69"><?php echo getMainPerso($CHARS, $DB, $d->proprioId); ?> </span>le <span style="color: #FFBD69"><?php echo convertTime($d->date); ?></span>  </p> 
            </div>
        </div> 
    <?php }?> 
    </div>
<?php
}
?>
</fieldset>
