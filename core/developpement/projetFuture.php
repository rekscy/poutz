<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],0) && !isset($_SESSION['Administrateur'])){
       header('Location: index.php');
    }
?>
<div id="projetEnCours">
    <p style =" font-size: 40px; color: #ffebb6;"> DEVELOPPEMENT<span style =" font-size: 16px; color: #c8c8c8;">PROJETS FUTURS</span></p><hr style="margin-top: -32px;" />
</div>

<fieldset>   
    <legend> Liste des projets à executer dans un future proche</legend>
	 <table class="voteTop" style="border:none; text-align: center;">
		<thead>
			<th width='10'><strong></strong></th>
			<th width='240'><strong>Projet</strong></th>
			<th width='80'><strong>Propriétaire</strong></th>
			<th width='140'><strong>Crée le</strong></th>
			<th width='140'><strong>Famille</strong></th>
			<th width='80'><strong>Débute le:</strong></th>
		</thead>
<?php
                
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
					?></td>
				<td> <?php echo convertTime($d->date); ?></td>
				<td> <?php echo recupobjetliste($DB,$d->familleId,'famille'); ?></td>
				<td> </td>
			</tr>
		<?php  
		} 
		?>
       </table>
</fieldset>