<?php
if (isset($_GET['commAdd']) && $_GET['commAdd'] == 1) {
    if (!empty($_POST)) {
        extract($_POST);
// Ajout du commentaire (on ne modifie pas pour garder la traçabilité

        if (!is_numeric($_GET['ticketId'])) {
            header('Location: index.php?page=gestTickets');
        }

        $id = $_GET['ticketId'];

        $sql0 = "SELECT MAX(numero) AS NbrMaxCommentaires FROM ticketscommentaires WHERE idtickets = $id";
        $req0 = $DB->query($sql0);

        $d = $req0->fetch(PDO::FETCH_OBJ);

        $nbr = $d->NbrMaxCommentaires + 1;


        $sql = "INSERT INTO `ticketscommentaires` ( `idtickets`, `numero`,`datecommentaire`, `proprioId`,`commentaire`) VALUES ( :tickets, :numero, now(), :idUser, :commentaire)";
        $req = $DB->prepare($sql);

        $req->execute(array(
            'tickets' => $_GET['ticketId'],
            'numero' => $nbr,
            'idUser' => $_SESSION['id'],
            'commentaire' => $message,
        ));

        unset($_POST['tickets']);
        ?>
        <fieldset>   
            <legend> Commentaire posté avec succés</legend>
            <br/>
            <h2 style="color:green;">Félicitations opération réussie!! </h2>			
        </fieldset>

        <?php
    } else {
        echo "<span class='erreurFormulaire'  color='red'>Veuillez remplir le champ.</span>;";
    }
}




if (isset($_GET['ticketId']) && is_numeric($_GET['ticketId'])) {

    $req = $DB->prepare("SELECT * FROM ticketscommentaires WHERE idtickets = :idTicket AND numero=1");
    $req->execute(array('idTicket' => $_GET['ticketId']));


    while ($data = $req->fetch(PDO::FETCH_OBJ)):
        ?>

        <div id="ticket<?php echo $data->numero; ?>" class="news">
            <div class="headNews"> <span> <?php echo recupobjetliste($DB, 'tickets', 'tickets', $data->idtickets, null) ?></span>
            </div>
            <div class="middleNews" style=" min-height: 80px;">
            <div class="corpNews" style=" min-height: 80px; color: white; text-shadow:none; font-weight:lighter;">
                <p>
        <?php echo $data->commentaire; ?>
                </p>
            </div>
            <div class="footNews">
                <a class="linkNews" href="index.php?page=gestTickets">Revenir en arrière</a>
            </div>                            
        </div>
        </div>

        <a NAME="comments"></a>
    <?php endwhile; ?>

    <?php
    if (isset($_SESSION['name']) && isset($_SESSION['accountLevel'])) {
        if (POSTES_ACTIVES == 1) {

            $req = $DB->prepare("SELECT * FROM ticketscommentaires WHERE idtickets = :idTicket");
            $req->execute(array('idTicket' => $_GET['ticketId']));

            while ($d = $req->fetch(PDO::FETCH_OBJ)):
                if ($d->numero > 1) {
                    ?>

                    <div style=" border: 1px saddlebrown solid; margin: 3px; padding: 4px;font-size:10px; line-height: 11px; vertical-align: top; background-color:#28221c; color: #6c3b22;" name="contentTickets2">
                        <p style="font-size: 12px; text-transform: uppercase; color:gold;">Commentaire posté le <?php echo convertTime($d->datecommentaire) . " par " . getMainPerso($CHARS, $DB, $d->proprioId); ?></p>
                        <hr/>
                        <div style="color:white;"><?php echo $d->commentaire; ?></div>
                    </div>

                    <?php
                } endwhile;
            ?>
            <form class="postComm" action="index.php?page=viewTicket&&ticketId=<?php echo $_GET['ticketId']; ?>&&commAdd=1" method="post"> 
                <fieldset>
                    <legend>Message</legend>
                    <input type="hidden" name="id" value="<?php echo $_GET['ticketId']; ?>"/>
                    <textarea cols="60" rows="8"  name="message" class="champ_message" onclick="this.focus(); this.select();"></textarea>
                </fieldset>
                <input type="submit" value="Poster" class="send"/>
            </form>
            <?php } else { ?>
            <span class="erreurFormulaire"> Les commentaires ont été désacivés</span>
        <?php }
    } else { ?>
        <span class="erreurFormulaire">Vos devez vos connecter pour voir les commentaires.</span>
    <?php
    }
} else {
    header('Location: index.php?page=gestTickets');
}