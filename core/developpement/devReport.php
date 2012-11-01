<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],0) && !isset($_SESSION['Administrateur'])){
//       header('Location: index.php');
    }
?>
<div id="devReport" class="news">
    <div class="headNews"> 
        <span>Deniers débugs effectués par l'équipe Rolkithan</span>
    </div>
    <div class="middleNews">

<?php

        $req = $DB->prepare("SELECT COUNT(*)FROM dev_report ");
        $req->execute();
        $nbArticles = $req->fetchColumn();

        $req->closeCursor();
        
        $parPage = 10;
        $total = $nbArticles;
        $currentPage = (isset($_GET['list'])) ? $_GET['list'] : 1;
        $currentPage = htmlentities($currentPage);
        $currentPage = ($currentPage > ceil($total / $parPage)) ? $currentPage = ceil($total / $parPage) : $currentPage;
        
        $sql="SELECT * FROM dev_report ORDER BY id DESC LIMIT " . ($currentPage - 1) * $parPage . ',' . $parPage;   
        $req = $DB->prepare($sql);
        $req->execute();


        while ($d = $req->fetch(PDO::FETCH_OBJ)):
?>

        <div id="Post<?php echo $d->id; ?>" class="reportDev">
            <div style=" background:  #0A0501; border: #080301 1px solid; margin-bottom: 5px; margin-left: 3px; padding: 1px; ">
                <p style="color:orange;"><span style="color:#ffff00; font-size: 10px;"><?php echo getTypeDebug($d->type); ?></span><?php echo $d->titre; ?></p>
                <p style="color: #E5EFFD; padding-left: 5px; font-size: 10px;"><?php echo $d->content; ?></p>
                <p style="color: #E5EFFD; padding-left: 5px; font-size: 10px;">Débugué par <span style="color: #FFBD69"><?php echo getMainPerso($CHARS, $DB, $d->gmId); ?> </span>le <span style="color: #FFBD69"><?php echo convertTime($d->date); ?></span>  </p>
            </div>
        </div>
    
<?php endwhile; ?>

    </div>
    <div style="float: left; width: 400px;; height: 20px; display: block;">
        <?php
            $next = ($currentPage * $parPage < $total) ? '| Page Suivante >>>' : null;
            $prev = ($currentPage > 1) ? '<<< Page Precédente |' : null;
        ?>
        <a href="index.php?page=devReport&&list=<?php echo $currentPage - 1; ?>"><?php echo $prev; ?></a>
        <a href="index.php?page=devReport&&list=<?php echo $currentPage + 1; ?>"><?php echo $next; ?></a>
    </div>
</div>