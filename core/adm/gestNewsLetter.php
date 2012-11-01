<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],levelAccessAdministration) && !isset($_SESSION['Administrateur'])){
        header('Location: index.php');
    }
?>

<div id="titreAdministration">
    <p style =" font-size: 40px; color: #ffebb6;"> ADMINISTRATION<span style =" font-size: 16px; color: #c8c8c8;">GESTION DES NOUVELLES</span></p>
</div>

<?php 


if(isset($_GET['newsAdd'])){

 if((isset($_GET['newsAdd'])) && $_GET['newsAdd']==4){
?>

            <fieldset>   
            <legend>News Letter postée</legend>
            
            <span style="color: #006600;">Opération Réussie</span>
                
            </fieldset> 

<?php 
 }
    
 if((isset($_GET['newsAdd'])) && $_GET['newsAdd']==3){

    $sql= "SELECT * FROM `users` WHERE `codeActivate` = '1';" ;
    $req = $DB->prepare($sql);
    $req->execute();
    while ($d = $req->fetch(PDO::FETCH_OBJ)) {
        
        $mail= $d->mail;
        $subject= $_SESSION['titreNewsLetter'];
        $message = $_SESSION['contentNews'];
        $name= getMainPerso($CHARS, $DB, $d->id);
        
        sendMail($mail, $subject, $message, $name);
        
    }
    unset ($_SESSION['titreNewsLetter']);
    unset ($_SESSION['contentNews']);
    header('Location: index.php?page=gestNewsLetter&&newsAdd=4');

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
<legend>Aperçu de la news letter</legend>
    <div  class="news">
            <div class="headNews"> 
                <span><?php echo $_SESSION['titreNewsLetter']; ?></span>
            </div><hr/>
            <div Style="background:#FFF; padding: 10px;">
                    <p>
                        <?php echo $_SESSION['contentNews']; ?>
                    </p>
                </div>
                <div class="footNews">
                    <span style="color: #c39640">Écrit par:</span><span><?php echo getAccount($_SESSION['id'],$DB); ?></span>
                </div>                            
     </div>
    <hr/>
     <a style="float: left;" href="index.php?page=gestNewsLetter"> <--Revenir en arrière</a>
     <a style="float: right;" href="index.php?page=gestNewsLetter&&newsAdd=3"> Poursuivre --></a>
     </fieldset>
</div>

 <?php } 
 
if((isset($_GET['newsAdd'])) &&($_GET['newsAdd']==1)){ 
        
        if(isset($_POST['titreNewsLetter']) && isset($_POST['contentNews'])){
            
            if(isset($_POST['titreNewsLetter'])){$_SESSION['titreNewsLetter']=$_POST['titreNewsLetter'];}
            if(isset($_POST['contentNews'])){$_SESSION['contentNews']=$_POST['contentNews'];}
             header('Location: index.php?page=gestNewsLetter&&newsAdd=2');
        }else{
                 echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
   } 
}}else{ 
?> 
    
    
        <form action="index.php?page=gestNewsLetter&&newsAdd=1" method="post" enctype="multipart/form-data">
            <fieldset>   
            <legend> Poster une newsLetter</legend>
                <label>Objet:</label><br/>
                <input type="text" name="titreNewsLetter" value="<?php if(isset($_SESSION['titreNewsLetter'])){ echo $_SESSION['titreNewsLetter'];} ?>"/><br/><br/>
                <label>Contenu:</label>
                <textarea cols="80" rows="30"  name="contentNews"><?php if(isset($_SESSION['contentNews'])){ echo $_SESSION['contentNews'];} ?></textarea>
                <input type="submit" value="Voir Aperçu" class="send"/>
            </fieldset> 
        </form>
    
  <?php    } ?>
</fieldset>