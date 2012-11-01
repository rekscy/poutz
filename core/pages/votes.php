<div id="NousRejoindre" class="news">
            <div class="headNews"> 
                <span>Soutenez le serveur</span>
            </div>
    <div class="middleNews">

        <?php
        function calcul_temps($secondes) {
            $heures = floor($secondes / 3600);
            $secondes %= 3600;
            $minutes = floor($secondes / 60);
            $secondes %= 60;

            echo $heures . 'h' . $minutes . 'min' . $secondes . 's';
        }

if(isset($_SESSION['name']) && isset($_SESSION['accountLevel'])){

   if(isset($_GET['key'])&&isset($_GET['top'])){
       
    if($_GET['key']==$_SESSION['keySec']&&  is_numeric($_GET['top'])){
    
    $sql="INSERT INTO `anti_FakeVote` (`url`, `userId`, `top`, `statut`, `date`) 
        VALUES (:url, :userId, :top, 0, now())";
    $req = $DB->prepare($sql);
    $req->execute(array(
        
        'url' => htmlspecialchars($_GET['key']),
        'userId' => $_SESSION['id'],
        'top' => $_GET['top'],
        ));
    
    
    echo '<fieldset><legend> Vérification anti-bot </legend>';
     $keyLien=$_SESSION['keySec'];
    if($_GET['top']==1){
        $_SESSION['keySec1']= $_SESSION['keySec'];
        
        echo "<a href='index.php?page=redirection_vote&&key=$keyLien&&top=1' target='_blank' style='color:gold; font-weight: bold; font-size:14px;'>Confirmer mon vote Gowanda</a>";
        
    }
    
    if($_GET['top']==2){
        $_SESSION['keySec2']= $_SESSION['keySec'];
        
        echo "<a href='index.php?page=redirection_vote&&key=$keyLien&&top=2' target='_blank' style='color:gold; font-weight: bold; font-size:14px;'>Confirmer mon vote Rpg-Paradize</a>";
        
    }
    
    if($_GET['top']==3){
        $_SESSION['keySec3']= $_SESSION['keySec'];
        echo "<a href='index.php?page=redirection_vote&&key=$keyLien&&top=3' target='_blank' style='color:gold; font-weight: bold; font-size:14px;'>Confirmer mon vote Mannoroth</a>";
        
    }
    echo '</fieldset>';
    
        }
    
            }
           
            
            $keysec= sha1(rand(1,10000000).$_SESSION['name']);
            $_SESSION['keySec']= $keysec;
            
            $query = $DB->query("SELECT * FROM users WHERE id='" . $_SESSION['id'] . "'");
            $data = $query->fetch();

            if ((time() - $data['timestamp1']) > 7200) {
        ?>
                <fieldset><legend>Gowanda</legend>  
                <p>
                <a href='index.php?page=votes&&key=<?php echo $keysec; ?>&&top=1' ><img src='http://www.gowonda.com/vote.gif' border='0' width='90' height='60' style="float: right; margin: 5px;" /></a><br/>
                Nous vous prions de nous soutenir sur le top-votes Gowanda. Chaque vote vous rapportera 1 point. <br/>
                </p></fieldset>
                <?php
            } else {
                $temps_restant = 7200 - (time() - $data['timestamp1']);
        ?>
                <fieldset><legend>Gowanda</legend>  
                <p>
                <a href='index.php?page=votes&&key=<?php echo $keysec; ?>&&top=1' ><img src='http://www.gowonda.com/vote.gif' border='0' width='90' height='60' style="float: right; margin: 5px;" /></a><br/>
                Nous vous prions de nous soutenir sur le top-votes Gowanda. Chaque vote vous rapportera 1 point.<br/><br/><span style="color:red; text-shadow:0px 0px 4px #000;"> (Veuillez patienter encore <?php calcul_temps($temps_restant); ?> )</span> <br/>
                </p></fieldset> <?php
            }

            if ((time() - $data['timestamp2']) > 7200) {
        ?>
                <fieldset><legend>Rpg-Paradize</legend>  
                <p>
                <a href="index.php?page=votes&&key=<?php echo $keysec; ?>&&top=2"><img src="http://www.rpg-paradize.com/vote.gif" border=0 style="float: right; margin: 5px;" ></a>
                Nous vous prions de nous soutenir sur le top-votes Rpg-Paradize. Il est trés important de faire attention a bien rentrer les bons caractères n'hésitez pas a réactualiser l'image.<br/>
                </p></fieldset>
        <?php
            } else {
                $temps_restant = 7200 - (time() - $data['timestamp2']);
        ?>
                <fieldset><legend>Rpg-Paradize</legend>  
                <p>
                <a href="index.php?page=votes&&key=<?php echo $keysec; ?>&&top=2" ><img src="http://www.rpg-paradize.com/vote.gif" border=0 style="float: right; margin: 5px;" ></a>
                Nous vous prions de nous soutenir sur le top-votes Rpg-Paradize. Il est trés important de faire attention a bien rentrer les bons caractères n'hésitez pas a réactualiser l'image.<br/><br/>
               <span style="color:red; text-shadow:0px 0px 4px #000;" >(Veuillez patienter encore <?php calcul_temps($temps_restant); ?> )</span>
                </p></fieldset>
<?php
            }

            if ((time() - $data['timestamp3']) > 3600) {
?>
               <fieldset><legend>Mannoroth</legend>  
               <p>
               <a href="index.php?page=votes&&key=<?php echo $keysec; ?>&&top=3"><img  src="http://www.mannoroth.fr/styles/icons/buttons/vote.png" alt="Votez pour ce serveur !" style="float: right; margin: 5px;" /></a><br/>
            Nous vous prions de nous soutenir sur le top-votes Mannoroth. N'oubliez pas de nous bosseter sur le top-pouces.<br/>
                </p></fieldset>
<?php
            } else {
                $temps_restant = 3600 - (time() - $data['timestamp3']);
        ?>
               <fieldset><legend>Mannoroth</legend>  
               <p>
               <a href="index.php?page=votes&&key=<?php echo $keysec; ?>&&top=3"><img  src="http://www.mannoroth.fr/styles/icons/buttons/vote.png" alt="Votez pour ce serveur !" style="float: right; margin: 5px;" /></a><br/>
            Nous vous prions de nous soutenir sur le top-votes Mannoroth. N'oubliez pas de nous bosseter sur le top-pouces.<br/><br/>
            <span style="color:red; text-shadow:0px 0px 4px #000;">(Veuillez patienter encore <?php calcul_temps($temps_restant); ?> )</span>
                </p></fieldset>
 <?php
            }
        } else {
        ?>
                
                <p  class="erreurFormulaire" style="margin: auto;">
                Vous devez vous connecter pour avoir vos votePoints !
                </p>
                <fieldset><legend>Gowanda</legend>  
                <p>
                <a href='http://www.gowonda.com/vote.php?server_id=3385' target='_blank'><img src='http://www.gowonda.com/vote.gif' border='0' width='90' height='60' style="float: right; margin: 5px;" /></a><br/>
                Nous vous prions de nous soutenir sur le top-votes Gowanda. Chaque vote vous rapportera 1 point. <br/>
                </p></fieldset>
                
                <fieldset><legend>Rpg-Paradize</legend>  
                <p>
                <a href="http://www.rpg-paradize.com/?page=vote&vote=17035" target=_blank><img src="http://www.rpg-paradize.com/vote.gif" border=0 style="float: right; margin: 5px;" ></a>
                Nous vous prions de nous soutenir sur le top-votes Rpg-Paradize. Il est trés important de faire attention a bien rentrer les bons caractères n'hésitez pas a réactualiser l'image.<br/>
               
                </p></fieldset>

                <fieldset><legend>Mannoroth</legend>  
                <p>
               <a href="http://www.mannoroth.fr/vote-206"><img  src="http://www.mannoroth.fr/styles/icons/buttons/vote.png" alt="Votez pour ce serveur !" style="float: right; margin: 5px;" /></a><br/>
            Nous vous prions de nous soutenir sur le top-votes Mannoroth. N'oubliez pas de nous bosseter sur le top-pouces.<br/>
                </p></fieldset>
                

        <?php
        }
        ?>
            </div> <div class="headNews"> 
                <span>Classement des meilleurs voteurs</span>
            </div>
                <div class="middleNews">
<fieldset>
    <legend>Top des 25 meilleurs votants</legend>
            <table class="voteTop" style="border:none">
                <thead>
                <th width='190'><strong>Place</strong></th>
                <th width='190'><strong>Pseudo</strong></th>
                <th width='190'><strong>Votes ce mois-ci</strong></th>
                </thead>


<?php
            $query = $DB->query("SELECT id, mainPseudo, votePoints FROM users WHERE votePoints>0 ORDER BY votePoints DESC  LIMIT 0,1");
            $i = 1;

            while ($data = $query->fetch()) {
?>
                <tr class="topVoteLigne" style=" font-size:20px;">
                    <td><?php echo '<em>' . $i . '</em>'; ?></td>
                    <td><?php echo '<em>' . getMainPerso($CHARS,$DB, $data['id']) . '</em>'; ?></td>
                    <td><?php echo '<em>' . $data['votePoints'] . '</em>'; ?></td>
                </tr>
            <?php
            }

            $query = $DB->query("SELECT id, mainPseudo, votePoints FROM users WHERE votePoints>0 ORDER BY votePoints DESC  LIMIT 1,1");
            $i = 2;

            while ($data = $query->fetch()) {
            ?>
                <tr class="topVoteLigne" style="font-size:18px;">
                    <td><?php echo '<em>' . $i . '</em>'; ?></td>
                    <td><?php echo '<em>' . getMainPerso($CHARS,$DB, $data['id']) . '</em>'; ?></td>
                    <td><?php echo '<em>' . $data['votePoints'] . '</em>'; ?></td>
                </tr>
            <?php
            }
            $query = $DB->query("SELECT id, mainPseudo, votePoints FROM users WHERE votePoints>0 ORDER BY votePoints DESC  LIMIT 2,1");
            $i = 3;

            while ($data = $query->fetch()) {
            ?>
                <tr class="topVoteLigne" style=" font-size:16px;">
                    <td><?php echo '<em>' . $i . '</em>'; ?></td>
                    <td><?php echo '<em>' . getMainPerso($CHARS,$DB, $data['id']) . '</em>'; ?></td>
                    <td><?php echo '<em>' . $data['votePoints'] . '</em>'; ?></td>
                </tr>
            <?php
            }
            ?>
            <tr></tr>
            <?php
            $query = $DB->query("SELECT id, mainPseudo, votePoints FROM users WHERE votePoints>0 ORDER BY votePoints DESC  LIMIT 3,22");
            while ($data = $query->fetch()) {
                $i++;
            ?>

                <tr class="topVoteLigne" style=" font-size:14px;">
                    <td><?php echo $i; ?></td>
                    <td><?php echo getMainPerso($CHARS,$DB, $data['id']) ; ?></td>
                    <td><?php echo $data['votePoints']; ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </fieldset>
  </div>
</div>		 

