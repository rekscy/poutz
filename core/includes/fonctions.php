<?php 

////////////////////////////////////////////
//FONCTIONS de Site 
///////////////////////////////////////////

function titre_page($page) {
    switch ($page) {
        
                        //Pages FrontOffice
        case 'accueil':
            return 'Accueil';
            break;
                        //Pages Administration
        case 'admin':
            return 'Administration';
            break;
        case 'gestRecups':
            return 'Administration';
            break;
        case 'gestNews':
            return 'Administration';
            break;
        case 'gestDebugDev':
            return 'Administration';
            break;
        case 'gestNewsLetter':
            return 'Administration';
            break;
        case 'gestFamilles':
            return 'Administration';
            break;
        case 'gestCategories':
            return 'Administration';
            break;
        case 'gestProjets':
            return 'Administration';
            break;
        case 'gestStatuts':
            return 'Administration';
            break;     
            
                        //Pages boutique
        case 'boutique':
            return 'Boutique';
            break;
        case 'panier':
            return 'Boutique';
            break;
        case 'achatPoints':
            return 'Boutique';
            break; 
        case 'achat_request':
            return 'Boutique';
            break; 
        case 'boutique-services':
            return 'Boutique';
            break;      
        
		//Pages gestionnaire de dev
        case 'bt':
            return 'dev';
            break;
        case 'gestTickets':
            return 'dev';
            break;
        case 'devReport':
            return 'dev';
            break;
        case 'projetEnCours':
            return 'dev';
            break;
        case 'projetFuture':
            return 'dev';
            break;
        case 'statusServer':
            return 'dev';
            break;
        case 'suggestion':
            return 'dev';
            break;
        default:
            return 'erreur';
    }
}


function getNumberComments($DB,$idNews){

    $req = $DB->prepare("SELECT * FROM posts WHERE newsParent = $idNews AND `online`=1 AND type='comment'");
    $req->execute();

    return $req->rowcount();
}


function serveur_online($host,$port) {
    $sock = fsockopen($host, $port, $errno, $errstr, 1);
     return $sock;
}


function getStatutNews($value){
    if($value != 1){
        return "<span style='color:red;'>Hors Ligne</span>";
    }else{
        return "<span style='color: green;'>En Ligne</span>";
    }
}

//fonction limitation de mots
function chaineLimitee($chaine, $nbmots) { // 1er argument : chaîne - 2e argument : nombre de mots
    
$chaine = preg_replace('!<br.*>!iU', "", $chaine); // remplacement des BR par des espaces
$chaine = strip_tags($chaine);
$chaine = preg_replace('/\s\s+/', ' ', $chaine); // retrait des espaces inutiles

$tab = explode(" ",$chaine);
    if (count($tab) <= $nbmots) {
    $affiche = $chaine;
    } else {
        $affiche = "$tab[0]";
        for ($i=1; $i<$nbmots; $i++) {
        $affiche .= " $tab[$i]";
    }
}

return $affiche.' ...';

}

function getTypeDebug($value) {
switch ($value){
        case 1:
            return 'Debug Sort ';
            break;   
        case 2:
            return 'Debug Instance ';
            break;   
        case 3:
            return 'Debug Quete ';
            break;   
        case 4:
            return 'Debug Bg ';
            break;   
        case 5:
            return 'Debug Général ';
            break;   
        case 6:
            return 'Site web ';
            break;   
        case 7:
            return 'Forum ';
            break;   
        case 8:
            return 'Fix Crash ';
            break;  
        case 09:
            return 'Debug Item ';
            break;   
        case 10:
            return 'Debug Talent ';
            break;   

   default:
        return 'Debug ';
    }
}




////////////////////////////////////////////
//FOCTIONS DE TEMPS 
///////////////////////////////////////////

function convertTime($time){
 $elementsdate = chunk_split($time, 2, "-");
 $elementsdate = explode("-", $elementsdate);
// echo '<PRE>';
 //print_r($elementsdate);
  //echo '</PRE>';

$annee = $elementsdate[0] . $elementsdate[1];
$mois =  $elementsdate[3] . $elementsdate[4];
$jour = $elementsdate[6] ;


echo $jour. getMoth($mois).$annee;
}


function getMoth($mois) {
switch ($mois){
        case 01:
            return ' Janvier ';
        case 02:
            return ' Février ';
        case 03:
            return ' Mars ';
        case 04:
            return ' Avirl ';
        case 05:
            return ' Mai ';
        case 06:
            return ' Juin ';
        case 07:
            return ' Juillet ';
        case 08:
            return ' Août ';
        case 09:
            return ' Septembre ';
        case 10:
            return ' Octobre ';
        case 11:
            return ' Novembre ';
        case 12:
            return ' Décembre ';  
   default:
        return 'Mois';
    }
}


function calculSecondes($secondes) {
    $jours = floor($secondes / (3600*24));
    $secondes %= 24*3600;
    $heures = floor($secondes / 3600);
    $secondes %= 3600;
    $minutes = floor($secondes / 60);
    $secondes %= 60;

    echo $jours . 'J ' .  $heures . 'H ' . $minutes . 'Min ' . $secondes . 'S';
}


////////////////////////////////////////////
//FOCTIONS de Royaume 
///////////////////////////////////////////



function getTypeKingdom($type) {
switch ($type){
//0 	Normal    
//1 	PvP
//4 	Normal
//6 	RP
//8 	RP PvP 
        case 01:
            return ' PVP-Fun ';
        case 04:
            return ' PVE BlizzLike ';
        case 06:
            return ' Rp ';
        case 08:
            return ' Rp Pvp ';  
   default:
        return 'Mois';
    }
}

////////////////////////////////////////////
//FOCTIONS D'ADMINISTRATION
///////////////////////////////////////////
function verifPermissionAccess($REALM,$sessionId,$levelSecurity){
    $req = $REALM->prepare("SELECT * FROM account_access WHERE `id` = $sessionId AND `gmlevel` >= $levelSecurity ");
    $req->execute();

    $nbrRecup = $req->rowcount();
    if($nbrRecup){
        return true;
    }else{
        return false;
    }
}


function uploadImageNews($file){

    $avatar = $file;
    $avatar_name = $avatar['name'];
    $ext = strtolower(substr(strrchr($avatar_name,'.'),1));
    $ext_aut = array('jpg');

    
    function check_extension($ext,$ext_aut)
    {
            if(in_array($ext,$ext_aut))
            {
                    return true;
            }
    }

    $valid = (!check_extension($ext,$ext_aut)) ? false : true;
    echo (!check_extension($ext,$ext_aut)) ? "<span class='erreurFormulaire'  color='red'>Veuillez charger une image</span>" : '';

    
    
    if($valid)
    {
            $max_size = 700000;
            if($avatar['size']>$max_size)
            {
                    $valid = false;
                    echo "<span class='erreurFormulaire'  color='red'>Fichier trop gros</span>";
                    exit ();
            }
    }

    if($valid)
    {
            if($avatar['error']>0)
            {
                    $valid = false;
                    $erreur = '';
                    echo "<span class='erreurFormulaire'  color='red'>Erreur lors du transfert</span>";
                    exit ();
            }
    }

    if($valid){
            $path_to_image = 'template/img/news/';

            $filename = sha1(uniqid($avatar_name));

            $source = $avatar['tmp_name'];
            $target = $path_to_image . $filename. '.'. $ext;

            move_uploaded_file($source,$target);

            if($ext == 'jpg' || $ext == 'jpeg') {$im = imagecreatefromjpeg($path_to_image.$filename.'.'.$ext);}
            if($ext == 'png') {$im = imagecreatefrompng($path_to_image.$filename.'.'.$ext);}
            if($ext == 'gif') { $im = imagecreatefromgif($path_to_image.$filename.'.'.$ext);}

            $ox = imagesx($im);
            $oy = imagesy($im);

            $nx = 149;
            $ny = floor($oy *($nx/$ox));

            $nm = imagecreatetruecolor($nx,$ny);

            imagecopyresized($nm, $im, 0,0,0,0, $nx,$ny,$ox,$oy);

            imagejpeg($nm, $path_to_image.$filename.'.'.$ext);

            $_SESSION['imgNews'] = $filename.'.'.$ext;
            
            
            return  true;
    }else{
        return false;
    }
}



////////////////////////////////////////////
//FOCTIONS de Compte 
///////////////////////////////////////////

function verifAncienMDP($DB, $PassVerif, $id){
    $req = $DB->prepare("SELECT password FROM users WHERE id= $id");
    $req->execute();
    
    $d = $req->fetch(PDO::FETCH_OBJ);
    $pass= $d->password;
    
    return $pass==$PassVerif? true : false;
    
}


function changeMDP($DB, $REALM, $nouveauMDP, $id){

    $req = $DB->prepare("UPDATE `users` SET `password`='$nouveauMDP' WHERE `id`=$id ");
    $req->execute();

    $req = $REALM->prepare("UPDATE `account` SET `sha_pass_hash`='$nouveauMDP',`v`=NULL, `s`=NULL  WHERE `id`=$id ");
    $req->execute();
    
   echo "<span class='validFormulaire' color='green'><strong>Opération effectuée avec succés.</strong></span> ";
    
    
}

function getAccount($id,$DB){
    $req = $DB->prepare("SELECT name FROM users WHERE id=". $id);
    $req->execute();
    
    $d = $req->fetch(PDO::FETCH_OBJ);
    return  $d->name;
    
}


function connexion($pseudo, $pass, $DB,$CHARS,$REALM) {
$pseudo = htmlspecialchars($pseudo);
$pass = htmlspecialchars($pass);
$pass_hash = sha1(strtoupper($pseudo) . ':' . strtoupper($pass));

    $req = $DB->prepare("SELECT * FROM users WHERE name='" . $pseudo . "'");
    $req->execute();

    $valid = ($req->rowcount() > 0) ? $req->rowcount() : null;
    if ($valid) {
        $d = $req->fetch(PDO::FETCH_OBJ);
        if (strtoupper($pass_hash) == strtoupper($d->password)) {
            if ($d->accountLevel > 0) {
                $sql = "UPDATE `users` SET `lastConection`='". date('Y-m-d H:i:s' ,time())."'  , `ipAdress`='".$_SERVER['REMOTE_ADDR']."' WHERE name='" . $pseudo . "'";
                $req1 = $DB->prepare($sql);
                $req1->execute();
                
                
                $req2 = $DB->prepare("SELECT * FROM users WHERE name='" . $pseudo . "'");
                $req2->execute();
                $_SESSION['id'] = $d->id;
                $_SESSION['name'] = $d->name;
                $_SESSION['mainPseudo'] = $d->mainPseudo;
                $_SESSION['mail'] = $d->mail;
                $_SESSION['accountLevel'] = $d->accountLevel;
                $_SESSION['ipAdress'] = $d->ipAdress;
                $_SESSION['lastConection'] = $d->lastConection;
                $_SESSION['idParrain'] = $d->idParrain;
                
                //Acces aux zones Protégées
                if(verifPermissionAccess($REALM,$_SESSION['id'],3)){
                    $_SESSION['MaitreJeu'] = true;
                }
               if(verifPermissionAccess($REALM,$_SESSION['id'],4)){
                    $_SESSION['Developpeur'] = true;
                }
               if(verifPermissionAccess($REALM,$_SESSION['id'],5)){
                    $_SESSION['Administrateur'] = true;
                }
                
                
                
                header('Location: index.php');
                return 'valid';
            } else {
                return '<span class="erreurFormulaire"><strong>Votre compte est inactif.</strong><br/><font style="color: #FFF; text-shadow:0px 0px 4px #000; ">Veuillez l\'activer en appuyant sur le lien que nous vos avons envoyé sur votre adresse e-mail.<br/> En cas de probléme majeur veuillez contacter un administrateur.</font></span>';
            }
        } else {
            return '<span class="erreurFormulaire">Identifiants incorrects</span>';
        }
    } else {
        return '<span class="erreurFormulaire">Identifiants incorrects</span>';
    }
}

function getMainPersoGuid($CHARS,$DB,$id){
    
    //DB CHARACTERES
    $sql= " SELECT name from `characters` WHERE `account` = $id  AND totaltime = (select max(totaltime) from `characters` WHERE `account` = $id)";
    $req = $CHARS->prepare($sql);
    $req->execute();
    
    $d = $req->fetch(PDO::FETCH_OBJ);
    
    if ($isset($d->guid)) {
		return $d->guid;
	}
	else
	{
		return 0;
	}
}
 
function getCharLevel($CHARS,$guid){
        $req = $CHARS->prepare(" SELECT level  from `characters` WHERE `guid` = $guid");
        $req->execute();
        $n = $req->fetch(PDO::FETCH_OBJ);
        
        return $n->level;
}


function getMainPerso($CHARS,$DB,$id){
    
    //DB CHARACTERES
	if ($id == 0) {
		return "Inconnu";
	}
	else
	{
		$sql= " SELECT name from `characters` WHERE `account` = $id  AND totaltime = (select max(totaltime) from `characters` WHERE `account` = $id)";
		$req = $CHARS->prepare($sql);
		$req->execute();
		
		$d = $req->fetch(PDO::FETCH_OBJ);
		
		
		
		if(isset($d->name)){
			$nom = $d->name;
		}else{
			$nom = getAccount($id, $DB);
		}
	}
   
    return $nom;
    
}



function getMail($id,$DB){
    $req = $DB->prepare("SELECT mail FROM users WHERE id=". $id);
    $req->execute();
    
    $d = $req->fetch(PDO::FETCH_OBJ);
    echo $d->mail;
    
}


function getParrainId($id,$DB){
    $req = $DB->prepare("SELECT idParrain FROM users WHERE id=". $id);
    $req->execute();
    
    $d = $req->fetch(PDO::FETCH_OBJ);
    return $d->idParrain;
    
}

function getAccountLevel($id,$DB){
    $req = $DB->prepare("SELECT accountLevel FROM users WHERE id=". $id);
    $req->execute();
    
    $d = $req->fetch(PDO::FETCH_OBJ);
    return $d->accountLevel;
    
}

function getLastConection($id,$DB){
    $req = $DB->prepare("SELECT lastConection FROM users WHERE id=". $id);
    $req->execute();
    
    $d = $req->fetch(PDO::FETCH_OBJ);
        
    return $d->lastConection;
    
}

function getSignIn($id,$DB){
    $req = $DB->prepare("SELECT signIn FROM users WHERE id=". $id);
    $req->execute();
    
    $d = $req->fetch(PDO::FETCH_OBJ);
    return ($d->signIn);
    
}

function getSignInUNIX($id,$DB){
    $req = $DB->prepare("SELECT signIn FROM users WHERE id=". $id);
    $req->execute();
    
    $d = $req->fetch(PDO::FETCH_OBJ);
    return strtotime($d->signIn);
    
}

function getShopPoints($id,$DB){
    $req = $DB->prepare("SELECT shopPoints FROM users WHERE id=". $id);
    $req->execute();
    
    $d = $req->fetch(PDO::FETCH_OBJ);
    return $d->shopPoints;
    
}

function getVotePoints($id,$DB){
    $req = $DB->prepare("SELECT votePoints FROM users WHERE id=". $id);
    $req->execute();
    
    $d = $req->fetch(PDO::FETCH_OBJ);
    echo $d->votePoints;
    
}

function statutParrainage($secondes) {

    $temps = 3*24*3600; //3J
    
    echo $temps<$secondes?"<font color='Green'>Disponible</font>" : "<font color='red'>Indisponible</font>";

}

function activationParrainage($DB,$fill, $parrain){
    
            $req = $DB->prepare("UPDATE `users` SET `shopPoints`=shopPoints+400,`parFinis`=parFinis+1   WHERE `id`='$parrain' ");
            $req->execute();
            
            $req = $DB->prepare("UPDATE `users` SET `shopPoints`=shopPoints+150,`accountLevel`='2'  WHERE `id`='$fill' ");
            $req->execute();
            
            
    
}

function getGuild($DB,$guid){
        $req = $DB->prepare("SELECT `guildid` FROM `guild_member` WHERE `guid` = $guid");
        $req->execute();

        $d = $req->fetch(PDO::FETCH_OBJ);
        if(isset($d->guildid)){
            if($d->guildid>0 && isset($d->guildid)){
            $guilde= $d->guildid;
            $req = $DB->prepare("SELECT `name` FROM `guild` WHERE `guildid`=$guilde");
            $req->execute(); 
            $d1 = $req->fetch(PDO::FETCH_OBJ);

            return $d1->name;
            }  else {
                return false;
            }
        }
}

function getNameGuid($DB, $id){
                
        $req = $DB->prepare(" SELECT name  from `characters` WHERE `guid` = $id");
        $req->execute();
        $n = $req->fetch(PDO::FETCH_OBJ);
        
        return $n->name;
}

function getNbrMembersGuild($DB, $id){
                
        $req = $DB->prepare(" SELECT *  from `guild_member` WHERE `guildid` = $id");
        $req->execute();
        $n = $req->rowcount();
        
        return $n;
}

function getAllPlayedTime($DB, $id){
    //DB CHARACTERES
    $temps=0;
    
    $sql= " SELECT * from `characters` WHERE `account` = $id";
    $req = $DB->prepare($sql);
    $req->execute(); 
    $valid= $req->rowcount();
    if($valid){
    $sql= " SELECT guid from `characters` WHERE `account` = $id";
    $req = $DB->prepare($sql);
    $req->execute();
    
        while ($d = $req->fetch(PDO::FETCH_OBJ)) {

        $guid= $d->guid;
                
        $req1 = $DB->prepare(" SELECT totaltime  from `characters` WHERE `guid` = $guid");
        $req1->execute();
        $d = $req1->fetch(PDO::FETCH_OBJ);
        $temps = $temps+$d->totaltime;
    }}
    
    return $temps;
}


function verifCompteGuid($guid, $compte,$DB){
    //DB CHARACTERES
    $sql= " SELECT guid from `characters` WHERE `account` = $compte AND `guid` = $guid " ;
    $req = $DB->prepare($sql);
    $req->execute();
    $valid = $req->rowcount();
    return $valid;
} 


////////////////////////////////////////////
//FOCTIONS de Characteres 
///////////////////////////////////////////

function isOnline($DB,$guid){
    
    
    $sql= " SELECT guid from `characters` WHERE `online` = 1 AND `guid` = $guid " ;
    $req = $DB->prepare($sql);
    $req->execute();

    return $req->rowcount();
}


function CharacterAlreadyExist($DB,$name){
    
    $sql= " SELECT * from `characters` WHERE `name` ='$name'" ;
    $req = $DB->prepare($sql);
    $req->execute();

    return $req->rowcount();
}


function customiseCharactere($DB, $CHARS, $guid,$account, $perso, $action){
    
    $points = getShopPoints($account, $DB);
    
    switch ($action) {
    case '1':
        $depense=100;
        
        if($points>=$depense){
            $pointsRestants= $points-$depense;
            $req = $DB->prepare("UPDATE `users` SET `shopPoints`=$pointsRestants WHERE `id`=$account ");
            $req->execute();
            
            $req = $CHARS->prepare("UPDATE `characters` SET `at_login`='1' WHERE `guid`='$guid' AND `account`='$account' ");
            $req->execute();
            
            echo "<span class='validFormulaire' color='green'><strong>Opération effectuée avec succés.</strong> <br/> <span style='color:darkgreen';>Votre nouveau pseudo vos sera demandé lors de  votre prochaine connection.</span></span>
                ";
            echo '<br/>';
            echo "<a style='display: block;' href='index.php?page=membre'>Liste des personnages</a>";
        
        }else{
            echo "<span class='erreurFormulaire'  color='red'>Vous n'avez pas assez de points pour cet achat.</span>";
            echo '<br/>';
            echo "<a style='display: block;' href='index.php?page=membre'>Liste des personnages</a>";
        }
        
        break;
    case '2':
        $depense=150;
        
        if($points>=$depense){
            $pointsRestants= $points-$depense;
            $req = $DB->prepare("UPDATE `users` SET `shopPoints`=$pointsRestants WHERE `id`=$account ");
            $req->execute();
            
            $req = $CHARS->prepare("UPDATE `characters` SET `at_login`='128' WHERE `guid`='$guid' AND `account`='$account' ");
            $req->execute();
            
            echo "<span class='validFormulaire' color='green'><strong>Opération effectuée avec succés.</strong> <br/> <span style='color:darkgreen';>Votre nouvelle race vos sera demandée lors de  votre prochaine connection.</span></span>
                ";
            echo '<br/>';
            echo "<a style='display: block;' href='index.php?page=membre'>Liste des personnages</a>";
        
        }else{
            echo "<span class='erreurFormulaire'  color='red'>Vous n'avez pas assez de points pour cet achat.</span>";
            echo '<br/>';
            echo "<a style='display: block;' href='index.php?page=membre'>Liste des personnages</a>";
        }
        break;
    case '3':
        $depense=200;
        
        if($points>=$depense){
            $pointsRestants= $points-$depense;
            $req = $DB->prepare("UPDATE `users` SET `shopPoints`=$pointsRestants WHERE `id`=$account ");
            $req->execute();
            
            $req = $CHARS->prepare("UPDATE `characters` SET `at_login`='64' WHERE `guid`='$guid' AND `account`='$account' ");
            $req->execute();
            
            echo "<span class='validFormulaire' color='green'><strong>Opération effectuée avec succés.</strong> <br/> <span style='color:darkgreen';>Votre nouvelle race vos sera demandée lors de  votre prochaine connection.</span></span>
                ";
            echo '<br/>';
            echo "<a style='display: block;' href='index.php?page=membre'>Liste des personnages</a>";
        
        }else{
            echo "<span class='erreurFormulaire'  color='red'>Vous n'avez pas assez de points pour cet achat.</span>";
            echo '<br/>';
            echo "<a style='display: block;' href='index.php?page=membre'>Liste des personnages</a>";
        }
        
        break;
    case '4':
        $depense=100;
        
        if($points>=$depense){
            $pointsRestants= $points-$depense;
            $req = $DB->prepare("UPDATE `users` SET `shopPoints`=$pointsRestants WHERE `id`=$account ");
            $req->execute();
            
            $req = $CHARS->prepare("UPDATE `characters` SET `at_login`='8' WHERE `guid`='$guid' AND `account`='$account' ");
            $req->execute();
            
            echo "<span class='validFormulaire' color='green'><strong>Opération effectuée avec succés.</strong> <br/> <span style='color:darkgreen';>Votre nouvelle apparence vos sera demandée lors de  votre prochaine connection.</span></span>
                ";
            echo '<br/>';
            echo "<a style='display: block;' href='index.php?page=membre'>Liste des personnages</a>";
        
        }else{
            echo "<span class='erreurFormulaire'  color='red'>Vous n'avez pas assez de points pour cet achat.</span>";
            echo '<br/>';
            echo "<a style='display: block;' href='index.php?page=membre'>Liste des personnages</a>";
        }
        
        break;

    default:
        header('Location: index.php?page=membre');
    }
}



function getArgentChar($DB,$guid) {
    $req = $DB->prepare(" SELECT money  from `characters` WHERE `guid` = $guid");
    $req->execute();
    $d = $req->fetch(PDO::FETCH_OBJ);
    $PC= $d->money;
    
    $PO = floor($PC / 10000);

    $PC %=  10000;
    $PA = floor($PC / 100);
    
    $PC %= 100;


    echo $PO.'<span style="color:gold;"> PO</span> ' .  $PA.'<span style="color:silver;"> PA</span> '. $PC. '<span style="color:#c39640;"> PC</span> ';
}


function image_race($race) {
    switch ($race) {
        case 1:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/1-0.jpg" title="Humain" alt="Humain" />';
        case 2:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/2-0.jpg" title="Orc" alt="Orc" />';
        case 3:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/3-0.jpg" title="Nain" alt="Nain" />';
        case 4:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/4-0.jpg" title="Elfe de la nuit " alt="Elfe de la nuit" />';
        case 5:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/5-0.jpg" title="Un-dead" alt="Mort vivant" />';
        case 6:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/6-0.jpg" title="Tauren" alt="Tauren" />';
        case 7:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/7-0.jpg" title="Gnome" alt="Gnome" />';
        case 8:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/8-0.jpg" title="Troll" alt="Troll" />';
         case 9:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/9-0.jpg" title="Gobelin" alt="Gobelin" />';
        case 10:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/10-0.jpg" title="Kikooelf" alt="Elfe de sang" />';
        case 11:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/11-0.jpg" title="Draneil" alt="Draenei" />';
        case 22:
            return '<img style="margin-left:12px; float: left;;" src="template/img/races/22-0.jpg" title="Worgen" alt="Worgen" />';

        default:
            return '';
    }
}

function image_classe($classe) {
    switch ($classe) {
        case 1:
            return '<img style="margin-left:12px; float: left;;" src="template/img/classes/guerrier.jpg" title="Guerrier" alt="Guerrier" />';
        case 2:
            return '<img style="margin-left:12px; float: left;;" src="template/img/classes/paladin.jpg" title="Paladin"alt="Paladin" />';
        case 3:
            return '<img style="margin-left:12px; float: left;;" src="template/img/classes/chasseur.jpg" title="Chasseur" alt="Chasseur" />';
        case 4:
            return '<img style="margin-left:12px; float: left;;"  src="template/img/classes/voleur.jpg" title="Voleur" alt="Voleur" />';
        case 5:
            return '<img style="margin-left:12px; float: left;;" src="template/img/classes/pretre.jpg" title="pretre" alt="Pretre" />';
        case 6:
            return '<img style="margin-left:12px; float: left;;" src="template/img/classes/dk.jpg" title="Dk" alt="Deathknight" />';
        case 7:
            return '<img style="margin-left:12px; float: left;;" src="template/img/classes/chaman.jpg" title="Chaman" alt="Chaman" />';
        case 8:
            return '<img style="margin-left:12px; float: left;;" src="template/img/classes/mage.jpg" title="Mage" alt="Mage" />';
        case 9:
            return '<img style="margin-left:12px; float: left;;" src="template/img/classes/demoniste.jpg" title="Démoniste" alt="Démoniste" />';
        case 11:
            return '<img style="margin-left:12px; float: left;;" src="template/img/classes/druide.jpg" alt="Druide" />';
        default:
            return '';
    }
}

function getMetier($metier) {
    switch ($metier) {
        case 1:
            return 'Alchimie';
        case 2:
            return 'Calligraphie';
        case 3:
            return 'Couture';
        case 4:
            return 'Dépeçage';
        case 5:
            return 'Enchantement';
        case 6:
            return 'Forge';
        case 7:
            return 'Cueillette';
        case 8:
            return 'Ingénierie';
        case 9:
            return 'Joaillerie';
        case 10:
            return 'Minage';
        case 11:
            return 'Travail du cuir';
        default:
            return 'Indéfini';
    }
}

// Fonctions de réupérations

////////////////////////////////////////////
//FOCTIONS DE MAIL & COMPTE
///////////////////////////////////////////

function addCompte($DB, $REALM, $compte, $password, $mail, $parrain) {

    //traintement du compte Jeu
    
    if($parrain>0){
    $req = $DB->prepare("UPDATE `users` SET `parComence`=parComence+1   WHERE `id`='$parrain' ");
    $req->execute();
    }
    
    
    $req = $REALM->prepare("INSERT INTO account (username, sha_pass_hash, email, joindate, locked, expansion) VALUES (:pseudo, :mdp_realmd, :email, NOW(), 1,'3')")
            or die(print_r($REALM->errorInfo()));
    $req->execute(array(
        'pseudo' => $compte,
        'mdp_realmd' => $password,
        'email' => $mail,));
    //traitement du compte Site
    $req = $DB->prepare("INSERT INTO `users` (`id`, `name`, `password`, `mainPseudo`, `mail`, `shopPoints`, `votePoints`, `ipAdress`, `signIn`, `lastConection`, `rankVote`, `votePointsLast`, `nbrAchats`, `idParrain`, `accountLevel`, `codeActivate`) 
        VALUES (:id, :name, :password, :mainPseudo, :mail, :shopPoints, :votePoints, :ipAdress, NOW(), :lastConection, :rankVote, :votePointsLast, :nbrAchats, :idParrain, :accountLevel, :codeActivate)");

    $linkActivation= sha1(rand(100, 1000).$mail.$password);
    
    $req->execute(array(
        'id'=> '',
        'name'=> $compte,
        'password'=> $password,
        'mainPseudo'=> 'indéfini',
        'mail'=> $mail,
        'shopPoints'=> '0',
        'votePoints'=> '0',
        'ipAdress'=> $_SERVER['REMOTE_ADDR'],
        'lastConection'=> '',
        'rankVote'=> '0',
        'votePointsLast'=> '0',
        'nbrAchats'=> '0',
        'idParrain'=> $parrain,
        'accountLevel'=> '0',
        'codeActivate'=> $linkActivation,

))or die(print_r($DB->errorInfo()));
    
    
    $message="
<html>
<style>
    
body{
    font: normal 12px/1.2   arial, sans-serif; font-weight: lighter; vertical-align: top;
    width: 900px;
    margin: auto;
    background: #030100;
    background: url('http://ressources.rolkithan.fr/background_mail.jpg') top center no-repeat #000;
    font-weight: bold;
}

h3{
    margin-top: 15px;
    font-size: 18px;
    color: gold;
    text-shadow:0px 0px 4px orange;
}
p{
    color: gold;
    text-shadow:0px 0px 4px orange;
 font-size: 14px;
}

a{
    color: orange;
    text-decoration: none;
}

</style>

<body>
    <h3>Inscription sur le Serveur Rolkithan-Project de <strong>$compte</strong></h3>

    <legend>Nouveau!!</legend>
Bonjour $compte, c'est avec grand plaisir que nous vous félicitons dès maintenant pour votre excellent choix.
Le staff de Rolkithan est très présent et à l'écoute c'est pourquoi nous nos tenons a votre disposition pour d'éventuelles questions. <br/>
    </p>
</fieldset>

<fieldset>
    <legend>Votre lien d'activation</legend>
    <p>
        <a href='http://www.rolkithan.fr/index.php?page=activateAccount&&link=$linkActivation&&compte=$compte' style='text-align: center;'>Activer mon compte</a>
    </p>
</fieldset>

</body>
</html>
";
    
    sendMail($mail,'Inscription sur Rolkithan.fr', $message,$compte);
}


function sendMail($to,$subject,$message, $name){
     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

     // En-têtes additionnels
     $headers .= 'From: Staff Asgard-server <administrattion@asgard-servers.com>' . "\r\n";
     mail($to, $subject, $message, $headers);
}




////////////////////////////////////////////
//FOCTIONS DE RECUPERATIONS
///////////////////////////////////////////

function verifNbrRecups($DB,$sessionId){
    $sql= " SELECT id from `recups` WHERE `user_id` = $sessionId  AND `status` = '1'" ;
    $req = $DB->prepare($sql);
    $req->execute();
    $nbrRecup = $req->rowcount();
    
    return $nbrRecup;
}

function verifNbrRecupsMembre($DB,$sessionId){
    $sql= " SELECT id from `recups` WHERE `user_id` = $sessionId" ;
    $req = $DB->prepare($sql);
    $req->execute();
    $nbrRecup = $req->rowcount();
    
    return $nbrRecup;
}
function saveRecup($DB){
    
    $sessionId = $_SESSION['id'];         
    $sql= " SELECT id from `recups` WHERE `user_id` = $sessionId" ;
    $req = $DB->prepare($sql);
    $req->execute();
    $nbrRecup = $req->rowcount();
    
    
    $personnage =  $_SESSION['pseudo'];
    $sql2= " SELECT * from `recups` WHERE `personnage` = $personnage" ;
    $req2 = $DB->prepare($sql2);
    $req2->execute();
    $nbrPerso = $req2->rowcount();
    
    if($nbrPerso==0){
    $req1 = $DB->prepare("INSERT INTO `recups` (`user_id`, `nbrRecup`, `personnage`, `classe`, `race`, `sexe`, `spe`, `metier1`, `metier2`, `screen1`, `screen2`, `screen3`, `screen4`, `screen5`, `screen6`, `motSemaine`, `dateStart`, `dateFinish`, `status`,`stuffLevel`,`level`,`Po`,`skill1`,`skill2`,`lien`)
    VALUES ( :user_id, :nbrRecup, :personnage, :classe, :race, :sexe, :spe, :metier1, :metier2, :screen1, :screen2, :screen3, :screen4, :screen5, :screen6, :motSemaine,  NOW(), '', '0',:stuffLevel,:level,:Po,:skill1,:skill2,:lien)");
    
    $req1->execute(array(
        'user_id'=> $_SESSION['id'],
        'nbrRecup'=>$nbrRecup,
        'personnage'=> $_SESSION['pseudo'],
        'classe'=>  $_SESSION['classe'],
        'race'=>    $_SESSION['race'],
        'spe'=>     $_SESSION['specialisation'],
        'sexe'=>    $_SESSION['sexe'],
        'metier1'=> $_SESSION['metier1'],
        'metier2'=> $_SESSION['metier2'],
        'screen1'=> $_SESSION['screen1'],
        'screen2'=> $_SESSION['screen2'],
        'screen3'=> $_SESSION['screen3'],
        'screen4'=> $_SESSION['screen4'],
        'screen5'=> $_SESSION['screen5'],
        'screen6'=> $_SESSION['screen6'],
        'motSemaine'=> $_SESSION['motSemaine'],
        'stuffLevel'=> $_SESSION['levelStuff'],
        'level'=> $_SESSION['level'],
        'Po'=> $_SESSION['Po'],
        'skill1'=> $_SESSION['skill1'],
        'skill2'=> $_SESSION['skill2'],
        'lien'=> $_SESSION['lienArmurerie']
))or die(print_r($DB->errorInfo()));
   
    $_SESSION['sucess'] = true;
    return true;
    }
}



function uploadImage($file,$nbrImg){

    $avatar = $file;
    $avatar_name = $avatar['name'];
    $ext = strtolower(substr(strrchr($avatar_name,'.'),1));
    $ext_aut = array('jpg','jpeg','png','gif');

    
    function check_extension($ext,$ext_aut)
    {
            if(in_array($ext,$ext_aut))
            {
                    return true;
            }
    }

    $valid = (!check_extension($ext,$ext_aut)) ? false : true;
    echo (!check_extension($ext,$ext_aut)) ? "<span class='erreurFormulaire'  color='red'>Veuillez charger une image</span>" : '';

    
    
    if($valid)
    {
            $max_size = 700000;
            if($avatar['size']>$max_size)
            {
                    $valid = false;
                    echo "<span class='erreurFormulaire'  color='red'>Fichier trop gros</span>";
                    exit ();
            }
    }

    if($valid)
    {
            if($avatar['error']>0)
            {
                    $valid = false;
                    $erreur = '';
                    echo "<span class='erreurFormulaire'  color='red'>Erreur lors du transfert</span>";
                    exit ();
            }
    }

    if($valid){
            $path_to_image = 'template/img/recuperation/fullsize/';
            $path_to_min = 'template/img/recuperation/min/';

            $filename = sha1(uniqid($avatar_name));

            $source = $avatar['tmp_name'];
            $target = $path_to_image . $filename. '.'. $ext;

            move_uploaded_file($source,$target);

            if($ext == 'jpg' || $ext == 'jpeg') {$im = imagecreatefromjpeg($path_to_image.$filename.'.'.$ext);}
            if($ext == 'png') {$im = imagecreatefrompng($path_to_image.$filename.'.'.$ext);}
            if($ext == 'gif') { $im = imagecreatefromgif($path_to_image.$filename.'.'.$ext);}

            $ox = imagesx($im);
            $oy = imagesy($im);

            $nx = 150;
            $ny = floor($oy *($nx/$ox));

            $nm = imagecreatetruecolor($nx,$ny);

            imagecopyresized($nm, $im, 0,0,0,0, $nx,$ny,$ox,$oy);

            imagejpeg($nm, $path_to_min.$filename.'.'.$ext);

            $_SESSION['screen'.$nbrImg] = $filename.'.'.$ext;
            
            
            return  true;
    }else{
        return false;
    }
}


function statutRecup($statut) {
    switch ($statut) {
        
                        //Pages FrontOffice
        case 0:
            return "<span style='color:orange;'>En attente</span>";
            break;
                        //Pages BackOffice
        case 1:
            return "<span style='color:Green;'>Acceptée</span>";
            break;
        case 2:
            return "<span style='color:red;'>Refusée</span>";
            break;
        default:
            return 'erreur';
    }
}

function refuseChar($name, $DB) {
    
    $req = $DB->prepare("UPDATE `recups` SET `status`=2  WHERE `personnage`='$name' ");
    $req->execute();
    
}


function resetChar($name, $DB) {
    
    $req = $DB->prepare("UPDATE `recups` SET `status`=0  WHERE `personnage`='$name' ");
    $req->execute();
    
}
function deleteChar($name, $CHARS) {
    
   
    $sql="SELECT * FROM `characters` WHERE `name` = '$name' ";
    $req = $CHARS->prepare($sql);
    $req->execute();
    $d=$req->fetch(PDO::FETCH_OBJ);

    $guid=$d->guid;
    
    $sql1="DELETE FROM characters WHERE guid= :guid";
    $req1 = $CHARS->prepare($sql1);
    $req1->execute(array('guid' => $guid));

    $sql2="DELETE FROM item_instance WHERE owner_guid=:guid";
    $req2 = $CHARS->prepare($sql2);
    $req2->execute(array('guid' => $guid));
    
    $sql3="DELETE FROM character_spell WHERE guid=:guid";
    $req3 = $CHARS->prepare($sql3);
    $req3->execute(array('guid' => $guid));

    $sql4="DELETE FROM character_skills WHERE guid=:guid";
    $req4 = $CHARS->prepare($sql4);
    $req4->execute(array('guid' => $guid));

}

function transfertChar($newAccount, $name, $CHARS,$DB) {
    
    $req = $CHARS->prepare("UPDATE `characters` SET `account`=$newAccount WHERE (`name`='$name')");
    $req->execute();
    
    $req7 = $DB->prepare("UPDATE `recups` SET `status`=1, `id_GM`=".$_SESSION['id']."  WHERE `personnage`='$name' ");
    $req7->execute();
}


function acceptChar($name, $DB, $CHARS) {

 
    
 $sql=  "SELECT * FROM `recups` WHERE `personnage` = '$name'" ;
 $req = $DB->prepare($sql);
 $req->execute();
 $d=$req->fetch(PDO::FETCH_OBJ);
 
$name = ucfirst($name);
$compte = $_SESSION['id'];
$classe= $d->classe;
$race= $d->race;
$gender= $d->sexe;
$level= $d->level;
$classe= $d->classe;
$specialisation= $d->spe;
$stuffLevel= $d->stuffLevel;

$metier1=$d->metier1;
$metier2=$d->metier2;
$skill1=$d->skill1;
$skill2=$d->skill2;

//tranformation en po

if($d->Po>=10000){
    $d->Po= 10000;
}
if($d->Po<=6000){
    $d->Po= 6000;
}

$Po =  $d->Po *10000;
 



function getSpellsJobs($metier){
/*** [1] Alchimie
ID:80731
Skill:171
Sorts supllémentaires: */
    switch ($metier){
        case 1: 

        return array(80731);
        break;
/**** [2] Calligraphie
ID:86008
Skill:773
Sorts supllémentaires:
-51005 -->Mouture
 */
        case 2: 

        return array(86008,51005);
        break;
/*** [3] Couture
ID:75156
Skill:197
Sorts supllémentaires:
-*/
        case 3: 

        return array(75156);
        break;
 /*** [4] Dépeçage
ID:74522
Skill:393
Sorts supllémentaires:
-*/
        case 4: 

        return array(74522);
        break;
 /*** [5] Enchantement
ID:74258
Skill:333
Sorts supllémentaires:
-13262 --->Désenchanter */
        case 5: 

        return array(74258,13262);
        break;
/*** [6] Forge
ID:2018
Skill:164
Sorts supllémentaires: */        
        case 6: 

        return array(2018);
        break;
 /*** [7] Cueillette
ID:74519
Skill:182
Sorts supllémentaires:
- 2383 ------>Découverte d'herbes */
        case 7: 

        return array(74519,2383);
        break;
 /*** [8] Ingénierie
ID:82774
Skill:202
Sorts supllémentaires:
-*/
        case 8: 

        return array(82774);
        break;
 /*** [9] Joaillerie
ID:73318
Skill:755
Sorts supllémentaires:
-*/
        case 9: 

        return array(73318);
        break;
 /*** [10] Minage
ID:74517
Skill:186
Sorts supllémentaires:
- 2656 ---> Fondre
- 2580 ---> Découverte de gisements*/
        case 10: 

        return array(74517,2656,2580);
        break;
    
 /*** [11] Travail du cuir
ID:81199
Skill:165
Sorts supllémentaires: */
        case 11: 

        return array(81199);
        break;
default: exit (); }

}


function getSkillJobs($metier){

    switch ($metier){
        case 1: 
        return 171;
        break;

        case 2: 
        return 773;
        break;

        case 3: 
        return 197;
        break;

        case 4: 
        return 393;
        break;

        case 5: 
        return 333;
        break;
     
        case 6: 
        return 164;
        break;

        case 7: 
        return 182;
        break;

        case 8: 
        return 202;
        break;

        case 9: 
        return 755;
        break;

        case 10: 
        return 186;
        break;
    
        case 11: 
        return 165;
        break;
default: exit (); }

}


switch ($race){
        case 1: //HUMAIN
            switch ($classe){ // 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
            case 1:
                $sql ="INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 1, 1, $gender, $level, 0, $Po, 84018688, 33554438, 0, -8914.57, -133.909, 80.5378, 0, 0, 0, 0, '2 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1334994195, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 12, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 68, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 375, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58231 0 0 0 39 0 40 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 49778 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
            case 2:
                $sql="INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 1, 2, $gender, $level, 0, $Po, 117704193, 33554433, 0, -8914.57, -133.909, 80.5378, 0, 0, 0, 0, '2 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1334994205, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 12, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 76, 80, 0, 0, 100, 0, 0, 0, 0, 0, 0, 375, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58233 0 0 0 44 0 43 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 52557 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
            case 4:
                $sql="INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 1, 4, $gender, $level, 0, $Po, 50334985, 33554438, 0, -8914.57, -133.909, 80.5378, 0, 0, 0, 0, '2 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1334994214, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 12, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 59, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 375, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58234 0 0 0 48 0 47 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 25 0 50055 0 28979 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
              break;
            case 5:
                $sql="INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 1, 5, $gender, $level, 0, $Po, 657161, 33554433, 0, -8914.57, -133.909, 80.5378, 0, 0, 0, 0, '2 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1334994265, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 12, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 72, 123, 0, 0, 100, 0, 0, 0, 0, 0, 0, 359, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 6098 0 0 0 52 0 51 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";
              break;
            case 6:
                $sql="INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 1, 6, $gender, $level, 0, $Po, 185010702, 33554434, 0, 2355.84, -5662.21, 426.028, 609, 0, 0, 3.93485, '4294967295 4093640703 830406655 8 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 0, 0, 0, 0, 1334994279, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4298, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2485, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 141, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
              break;
            case 8:
                $sql="INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 1, 8, $gender, $level, 0, $Po, 151127047, 33554438, 0, -8914.57, -133.909, 80.5378, 0, 0, 0, 0, '2 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1334994291, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 12, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 52, 165, 0, 0, 100, 0, 0, 0, 0, 0, 0, 141, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 56 0 0 0 1395 0 55 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 8 ', 0, NULL, NULL, NULL, -1, 0);";
              break;
            case 9:
                $sql="INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 1, 9, $gender, $level, 0, $Po, 525058, 33554438, 0, -8914.57, -133.909, 80.5378, 0, 0, 0, 0, '2 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1334994318, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 12, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 57, 140, 0, 0, 100, 0, 0, 0, 0, 0, 0, 140, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 57 0 0 0 1396 0 59 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 43 ', 0, NULL, NULL, NULL, 100, 3452816845);";
             break;
            default:
               exit ();
           } 
            
        break;
      case 2: //ORC
            switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
            case 1:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 2, 1, $gender, $level, 0, $Po, 67591, 33554438, 0, -618.518, -4251.67, 38.718, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335043545, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 96, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 78, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58245 0 0 0 139 0 140 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 12282 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
              break;
            case 3:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 2, 3, $gender, $level, 0, $Po, 67591, 33554438, 0, -618.518, -4251.67, 38.718, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335043558, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 108, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 78, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58247 0 0 0 6137 0 6138 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 57243 0 0 0 2504 0 0 0 ', 0, '0 0 0 0 0 0 0 400 163 65537 0 95 ', 0, NULL, NULL, NULL, 0, 1);";
              break;
            case 4:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 2, 4, $gender, $level, 0, $Po, 33752066, 33554442, 0, -618.518, -4251.67, 38.718, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335043571, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 87, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 93, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58246 0 0 0 120 0 121 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 37 0 50055 0 25861 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
              break;
            case 6:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 2, 6, $gender, $level, 0, $Po, 69895, 33554438, 0, 2355.84, -5662.21, 426.028, 609, 0, 0, 3.93485, '4294967295 4093640703 830406655 4 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 0, 0, 0, 0, 1335043584, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4298, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2499, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 93, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";        
              break;
            case 7:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 2, 7, $gender, $level, 0, $Po, 33620739, 33554437, 0, -618.518, -4251.67, 38.718, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335043594, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 102, 103, 0, 0, 100, 0, 0, 0, 0, 0, 0, 94, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52544 0 0 0 52545 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 36 0 2362 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";       
              break;
            case 8:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 2, 8, $gender, $level, 0, $Po, 100664320, 33554442, 0, -618.518, -4251.67, 38.718, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335043606, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 51, 225, 0, 0, 100, 0, 0, 0, 0, 0, 0, 94, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52546 0 0 0 52681 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 8 ', 0, NULL, NULL, NULL, -1, 0);";
              break;
            case 9:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 2, 9, $gender, $level, 0, $Po, 67591, 33554438, 0, -618.518, -4251.67, 38.718, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335043617, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 85, 109, 0, 0, 100, 0, 0, 0, 0, 0, 0, 94, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52543 0 0 0 52679 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 43 ', 0, NULL, NULL, NULL, 100, 3452816845);";

                break;
            default:
               exit ();
           }      
       break;
     case 3://NAIN
            switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
            case 1:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 3, 1, $gender, $level, 0, $Po, 17434119, 33554438, 0, -6230.42, 330.232, 383.105, 0, 0, 0, 6.17716, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335045637, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 110, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 343, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58231 0 0 0 39 0 40 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 12282 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";

              break;
            case 2:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 3, 2, $gender, $level, 0, $Po, 117573125, 33554434, 0, -6230.42, 330.232, 383.105, 0, 0, 0, 6.17716, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335045647, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 118, 79, 0, 0, 100, 0, 0, 0, 0, 0, 0, 343, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58233 0 0 0 44 0 43 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 52557 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";

              break;
            case 3:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                       VALUES ($compte, '$name', 3, 3, $gender, $level, 0, $Po, 118227202, 33554435, 0, -6230.42, 330.232, 383.105, 0, 0, 0, 6.17716, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335045657, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 122, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 343, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58232 0 0 0 147 0 129 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 52532 0 0 0 2508 0 0 0 ', 0, '0 0 0 0 0 0 0 400 163 65537 0 95 ', 0, NULL, NULL, NULL, 0, 1);";

              break;
            case 4:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 3, 4, $gender, $level, 0, $Po, 591112, 33554442, 0, -6230.42, 330.232, 383.105, 0, 0, 0, 6.17716, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335045667, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 101, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 312, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58234 0 0 0 48 0 47 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 36 0 50055 0 25861 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";

              break;
            case 5:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 3, 5, $gender, $level, 0, $Po, 118227202, 33554435, 0, -6230.42, 330.232, 383.105, 0, 0, 0, 6.17716, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335045682, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 114, 108, 0, 0, 100, 0, 0, 0, 0, 0, 0, 312, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 6098 0 0 0 52 0 51 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";

              break;
            case 6:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 3, 6, $gender, $level, 0, $Po, 16911620, 33554435, 0, 2355.84, -5662.21, 426.028, 609, 0, 0, 3.93485, '4294967295 4093640703 830406655 8 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 0, 0, 0, 0, 1335045690, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4298, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2499, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 905, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";

              break;
            case 7:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 3, 7, $gender, $level, 0, $Po, 117966344, 33554441, 0, -6230.42, 330.232, 383.105, 0, 0, 0, 6.17716, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335045700, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 60, 135, 0, 0, 100, 0, 0, 0, 0, 0, 0, 905, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52538 0 0 0 52539 0 52540 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 36 0 2362 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";

              break;
            case 8:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 3, 8, $gender, $level, 0, $Po, 118227202, 33554435, 0, -6230.42, 330.232, 383.105, 0, 0, 0, 6.17716, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335045708, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 52, 165, 0, 0, 100, 0, 0, 0, 0, 0, 0, 905, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 56 0 0 0 1395 0 55 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 8 ', 0, NULL, NULL, NULL, -1, 0);";
              break;
            case 9:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 3, 9, $gender, $level, 0, $Po, 118227202, 33554435, 0, -6230.42, 330.232, 383.105, 0, 0, 0, 6.17716, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335045724, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 71, 110, 0, 0, 100, 0, 0, 0, 0, 0, 0, 94, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 57 0 0 0 1396 0 59 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 43 ', 0, NULL, NULL, NULL, 100, 3452816845);";
                default:
               exit ();
           }     
       break;
     case 4:// Elfe de la nuit
            switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
            case 1:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 4, 1, $gender, $level, 0, $Po, 33948678, 33554434, 0, 10311.3, 831.463, 1326.41, 1, 0, 0, 5.69632, '100663296 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335046531, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 141, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 54, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 359, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58244 0 0 0 6121 0 6122 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 49778 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";

              break;
            case 3:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 4, 3, $gender, $level, 0, $Po, 33948678, 33554434, 0, 10311.3, 831.463, 1326.41, 1, 0, 0, 5.69632, '100663296 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335046540, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 141, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 66, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 359, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58232 0 0 0 147 0 129 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 3661 0 0 0 2504 0 0 0 ', 0, '0 0 0 0 0 0 0 400 163 65537 0 95 ', 0, NULL, NULL, NULL, 0, 1);";

              break;
            case 4:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 4, 4, $gender, $level, 0, $Po, 33948678, 33554434, 0, 10311.3, 831.463, 1326.41, 1, 0, 0, 5.69632, '100663296 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335046553, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 141, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 45, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 359, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58234 0 0 0 48 0 47 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 25 0 50055 0 28979 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";

              break;
            case 5:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 4, 5, $gender, $level, 0, $Po, 198661, 33554433, 0, 10311.3, 831.463, 1326.41, 1, 0, 0, 5.69632, '100663296 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335046563, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 141, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 71, 123, 0, 0, 100, 0, 0, 0, 0, 0, 0, 156, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 6119 0 0 0 52 0 51 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 3661 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";

              break;
            case 6:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 4, 6, $gender, $level, 0, $Po, 117443841, 33554435, 0, 2355.84, -5662.21, 426.028, 609, 0, 0, 3.93485, '4294967295 4093640703 830406655 8 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 0, 0, 0, 0, 1335046573, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4298, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2485, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 156, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";

              break;
            case 8:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 4, 8, $gender, $level, 0, $Po, 33948678, 33554434, 0, 10311.3, 831.463, 1326.41, 1, 0, 0, 5.69632, '100663296 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335046621, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 141, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 52, 165, 0, 0, 100, 0, 0, 0, 0, 0, 0, 359, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52553 0 0 0 1395 0 52554 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 8 ', 0, NULL, NULL, NULL, -1, 0);";

              break;
            case 11:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 4, 11, $gender, $level, 0, $Po, 84083716, 33554435, 0, 10311.3, 831.463, 1326.41, 1, 0, 0, 5.69632, '100663296 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335046632, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 141, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 63, 110, 0, 0, 100, 0, 0, 0, 0, 0, 0, 359, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 6123 0 0 0 6124 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 3661 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";
              break;
            default:
               exit ();
           }      
          break;
        case 5:// UNDEAD
          switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
            case 1:
                
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                            VALUES ($compte, '$name', 5, 1, $gender, $level, 0, $Po, 17172741, 33554432, 0, 1699.85, 1706.56, 135.928, 0, 0, 0, 2.70526, '1024 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089015, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 85, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 82, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58231 0 0 0 39 0 40 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 49778 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
           break;
          case 3:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 5, 3, $gender, $level, 0, $Po, 134479873, 33554444, 0, 1699.85, 1706.56, 135.928, 0, 0, 0, 2.70526, '1024 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089027, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 85, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 66, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58232 0 0 0 147 0 129 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 52532 0 0 0 23347 0 0 0 ', 0, '0 0 0 0 0 0 0 400 163 65537 0 95 ', 0, NULL, NULL, NULL, 0, 1);";
            break;
          case 4:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 5, 4, $gender, $level, 0, $Po, 17104898, 33554437, 0, 1699.85, 1706.56, 135.928, 0, 0, 0, 2.70526, '1024 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089036, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 85, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 73, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58234 0 0 0 48 0 47 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 2092 0 50055 0 28979 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
           case 5:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 5, 5, $gender, $level, 0, $Po, 34145024, 33554432, 0, 1699.85, 1706.56, 135.928, 0, 0, 0, 2.70526, '1024 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089044, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 85, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 86, 93, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 6144 0 0 0 52 0 51 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
           case 6:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 5, 6, $gender, $level, 0, $Po, 67439105, 33554439, 0, 2355.84, -5662.21, 426.028, 609, 0, 0, 3.93485, '4294967295 4093640703 830406655 4 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 0, 0, 0, 0, 1335089052, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4298, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2485, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
           case 8:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 5, 8, $gender, $level, 0, $Po, 100927746, 33554440, 0, 1699.85, 1706.56, 135.928, 0, 0, 0, 2.70526, '1024 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089064, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 85, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 66, 135, 0, 0, 100, 0, 0, 0, 0, 0, 0, 102, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 6140 0 0 0 1395 0 55 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 8 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
           case 9:
                $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 5, 9, $gender, $level, 0, $Po, 118030850, 33554438, 0, 1699.85, 1706.56, 135.928, 0, 0, 0, 2.70526, '1024 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089074, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 85, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 71, 110, 0, 0, 100, 0, 0, 0, 0, 0, 0, 102, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 6129 0 0 0 1396 0 59 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 43 ', 0, NULL, NULL, NULL, 100, 3452816845);";
              break;
            default:
               exit ();
           } 
          break;  
        case 6://TAUREN
          switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
               case 1:
                    $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 6, 1, $gender, $level, 0, $Po, 33686017, 33554434, 0, -2915.55, -257.347, 59.2693, 1, 0, 0, 0, '2097152 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089303, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 215, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 96, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 1370, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58245 0 0 0 139 0 140 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 12282 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
                 break;
               case 2:
                    $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 6, 2, $gender, $level, 0, $Po, 33555213, 33554434, 0, -2915.55, -257.347, 59.2693, 1, 0, 0, 0, '2097152 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089311, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 215, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 62, 140, 0, 0, 100, 0, 0, 0, 0, 0, 0, 1370, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58248 0 0 0 52549 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 2361 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
                 break;
               case 3:
                    $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 6, 3, $gender, $level, 0, $Po, 34013199, 33554436, 0, -2915.55, -257.347, 59.2693, 1, 0, 0, 0, '2097152 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089318, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 215, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 108, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 1370, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58247 0 0 0 6137 0 6138 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 57243 0 0 0 2504 0 0 0 ', 0, '0 0 0 0 0 0 0 400 163 65537 0 95 ', 0, NULL, NULL, NULL, 0, 1);";
                 break;
               case 5:
                    $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 6, 5, $gender, $level, 0, $Po, 33686017, 33554434, 0, -2915.55, -257.347, 59.2693, 1, 0, 0, 0, '2097152 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089325, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 215, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 71, 183, 0, 0, 100, 0, 0, 0, 0, 0, 0, 84, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52547 0 0 0 52680 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";
                 break;
               case 6:
                    $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 6, 6, $gender, $level, 0, $Po, 33687041, 33554434, 0, 2355.84, -5662.21, 426.028, 609, 0, 0, 3.93485, '4294967295 4093640703 830406655 4 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 0, 0, 0, 0, 1335089336, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4298, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2499, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 84, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
                 break;
               case 7:
                    $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 6, 7, $gender, $level, 0, $Po, 65538, 33554436, 0, -618.518, -4251.67, 38.718, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089346, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 102, 103, 0, 0, 100, 0, 0, 0, 0, 0, 0, 84, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52544 0 0 0 52545 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 36 0 2362 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
                 break;
               case 11:
                    $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                        VALUES ($compte, '$name', 6, 11, $gender, $level, 0, $Po, 33817605, 33554432, 0, -2915.55, -257.347, 59.2693, 1, 0, 0, 0, '2097152 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335089357, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 215, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 92, 77, 0, 0, 100, 0, 0, 0, 0, 0, 0, 88, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 6139 0 0 0 6124 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";
                  break;
                default:
                   exit ();
           } 
          break;  
        case 7://GNOME
          switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
            case 1:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                            VALUES ($compte, '$name', 7, 1, $gender, $level, 0, $Po, 84149761, 33554439, 0, -4983.42, 877.7, 274.31, 0, 0, 0, 0, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090053, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 54, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 101, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58231 0 0 0 39 0 40 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 49778 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 4:
                   $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 7, 4, $gender, $level, 0, $Po, 33947905, 33554432, 0, -4983.42, 877.7, 274.31, 0, 0, 0, 0, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090064, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 45, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 101, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58234 0 0 0 48 0 47 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 25 0 50055 0 28979 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 5:
                   $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 7, 5, $gender, $level, 0, $Po, 117703680, 33554437, 0, -4983.42, 877.7, 274.31, 0, 0, 0, 0, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090074, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 72, 123, 0, 0, 100, 0, 0, 0, 0, 0, 0, 103, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 6098 0 0 0 52 0 51 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 6:
                   $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 7, 6, $gender, $level, 0, $Po, 33622528, 33554438, 0, 2355.84, -5662.21, 426.028, 609, 0, 0, 3.93485, '4294967295 4093640703 830406655 8 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 0, 0, 0, 0, 1335090082, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4298, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2485, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 103, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 8:
                   $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 7, 8, $gender, $level, 0, $Po, 33620736, 33554438, 0, -4983.42, 877.7, 274.31, 0, 0, 0, 0, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090089, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 51, 225, 0, 0, 100, 0, 0, 0, 0, 0, 0, 103, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 56 0 0 0 1395 0 55 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 8 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 9:
                   $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`)
                        VALUES ($compte, '$name', 7, 9, $gender, $level, 0, $Po, 33948930, 33554438, 0, -4983.42, 877.7, 274.31, 0, 0, 0, 0, '32 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 1, 124, 124, 1335276122, 0, 0.2613, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 43, 209, 0, 0, 100, 0, 0, 0, 0, 0, 0, 110, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 536870912 0 0 0 0 0 0 0 0 65536 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 57 0 0 0 1396 0 59 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 43 327685 0 95 ', 0, NULL, NULL, NULL, 100, 3452816845);";
                  break;
                default:
                   exit ();
           }
          break;  
        case 8://TROLL
          switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
            case 1:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                            VALUES ($compte, '$name', 8, 1, $gender, $level, 0, $Po, 66564, 33554434, 0, -1171.45, -5263.65, 0.847728, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090276, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 82, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 1271, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58245 0 0 0 139 0 140 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 12282 0 0 0 25861 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 3:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 8, 3, $gender, $level, 0, $Po, 66564, 33554434, 0, -1171.45, -5263.65, 0.847728, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090288, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 94, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 542, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58247 0 0 0 6137 0 6138 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 57243 0 0 0 2504 0 0 0 ', 0, '0 0 0 0 0 0 0 400 163 65537 0 95 ', 0, NULL, NULL, NULL, 0, 1);";
             break;
               case 4:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 8, 4, $gender, $level, 0, $Po, 66564, 33554434, 0, -1171.45, -5263.65, 0.847728, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090297, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 73, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 542, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58246 0 0 0 120 0 121 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 2092 0 50055 0 25861 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 5:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 8, 5, $gender, $level, 0, $Po, 33686528, 33554439, 0, -1171.45, -5263.65, 0.847728, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090314, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 86, 91, 0, 0, 100, 0, 0, 0, 0, 0, 0, 115, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52547 0 0 0 52680 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 6:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 8, 6, $gender, $level, 0, $Po, 33687808, 33554439, 0, 2355.84, -5662.21, 426.028, 609, 0, 0, 3.93485, '4294967295 4093640703 830406655 4 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 0, 0, 0, 0, 1335090321, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4298, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2485, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 115, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 7:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 8, 7, $gender, $level, 0, $Po, 33686528, 33554439, 0, -1171.45, -5263.65, 0.847728, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090330, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 88, 102, 0, 0, 100, 0, 0, 0, 0, 0, 0, 115, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52544 0 0 0 52545 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 36 0 2362 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 8:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 8, 8, $gender, $level, 0, $Po, 66564, 33554434, 0, -1171.45, -5263.65, 0.847728, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090351, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 66, 119, 0, 0, 100, 0, 0, 0, 0, 0, 0, 136, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52546 0 0 0 52681 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 8 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 9:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 8, 9, $gender, $level, 0, $Po, 33686528, 33554439, 0, -1171.45, -5263.65, 0.847728, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090358, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 71, 110, 0, 0, 100, 0, 0, 0, 0, 0, 0, 136, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52543 0 0 0 52679 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 43 ', 0, NULL, NULL, NULL, 100, 3452816845);";
             break;
               case 11:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 8, 11, $gender, $level, 0, $Po, 66564, 33554434, 0, -1171.45, -5263.65, 0.847728, 1, 0, 0, 0, '4194304 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090368, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 14, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 92, 77, 0, 0, 100, 0, 0, 0, 0, 0, 0, 136, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 6139 0 0 0 6124 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";
             break;   
             default:
                   exit ();
           }

          break;   
        case 9://GOBLIN
          switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
            case 1:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                            VALUES ($compte, '$name', 9, 1, $gender, $level, 0, $Po, 117507075, 33554434, 0,  -618.518, -4251.67, 38.718, 1, 0, 0, 1.56294, '0 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090575, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4737, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 68, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 356, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 49524 0 0 0 49528 0 49527 0 0 0 49529 0 0 0 0 0 0 0 0 0 0 0 2361 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 3:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 9, 3, $gender, $level, 0, $Po, 83886081, 33554440, 0,  -618.518, -4251.67, 38.718, 1, 0, 0, 1.56294, '0 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090583, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4737, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 94, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 356, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 49502 0 0 0 49503 0 49504 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 52532 0 0 0 2508 0 0 0 ', 0, '0 0 0 0 0 0 0 400 163 65537 0 95 ', 0, NULL, NULL, NULL, 0, 1);";
             break;
               case 4:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 9, 4, $gender, $level, 0, $Po, 83886081, 33554440, 0,  -618.518, -4251.67, 38.718, 1, 0, 0, 1.56294, '0 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090592, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4737, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 59, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 144, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 49514 0 0 0 49515 0 49516 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 36 0 50055 0 28979 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 5:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 9, 5, $gender, $level, 0, $Po, 16843779, 33554434, 0,  -618.518, -4251.67, 38.718, 1, 0, 0, 1.56294, '0 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090606, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4737, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 72, 123, 0, 0, 100, 0, 0, 0, 0, 0, 0, 144, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 49510 0 0 0 49512 0 49531 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 6:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 9, 6, $gender, $level, 0, $Po, 167841283, 33554434, 0, 2355.84, -5662.21, 426.028, 609, 0, 0, 3.93485, '4294967295 4093640703 830406655 4 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 0, 0, 0, 0, 1335090616, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4298, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2485, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 77, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 7:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 9, 7, $gender, $level, 0, $Po, 83886081, 33554440, 0,  -618.518, -4251.67, 38.718, 1, 0, 0, 1.56294, '0 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090648, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4737, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 102, 103, 0, 0, 100, 0, 0, 0, 0, 0, 0, 104, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52550 0 0 0 52551 0 52552 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 36 0 2362 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 8:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 9, 8, $gender, $level, 0, $Po, 524293, 33554437, 0,  -618.518, -4251.67, 38.718, 1, 0, 0, 1.56294, '0 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090653, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4737, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 52, 165, 0, 0, 100, 0, 0, 0, 0, 0, 0, 104, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 49505 0 0 0 49506 0 49508 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 8 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 9:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 9, 9, $gender, $level, 0, $Po, 117507075, 33554434, 0,  -618.518, -4251.67, 38.718, 1, 0, 0, 1.56294, '0 0 0 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335090662, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4737, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 57, 140, 0, 0, 100, 0, 0, 0, 0, 0, 0, 104, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 49520 0 0 0 49521 0 49522 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 43 ', 0, NULL, NULL, NULL, 100, 3452816845);";
             break;   
             default:
                   exit ();
           }
           break;  
        case 10://ELFE DE SANG
          switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
            case 1:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                            VALUES ($compte, '$name', 10, 1, $gender, $level, 0, $Po, 84609032, 33554439, 0, 10349.6, -6357.29, 33.4026, 530, 0, 0, 5.31605, '0 0 131072 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335091250, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3430, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 68, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 20904 0 0 0 20902 0 20903 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 23346 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 2:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 10, 2, $gender, $level, 0, $Po, 100860937, 33554432, 0, 10349.6, -6357.29, 33.4026, 530, 0, 0, 5.31605, '0 0 131072 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335091262, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3430, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 62, 140, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58237 0 0 0 24145 0 24146 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 23346 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 3:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 10, 3, $gender, $level, 0, $Po, 134874883, 33554439, 0, 10349.6, -6357.29, 33.4026, 530, 0, 0, 5.31605, '0 0 131072 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335091273, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3430, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 66, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58235 0 0 0 20899 0 20900 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 57244 0 0 0 20980 0 0 0 ', 0, '0 0 0 0 0 0 0 400 163 65537 0 95 ', 0, NULL, NULL, NULL, 0, 1);";
             break;
               case 4:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 10, 4, $gender, $level, 0, $Po, 197891, 33554438, 0, 10349.6, -6357.29, 33.4026, 530, 0, 0, 5.31605, '0 0 131072 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335091284, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3430, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 45, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 68, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58238 0 0 0 20896 0 20898 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 20977 0 50057 0 28979 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 5:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 1, 5, $gender, $level, 0, $Po, 68224777, 33554435, 0, -8914.57, -133.909, 80.5378, 0, 0, 0, 0, '2 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335091292, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 12, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 72, 123, 0, 0, 100, 0, 0, 0, 0, 0, 0, 68, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 6098 0 0 0 52 0 51 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 6:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 10, 6, $gender, $level, 0, $Po, 151130375, 33554440, 0, 2355.84, -5662.21, 426.028, 609, 0, 0, 3.93485, '4294967295 4093640703 830406655 4 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 0, 0, 0, 0, 1335091300, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4298, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2485, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 68, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 8:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 10, 8, $gender, $level, 0, $Po, 134481926, 33554436, 0, 10349.6, -6357.29, 33.4026, 530, 0, 0, 5.31605, '0 0 131072 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335091311, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3430, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 51, 225, 0, 0, 100, 0, 0, 0, 0, 0, 0, 729, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 20893 0 0 0 20894 0 20895 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 20978 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 8 ', 0, NULL, NULL, NULL, -1, 0);";
             break;
               case 9:
              $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
                    VALUES ($compte, '$name', 10, 9, $gender, $level, 0, $Po, 117703170, 33554435, 0, 10349.6, -6357.29, 33.4026, 530, 0, 0, 5.31605, '0 0 131072 4 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335091323, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3430, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 43, 200, 0, 0, 100, 0, 0, 0, 0, 0, 0, 729, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 20892 0 0 0 1396 0 59 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 20978 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 43 ', 0, NULL, NULL, NULL, 100, 3452816845);";
             break;   
             default:
                   exit ();
           }
           break; 
        case 11: //DRANEI
         switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
            case 1:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 11, 1, $gender, $level, 0, $Po, 33883145, 33554438, 0, -3961.64, -13931.2, 100.615, 530, 0, 0, 2.08364, '0 0 536870912 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335277357, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3524, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 54, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 0, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58243 0 0 0 23474 0 23475 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 23346 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
                
             break;
             case 2:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 11, 2, $gender, $level, 0, $Po, 17172229, 33554434, 0, -3961.64, -13931.2, 100.615, 530, 0, 0, 2.08364, '0 0 536870912 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335277371, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3524, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 62, 95, 0, 0, 100, 0, 0, 0, 0, 0, 0, 94, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58242 0 0 0 23477 0 52533 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 2361 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
                
             break;
             case 3:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 11, 3, $gender, $level, 0, $Po, 33753344, 33554432, 0, -3961.64, -13931.2, 100.615, 530, 0, 0, 2.08364, '0 0 536870912 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335277380, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3524, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 66, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 94, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 58240 0 0 0 23344 0 23348 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 12282 0 0 0 23347 0 0 0 ', 0, '0 0 0 0 0 0 0 400 163 65537 0 95 ', 0, NULL, NULL, NULL, 0, 1);";
                
             break;
             case 5:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 11, 5, $gender, $level, 0, $Po, 100861189, 33554437, 0, -3961.64, -13931.2, 100.615, 530, 0, 0, 2.08364, '0 0 536870912 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335277390, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3524, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 71, 138, 0, 0, 100, 0, 0, 0, 0, 0, 0, 94, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 23322 0 0 0 1396 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 3661 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 54 ', 0, NULL, NULL, NULL, -1, 0);";
                
             break;
             case 6:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 11, 6, $gender, $level, 0, $Po, 101059072, 33554438, 0, 2355.84, -5662.21, 426.028, 609, 0, 0, 3.93485, '4294967295 4093640703 830406655 8 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 0, 0, 0, 0, 1335277397, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 4298, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2485, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 125, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
                
             break;
             case 7:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 11, 7, $gender, $level, 0, $Po, 100861185, 33554436, 0, -3961.64, -13931.2, 100.615, 530, 0, 0, 2.08364, '0 0 536870912 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335277404, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3524, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 60, 135, 0, 0, 100, 0, 0, 0, 0, 0, 0, 125, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 52534 0 0 0 52535 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 36 0 2362 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
                
             break;
             case 8:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 11, 8, $gender, $level, 0, $Po, 84410627, 33554436, 0, -3961.64, -13931.2, 100.615, 530, 0, 0, 2.08364, '0 0 536870912 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 0, 0, 0, 1335277413, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 3524, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 51, 180, 0, 0, 100, 0, 0, 0, 0, 0, 0, 125, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 23479 0 0 0 23478 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 3661 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 95 327681 0 8 ', 0, NULL, NULL, NULL, -1, 0);";
                
             break;
             
             default:
                   exit ();
           }
           
           break; 
        case 22: //WORGEN
         switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST &-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
            case 1:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 22, 1, $gender, $level, 0, $Po, 50924547, 33554442, 32, -8834.61, 623.521, 93.8793, 0, 0, 0, 4.06557, '0 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 1, 81, 81, 1335276224, 1, 0.304011, 0, 0, 0, 0, 0, 0, 0, 512, 0, 0, 1519, 0, '', 0, 0, 0, 0, 2877292544, 0, 0, 0, 0, 4294967295, 0, 68, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 78, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 536870912 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 49567 0 49578 0 49577 0 49576 0 49579 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 23346 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 26 65537 0 43 ', 0, NULL, NULL, NULL, -1, 0);";
        break;
            case 3:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 22, 3, $gender, $level, 0, $Po, 50857730, 33554439, 32, -8834.61, 623.521, 93.8793, 0, 0, 0, 4.11584, '0 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 1, 44, 44, 1335276281, 1, 0.293144, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1519, 0, '', 0, 0, 0, 0, 2877292544, 0, 0, 0, 0, 4294967295, 0, 94, 0, 0, 100, 100, 0, 0, 0, 0, 0, 0, 78, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 49567 0 49570 0 0 0 49568 0 49569 0 0 0 49571 0 0 0 0 0 0 0 0 0 0 0 52532 0 0 0 2508 0 0 0 ', 0, '0 0 0 0 0 0 0 400 43 327685 0 44 ', 0, NULL, NULL, NULL, 0, 1);";
        break;
            case 4:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 22, 4, $gender, $level, 0, $Po, 50924547, 33554442, 32, -8834.61, 623.521, 93.8793, 0, 0, 0, 4.06557, '0 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 1, 81, 81, 1335276224, 1, 0.304011, 0, 0, 0, 0, 0, 0, 0, 512, 0, 0, 1519, 0, '', 0, 0, 0, 0, 2877292544, 0, 0, 0, 0, 4294967295, 0, 68, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 78, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 536870912 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 49567 0 49578 0 49577 0 49576 0 49579 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 23346 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 26 65537 0 43 ', 0, NULL, NULL, NULL, -1, 0);";
        break;
            case 5:
             $sql= "
                 INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 22, 5, $gender, $level, 0, $Po, 33687296, 33554434, 32, -8834.61, 623.521, 93.8793, 0, 0, 0, 4.11584, '0 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 1, 52, 52, 1335276477, 1, 0.325033, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1519, 0, '', 0, 0, 0, 0, 2877292544, 0, 0, 0, 0, 4294967295, 0, 72, 123, 0, 0, 100, 0, 0, 0, 0, 0, 0, 63, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 49403 0 0 0 49404 0 49406 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 54 327685 0 56 ', 0, NULL, NULL, NULL, -1, 0);";
        break;
            case 6:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 22, 6, $gender, $level, 0, $Po, 17107204, 33554437, 0, -8834.61, 623.521, 93.8793, 0, 0, 0, 4.11584, '4294967295 4093640703 830406655 8 33570816 1310944 3225427988 65560 896 67111952 3980787712 4227858314 806487422 13307904 2944 0 495730433 30930880 4294965216 127938559 3221208880 1807 ', 1, 0, 0, 0, 1335274717, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32, 1519, 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 4294967295, 0, 2485, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0, 156, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '34652 0 34657 0 34655 0 0 0 34650 0 34651 0 34656 0 34648 0 34653 0 34649 0 34658 0 38147 0 0 0 0 0 34659 0 0 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 148200 95 18022401 0 44 ', 0, NULL, NULL, NULL, -1, 0);";
        break;
            case 8:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 22, 8, $gender, $level, 0, $Po, 329216, 33554439, 32, -8834.61, 623.521, 93.8793, 0, 0, 0, 4.11584, '0 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 1, 14, 14, 1335276506, 1, 0.3038, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1519, 0, '', 0, 0, 0, 0, 2877292544, 0, 0, 0, 0, 4294967295, 0, 52, 165, 0, 0, 100, 0, 0, 0, 0, 0, 0, 1264, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 49399 0 0 0 49400 0 49401 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 6 65537 0 8 ', 0, NULL, NULL, NULL, -1, 0);";
        break;
            case 9:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 22, 9, $gender, $level, 0, $Po, 328711, 33554434, 32, -8834.61, 623.521, 93.8793, 0, 0, 0, 4.11584, '0 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 1, 49, 49, 1335276568, 1, 0.327911, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1519, 0, '', 0, 0, 0, 0, 2877292544, 0, 0, 0, 0, 4294967295, 0, 57, 140, 0, 0, 100, 0, 0, 0, 0, 0, 0, 62, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 49408 0 0 0 49409 0 49407 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 43 327685 0 95 ', 0, NULL, NULL, NULL, 100, 3452816845);";
        break;
            case 11:
             $sql= "INSERT INTO `characters` (`account`, `name`, `race`, `class`, `gender`, `level`, `xp`, `money`, `playerBytes`, `playerBytes2`, `playerFlags`, `position_x`, `position_y`, `position_z`, `map`, `instance_id`, `instance_mode_mask`, `orientation`, `taximask`, `online`, `cinematic`, `totaltime`, `leveltime`, `logout_time`, `is_logout_resting`, `rest_bonus`, `resettalents_cost`, `resettalents_time`, `trans_x`, `trans_y`, `trans_z`, `trans_o`, `transguid`, `extra_flags`, `stable_slots`, `at_login`, `zone`, `death_expire_time`, `taxi_path`, `arenaPoints`, `totalHonorPoints`, `todayHonorPoints`, `yesterdayHonorPoints`, `totalKills`, `todayKills`, `yesterdayKills`, `chosenTitle`, `knownCurrencies`, `watchedFaction`, `drunk`, `health`, `power1`, `power2`, `power3`, `power4`, `power5`, `power6`, `power7`, `power8`, `power9`, `power10`, `latency`, `speccount`, `activespec`, `exploredZones`, `equipmentCache`, `ammoId`, `knownTitles`, `actionBars`, `deleteInfos_Account`, `deleteInfos_Name`, `deleteDate`, `currentPetSlot`, `petSlotUsed`) 
         VALUES ($compte, '$name', 22, 11, $gender, $level, 0, $Po, 67372034, 33554439, 32, -8834.61, 623.521, 93.8793, 0, 0, 0, 4.11584, '0 0 0 8 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', 0, 1, 18, 18, 1335276599, 1, 0.316028, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1519, 0, '', 0, 0, 0, 0, 2877292544, 0, 0, 0, 0, 4294967295, 0, 92, 77, 0, 0, 100, 0, 0, 0, 0, 0, 0, 78, 1, 0, '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0 0 0 0 0 0 0 0 49563 0 0 0 49566 0 49564 0 0 0 49565 0 0 0 0 0 0 0 0 0 0 0 35 0 0 0 0 0 0 0 ', 0, '0 0 0 0 0 0 0 400 54 327685 0 95 ', 0, NULL, NULL, NULL, -1, 0);";
        break;

         default:
               exit ();
           }
         break;    
   default:
        exit ();
       
      
    }
//CREATION DU PERSONNAGE
    $req = $CHARS->prepare($sql);
    $req->execute(); //INSERTION CHARACTERE

    $guid= $CHARS->lastInsertId(); //RECUPERATION GUID

    $sql01 = "UPDATE `characters` SET `totaltime`='0'  WHERE (`guid`='$guid')"; //RESET LE TEMPS DE JEU
    $req01 = $CHARS->prepare($sql01);
    $req01->execute();


//CREATION DU STUFF
    $stuff= choixStuff($stuffLevel,$classe,$specialisation); //RECUPERE LE STUFF EN FONCTION DES DONNEES

    $i=23; //EMPLACEMENT 0 SAC
    
     $sql1="INSERT INTO `item_instance` ( `itemEntry`, `owner_guid`, `creatorGuid`, `giftCreatorGuid`, `count`, `duration`, `charges`, `flags`, `enchantments`, `randomPropertyId`, `durability`, `playedTime`, `text`) 
            VALUES ( '$item', '$guid', '0', '0', '1', '0', '0 0 0 0 0 ', '1', '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0', '165', '7200', NULL);";
    $req1 = $CHARS->prepare($sql1);
    $req1->execute(); //INSERTION ITEM DANS INSTANCE
    
    $interval= 30000;
    $guidStart = $CHARS->lastInsertId() + $interval;
    $sql11="DELETE FROM item_instance WHERE owner_guid=:guid";
    $req11 = $CHARS->prepare($sql11);
    $req11->execute(array('guid' => $guid));
    
    
    foreach ($stuff as $item) {
    $sql1="INSERT INTO `item_instance` (`guid`, `itemEntry`, `owner_guid`, `creatorGuid`, `giftCreatorGuid`, `count`, `duration`, `charges`, `flags`, `enchantments`, `randomPropertyId`, `durability`, `playedTime`, `text`) 
            VALUES ('$guidStart', '$item', '$guid', '0', '0', '1', '0', '0 0 0 0 0 ', '1', '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0', '165', '7200', NULL);";
    
    $req1 = $CHARS->prepare($sql1);
    $req1->execute(); //INSERTION ITEM DANS INSTANCE
    $guidStart++;

    $guidItem= $CHARS->lastInsertId(); //RECUPERATION GUID ITEM
    $sql2="INSERT INTO `character_inventory` (`guid`, `bag`, `slot`, `item`) VALUES ($guid, '0', $i, $guidItem);";
    $req2 = $CHARS->prepare($sql2);
    $req2->execute(); //INSERTION ITEM DANS SAC
    $i++;
   
    }
    //Verification d'items
    
   
    
//INSERTION 1ER METIER
    foreach (getSpellsJobs($metier1) as $spell) {
    $sql3="INSERT INTO `character_spell` (`guid`, `spell`) VALUES ($guid, $spell);";
    $req3 = $CHARS->prepare($sql3);
    $req3->execute(); //INSERTION METIER1
    }
    $skill=getSkillJobs($metier1);
    $sql4="INSERT INTO `character_skills` (`guid`, `skill`, `value`, `max`) VALUES ($guid, $skill, $skill1, '525');";
    $req4 = $CHARS->prepare($sql4);
    $req4->execute(); //INSERTION SKILL1

    
//INSERTION 2EME METIER
    foreach (getSpellsJobs($metier2) as $spell) {
    $sql5="INSERT INTO `character_spell` (`guid`, `spell`) VALUES ($guid, $spell);";
    $req5 = $CHARS->prepare($sql5);
    $req5->execute(); //INSERTION METIER2
    }

    $skill=getSkillJobs($metier2);
    $sql6="INSERT INTO `character_skills` (`guid`, `skill`, `value`, `max`) VALUES ($guid, $skill, $skill2, '525');";
    $req6 = $CHARS->prepare($sql6);
    $req6->execute(); //INSERTION SKILL2

    
    return true;
}
function verifItemAdd($item, $guid, $CHARS){
    

    $sql1a="SELECT * FROM `item_instance` WHERE `owner_guid` = '$guid' AND `itemEntry` = '$item'"; //CONTROLE DE POSTE EFFECTUE
    $req1a = $CHARS->prepare($sql1a);
    $req1a->execute();
    $valid = $req1a->rowcount();
    
        if($valid==0){ //VERIFIE L'INJECTION OK OU PAS
            

        $sql1="INSERT INTO `item_instance` ( `itemEntry`, `owner_guid`, `creatorGuid`, `giftCreatorGuid`, `count`, `duration`, `charges`, `flags`, `enchantments`, `randomPropertyId`, `durability`, `playedTime`, `text`) 
                VALUES ( '$item', '$guid', '0', '0', '1', '0', '0 0 0 0 0 ', '1', '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 ', '0', '105', '7200', NULL);";

        $req1 = $CHARS->prepare($sql1);
        $req1->execute(); //INSERTION ITEM DANS INSTANCE
        }else{
            
        }
    }

function choixStuff($levelStuff,$classe,$specialisation){
      
    
switch ($levelStuff){
  case 226: //STUFF LEVEL 80
    switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST 6-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
        case 1: //WAR
            switch ($specialisation){//$spe1='Armes';            $spe2='Fureur';            $spe3='Protection';
             case 1:
             case 2:
                return array(46149,46150,46151,46148,46146,46016,46016,46339,45330,45283,49808,45318,45285,45675,46010,45286,40431); //Guerrier DPS
             break;
             case 3:
                return array(46167,46169,46166,46164,46162,45700,45707,46339,49795,39764,45304,45322,45696,45874,47243,45313,46021); //Guerrier TANK
             break;
             default: exit (); }
        break;
        case 2://PALADIN
            switch ($specialisation){//$spe1='Sacré';            $spe2='Protection';            $spe3='Vindict';
             case 1:
                 return array(46182,46181,46180,46179,46178,45972,45682,39728,45698,45680,45975,45317,46015,45418,49800,45292,45308);//PALA HEAL
             break;
             case 2:
               return array(46177,46176,46175,46174,46173,45700,45707,40337,49795,39764,45304,45322,45696,45874,47243,45313,46021); //PALA TANK
             break;
             case 3:
               return array(46152,46153,46156,46155,46154,46016,40207,45330,45283,49808,45318,45285,45675,46010,45286,40431);//PALA DPS
             break;
             default: exit (); }
        break;
        case 3://CHASSEUR
            switch ($specialisation){//$spe1='Maîtrise des bêtes';            $spe2='Précision';            $spe3='Survie';
             case 1:
             case 2:
             case 3:
               return array(46145,46144,46143,46142,46141,45996,46342,46346,45301,45895,45704,46008,45303,49803,45286,40431);//CHASSEUR DPS
             break;
             default: exit (); }
        break;
        case 4://VOLEUR
            switch ($specialisation){// $spe1='Assassinat';            $spe2='Combat';            $spe3='Finesse';
             case 1:
             case 2:
             case 3:
               return array(46127,46126,46125,46124,46123,46024,46011,40190,45302,47496,45709,45704,46008,45303,49803,45286,40431);//VOLEUR DPS
             break;
             default: exit (); }
            break;
        case 5://PRIEST
            switch ($specialisation){//$spe1='Discipline';          $spe2='Sacré';            $spe3='Magie de l\'ombre';
             case 1:
             case 2:
                return array(46190,46195,46197,46188,46193,46025,45713,46030,45423,45306,45317,46015,45418,49800,45292,45308); //PRETRE HEAL
             break;
             case 3:
                return array(46165,46170,46172,46163,46168,46025,45713,47560,45291,45306,45317,45699,45702,47512,45308,40255); //PRETRE DPS
             break;
             default: exit (); }
            break;
        case 6://DK
            switch ($specialisation){//$spe1='Sang';            $spe2='Givre';            $spe3='Impie';
             case 2:
             case 3:
               return array(46117,46116,46115,46113,46111,46016,40207,45330,45283,49808,45318,45285,45675,46010,45286,40431);//DK DPS
             break;
             case 1:
               return array(46122,46121,46120,46119,46118,46016,40337,45698,39764,45304,45322,45696,45874,47243,45313,46021);//DK TANK
             break;
             default: exit (); }
            break;
        case 7://CHAMAN
            switch ($specialisation){//$spe1='Élémentaire';            $spe2='Amélioration';            $spe3='Restauration';
             case 1:
                 return array(46211,46210,46209,46207,46206,45972,45682,39728,45701,45316,45333,45317,45699,45702,47512,45308,45703);//CHAMAN DPS CASTER
             break;
             case 2:
               return array(46203,46208,46212,46200,46205,46031,46031,39757,46346,45301,45895,45704,46008,45303,49803,45286,40431); //CHAMAN DPS CAC
             break;
             case 3:
               return array(46211,46210,46209,46207,46206,45972,45682,39728,45701,45316,45333,45317,45699,45702,47512,45308,45703);//CHAMAN HEAL
             break;
             default: exit (); }
            break;
        case 8://MAGO
            switch ($specialisation){//$spe1='Arcane';            $spe2='Feu';            $spe3='Givre';
             case 1:
             case 2:
             case 3:
               return array(46134,46133,46129,46132,46130,46025,45713,47560,45291,45306,45317,45699,45702,47512,45308,45866);//MAGO DPS
             break;
             default: exit (); }
            break;
        case 9://DEMONISTE
            switch ($specialisation){// $spe1='Affliction';            $spe2='Démonologie';            $spe3='Destruction';
             case 1:
             case 2:
             case 3:
               return array(46136,46139,46140,46135,46137,46025,45713,47560,45291,45306,45317,45699,45702,47512,45308,45866);//DEMONISTE DPS
             break;
             default: exit (); }
            break;
        case 11:
            switch ($specialisation){//$spe1='Équilibre';            $spe2='Farouche';            $spe3='Restauration';
             case 1:
                 return array(46196,46192,46191,46189,46194,46025,39728,45378,46009,40200,45317,45699,45702,47512,45308,40255);//DRUIDE DPS CASTER
             break;
             case 2:
               return array(46157,46160,46161,46158,46159,45996,39757,45302,47496,45709,45704,46008,45303,49803,45286,40431); //DRUIDE DPS CAC
             break;
             case 3:
               return array(46187,46185,46184,46183,46186,46025,39728,45378,46009,40200,45317,46015,45418,49800,45292,45308);//DRUIDE HEAL
             break;
             default: exit (); }
            break;
        default: exit ();
    
    }break;

  case 333: //STUFF LEVEL 85 GRATUIT
    switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST 6-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
        case 1: //WAR
            switch ($specialisation){//$spe1='Armes';            $spe2='Fureur';            $spe3='Protection';
             case 1:
             case 2:
                return array(66891,66911,66983,66989,66992,63787,63787,59599,55856,57855,56118,55872,55999,55996,62375,66994,55868); //Guerrier DPS
             break;
             case 3:
                return array(56124,67043,57861,67057,66933,56101,67061,67045,66909,55992,67067,56519,55888,55873,56111,56121,55881); //Guerrier TANK
             break;
             default: exit (); }
             

        break;
        case 2://PALADIN
            switch ($specialisation){//$spe1='Sacré';            $spe2='Protection';            $spe3='Vindict';
             case 1:
                 return array(66907,56104,67122,65740,57856,56108,67124,66912,55862,56135,55803,56126,56110,66942,63761,56138,55995); //Paladin HEAL
             break;
             case 2:
               return array(56124,67043,57861,67057,66933,56101,67061,67059,66909,55992,67067,56519,55888,55873,56111,56121,55881); //Paladin TANK
             break;
             case 3:
               return array(66891,66911,66983,66989,66992,63787,66988,55856,57855,56118,55872,55999,55996,62375,66994,55868); //Paladin DPS
             break;
             default: exit (); }
        break;
    


        case 3://CHASSEUR
            switch ($specialisation){//$spe1='Maîtrise des bêtes';            $spe2='Précision';            $spe3='Survie';
             case 1:
             case 2:
             case 3:
               return array(66976,66971,56112,66915,65862,55860,66973,57857,66935,66966,56518,56095,56120,55994,56115,55874); //Chasseur
             break;
             default: exit (); }
             
        break;
        case 4://VOLEUR
            switch ($specialisation){// $spe1='Assassinat';            $spe2='Combat';            $spe3='Finesse';
             case 1:
             case 2:
             case 3:
               return array(66905,61396,66975,67234,56128,63792,55870,56001,55871,55886,56098,56518,56095,56120,55994,56115,55874); //Voleur
             break;
             default: exit (); }
            break;
        case 5://PRIEST
            switch ($specialisation){//$spe1='Discipline';          $spe2='Sacré';            $spe3='Magie de l\'ombre';
             case 1:
             case 2:
                return array(55876,55993,56133,67126,55998,56137,67125,67237,56125,55878,56126,55864,63761,55859,56138,55995); //Pretre HEAL
             break;
             case 3:
                return array(55876,55993,56133,67126,55998,56137,67125,66937,66917,55878,56126,56110,66942,55859,56138,55889); //Pretre DPS
             break;
             default: exit (); }
            break;
        case 6://DK
            switch ($specialisation){//$spe1='Sang';            $spe2='Givre';            $spe3='Impie';
             case 2:
             case 3:
               return array(66891,66911,66983,66989,66992,63787,66988,55856,57855,56118,55872,55999,55863,62375,66994,55868); //DK DPS
             break;
             case 1:
               return array(56124,67043,57861,67057,66933,63787,67059,66909,55992,67067,56519,55888,55873,56111,56121,55881); //DK TANK
             break;
             default: exit (); }
            break;
        case 7://CHAMAN
            switch ($specialisation){//$spe1='Élémentaire';            $spe2='Amélioration';            $spe3='Restauration';
             case 1:
               return array(66938,57862,67123,55857,55205,63790,67124,55852,56119,66906,55887,56126,56110,66942,63761,56138,55889); //Chaman DPS DISTANT
             break;
             case 2:
               return  array(66976,66971,56112,66915,65862,63788,63788,62242,56123,66935,62439,56518,66974,56120,55994,56115,55874); //Chaman DPS CAC
             break;
             case 3:
               return  array(66938,57862,67123,55857,55205,63790,67124,55852,56119,66906,55887,56126,55864,66942,63761,56138,55995); //Chaman HEAL
             break;
             default: exit (); }
            break;
        case 8://MAGO
            switch ($specialisation){//$spe1='Arcane';            $spe2='Feu';            $spe3='Givre';
             case 1:
             case 2:
             case 3:
               return array(55876,55993,56133,67126,55998,56137,56122,66937,55866,66941,56126,56110,66942,63761,56138,55889); //Mage
             break;
             default: exit (); }
            break;
        case 9://DEMONISTE
            switch ($specialisation){// $spe1='Affliction';            $spe2='Démonologie';            $spe3='Destruction';
             case 1:
             case 2:
             case 3:
               return array(55876,55993,56133,67126,55998,56137,67125,66937,55866,66941,56126,56110,66942,63761,56138,55889); //DEMONISTE DPS
             break;
             default: exit (); }
            break;
        case 11:
            switch ($specialisation){//$spe1='Équilibre';            $spe2='Farouche';            $spe3='Restauration';
             case 1:
               return array(57858,55877,66921,66934,56113,56137,55852,55890,67127,56094,56126,56110,66942,63761,56138,55889); //DRUIDE DPS DISTANT
             break;
             case 2:
               return array(66905,61396,66975,67234,56128,55860,62242,55871,55886,56098,56518,66974,56120,55994,56115,55874); //Druide DPS CAC
             break;
             case 3:
               return array(57858,55877,66921,66934,56113,56137,55852,55890,67127,56094,56126,55864,66942,63761,56138,55995); //Druide HEAL
             break;
             default: exit (); }
            break;
        default: exit ();
            }break;
        
  case 346: //STUFF LEVEL 85 PAYANT
    switch ($classe){// 1-WAR 2-PALA 3-CHASSOU 4-VOVO 5-PRIEST 6-DK 7-CHAMAN 8- MAGO 9- DEMO 11-DRIDE
        case 1: //WAR
            switch ($specialisation){//$spe1='Armes';            $spe2='Fureur';            $spe3='Protection';
             case 1:
             case 2:
                return array(60327,60324,60325,60326,60323,59330,59330,60210,55856,57855,56118,55872,55999,55996,62375,66994,55868); //Guerrier DPS
             break;
             case 3:
                return array(60331,60330,60328,60332,60329,59521,67145,60210,66909,55992,67067,56519,55888,55873,56111,56121,55881); //Guerrier TANK
             break;
             default: exit (); }
        break;
        case 2://PALADIN
            switch ($specialisation){//$spe1='Sacré';            $spe2='Protection';            $spe3='Vindict';
             case 1:
                 return array(60362,60361,60359,60363,60360,59463,59327,66912,55862,56135,55803,56126,56110,66942,63761,56138,55995); //Paladin HEAL
             break;
             case 2:
               return array(60358,60357,60356,60355,60354,59521,67145,67059,66909,55992,67067,56519,55888,55873,56111,56121,55881); //Paladin TANK
             break;
             case 3:
               return array(60348,60347,60346,60345,60344,59330,66988,55856,57855,56118,55872,55999,55996,62375,66994,55868); //Paladin DPS
             break;
             default: exit (); }
        break;
        case 3://CHASSEUR
            switch ($specialisation){//$spe1='Maîtrise des bêtes';            $spe2='Précision';            $spe3='Survie';
             case 1:
             case 2:
             case 3:
               return array(60306,60305,60303,60307,60304,63533,59320,57857,66935,66966,56518,56095,56120,55994,56115,55874); //Chasseur
             break;
             default: exit (); }
             
        break;
        case 4://VOLEUR
            switch ($specialisation){// $spe1='Assassinat';            $spe2='Combat';            $spe3='Finesse';
             case 1:
             case 2:
             case 3:
               return array(60302,60300,60299,60298,60301,59122,68601,68608,55871,55886,56098,56518,56095,56120,55994,56115,55874); //Voleur
             break;
             default: exit (); }
            break;
        case 5://PRIEST
            switch ($specialisation){//$spe1='Discipline';          $spe2='Sacré';            $spe3='Magie de l\'ombre';
             case 1:
             case 2:
                return array(60262,60261,60258,60275,60259,59525,59314,67237,56125,55878,56126,55864,63761,55859,56138,55995); //Pretre HEAL
             break;
             case 3:
                return array(60253,60255,60256,60257,60254,59525,59460,66937,66917,55878,56126,56110,66942,55859,56138,55889); //Pretre DPS
             break;
             default: exit (); }
            break;
        case 6://DK
            switch ($specialisation){//$spe1='Sang';            $spe2='Givre';            $spe3='Impie';
             case 2:
             case 3:
               return Array(60343,60342,60341,60340,60339,59330,64674,55856,57855,56118,55872,55999,55863,62375,66994,55868); //DK DPS
             break;
             case 1:
               return Array(60353,60352,60351,60350,60349,59330,64676,66909,55992,67067,56519,55888,55873,56111,56121,55881); //DK TANK
             break;
             default: exit (); }
            break;
        case 7://CHAMAN
            switch ($specialisation){//$spe1='Élémentaire';            $spe2='Amélioration';            $spe3='Restauration';
             case 1:
               return array(60317,60316,60315,60314,60313,59459,59484,64672,56119,66906,55887,56126,56110,66942,63761,56138,55889); //Chaman DPS DISTANT
             break;
             case 2:
               return  array(60322,60321,60320,60319,60318,59443,59462,64671,56123,66935,62439,56518,66974,56120,55994,56115,55874); //Chaman DPS CAC
             break;
             case 3:
               return  array(60311,60310,60308,60312,60309,59459,59513,64672,56119,66906,55887,56126,55864,66942,63761,56138,55995); //Chaman HEAL
             break;
             default: exit (); }
            break;
        case 8://MAGO
            switch ($specialisation){//$spe1='Arcane';            $spe2='Feu';            $spe3='Givre';
             case 1:
             case 2:
             case 3:
               return array(60246,60245,60243,60247,60244,59463,59484,59460,66937,55866,66941,56126,56110,66942,63761,56138,55889); //Mage
             break;
             default: exit (); }
            break;
        case 9://DEMONISTE
            switch ($specialisation){// $spe1='Affliction';            $spe2='Démonologie';            $spe3='Destruction';
             case 1:
             case 2:
             case 3:
               return array(60252,60250,60249,60248,60251,59463,59484,59460,66937,55866,66941,56126,56110,66942,63761,56138,55889); //Demoniste
             break;
             default: exit (); }
            break;
        case 11:
            switch ($specialisation){//$spe1='Équilibre';            $spe2='Farouche';            $spe3='Restauration';
             case 1:
               return array(60284,60283,60282,60285,60281,59525,64673,55890,67127,56094,56126,56110,66942,63761,56138,55889); //DRUIDE DPS DISTANT
             break;
             case 2:
               return array(60289,60288,60286,60290,60287,59474,64671,55871,55886,56098,56518,66974,56120,55994,56115,55874); //Druide DPS CAC
             break;
             case 3:
               return array(60279,60278,60277,60280,60276,59525,64673,55890,67127,56094,56126,55864,66942,63761,56138,55995); //Druide HEAL
             break;
             default: exit (); }
            break;
        default: exit ();
            }break;
default: exit ();
}
}


////////////////////////////////////////////
//FOCTIONS DE Boutique
///////////////////////////////////////////
function enlevePoints($DB,$user,$pointsAenlever){
    
    $req = $DB->prepare("UPDATE `users` SET `shopPoints`=shopPoints-$pointsAenlever WHERE `id`=$user ");
    $req->execute();
}


function deleteArticlePanier($DB,$article){
    
        $req = $DB->prepare("DELETE FROM `shop_panier` WHERE (`id` = :idArticle)");
        $req->execute(array('idArticle' => $article));
}


function enregistrementDebitHistorique($DB, $articleId,$prix,$guidChar,$promo){
    
    $sql="INSERT INTO `logs_transactions` (`userId`, `guidId`, `Article`, `debitPoints`, `creditPoints`, `adresseIp`, `date`, `promo`) 
            VALUES (:userId, :guidId, :Article, :debitPoints, '0', :adresseIp, now(), :promo)";
    $req = $DB->prepare($sql);
    $req->execute(array(
        
        'userId' => $_SESSION['id'],
        'guidId' => $guidChar,
        'Article' => $articleId,
        'debitPoints' => $prix,
        'adresseIp' => $_SERVER['REMOTE_ADDR'],
        'promo' => $promo
        ));
    
    
    
}


function getNameAction($action){
    switch ($action){
        case 1:
            return 'Modification du nom ';
            break;
        case 2:
            return 'Modification du nom & Visuel';
            break;
        case 3:
            return 'Changement de race';
            break;
        case 4:
            return 'Changement de faction';
            break;
        case 5:
            return 'Achat de piéces d’or';
            break;
        case 6:
            return 'Achat de niveaux';
            break;
        case 7:
            return 'Achat d\'un personnage 80';
            break;
        default: 
           return 'Aucun';
    }
}


function getPrixService($action){
    switch ($action){
        case 1:
             return '100'; //Nom
            break;
        case 2:
             return '150'; //visage
            break;
        case 3:
             return '200'; //race
            break;
        case 4:
             return '300'; //faction
            break;
       default :
            exit();
            break;
    }
}

function getInformationArticle($DB,$article){
        
        $sql=  "SELECT * FROM `shop_items` WHERE `id` = '$article'";

        $req = $DB->prepare($sql);
        $req->execute();

        $data= $req->fetch(PDO::FETCH_OBJ);
        $req->closeCursor();
        
        return $data;
    
}


function addItemPanier($DB, $guid, $idArticle ,$prix){
    
        $d= getInformationArticle($DB,$idArticle);
        
        if(!isset($prix)){
        $prix= ($d->prix * $d->facteur);
        }
        $sql= "INSERT INTO `shop_panier` (`articleId`, `prix`, `statut`, `idUser`, `characterGuid`, `ipAdress`, `date`) 
                VALUES ( :idArticle, :prix, '1', :idUser, :guidCharacter, :ipAdress, now() )";

        $req = $DB->prepare($sql);
        $req->execute(array(
            'idArticle' => $idArticle,
            'prix' => $prix,
            'idUser' => $_SESSION['id'],
            'guidCharacter' => $guid,
            'ipAdress' => $_SERVER['REMOTE_ADDR'],
    ));
          
}

function getTypeService($DB, $type){
    
    switch ($type){
        case 1:
            return 'Service: ';
            break;
        case 2:
            return 'Objet: ';
            break;
        case 3:
            return 'Monture: ';
            break;
        default: 
           return '';
    }  
    
}


function traitementAchatArticle($DB, $CHARS, $idArticle, $characterGuid){
    
     $account= $_SESSION['id'];
     
     
     $d= getInformationArticle($DB,$idArticle);

     $type= $d->type;
     
     switch ($type){
        case 1:
            $service= $d->service;
            
                 switch ($service){
                        case 1:
                        $req = $CHARS->prepare("UPDATE `characters` SET `at_login`='1' WHERE `guid`='$characterGuid' AND `account`='$account' ");
                        $req->execute();
                              break;
                        case 2:
                        $req = $CHARS->prepare("UPDATE `characters` SET `at_login`='8' WHERE `guid`='$characterGuid' AND `account`='$account' ");
                        $req->execute();
                             break;
                        case 3:
                        $req = $CHARS->prepare("UPDATE `characters` SET `at_login`='128' WHERE `guid`='$characterGuid' AND `account`='$account' ");
                        $req->execute();
                             break;
                        case 4:
                        $req = $CHARS->prepare("UPDATE `characters` SET `at_login`='64' WHERE `guid`='$characterGuid' AND `account`='$account' ");
                        $req->execute();
                        break;
                        case 5:
                            
                        $d= getInformationArticle($DB, $idArticle);
                        $gold= $d->gold* 10000;
                            
                        $req = $CHARS->prepare("UPDATE `characters` SET `money`= money + $gold WHERE `guid`='$characterGuid' AND `account`='$account' ");
                        $req->execute();
                        break;
                        case 6:
                            
                        $d= getInformationArticle($DB, $idArticle);
                            
                        $level= $d->levelMax;
                        $req = $CHARS->prepare("UPDATE `characters` SET `level`='$level' WHERE `guid`='$characterGuid' AND `account`='$account' ");
                        $req->execute();
                        break;
                   default :
                        exit();
                        break;
                 }
            break;
        case 2:
             
            break;
        case 3:
            
            break;
        case 4:
            
            break;
       default :
            exit();
            break;
    }
}
function recupobjetliste($DB, $id, $table){
	$req = $DB->prepare('SELECT '.$table.' from '.$table.' WHERE `id` = '.$id);
	$req->execute();

	$result = $req->fetchAll(PDO::FETCH_ASSOC);
	if( count($result) > 0 )
	{
		foreach($result as $donnees)
		{
			return $donnees[$table];
		}
	}
	else
	{
		return 'Aucun';
	}
	unset($req);
	unset($result);
}

function recupliste($DB, $table,$value){
	$sql = 'SELECT id,'.$table.' from '.$table;
	
	if ($value == 0) {
		$sql.=' order by '.$table;
	}
	else
	{
		$sql.=' order by id';
	}

	$req = $DB->prepare($sql);
	$req->execute();
	
	$html = '';
	$result = $req->fetchAll(PDO::FETCH_ASSOC);
	if( count($result) > 0 )
	{
		foreach($result as $donnees)
		{
			$cle = $donnees['id'];
			if ($cle == $value) {
				$html.= '<option selected value="'.$cle.'">'.$donnees[$table].'</option>';
			}
			else
			{
				$html.= '<option value="'.$cle.'">'.$donnees[$table].'</option>';
			}
		}
	}
	else
	{
		$html = '<option cle="0">(Aucun)';
	}
	unset($req);
	unset($result);
	unset($donnees);
	unset($cle);
	
	return $html;
}


function getPercentColor($value){

    if($value<=25){
        return '#7f0202';
    }
    if($value<=50&&$value>25){
        return '#4f4637';
    }
    if($value<=75&&$value>50){
        return '#7f6602';
    }
    if($value<=90&&$value>75){
        return '#b5d521';
    }
    if($value<=99&&$value>90){
        return '#8bd521';
    }
    if($value==100){
        return '#26fd03';
    }
}

function calculPercent($valueTot,$valueCourant){
        
    return ceil(($valueCourant/$valueTot)*100);
    
}

function CalculPourcentAvance($DB, $categorie,$value){
    
	$sql = "SELECT nbrTotalAction, nbrActionTermine FROM `sous-taches` WHERE `$categorie` = '$value'";
	$req = $DB->prepare($sql);
	$req->execute();
	
	$perentTotal = 1;
        
	$tab = $req->fetchAll(PDO::FETCH_ASSOC);
        $nbrResult = count($tab);
        
        
	if ($nbrResult > 0 )
	{
            
            foreach ($tab as $d) {
                $valTot=$d['nbrTotalAction'];
                $valCourt=$d['nbrActionTermine'];
                
                $perentTotal+= calculPercent($valTot, $valCourt);
            }
                
	}
	else{
	$nbrResult=1;
	$perentTotal = 1;
	}
	unset($req);
	unset($sql);
	return ceil($perentTotal/$nbrResult);
}



?>
