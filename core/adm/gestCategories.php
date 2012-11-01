<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],levelAccessAdministration) && !isset($_SESSION['Administrateur'])){
        header('Location: index.php');
    }
?>

<div id="titreAdministration">
    <p style =" font-size: 40px; color: #ffebb6;"> ADMINISTRATION<span style =" font-size: 16px; color: #c8c8c8;">GESTION DES CATEGORIES</span></p>
</div>

<?php if(isset($_GET['categoriesAdd'])||isset($_GET['categoriesDelete'])||isset($_GET['categoriesEdit'])){ 

if(isset($_GET['categoriesDelete']) && ($_GET['categoriesDelete'])){
    
    $req = $DB->prepare("DELETE FROM `categorie` WHERE (`id` = :idcategorie)");
    if(!is_numeric($_GET['categoriesDelete'])){
        header('Location: index.php?page=gestCategories');
    }
	$cle = $_GET['categoriesDelete'];
    $req->execute(array('idcategorie' => $cle));
	
	$req = $DB->prepare("UPDATE `tickets` set categorieId = 0 WHERE (`categorieId` = :idcategorie)");
    $req->execute(array('idcategorie' => $cle));
	
    header('Location: index.php?page=gestCategories');
}
    
if(isset($_GET['categoriesEdit']) && ($_GET['categoriesEdit'])){
        $idcategorie= $_GET['categoriesEdit'];
        if(isset($_POST['categorie'])) {
            
            $categorie= ucfirst($_POST['categorie']);
            $idUser = $_SESSION['id'];
            
            $sql= "UPDATE `categorie` SET `categorie`=:categorie WHERE (`id`=$idcategorie)";
            $req = $DB->prepare($sql);
            $req->execute(array('categorie' => $categorie));
            
            ?>
            <fieldset>   
                <legend> Catégorie editée avec succés</legend>
                <br/>
                <h2 style="color:green;">Félicitations opération réussie!! </h2>
                 <br/> <br/>
                <a href="index.php?page=gestCategories">Revenir à la gestion des catégories</a>
            </fieldset>

            <?php 
            
        }else{
                 echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
                }

    $req = $DB->prepare("SELECT * FROM categorie WHERE id = :idcategorie");
    if(!is_numeric($_GET['categoriesEdit'])){
        header('Location: index.php?page=gestCategories');
    }
    $req->execute(array('idcategorie' => $_GET['categoriesEdit']));
    
    $d = $req->fetch(PDO::FETCH_OBJ); ?>
    
        <form action="index.php?page=gestCategories&&categoriesEdit=<?php echo $d->id; ?>" method="post" enctype="multipart/form-data">
            <fieldset>   
            <legend> Edition d'une catégorie</legend>
            <label>Catégorie</label><br/>
            <input type="text" name="categorie" value="<?php echo $d->categorie; ?>"/><br/><br/>
            <input type="submit" value="Enregistrer" class="send"/>
            </fieldset> 
        </form>
    
 <?php    
}
 
if((isset($_GET['categoriesAdd'])) &&($_GET['categoriesAdd']==2)) { 
	if(isset($_POST['categorie'])){
		$categorie=$_POST['categorie'];

		$sql = "INSERT INTO `categorie` (`categorie`) VALUES ( :categorie)";
		$req = $DB->prepare($sql);
		$req->execute(array(
			'categorie' => ucfirst($_POST['categorie'])
		));
		unset ($_POST['categorie']);
    }
    ?>
	<fieldset>   
		<legend> Catégorie créée avec succés</legend>
		<br/>
		<h2 style="color:green;">Félicitations, opération réussie!! </h2>
		<br/> <br/>
		<a href="index.php?page=gestCategories">Revenir à la gestion des catégories</a>
	</fieldset>
	<?php    
}

if((isset($_GET['categoriesAdd'])) &&($_GET['categoriesAdd']==1)){ 
?>
        <form action="index.php?page=gestCategories&&categoriesAdd=2" method="post">
            <fieldset>   
            <legend> Ajout d'une catégorie</legend>
                <label>Catégorie:</label>
                <input type="text" name="categorie" value="<?php if(isset($_SESSION['categorie'])){ echo $_SESSION['categorie'];} ?>"/><br/><br/>
                <input type="submit" value="Poster" class="send"/>
            </fieldset> 
        </form>
<?php }
}
else
{
?>
<fieldset>   
    <legend> Ajouter une catégorie</legend>
    <a href="index.php?page=gestCategories&&categoriesAdd=1">Cliquez ici pour ajouter une catégorie...</a>
</fieldset>
<fieldset>   
    <legend> Liste des catégorie</legend>
	 <table class="voteTop" style="border:none; text-align: center;">
		<thead>
			<th width='10'><strong></strong></th>
			<th width='140'><strong>Catégorie</strong></th>
			<th width='80'><strong>Editer</strong></th>
			<th width='80'><strong>Supprimer</strong></th>
		</thead>
<?php

		$sessionId = $_SESSION['id'];
		$sql= "SELECT * FROM `categorie` ORDER BY `categorie` LIMIT 0, 50" ;
		$req = $DB->prepare($sql);
		$req->execute();
		
		while ($d = $req->fetch(PDO::FETCH_OBJ)) {
		?>
			<tr style=" font-size:12px; color: #FFF; padding: 2px; height: 40px;">
				<td> <?php echo $d->id; ?></td>
				<td style="color: #FFE7A1; font-weight: bold;"> <strong><?php echo $d->categorie; ?></strong></td>
				<td> <a href="index.php?page=gestCategories&&categoriesEdit=<?php echo $d->id;?>">Editer</a></td>
				<td> <a href="index.php?page=gestCategories&&categoriesDelete=<?php echo $d->id;?>">Supprimer</a></td>
			</tr>
		<?php  
		} 
		?>
       </table>
<?php
}
?>
</fieldset>