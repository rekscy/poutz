<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],levelAccessAdministration) && !isset($_SESSION['Administrateur'])){
        header('Location: index.php');
    }
?>

<div id="titreAdministration">
    <p style =" font-size: 40px; color: #ffebb6;"> ADMINISTRATION<span style =" font-size: 16px; color: #c8c8c8;">GESTION DES NOUVELLES</span></p>
</div>

<?php if(isset($_GET['newsAdd'])||isset($_GET['newsDelete'])||isset($_GET['newsEdit'])){ 

if(isset($_GET['newsDelete']) && ($_GET['newsDelete'])){
    
    $req = $DB->prepare("DELETE FROM `dev_report` WHERE (`id` = :idNews)");
    if(!is_numeric($_GET['newsDelete'])){
        header('Location: index.php?page=gestDebugDev');
    }
    $req->execute(array('idNews' => $_GET['newsDelete']));
    header('Location: index.php?page=gestDebugDev');
    
}
    
    
    
if(isset($_GET['newsEdit']) && ($_GET['newsEdit'])){
        $news= $_GET['newsEdit'];
        if(isset($_POST['titreNews']) && isset($_POST['contentNews'])){
            
            $titre= ucfirst($_POST['titreNews']);
            $content= ucfirst($_POST['contentNews']);
            $type= $_POST['typeNews'];
            $idUser = $_SESSION['id'];
            
            
            $sql= "UPDATE `dev_report` SET `titre`=:titre, `content`= :content,`type`= :type, `date`=now(), `gmId`='$idUser'  WHERE (`id`=$news)";
            $req = $DB->prepare($sql);
            $req->execute(array('titre' => $titre, 'content' => $content, 'type' => $type));
            
            ?>
            <fieldset>   
                <legend> Débug edité avec succés</legend>
                <br/>
                <h2 style="color:green;">Félicitations opération réussie!! </h2>
                 <br/> <br/>
                <a href="index.php?page=gestDebugDev">Revenir à la gestion des débugs</a>
            </fieldset>

            <?php 
            
        }else{
                 echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
                }

    $req = $DB->prepare("SELECT * FROM dev_report WHERE id = :idNews");
    if(!is_numeric($_GET['newsEdit'])){
        header('Location: index.php?page=gestDebugDev');
    }
    $req->execute(array('idNews' => $_GET['newsEdit']));
    
    $d = $req->fetch(PDO::FETCH_OBJ); ?>
    
        <form action="index.php?page=gestDebugDev&&newsEdit=<?php echo $d->id; ?>" method="post" enctype="multipart/form-data">
            <fieldset>   
            <legend> Edition de débug</legend>
            <label>Type:</label>
            <select name="typeNews">
                <option value=""></option>
                <option value="1">Debug Sort</option>
                <option value="2">Debug Instance</option>
                <option value="3">Debug Quete</option>
                <option value="4">Debug Bg</option>
                <option value="5">Debug Général</option>
                <option value="6">Site web</option>
                <option value="7">Forum</option>
                <option value="8">Fix Crash</option>
                <option value="9">Debug Item</option>
                <option value="10">Debug Talent</option>
            </select><br/><br/>
            <label>Titre</label><br/>
            <input type="text" name="titreNews" value="<?php echo $d->titre; ?>"/><br/><br/>
            <label>Contenu:</label>
            <textarea cols="30" rows="30"  name="contentNews"><?php echo $d->content; ?></textarea>
            <input type="submit" value="Enregistrer" class="send"/>
            </fieldset> 
        </form>
    
 <?php    
}
 
if((isset($_GET['newsAdd'])) &&($_GET['newsAdd']==2)){ 
    
        if(isset($_POST['titreNews'])&& isset($_POST['typeNews'])&& isset($_POST['contentNews'])){
            
        $titre=$_POST['titreNews'];
        $content= $_POST['contentNews'];
        $type=$_POST['typeNews'];
    
    
    $sql = "INSERT INTO `dev_report` ( `titre`,`content`, `type`, `date`, `gmId`) 
        VALUES ( :title, :content, :type, now(), :idUser)";
    $req = $DB->prepare($sql);
    $req->execute(array(
        'title' => $_POST['titreNews'],
        'content' => $_POST['contentNews'],
        'type' => $_POST['typeNews'],
        'idUser' => $_SESSION['id']
    ));
    
    unset ($_POST['titreNews']);
    unset ($_POST['contentNews']);
    unset ($_POST['typeNews']);
    
        }
    ?>
    
<fieldset>   
    <legend> Report de bug posté avec succés</legend>
    <br/>
    <h2 style="color:green;">Félicitations opération réussie!! </h2>
     <br/> <br/>
    <a href="index.php?page=gestDebugDev">Revenir à la gestion des nouvelles</a>
</fieldset>

<?php    }


if((isset($_GET['newsAdd'])) &&($_GET['newsAdd']==1)){ 
?>
        <form action="index.php?page=gestDebugDev&&newsAdd=2" method="post">
            <fieldset>   
            <legend> Ajout de débug</legend>
            <label>Type:</label>
            <select name="typeNews">
                <option value=""></option>
                <option value="1">Debug Sort</option>
                <option value="2">Debug Instance</option>
                <option value="3">Debug Quete</option>
                <option value="4">Debug Bg</option>
                <option value="5">Debug Général</option>
                <option value="6">Site web</option>
                <option value="7">Forum</option>
                <option value="8">Fix Crash</option>
                <option value="9">Debug Item</option>
                <option value="10">Debug Talent</option>
            </select><br/><br/>
                <label>Titre:</label>
                <input type="text" name="titreNews" value="<?php if(isset($_SESSION['titreNews'])){ echo $_SESSION['titreNews'];} ?>"/><br/><br/>
                <label>Contenu:</label>
                <textarea cols="80" rows="30"  name="contentNews"><?php if(isset($_SESSION['contentNews'])){ echo $_SESSION['contentNews'];} ?></textarea>
                <input type="submit" value="Poster" class="send"/>
            </fieldset> 
        </form>

      <?php }
  
  }else{?>
<fieldset>   
    <legend> Ajouter un débug</legend>
    <a href="index.php?page=gestDebugDev&&newsAdd=1">Cliquez ici pour ajouter un débug...</a>
</fieldset>
<fieldset>   
    <legend> Liste des débugs accomplis</legend>
<?php
$sql= "SELECT * FROM `dev_report`" ;
$req = $DB->prepare($sql);
$req->execute();

while ($d = $req->fetch(PDO::FETCH_OBJ)){
?>
             <table class="voteTop" style="border:none; text-align: center;">
                <thead>
                    <th width='10'><strong></strong></th>
                    <th width='240'><strong>Titre</strong></th>
                    <th width='80'><strong>Auteur</strong></th>
                    <th width='140'><strong>Date</strong></th>
                    <th width='80'><strong>Editer</strong></th>
                    <th width='80'><strong>Supprimer</strong></th>
                </thead>
<?php
            $sessionId = $_SESSION['id'];
            $sql= "SELECT * FROM `dev_report` ORDER BY `id` DESC LIMIT 0, 50" ;
            $req = $DB->prepare($sql);
            $req->execute();
            while ($d = $req->fetch(PDO::FETCH_OBJ)) {
?>
                <tr style=" font-size:12px; color: #FFF; padding: 2px; height: 40px;">
                    <td> <?php echo $d->id; ?></td>
                    <td style="color: #FFE7A1; font-weight: bold;"> <strong><?php echo $d->titre; ?></strong></td>
<!--                    <td style="color: #ffebb6; font-weight: bold;"> <div style="height: 40px; overflow: hidden; display: block; width: 230px; text-align: left; padding-left: 10px; padding-right: 10px;"><?php echo $d->content; ?></div></td>-->
                    <td> <?php echo getMainPerso($CHARS, $DB, $d->gmId); ?></td>
                    <td> <?php echo convertTime($d->date); ?></td>
                    <td> <a href="index.php?page=gestDebugDev&&newsEdit=<?php echo $d->id;?>">Editer</a></td>
                    <td> <a href="index.php?page=gestDebugDev&&newsDelete=<?php echo $d->id;?>">Supprimer</a></td>
                </tr>
            <?php  } ?>

        </table>
 <?php  }} ?>
</fieldset>