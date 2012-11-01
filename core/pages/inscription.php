<?php
$etat = '';
$afficher_form = true;

if (isset($_GET['p']) && !empty($_GET['p'])) {
    $parrain = (int) $_GET['p'];
} else {
    $parrain = 0;
}
if(isset($_SESSION['name']) && isset($_SESSION['accountLevel'])){
      header('Location: index.php');
}
if (isset($_POST['envoyer'])) {
    if (isset($_POST['pseudo']) && !empty($_POST['pseudo']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['password_rep']) && !empty($_POST['password_rep']) && isset($_POST['mail']) && !empty($_POST['mail']) && isset($_POST['verif']) && !empty($_POST['verif'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $pass = htmlspecialchars($_POST['password']);
        $pass_rep = htmlspecialchars($_POST['password_rep']);
        $email = htmlspecialchars($_POST['mail']);
        $code = (int) $_POST['verif'];

        if (strlen($pseudo) >= 2 && strlen($pseudo) <= 25) {
            if (strlen($pass) >= 4 && strlen($pass) <= 16) {
                if ($pass == $pass_rep) {
                    if (preg_match("#^[a-zA-Z0-9]+$#", $pseudo)) {
                        if (preg_match("#^[a-zA-Z0-9]+$#", $pass)) {
                            if (preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$#", $email)) {
                                if ($_SESSION['captcha'] == $code) {
                                    $query = $REALM->query("SELECT COUNT(*) AS nb_pseudos FROM account WHERE username='" . $pseudo . "'");
                                    $data = $query->fetch();
                                    if ($data['nb_pseudos'] == 0) {
                                        $query = $REALM->query("SELECT COUNT(*) AS nb_mails FROM account WHERE email='" . $email . "'");
                                        $data = $query->fetch();
                                        if ($data['nb_mails'] == 0) {
                                            if (isset($_POST['parrain_id'])) {
                                                $parrain_id = (int) $_POST['parrain_id'];
                                            } else if (isset($_POST['parrain'])) {
                                                $parrain = htmlspecialchars($_POST['parrain']);
                                                $req = "SELECT id FROM users WHERE mail='" . $parrain . "'";
                                                $query = $DB->query($req);
                                                $data = $query->fetch();
                                                $parrain_id = $data['id'];
                                            }

                                            if (!isset($parrain_id) || $parrain_id < 0)
                                                $parrain_id = 0;

                                            $mdp_realmd = sha1(strtoupper($pseudo) . ':' . strtoupper($pass));


                                            addCompte($DB, $REALM, $pseudo, $mdp_realmd, $email, $parrain_id);

                                            $afficher_form = false;
                                            $etat = "<p class='contentForme'> <font class='validFormulaire'><strong>Félicitations votre inscription est un succés.</strong></font>
                                                    <font color='#FFF'><strong>Vous allez bientôt recevoir un mail de notre équipe  qui vous permettra d'activer votre compte.</strong></font></br></br>
                                                    Nous vos suggerons de bien vouloir  vous inscrire sur le <a href='./forum/'>forum</a> pendant ce temps.<br /><br /><br />
                                                    <a href='index.php''>Revenir à l'accueil</a>
                                                    </p></div>";		
                                        }
                                        else {
                                            $afficher_form = true;
                                            $etat = "<font class='erreurFormulaire'  color='red'><em>Adresse e-mail déjà utilisée...</em></font>";
                                        }
                                    } else {
                                        $afficher_form = true;
                                        $etat = "<font class='erreurFormulaire'  color='red'><em>Nom de compte déjà utilisé...</em></font>";
                                    }
                                } else {
                                    $afficher_form = true;
                                    $etat = "<font class='erreurFormulaire'  color='red'><em>Code invalide...</em></font>";
                                }
                            } else {
                                $afficher_form = true;
                                $etat = "<font class='erreurFormulaire'  color='red'><em>L'adresse e-mail est invalide...</em></font>";
                            }
                        } else {
                            $afficher_form = true;
                            $etat = "<font class='erreurFormulaire'  color='red'><em>Le mot de passe ne peut contenir que des caractéres alphanumériques (Sans caractéres spéciaux ni accents)</em></font>";
                        }
                    } else {
                        $afficher_form = true;
                        $etat = "<font class='erreurFormulaire'  color='red'><em>Le pseudo ne peut contenir que des caractéres alphanumériques (Sans caractères spéciaux ni accents)</em></font>";
                    }
                } else {
                    $afficher_form = true;
                    $etat = "<em><font class='erreurFormulaire'  color='red'>Vous n'avez pas entré deux mots de passe identiques...</em></font>";
                }
            } else {
                $afficher_form = true;
                $etat = "<em><font class='erreurFormulaire'  color='red'>Le mot de passe doit faire entre 4 et 16 caractéres...</em></font>";
            }
        } else {
            $afficher_form = true;
            $etat = "<em><font class='erreurFormulaire'  color='red'>Le pseudo doit faire entre 2 et 25 caractéres...</em></font>";
        }
    } else {
        $afficher_form = true;
        $etat = "<em><font class='erreurFormulaire'  color='red'>Vous n'avez pas rempli tous les champs...</em></font>";
    }
}

if (isset($_GET['step'])) {
?>


<div id="Inscription" class="news">
            <div class="headNews"> 
                <span>Creer un compte</span>
            </div>
    <div class="middleNews">
        <?php
        echo $etat;
        if ($afficher_form) {
        ?>
            <form action="index.php?page=inscription&&step=1" method="post">
                
                <fieldset><legend>Nom de compte</legend>  
                <p>Le nom de compte sert à vous identifier en jeu et sur le site. Pour des raisons de sécurité ne le transmettez qu'aux maîtres de jeu.</p>
                <label class="labelInsc" for="pseudo">Nom d'utilisateur :</label>
                <input class="champInsc" id="pseudo" class="champ" name="pseudo" type="text" /><br />
                </fieldset>
                <fieldset>
                <legend>Mot de passe</legend>
                <p>Il est fortement conseillé que le mot de passe soit différent de celui de votre compte de messagerie. Ne le transmettez à personne, un Maître de Jeu ne vous le demandera jamais.</p>
                <br />
                <label class="labelInsc" for="password">Mot de passe :</label>
                <input id="password" class="champInsc" name="password" type="password" />
                <label class="labelInsc" for="password_rep">Répéter mot de passe :</label>
                <input id="password_rep" class="champInsc" name="password_rep" type="password" /><br />
                </fieldset>
                <fieldset>
                <legend>Adresse email</legend>
                <p>Un courriel de validation vous sera envoyé, cette adresse doit donc être valide. Celle-ci nous est utile au cas où vous auriez perdu votre mot de passe.</p><br />
                <label class="labelInsc" for="mail">Adresse e-mail :</label>
                <input id="mail" name="mail" class="champInsc" type="text" /> <br />
                </fieldset>
                <?php if (isset($_GET['par']) && $_GET['par'] > 0 && is_numeric($_GET['par'])) {
 ?>                    <input type="hidden" name="parrain_id" value="<?php echo $_GET['par']; ?>" />
                <?php } else {
                    
 ?>
                     <fieldset>
                    <legend>Parrainage</legend>
                    <p>Vous pouvez indiquer une adresse e-mail de joueur comme étant votre parrain. Cela lui permettra non seulement de gagner 400 points R à cette personne mais en plus vous aussi vous serez crédité de 150 points R.<br/>
                       Une fois inscrit,  vous pourrez à votre tour vous aussi parrainer de nouveaux joueurs. Plus d'informations dans la zone membre.</p>
                    <br />
                    <label class="labelInsc" for="parrain">Adresse mail du parrain:</label>
                    <input id="parrain" class="champInsc" name="parrain" type="text" /><br /><br />
                     </fieldset>
<?php } ?>
           
            
            <fieldset>
            <legend>Sécurité</legend>
            <p>Vous devez recopier le numero dans le champs. Ceci nous assure que vous êtes bien un humain.</p><br />
            <div style="margin: auto; width: 94px; height: 38px; display: block; border: 2px solid #c39640;"> <img style="margin:auto;" src="./template/capcha/captcha.php" alt="anti_robot"/> </div><br />
            <label class="labelInsc" for="verif">Recopier le texte:</label>
            <input id="verif" class="champInsc" name="verif" size="10" maxlength="6" type="text" /><br />
            </fieldset>
            <input name="envoyer" class="sendInsc" value="" type="submit" /><br />
        </form>
<br />
        <p>Note: Si l'image ne s'affiche pas correctement, veuillez actualiser la page !</p></div>
<?php
            }
}else{?>
<div id="Inscription" class="news">
            <div class="headNews"> 
                <span>Creer un compte</span>
            </div>
    <div class="middleNews">
        
<p  class="contentForme">
<strong>Bienvenue sur la page d'inscription de Rolkithan-Project.</strong> <br/><br/>

Vous vous apprêtez à entrer sur un serveur de qualité qui possède deux royaumes constamment mis à jour.<br/>

Nos royaumes sont axés sur le JcJ ainsi que le JcE, vous pourrez choisisr entre un serveur semi-fun ou un serveur de type blizzLiKe. Ces deux royaumes fonctionnent avec l'extention Cataclysme.<br/><br/>

Le royaume Shalkiran vous propose ainsi une qualité de jeu trés proche de celle de l'officiel avec des rates X2 en semaine et X5 en week-end, vos pourrez ainsi évoluer a votre rytme. <br/><br/>
De son côté, le royaume Ralkisan vous permetra d'arriver avec un personnage de niveau 85, une zone shop avec tous les accessoires est mise a votre disposition pour une expérience de jeu
plus vive et dynamique. <br/><br/>

En cliquant sur le bouton suivant, nos considérons que vous avez pris connaissance et accepté les conditions de jeu mentionées sur <a href="index.php?page=reglement">notre règlement.</a><br/>
Nous vous remercions de votre visite et sommes impatient de vous voir vous connecter sur un ou plusieurs de nos royaumes.<br/>
<br/><br/>
Bon jeu à vous ! <br/><br/>

<a href="index.php?page=inscription&&step=1
 <?php if (isset($_GET['par']) && $_GET['par'] > 0 && is_numeric($_GET['par'])) {
     echo '&&par='.$_GET['par'];
 }
 ?> " class="nextStage"></a>
</p>
    </div>
        
    

<?php }?></div>