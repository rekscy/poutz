 
<?php
$req = $DB->prepare("SELECT COUNT(*) FROM posts WHERE `online`=1 AND type='news'");
$req->execute();
$nbArticles = $req->fetchColumn();

$req->closeCursor();

if (isset($_POST) && isset($_POST['message']) && isset($_POST['id'])) {
    extract($_POST);
    $message=='Votre commentaire...'?$message= '' : null;
    $code = (int) $_POST['verif'];
         if (!empty($message)) {
            if (preg_match("#^[^\<>{}*]+$#", $message)) {
                if ($_SESSION['captcha'] == $code) {
                $sql = "INSERT INTO `posts` ( `content`, `type`, `date`, `idUser`, `ipUser`, `newsParent`, `online`) 
                    VALUES ( :message, 'comment', now(), :idUser, :ipUser, :newsParent, '1')";
                $req = $DB->prepare($sql);
                $req->execute(array(
                    'message' => $message,
                    'idUser' => $_SESSION['id'],
                    'ipUser' => $_SERVER['REMOTE_ADDR'],
                    'newsParent'=> $id
                ));
                header("Location: index.php?news=$id");                
                }else{
                 echo '<span class="erreurFormulaire">Code invalide</span>';   
                }
            } else {
                echo '<span class="erreurFormulaire">Votre message contient des caractéres non autorisés</span>';
                
            }
        }  else {
            echo '<span class="erreurFormulaire">Votre message est vide</span>';
        }
}
if (isset($_GET['news'])) {

    $req = $DB->prepare("SELECT * FROM posts WHERE id = :idNews AND `online`=1 AND type='news'");
    if(!is_numeric($_GET['news'])){
        header('Location: index.php');
    }
    $req->execute(array('idNews' => $_GET['news']));


    while ($data = $req->fetch(PDO::FETCH_OBJ)):
?>

<div id="news<?php echo $data->id; ?>" class="news">
            <div class="headNews"> 
                <span><?php echo $data->title; ?></span>
            </div>
            <div class="middleNews">
                <div class="fb-like" style="padding-left: 10px; padding-top: 3px; " data-href="www.rolkithan.fr/index.php?news=<?php echo $data->id;?> " data-send="true" data-width="440" data-show-faces="false" data-colorscheme="dark"></div>
                <div class="corpNews">
                    <p><img src="template/img/news/<?php echo $data->img; ?>" class="imgNews" alt="Image de description"/>
                        <?php echo $data->content; ?>
                    </p>
                </div>
                <div class="footNews">
                    <span style="color: #c39640">Écrit par:</span><span><?php echo getMainPerso($CHARS, $DB, $data->idUser); ?></span>
                    <a class="linkNews" href="index.php">Revenir en arrière</a>
                </div>                            
            </div>
</div>

<a NAME="comments"></a>
<?php  endwhile; ?>

<?php
   if(isset($_SESSION['name']) && isset($_SESSION['accountLevel'])){
       if(POSTES_ACTIVES == 1){
   
       
                ?>
                <form class="postComm" action="index.php" method="post"> 
                    <fieldset>
                    <legend>Message</legend>
                    <input type="hidden" name="id" value="<?php echo $_GET['news']; ?>"/>
                    <textarea cols="60" rows="8"  name="message" class="champ_message" onclick="this.focus(); this.select();"></textarea>
                    </fieldset>
                    <fieldset>
                    <legend>Sécurité</legend>
                    <p>Vous devez recopier le numero dans le champs. Ceci nous assure que vous êtes bien un humain.</p><br />
                    <div style="margin: auto; width: 94px; height: 38px; display: block; border: 2px solid #c39640; float: right;"> <img style="margin:auto;" src="./template/capcha/captcha.php" alt="anti_robot"/> </div><br />
                    <label class="labelInsc" for="verif">Recopier le texte:</label>
                    <input id="verif" style="cursor:text; float: left;" class="send" name="verif" size="10" maxlength="6" type="text" /><br />
                    </fieldset>
                    <input type="submit" value="Poster" class="send"/>
                </form>
                <?php


                    $req = $DB->prepare("SELECT * FROM posts WHERE newsParent = :idNews AND `online`=1 AND type='comment'");
                    $req->execute(array('idNews' => $_GET['news']));

                    while ($data = $req->fetch(PDO::FETCH_OBJ)):
                ?>

                <div id="news<?php echo $data->id; ?>" class="comment">
                            <div class="headcomment"> 
                                <span><?php echo getMainPerso($CHARS,$DB, $data->idUser);?> a écrit le <?php echo convertTime($data->date) ?> </span>
                            </div>
                    <hr/>
                            <div class="middleComment">
                                    <p> <?php echo $data->content; ?> </p>                         
                            </div>
                </div>

<?php
                endwhile;
               }else{ ?>
           <span class="erreurFormulaire"> Les commentaires ont été désacivés</span>
     <?php  }}else{ ?>
       <span class="erreurFormulaire">Vos devez vos connecter pour voir les commentaires.</span>
 <?php  }
    } else {
        $parPage = 2;
        $total = $nbArticles;
        $currentPage = (isset($_GET['list'])) ? $_GET['list'] : 1;
        $currentPage = htmlentities($currentPage);
        $currentPage = ($currentPage > ceil($total / $parPage)) ? $currentPage = ceil($total / $parPage) : $currentPage;
        
        $sql="SELECT * FROM posts WHERE `online`=1  AND type='news' ORDER BY id DESC LIMIT " . ($currentPage - 1) * $parPage . ',' . $parPage;   
        $req = $DB->prepare($sql);
        $req->execute();


        while ($data = $req->fetch(PDO::FETCH_OBJ)):
?>

        <div id="news<?php echo $data->id; ?>" class="news">
            <div class="headNews"> 
                <span><?php echo $data->title; ?></span>
            </div>
            <div class="middleNews">
                <div class="fb-like" style="padding-left: 10px; padding-top: 3px; " data-href="www.rolkithan.fr/index.php?news=<?php echo $data->id;?> "  data-send="true" data-width="440" data-show-faces="false" data-colorscheme="dark"></div>
                <a class="commentNews" href="index.php?news=<?php echo $data->id;?>#comments"><?php echo getNumberComments($DB,$data->id); ?></a>
                <div class="corpNews" style="height:190px; overflow: hidden;">
                    <p><img src="template/img/news/<?php echo $data->img; ?>" class="imgNews" alt="Image de description"/>
                        <?php echo $data->content; ?>
                    </p>
                </div>
                <div class="footNews">
                    <span style="color: #c39640; margin-left: 5px;">Écrit par:</span><span><?php echo getMainPerso($CHARS, $DB, $data->idUser); ?></span>
                    <a class="linkNews" href="index.php?news=<?php echo $data->id; ?>">Voir la news compléte...</a>
                    <p style="color: darkgoldenrod;text-shadow:0px 0px 4px #000; font-size:10px; margin-top: -15px;">le <?php echo convertTime($data->date); ?> </p>
                </div>                            
            </div>
        </div>
    
<?php endwhile; ?>

            <div class="pagination">
    <?php
            /* $numLinks = ceil($total/$parPage);

              //for($i=1;$i<=$numLinks;$i++):?>

              <a href="index.php?list=<?php echo $i-1;?>"><?php echo $i;?></a>
              <?php
              endfor; */

            $next = ($currentPage * $parPage < $total) ? '| Page Suivante >>>' : null;
            $prev = ($currentPage > 1) ? '<<< Page Precédente |' : null;
    ?>
            <a href="index.php?list=<?php echo $currentPage - 1; ?>"><?php echo $prev; ?></a>
            <a href="index.php?list=<?php echo $currentPage + 1; ?>"><?php echo $next; ?></a>

        </div>

<?php } ?>