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
    
    $req = $DB->prepare("DELETE FROM `posts` WHERE (`id` = :idNews AND type='news')");
    if(!is_numeric($_GET['newsDelete'])){
        header('Location: index.php?page=gestNews');
    }
    $req->execute(array('idNews' => $_GET['newsDelete']));
    header('Location: index.php?page=gestNews');
    
}
    
    
    
if(isset($_GET['newsEdit']) && ($_GET['newsEdit'])){
        $news= $_GET['newsEdit'];
        if(isset($_POST['titreNews']) && isset($_POST['contentNews'])){
            $online=0;
            $online=$_POST['onlineNews'];
            $online==0 ? $online=0 : $online=1;
            
            $titre= $_POST['titreNews'];
            $content= $_POST['contentNews'];
            $idUser = $_SESSION['id'];
            $ipUser = $_SERVER['REMOTE_ADDR'];
            
            
            $sql= "UPDATE `posts` SET `title`=':titre', `content`= :content, `date`=now(), `idUser`='$idUser', `ipUser`='$ipUser', `online`='$online' WHERE (`id`=$news)";
            $req = $DB->prepare($sql);
            $req->execute(array('titre' => $titre, 'content' => $content));
            
            ?>
            <fieldset>   
                <legend> Nouvelle editée avec succés</legend>
                <br/>
                <h2 style="color:green;">Félicitations opération réussie!! </h2>
                 <br/> <br/>
                <a href="index.php?page=gestNews">Revenir à la gestion des nouvelles</a>
            </fieldset>

            <?php 
            
        }else{
                 echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
                }

    $req = $DB->prepare("SELECT * FROM posts WHERE id = :idNews AND type='news'");
    if(!is_numeric($_GET['newsEdit'])){
        header('Location: index.php?page=gestNews');
    }
    $req->execute(array('idNews' => $_GET['newsEdit']));
    
    $d = $req->fetch(PDO::FETCH_OBJ); ?>
    
        <form action="index.php?page=gestNews&&newsEdit=<?php echo $d->id; ?>" method="post" enctype="multipart/form-data">
            <fieldset>   
            <legend> Edition de nouvelle</legend>
            <label>Titre</label><br/>
            <input type="text" name="titreNews" value="<?php echo $d->title; ?>"/><br/><br/>
            <span class="label"> Online:<input type="checkbox" <?php if($d->online){echo 'checked';} ?> name="onlineNews" value="1"></span><br/>
            <label>Image</label><br/>
            <img src="template/img/news/<?php echo $d->img; ?>" width="60" height="60 "alt="Image de description"/>
            <label>Contenu:</label>
            <textarea cols="80" rows="30"  name="contentNews"><?php echo $d->content; ?></textarea>
            <input type="submit" value="Enregistrer" class="send"/>
            </fieldset> 
        </form>
    
    
 <?php    
}
    

 if((isset($_GET['newsAdd'])) && $_GET['newsAdd']==3){
    $sql = "INSERT INTO `posts` ( `title`,`content`, `type`, `date`, `idUser`, `ipUser`, `online`,`img`) 
        VALUES ( :title, :message, 'news', now(), :idUser, :ipUser,  '1', :img)";
    $req = $DB->prepare($sql);
    $req->execute(array(
        'title' => $_SESSION['titreNews'],
        'message' => $_SESSION['contentNews'],
        'idUser' => $_SESSION['id'],
        'ipUser' => $_SERVER['REMOTE_ADDR'],
        'img'=> $_SESSION['imgNews'],
    ));
    
    unset ($_SESSION['titreNews']);
    unset ($_SESSION['contentNews']);
    unset ($_SESSION['imgNews']);
    
?>
<fieldset>   
    <legend> Nouvelle postée avec succés</legend>
    <br/>
    <h2 style="color:green;">Félicitations opération réussie!! </h2>
     <br/> <br/>
    <a href="index.php?page=gestNews">Revenir à la gestion des nouvelles</a>
</fieldset>

<?php 

}
    
if((isset($_GET['newsAdd'])) && $_GET['newsAdd']==2){ ?>

<style type="text/css">
    
 #contentLeft{
    min-height: 571px;
    width: 660px;
    display: block;
    float: left;
    padding: 10px;
}
#newsContent{
    margin-top: 8px;
    min-height: 600px;
    width: 660px;
    display: block;
    float: left;
}

 .news{
    background: url('../img/tranparence.png') top center repeat;
}

 .imgNews{
    background: url('../img/backImg.png') top center repeat;
    float: left;
    margin-right: 10px;
    margin-bottom: 5px;
    padding: 3px;
    height: 138px;
    width: 159px;
    display: block;
}
.commentNews{
    background: url('../img/comNews.png') top right no-repeat;
    float: right;
    color: #7a5530;
    padding-right: 11px;
    height: 17px;
    width: 20px;
    text-shadow:0px 0px 2px #7a5530;
    display: block;
    opacity:0.8;
}
 .headNews{
    background: url('../img/headNews.png') top center no-repeat;
    margin-right:0;
    height: 34px;
    font: normal 16px/1.2  "Trojan Pro", arial, sans-serif; font-weight: lighter; vertical-align: top;
    width: 640px;
    font-weight: bold;
    text-shadow:0px 0px 4px #7a5530;
    padding-left: 20px;
    line-height: 34px;
    font-size: 16px;
    color: #f3d59f;
    display: block;
}

.middleNews{
    
    margin-right:0;
    min-height: 300px;
    font: normal 12px/1.2  "arial", arial, sans-serif; font-weight: lighter; vertical-align: top;
    width: 620px;
    font-weight: bold;
    text-shadow:0px 0px 4px #7a5530;
    margin: 15px;
    margin-top: 0;
    margin-bottom: 5px;
    padding: 5px;
    font-size: 12px;
    color: #f9dabb;
    display: block;
    background: url('../img/backnews.png') top center no-repeat;
}

.footNews{
    margin-left:-15px;
    height: 34px;
    font: normal 14px/1.2  "Trojan Pro", arial, sans-serif; font-weight: lighter; vertical-align: top;
    width: 630px;
    font-weight: bold;
    text-shadow:0px 0px 4px #7a5530;
    padding-left: 20px;
    line-height: 34px;
    font-size: 14px;
    color: #f3d59f;
    display: block;
    
}

    </style>

<div id="contentLeft">
<fieldset>
<legend>Aperçu de la nouvelle</legend>
    <div  class="news">
            <div class="headNews"> 
                <span><?php echo $_SESSION['titreNews']; ?></span>
            </div><hr/>
            <div class="corpNews">
                    <p><img src="template/img/news/<?php echo $_SESSION['imgNews']; ?>" class="imgNews" alt="Image de description"/>
                        <?php echo $_SESSION['contentNews']; ?>
                    </p>
                </div>
                <div class="footNews">
                    <span style="color: #c39640">Écrit par:</span><span><?php echo getAccount($_SESSION['id'],$DB); ?></span>
                </div>                            
     </div>
    <hr/>
     <a style="float: left;" href="index.php?page=gestNews&&newsAdd=1"> <--Revenir en arrière</a>
     <a style="float: right;" href="index.php?page=gestNews&&newsAdd=3"> Poursuivre --></a>
     </fieldset>
</div>

 <?php } 
 
if((isset($_GET['newsAdd'])) &&($_GET['newsAdd']==1)){ 
        
        if(isset($_POST['titreNews']) && !empty($_FILES['scrNews']) && isset($_POST['contentNews'])){
            
            if(isset($_POST['titreNews'])){$_SESSION['titreNews']=$_POST['titreNews'];}
            if(isset($_POST['contentNews'])){$_SESSION['contentNews']=$_POST['contentNews'];}
            if(isset($_FILES['scrNews'])){
                if(!empty($_FILES['scrNews'])){
                    
                        $file = $_FILES['scrNews'];
                        $fileName = $file['name'];
                        $fileNameSh1 = sha1(uniqid($fileName)).'jpg';
                    if(isset($_SESSION['imgNews']) && $_SESSION['imgNews']==$fileNameSh1){ 
                            header('Location: index.php?page=gestNews&&newsAdd=2');
                    }else{
                        if(uploadImageNews($_FILES['scrNews'])){
                            header('Location: index.php?page=gestNews&&newsAdd=2');
                        }
                    }
                }else{
                 echo "<span class='erreurFormulaire'  color='red'>Veuillez charger une image</span>";
                }
            }
        }else{
                 echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
                }
?>
        <form action="index.php?page=gestNews&&newsAdd=1" method="post" enctype="multipart/form-data">
            <fieldset>   
            <legend> Ajout de nouvelle</legend>
                <label>Titre:</label><br/>
                <input type="text" name="titreNews" value="<?php if(isset($_SESSION['titreNews'])){ echo $_SESSION['titreNews'];} ?>"/><br/><br/>
                <label>Charger une image:</label><br/>
                <input id="scrNews"name="scrNews" type="file" value="<?php if(isset($_SESSION['imgNews'])){ echo $_SESSION['imgNews'];} ?>" /><br /><br/>
                <label>Contenu:</label>
                <textarea cols="80" rows="30"  name="contentNews"><?php if(isset($_SESSION['contentNews'])){ echo $_SESSION['contentNews'];} ?></textarea>
                <input type="submit" value="Voir Aperçu" class="send"/>
            </fieldset> 
        </form>

      <?php }
  
  
  
  
  
  
  
  
  }else{?>
<fieldset>   
    <legend> Ajouter de nouvelles actualités</legend>
    <a href="index.php?page=gestNews&&newsAdd=1">Cliquez ici pour ajouter une nouvelle...</a>
</fieldset>
<fieldset>   
    <legend> Liste de nouvelles</legend>
<?php
$sql= "SELECT * FROM `posts` WHERE `type` = 'news' LIMIT 0, 50" ;
$req = $DB->prepare($sql);
$req->execute();

while ($d = $req->fetch(PDO::FETCH_OBJ)){
?>     
             
             
             <table class="voteTop" style="border:none; text-align: center;">
                <thead>
                    <th width='10'><strong></strong></th>
                    <th width='240'><strong>Titre</strong></th>
                    <th width='60'><strong> Image</strong></th>
<!--                    <th width='250'><strong>Contenu</strong></th>-->
                    <th width='80'><strong>Auteur</strong></th>
                    <th width='140'><strong>Date</strong></th>
                    <th width='100'><strong>Statut</strong></th>
                    <th width='80'><strong>Editer</strong></th>
                    <th width='80'><strong>Supprimer</strong></th>
                </thead>


<?php
            $sessionId = $_SESSION['id'];
            $sql= "SELECT * FROM `posts` WHERE `type` = 'news' ORDER BY `id` DESC LIMIT 0, 50" ;
            $req = $DB->prepare($sql);
            $req->execute();
            while ($d = $req->fetch(PDO::FETCH_OBJ)) {
?>
                <tr style=" font-size:12px; color: #FFF; padding: 2px; height: 40px;">
                    <td> <?php echo $d->id; ?></td>
                    <td style="color: #FFE7A1; font-weight: bold;"> <strong><?php echo $d->title; ?></strong></td>
                    <td> <img src="template/img/news/<?php echo $d->img; ?>" alt="image" width="40" height="40"></td>
<!--                    <td style="color: #ffebb6; font-weight: bold;"> <div style="height: 40px; overflow: hidden; display: block; width: 230px; text-align: left; padding-left: 10px; padding-right: 10px;"><?php echo $d->content; ?></div></td>-->
                    <td> <?php echo getMainPerso($CHARS, $DB, $d->idUser); ?></td>
                    <td> <?php echo convertTime($d->date); ?></td>
                    <td> <?php echo getStatutNews($d->online); ?></td>
                    <td> <a href="index.php?page=gestNews&&newsEdit=<?php echo $d->id;?>">Editer</a></td>
                    <td> <a href="index.php?page=gestNews&&newsDelete=<?php echo $d->id;?>">Supprimer</a></td>
                </tr>
            <?php  } ?>

        </table>
 <?php  }} ?>
</fieldset>