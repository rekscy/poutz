<div id="membre" class="news">
            <div class="headNews"> 
                <span>Activation de compte</span>
            </div>
    <div class="middleNews">

 <?php   
if (isset($_GET['link']) && isset($_GET['compte'])){
    if (!empty($_GET['link']) &&!empty($_GET['compte'])){
        
    extract($_GET);
    
        if (preg_match("#^[a-zA-Z0-9]+$#", $_GET['link'])) {
            if (preg_match("#^[a-zA-Z0-9]+$#", $compte)) {

                $sql = "SELECT * FROM users WHERE name='$compte' AND codeActivate='$link'";
                $req = $DB->prepare($sql);
                $req->execute();
                $valid = $req->rowcount();
                    if($valid==1){
                        //FIN CONTROLE
                        
                        $req1 = $DB->prepare("UPDATE `users` SET `codeActivate`='1', `accountLevel`='1'   WHERE `name`='$compte' ");
                        $req1->execute();
                        
                        $req2 = $REALM->prepare("UPDATE `account` SET `locked`='0'   WHERE `username`='$compte' ");
                        $req2->execute();
                        
                     echo "<span class='validFormulaire' color='green'><strong>Opération effectuée avec succés.</strong> <br/> Merci $compte";
                        
                    }else {
                    header('Location: index.php?page=membre');
                    }
                }else{
                header('Location: index.php?page=membre');
                }
            }else{
            header('Location: index.php?page=membre');
            }
        }else{
        header('Location: index.php?page=membre');
        }
    }else{
    header('Location: index.php?page=membre');
}
 ?>
             
             

</div>

</div>
