<div id="Recup" class="news">
<div class="headNews"> 
    <span>Demander une récupération</span>
</div>
<div class="middleNews">
    
<?php

if(!isset($_SESSION['name']) && !isset($_SESSION['id']) && !isset($_SESSION['accountLevel'])){
    
     header('Location: index.php?page=connexion');
 }

if (isset($_GET['step']) && is_numeric($_GET['step'])){

if ($_GET['step']==11){
    
        unset($_SESSION['pseudo']);
        unset($_SESSION['classe']);
        unset($_SESSION['race']);
        unset($_SESSION['specialisation']);
        unset($_SESSION['sexe']);
        unset($_SESSION['Po']);
        unset($_SESSION['level']);
        unset($_SESSION['metier1']);
        unset($_SESSION['metier2']);
        unset($_SESSION['skill1']);
        unset($_SESSION['skill2']);
        unset($_SESSION['screen1']);
        unset($_SESSION['screen2']);
        unset($_SESSION['screen3']);
        unset($_SESSION['screen4']);
        unset($_SESSION['screen5']);
        unset($_SESSION['screen6']);
        unset($_SESSION['motSemaine']);
        unset($_SESSION['sucess']);

        header('Location: index.php?page=membre');
}
    
if ($_GET['step']==10){

if(!isset( $_SESSION['sucess'])){
         header('Location: index.php?page=recups&&step=9');
}
 ?>     

<fieldset>
    <legend>Succés</legend>
    
    <h2>Bravo Opération réussie!!</h2>
    <p>Vous devez maintenant attendre que la récupération soie controlée par un modérateur. Vous pourrez a tout moment voir l'état de cette derniere dans votre espace membre.</p>
<a style ="float: right; margin: 1px;" href="index.php?page=recups&&step=11" class="nextStage"></a>
    
</fieldset>
<fieldset>
    <legend>Personnage:</span> <?php echo $_SESSION['pseudo']?> <?php echo $_SESSION['pseudo']?></legend>
        
            <div style="width: 200px; min-height: 80px; display: block; float: left;">
            <p><span style="color: #e1c184;">Nom:</span> <?php echo $_SESSION['pseudo']?></p>
            <p><span style="color: #e1c184;">Niveau:</span><?php echo $_SESSION['level']?></p>
            <p><span style="color: #e1c184;">Temps de jeu:</span><?php echo 'Neuf!' ?></p>
            <p><span style="color: #e1c184;">Argent: </span>
            <?php     echo ($_SESSION['Po']>=10000) ?
            '10\'000<span style="color:gold;"> PO</span> 00 <span style="color:silver;"> PA</span> 00 <span style="color:#c39640;"> PC</span> </span> 00 <span style="color:red;">Seulement 10 000 PO Autorisés</span> ':
            $_SESSION['Po'].'<span style="color:gold;"> PO</span> 00 <span style="color:silver;"> PA</span> 00 <span style="color:#c39640;"> PC</span> ' ; ?></p>
            <?php echo image_race($_SESSION['race']); ?>
            <?php echo image_classe($_SESSION['classe']); ?>
             </div>
            <div style="width: 380px; min-height: 80px; display: block; float: left;">
            <p Style="color: #e1c184; font-size: 14px;">Statut:  <?php echo '  <span style="color:red;"> En attende de validation</span> ' ?> </p>
            <p><span style="color: #e1c184;">Métier 1:</span> <?php echo getMetier($_SESSION['metier1'])?></p>
            <p><span style="color: #e1c184;">Métier 2:</span> <?php echo getMetier($_SESSION['metier2'])?></p>
            

            <p><span style="color: #e1c184;">Stuff:</span><span style="color: lightskyblue;"> Niveau d'objet <?php echo $_SESSION['levelStuff']; ?></span> </p>

            </div>
</fieldset>
    
<fieldset>
  <legend>Screens </legend>
  <div  style="width: 460px; min-height: 80px; display: block; margin: auto;">
  <img style ="float: left; margin: 1px;" src="template/img/recuperation/min/<?php echo $_SESSION['screen1']?>" alt="" />
  <img style ="float: left; margin: 1px;" src="template/img/recuperation/min/<?php echo $_SESSION['screen2']?>" alt="" />
  <img style ="float: left; margin: 1px;" src="template/img/recuperation/min/<?php echo $_SESSION['screen3']?>" alt="" />
  <img style ="float: left; margin: 1px;" src="template/img/recuperation/min/<?php echo $_SESSION['screen4']?>" alt="" />
  <img style ="float: left; margin: 1px;" src="template/img/recuperation/min/<?php echo $_SESSION['screen5']?>" alt="" />
  <img style ="float: left; margin: 1px;" src="template/img/recuperation/min/<?php echo $_SESSION['screen6']?>" alt="" />
  </div>
</fieldset>

<?php 
}

if ($_GET['step']==9){

if(!isset($_SESSION['screen6'])){
         header('Location: index.php?page=recups&&step=8');
}

if(isset($_POST['verif'])){
    
 $code = (int) $_POST['verif'];
  if ($_SESSION['captcha'] == $code) { //capcha
      
      if (verifNbrRecups($DB,$_SESSION['id'])<1 || isset($_SESSION['paytarecup'])==$_SESSION['id']){ // Verifie qu'on n'aie pas fraudé au début apres avoir fait une premiere recup

          $_SESSION['levelStuff'] = levelItemRecupGratuite; //constante dans DB
          
          if(isset($_SESSION['paytarecup'])){ //Si recup payante le stuff sera meilleur
              $_SESSION['levelStuff'] = levelItemRecupPayante; //constante dans DB
          }
          
          if($_SESSION['level']<=80){
               $_SESSION['levelStuff'] =levelItemRecup80;
          }
          
     
      if(saveRecup($DB)){ //Sauvegarde du personnage
          unset ($_SESSION['paytarecup']);
          unset($_SESSION['conditions']);
          header('Location: index.php?page=recups&&step=10');
      }
    }else{
        header('Location: index.php?page=recups'); //Redirection en cas de fraude
    }
  }
}
 ?>     
<form action="index.php?page=recups&&step=9" method="post">

<fieldset>
<legend>Sécurité</legend>

<p>On y est presque !!! </p><br />
<p>Vous devez recopier le numero dans le champs. Ceci nous assure que vous êtes bien un humain.</p><br />
<div style="margin: auto; width: 94px; height: 38px; display: block; border: 2px solid #c39640;"> <img style="margin:auto;" src="./template/capcha/captcha.php" alt="anti_robot"/> </div><br />
<label class="labelInsc" for="verif">Recopier le texte:</label>
<input id="verif" class="champInsc" name="verif" size="10" maxlength="6" type="text" /><br />
</fieldset>
<br/> 
<input name="envoyer" class="nextStage" value="" type="submit" /><br />
</form>

<?php 
}


if ($_GET['step']==8){

if(!isset($_SESSION['screen5'])){
         header('Location: index.php?page=recups&&step=7');
}

$motSemaine = motSemaine;

$_SESSION['motSemaine']=$motSemaine;

if(isset($_FILES['scrMot'])){
    if(!empty($_FILES['scrMot'])){
        if(uploadImage($_FILES['scrMot'],6)){
            header('Location: index.php?page=recups&&step=9');
        }

    }else{
     echo "<span class='erreurFormulaire'  color='red'>Veuillez charger une image</span>";
    }
}

?>

<form action="index.php?page=recups&&step=8" method="post" enctype="multipart/form-data">

<fieldset><legend>Identification du personnage</legend>  
<p>Ces quelques informations nous serviront à détérminer si ce personnage vous appartien ou pas pensez a fournir des images de qualité.</p>

<label class="labelInsc" for="scrMot" style="width: 200px;">Screen disant le mot de la semaine: Mot de la semaine:<br /> " <?php echo $motSemaine; ?>"</label>
<input class="champInsc"  id="scrMot" height style="width: 100px; margin-top: 0px; height: 25px; color: #c39640; margin-right: 130px;" class="scrConn" name="scrMot" type="file" /><br />
<br/> <br/>

</fieldset>
<br/> 
<input name="envoyer" class="nextStage" value="" type="submit" /><br />
</form>
<?php 
}


if ($_GET['step']==7){


if(!isset($_SESSION['screen4'])){
         header('Location: index.php?page=recups&&step=6');
}
if(isset($_FILES['scrTown'])){
    if(!empty($_FILES['scrTown'])){
        if(uploadImage($_FILES['scrTown'],5)){
            header('Location: index.php?page=recups&&step=8');
        }

    }else{
     echo "<span class='erreurFormulaire'  color='red'>Veuillez charger une image</span>";
    }
}

?>

    
<form action="index.php?page=recups&&step=7" method="post" enctype="multipart/form-data">

<fieldset><legend>Identification du personnage</legend>  
<p>Ces quelques informations nous serviront à détérminer si ce personnage vous appartien ou pas pensez a fournir des images de qualité.</p>

<label class="labelInsc" for="scrTown" style="width: 200px;">Screen dans une ville peuplée:</label>
<input class="champInsc"  id="scrTown" height style="width: 100px; margin-top: 0px; height: 25px; color: #c39640; margin-right: 130px;" class="scrConn" name="scrTown" type="file" /><br />
<br/> <br/> 

</fieldset>
<br/> 
<input name="envoyer" class="nextStage" value="" type="submit" /><br />
</form>

<?php 
}

if ($_GET['step']==6){

if(!isset($_SESSION['screen3'])){
         header('Location: index.php?page=recups&&step=5');
}
if(isset($_FILES['scrPlayd'])){
    if(!empty($_FILES['scrPlayd'])){
        if(uploadImage($_FILES['scrPlayd'],4)){
            header('Location: index.php?page=recups&&step=7');
        }

    }else{
     echo "<span class='erreurFormulaire'  color='red'>Veuillez charger une image</span>";
    }
}

?>

<form action="index.php?page=recups&&step=6" method="post" enctype="multipart/form-data">

<fieldset><legend>Identification du personnage</legend>  
<p>Ces quelques informations nous serviront à détérminer si ce personnage vous appartien ou pas pensez a fournir des images de qualité.</p>

<label class="labelInsc" for="scrPlayd" style="width: 200px;">Screen de votre /played:</label>
<input class="champInsc"  id="scrPlayd" height style="width: 100px; margin-top: 0px; height: 25px; color: #c39640; margin-right: 130px;" class="scrConn" name="scrPlayd" type="file" /><br />
<br/> <br/> 

</fieldset>
<br/> 
<input name="envoyer" class="nextStage" value="" type="submit" /><br />
</form>

<?php 
}

if ($_GET['step']==5){

if(!isset($_SESSION['screen2'])){
         header('Location: index.php?page=recups&&step=4');
}
if(isset($_FILES['scrMeti'])){
    if(!empty($_FILES['scrMeti'])){
        if(uploadImage($_FILES['scrMeti'],3)){
            header('Location: index.php?page=recups&&step=6');
        }

    }else{
     echo "<span class='erreurFormulaire'  color='red'>Veuillez charger une image</span>";
    }
}

?>

<form action="index.php?page=recups&&step=5" method="post" enctype="multipart/form-data">

<fieldset><legend>Identification du personnage</legend>  
<p>Ces quelques informations nous serviront à détérminer si ce personnage vous appartien ou pas pensez a fournir des images de qualité.</p>

<label class="labelInsc" for="scrMeti" style="width: 200px;">Screen de votre grimoire de métiers:</label>
<input class="champInsc"  id="scrMeti" height style="width: 100px; margin-top: 0px; height: 25px; color: #c39640; margin-right: 130px;" class="scrConn" name="scrMeti" type="file" /><br />
<br/> <br/> 

</fieldset>
<br/> 
<input name="envoyer" class="nextStage" value="" type="submit" /><br />
</form>

<?php 
}

if ($_GET['step']==4){

if(!isset($_SESSION['screen1'])){
         header('Location: index.php?page=recups&&step=3');
}
if(isset($_FILES['scrPerso'])){
    if(!empty($_FILES['scrPerso'])){
        if(uploadImage($_FILES['scrPerso'],2)){
            header('Location: index.php?page=recups&&step=5');
        }

    }else{
     echo "<span class='erreurFormulaire'  color='red'>Veuillez charger une image</span>";
    }
}

?>

<form action="index.php?page=recups&&step=4" method="post" enctype="multipart/form-data">

<fieldset><legend>Identification du personnage</legend>  
<p>Ces quelques informations nous serviront à détérminer si ce personnage vous appartien ou pas pensez a fournir des images de qualité.</p>

<label class="labelInsc" for="scrPerso" style="width: 200px;">Screenshot de personnage en jeu avec sac ouvert:</label>
<input class="champInsc"  id="scrPerso" height style="width: 100px; margin-top: 0px; height: 25px; color: #c39640; margin-right: 130px;" class="scrConn" name="scrPerso" type="file" /><br />
<br/> <br/> 

</fieldset>
<br/> 
<input name="envoyer" class="nextStage" value="" type="submit" /><br />
</form>
    
<?php 
}

if ($_GET['step']==3){

if(!isset($_SESSION['specialisation'])&&!isset($_SESSION['metier1'])&&!isset($_SESSION['metier2'])){
         header('Location: index.php?page=recups&&step=2');
}


if(isset($_POST['armurerie'])){
    if(!empty($_POST['armurerie'])){
    $armurerie = htmlspecialchars($_POST['armurerie']);
    
    if (preg_match("|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i", $armurerie)) {
        $_SESSION['lienArmurerie']=$armurerie;
            if(!empty($_FILES['scrConn'])){
                if(uploadImage($_FILES['scrConn'],1)){
                    header('Location: index.php?page=recups&&step=4');
                }
                
            }}else{
             echo "<span class='erreurFormulaire'  color='red'>Adresse invalide</span>";
        }}else{
    echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
}}

?>
    
<form action="index.php?page=recups&&step=3" method="post" enctype="multipart/form-data">

<fieldset><legend>Identification du personnage</legend>  
<p>Ces quelques informations nous serviront à détérminer si ce personnage vous appartien ou pas pensez a fournir des images de qualité.</p>

<label class="labelInsc" for="armurerie">Lien du serveur (armurerie si existant):</label>
<input class="champInsc" id="armurerie" class="champ" name="armurerie" type="text" /><br />
<br/> <br/>
<label class="labelInsc" for="scrConn" style="width: 200px;">Screen de votre liste des personnages:</label>
<input class="champInsc"  id="scrConn" height style="width: 100px; margin-top: 0px; height: 25px; color: #c39640; margin-right: 130px;" class="scrConn" name="scrConn" type="file" /><br />
<br/> <br/> 

</fieldset>
<br/> 
<input name="envoyer" class="nextStage" value="" type="submit" /><br />
</form>
    

<?php 
}

if ($_GET['step']==2 ){
    
if(!isset($_SESSION['pseudo'])&&!isset($_SESSION['race'])&&!isset($_SESSION['classe'])&&!isset($_SESSION['sexe'])&&!isset($_SESSION['level'])&&!isset($_SESSION['po'])){
         header('Location: index.php?page=recups&&step=1');
}

if(isset($_POST['specialisation']) && isset($_POST['metier1']) &&isset($_POST['skill1']) &&isset($_POST['skill2']) && isset($_POST['metier2'])){
    if(!empty($_POST['specialisation']) && !empty($_POST['metier1']) && !empty($_POST['metier2'])){
    $specialisation = htmlspecialchars($_POST['specialisation']);
    $metier1 = htmlspecialchars($_POST['metier1']);
    $metier2 = htmlspecialchars($_POST['metier2']);
    $skill1 = htmlspecialchars($_POST['skill1']);
    $skill2 = htmlspecialchars($_POST['skill2']);
    
    if (preg_match("#^[0-9]+$#", $specialisation)) {
        if (preg_match("#^[0-9]+$#", $metier1)) {
            if (preg_match("#^[0-9]+$#", $metier2)) {
                if($metier1 != $metier2){
                    if (preg_match("#^[0-9]+$#", $skill1  && $skill1 <=525)) {
                        if (preg_match("#^[0-9]+$#", $skill2) && $skill2 <=525) {
                    $_SESSION['specialisation']= $specialisation;
                    $_SESSION['metier1']= $metier1;
                    $_SESSION['metier2']= $metier2;
                    $_SESSION['skill1']= $skill1;
                    $_SESSION['skill2']= $skill2;

                     header('Location: index.php?page=recups&&step=3');
                     
                            }else{
                                echo "<span class='erreurFormulaire'  color='red'>Valeurs du deuxieme métier incorrectes veuillez écrire un nombre entre 1 et 525</span>"; 
                        }}else{
                        echo "<span class='erreurFormulaire'  color='red'>Valeurs du premier métier incorrectes veuillez écrire un nombre entre 1 et 525</span>"; 
                     }}else{
                    echo "<span class='erreurFormulaire'  color='red'>Veuillez choisir deux métiers différents</span>"; 
                }}else{
                header('Location: index.php');
            }}else{
              header('Location: index.php');
        }}else{
        header('Location: index.php');
     }}else{
    echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
}}


$classe = $_SESSION['classe'];
$spe1='';
$spe2='';
$spe3='';

switch ($classe){
        case 1:
            $spe1='Armes';
            $spe2='Fureur';
            $spe3='Protection';
            break;
        case 2:
            $spe1='Sacré';
            $spe2='Protection';
            $spe3='Vindict';
            break;
        case 3:
            $spe1='Maîtrise des bêtes';
            $spe2='Précision';
            $spe3='Survie';
            break;
        case 4:
            $spe1='Assassinat';
            $spe2='Combat';
            $spe3='Finesse';
            break;
        case 5:
            $spe1='Discipline';
            $spe2='Sacré';
            $spe3='Magie de l\'ombre';
            break;
        case 6:
            $spe1='Sang';
            $spe2='Givre';
            $spe3='Impie';
            break;
        case 7:
            $spe1='Élémentaire';
            $spe2='Amélioration';
            $spe3='Restauration';
            break;
        case 8:
            $spe1='Arcane';
            $spe2='Feu';
            $spe3='Givre';
            break;
        case 9:
            $spe1='Affliction';
            $spe2='Démonologie';
            $spe3='Destruction';
            break;
        case 11:
            $spe1='Équilibre';
            $spe2='Farouche';
            $spe3='Restauration';
            break;
}
    
    
    
?>
<form action="index.php?page=recups&&step=2" method="post">

<fieldset><legend>Détails de personnage</legend>  
<p>Ces quelques informations nous serviront à détérminer les caractèristiques de votre nouvel personnage si toutefois il est accépté.</p>

<label class="labelInsc" for="specialisation">Spécialisation:</label>
<select class="champInsc" name="specialisation">
    <option value=""></option>
    <option value="1"><?php echo $spe1; ?></option>
    <option value="2"><?php echo $spe2; ?></option>
    <option value="3"><?php echo $spe3; ?></option>
</select>


<label class="labelInsc" for="metier1">Métier 1:</label>
<select class="champInsc" name="metier1">
    <option value=""></option>
    <option value="1">Alchimie</option>
    <option value="2">Calligraphie</option>
    <option value="3">Couture</option>
    <option value="4">Dépeçage</option>
    <option value="5">Enchantement</option>
    <option value="6">Forge</option>
    <option value="7">Cueillette</option>
    <option value="8">Ingénierie</option>
    <option value="9">Joaillerie</option>
    <option value="10">Minage</option>
    <option value="11">Travail du cuir</option>
</select>
<label class="labelInsc" for="skill1">Skill du métier (X/525)</label>
<input class="champInsc" id="skill1" class="champ" name="skill1" type="text" /><br />



<label class="labelInsc" for="metier2">Métier 2:</label>
<select class="champInsc" name="metier2">
    <option value=""></option>
    <option value="1">Alchimie</option>
    <option value="2">Calligraphie</option>
    <option value="3">Couture</option>
    <option value="4">Dépeçage</option>
    <option value="5">Enchantement</option>
    <option value="6">Forge</option>
    <option value="7">Cueillette</option>
    <option value="8">Ingénierie</option>
    <option value="9">Joaillerie</option>
    <option value="10">Minage</option>
    <option value="11">Travail du cuir</option>
</select>
<label class="labelInsc" for="skill2">Skill du métier (X/525)</label>
<input class="champInsc" id="skill2" class="champ" name="skill2" type="text" /><br />


</fieldset>
<br/> 
<input name="envoyer" class="nextStage" value="" type="submit" /><br />
</form>

    
<?php 
}

if ($_GET['step']==1){

    if(!isset($_SESSION['conditions'])){
        header('Location: index.php?page=recups');
    }

    if(isset($_POST['pseudo']) && isset($_POST['race']) && isset($_POST['classe']) && isset($_POST['sexe']) && isset($_POST['level']) && isset($_POST['Po'])){
        if(!empty($_POST['pseudo']) && !empty($_POST['race']) && !empty($_POST['classe'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $race = htmlspecialchars($_POST['race']);
        $classe = htmlspecialchars($_POST['classe']);
        $sexe = htmlspecialchars($_POST['sexe']);
        $level = htmlspecialchars($_POST['level']);
        $Po= htmlspecialchars($_POST['Po']);
        
        if (preg_match("#^[a-zA-Z0-9]+$#", $pseudo)) {
           if(CharacterAlreadyExist($CHARS, $pseudo)==false){
                if (preg_match("#^[0-9]+$#", $race)) {
                    if (preg_match("#^[0-9]+$#", $classe)) {
                        if (preg_match("#^[0-9]+$#", $sexe)) {
                            if (preg_match("#^[0-9]+$#", $level)) {
                                if (preg_match("#^[0-9]+$#", $Po)) {

                            $_SESSION['pseudo']= $pseudo;
                            $_SESSION['race']= $race;
                            $_SESSION['classe']= $classe;
                            $_SESSION['sexe']= $sexe;
                            $_SESSION['level']= $level;
                            $_SESSION['Po']= $Po;

                             header('Location: index.php?page=recups&&step=2');
                                }else{
                                  header('Location: index.php');
                             }}else{
                                 header('Location: index.php');
                            }}else{
                                header('Location: index.php');
                            }}else{
                             header('Location: index.php');
                        }}else{
                        header('Location: index.php');
                    }}else{
                      echo "<span class='erreurFormulaire'  color='red'>Pseudo déja existant</span>";
                }}else{
                echo "<span class='erreurFormulaire'  color='red'>Caractères non autorisés sur votre pseudo</span>";
             }}else{
            echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir tous les champs</span>";
        }  
    }
    
?>  

<form action="index.php?page=recups&&step=1" method="post">

<fieldset><legend>Informations sur personnage</legend>  
<p>Ces quelques informations nous serviront à détérminer les caractèristiques de votre nouvel personnage si toutefois il est accépté. Pensez a vous relire si besoin.</p>
<label class="labelInsc" for="pseudo">Personnage:</label>
<input class="champInsc" id="pseudo" class="champ" name="pseudo" type="text" /><br />

<label class="labelInsc" for="level">Niveau:</label>
<input class="champInsc" id="level" class="champ" name="level" type="text" /><br />

<label class="labelInsc" for="Po">Pièces d'or:</label>
<input class="champInsc" id="Po" class="champ" name="Po" type="text" /><br />

<label class="labelInsc" for="race">Race:</label>
<select class="champInsc" id="race" name="race">

    <option value=""></option>
    <option value="1">Humain</option>
    <option value="2">Orc</option>
    <option value="3">Nain</option>
    <option value="4">Elfe de la nuit</option>
    <option value="5">Mort-vivant</option>
    <option value="6">Tauren</option>
    <option value="7">Gnome</option>
    <option value="8">Troll</option>
    <option value="9">Gobelin</option>
    <option value="10">Elfe de sang</option>
     <option value="11">Dranei</option>
    <option value="22">Worgen</option>
</select>


<label class="labelInsc" for="classe">Classe:</label>
<select id="ClassList" class="champInsc" id="classe" name="classe">

    <option value=""></option>
    <option value="1">Guerrier</option>
    <option value="2">Paladin</option>
    <option value="3">Chasseur</option>
    <option value="4">Voleur</option>
    <option value="5">Prêtre</option>
    <option value="6">Chevalier de la mort</option>
    <option value="7">Chaman</option>
    <option value="8">Mage</option>
    <option value="9">Démoniste</option>
    <option value="11">Druide</option>
</select>


<label class="labelInsc" for="sexe">Sexe:</label>
<select class="champInsc" id="sexe" name="sexe">
    
    <option value="0">Homme</option>
    <option value="1">Femme</option>
</select>
</fieldset>
<br/> 
<input name="envoyer" class="nextStage" value="" type="submit" /><br />
</form>
<?php
}

if ($_GET['step']==0){

if(isset($_SESSION['paytarecup'])){
        header('Location: index.php?page=recups');
}else{
   if(getShopPoints($_SESSION['id'], $DB)>=prixRecup){
       //paye la récuperation
    enlevePoints($DB,$_SESSION['id'],prixRecup);
    $_SESSION['paytarecup']=$_SESSION['id'];
    header('Location: index.php?page=recups');
   }else{
       header('Location: index.php?page=recups');
   }
}

    
?>  
    
<?php 
}}else{ 
    
    
if (verifNbrRecups($DB,$_SESSION['id'])<1 || isset($_SESSION['paytarecup'])==$_SESSION['id']){

 ?>
        
<fieldset>
<legend>Conditions générales</legend> 

<?php if( RECUPS_INACTIFS==1){ ?>
<h2><strong style="color:Red; font-size:16px;" >/!\Recupérations Actuellement désactivées</strong ></h2><br/>
<?php }?>

<h3><strong style="color:orange; font-size:14px;" >//Recupérations payantes/gratuites</strong ></h3>
<p>
    Le staff de rolkithan vous offre la possibilité de récupérer un personnage de votre ancien serveur. Toutefois si vous souhaitez en récupérer plusieurs il vous faudra echanger quelques points afin de l'effectuer.
</p>

 <h3><strong style="color:orange; font-size:14px;" >//Généralités</strong ></h3>
<p>
- Afin que votre récupération soit acceptée il est nésséssaire de présenter tous les éléments demandés. <br/>
- Toute récupération avec des informations manquantes sera effacée sans préavis.
- Le stuff récupéré est de niveau 333 pour les récupérations gratuites et de 346 pour les récupérations payantes. Ces derniers sont prédifinis par notre équipe et aucun echange ou exeption ne sera accordée sur la question.
- <strong>Toutes les offres payantes ou gratuites de niveau inférieur ou égal a 80 reçoivent un stuff de niveau 226.</strong>
</p>
 <h3><strong style="color:orange; font-size:14px;" >//Screens</strong ></h3>
<p>
- Au long de cette récupération il vous sera demandé 6 screens:
<ul>
    <li>-> Screen de votre liste des personnages</li>
    <li>-> Screen en jeu dans une ville peuplée</li>
    <li>-> Screen des métiers</li>
    <li>-> Screen du personnage en jeu avec sac ouvert</li>
    <li>-> Screen du /played (celui-ci soit être supérieur à <?php echo joursDeJeuRecup; ?> J)</li>
    <li>-> Screen disant la phrase de la semaine  " <?php echo motSemaine; ?> "</li>
</ul>
<br/>
Il est impératif que les screens fournis correspondent aux informations fournies dans les formulaires dans le cas contraire votre récupération sera éfacée sans préavis.
</p>

 <h3><strong style="color:orange; font-size:14px;" >//Provenance</strong ></h3>
<p>
- Sont acceptées toutes les récupérations provenant de serveurs officiels et privés de rates inférieurs ou égales à 8. De plus les serveurs en question doivent avoir une population supérieur
à 100 personnes connectées simultanément.
</p>
 <h3><strong style="color:orange; font-size:14px;" >//Durée</strong ></h3>
<p>
- Toute récupération est traitée au maximum dans les 72H.
</p>

 <h3><strong style="color:orange; font-size:14px;" >//Fraudes</strong ></h3>
<p>
-  Les personnes essayant de frauder le systéme ou de récuperer des personnages ne leur appartenant pas se verront EFFACER leur COMPTE. Cette désicion est inrévocable.
</p>
 <h3><strong style="color:orange; font-size:14px;" >//Récupérations doubles</strong ></h3>
<p>
    Il est STRICTEMENT INTERDIT de faire plusieurs récupérations sur plusieurs comptes, notre offre contiens un personnage par personne physique et non par compte.
    Si vous avez un deuxiéme compte et que vous souhaitez récupérer un deuxieme personnage il vous faudra avertir un administrateur. 
    Dans le cas contraire celle-ci sera considérée comme une fraude et le deuxième compte sera effacé ainsi que votre première récuperation.
</p>
<h3><strong style="color:orange; font-size:14px;" >//Echanges</strong ></h3>
<p>
- Aucun remboursement ou échange ne sera effectué sur une récupération payante ou gratuite.<br/>
- Dans tous les cas et sur tous les points ci-dessus vous êtes responsable de vous actions et le staff se garde le droit d'interdire, refuser ou modifier une récupération.
</p>

</fieldset>

<fieldset>
<legend>Lu et approuvé</legend> 

En appuyant sur le bouton suivant vous reconnaissez avoir lu et approuvé les information ci-dessus.

</fieldset>
<br />
<?php if( RECUPS_INACTIFS!=1){ ?>
<a href="index.php?page=recups&&step=1" class="nextStage"></a>
<?php }?>


<?php 
$_SESSION['conditions']=true;
}else{
 ?>
<fieldset>
<legend>Récupération payante</legend> 

<?php if( RECUPS_INACTIFS==1){ ?>
<h2><strong style="color:Red; font-size:16px;" >/!\Recupérations Actuellement désactivées</strong ></h2><br/>
<?php }?>

<h3><strong style="color:orange; font-size:14px;" >//Recupérations payante</strong ></h3>
<p>
    Le staff de Rolkithan vous offre la possibilité de récupérer un personnage de votre ancien serveur. Toutefois vous avez déjà effectué une première récupération c'est pourquoi une somme de 
    <strong > <?php echo prixRecup; ?> points R</strong > vous sera demandée pour toutes les récupérations supplémentaires.<br/>
    En appuyant sur le boutton ci-dessous le montant prescrit sera débité sur votre compte et il vous sera impossible de récupérer ces points.
</p>

<p><span style="color: #e1c184;">Vous avez actuellement</span> <?php echo getShopPoints($_SESSION['id'], $DB); ?><span style="color: #e1c184;">  Points R</span></p>


<?php 
if(getShopPoints($_SESSION['id'], $DB)>=prixRecup){
    
?>
<div>
<a id="recupPayd" href="index.php?page=recups&&step=0"> </a>
</div>
<?php 
}else{
?>
<div>
    
<br/>
<h3><strong style="color:Red; font-size:14px;" > Il vous manque <?php echo (prixRecup - getShopPoints($_SESSION['id'], $DB)); ?>  points R pour poursuivre cette action</strong ></h3>
<p>
    Afin de pouvoir profiter de plus de récupérations nous vous invitons à  <a href="index.php?page=achatPoints" style="font-weight: bold;"> acheter d'avantage de points R</a>.
</p>
</div>
<?php 
}
?>
</fieldset>
<?php 
}}
 ?>

<br />
</div>
</div>