
<div id="Connexion" class="news">
            <div class="headNews"> 
                <span>Connexion</span>
            </div>
    <div class="middleNews" id="connexion">
<?php

if(isset($_SESSION['name']) && isset($_SESSION['accountLevel'])){
      header('Location: index.php');
}
    if (isset($_POST) && isset($_POST['pseudo']) && isset($_POST['pass'])) {
        extract($_POST);

        $pseudo == 'Login' ? $pseudo = null : $pseudo;
        $pass == 'pass' ? $pass = null : $pass;
        if (!empty($pseudo) && !empty($pass)) {
            if (preg_match("#^[^\<>{}*]+$#", $pass)) {
                if (preg_match("#^[^\<>{}*]+$#", $pseudo)) {
                    $pseudo = addslashes($_POST['pseudo']);
                    $pass = addslashes($_POST['pass']);

                    if(connexion($pseudo, $pass, $DB,$CHARS, $REALM)=='valid'){
                        echo "<span class='validFormulaire'>Connection en cours...</span>";
                    }else{
                    echo connexion($pseudo, $pass, $DB,$CHARS, $REALM);
                    }
                } else {
                    echo '<span class="erreurFormulaire">Votre pseudo contient des caractéres non autorisés</span>';
                }
            } else {
                echo '<span class="erreurFormulaire">Votre message contient des caractéres non autorisés</span>';
            }
        } else {
            echo '<span class="erreurFormulaire">Vous n\'avez pas remplit tous les champs</span>';
        }
    }
    

    ?>
        <p class="contentForme"><strong>Bienvenu sur notre page de connexion,</strong><br/> il est important pour des raisons de sécurité de ne pas divulguer votre mot de passe ainsi que de ne pas partager votre compte avec une deuxiéme personne.</p>
        <div class="champOrange">
            <form  action="index.php?page=connexion" method="post">
            <input  class="champ" value="<?php echo isset($_POST['pseudo'])?$_POST['pseudo']:'Login'; ?>"onFocus="if (this.value=='Login') {this.value=''}" type="text" name="pseudo">
            <input  class="champ" value="<?php echo isset($_POST['pass'])?'':'Password'; ?>" type="password" onFocus="if (this.value=='Password') {this.value=''}"  name="pass">
            <input type="submit" id="send" value=""><a id="signMe" href="index.php?page=inscription"></a>
            </form>
        </div>
    </div>
</div>