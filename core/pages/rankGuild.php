<div id="membre" class="news">
            <div class="headNews"> 
                <span>Venez connaitres les meilleurs guildes du serveur</span>
            </div>
    <div class="middleNews">
        
        <fieldset>
       <legend>Top guildes</legend> 
             <table class="voteTop" style="border:none">
                <thead>
                <th width='140'><strong>Nom</strong></th>
                <th width='40'><strong>Niveau</strong></th>
                <th width='140'><strong>Nbr de membres</strong></th>
                <th width='140'><strong>Chef de guilde</strong></th>
                <th width='140'><strong>Date de création</strong></th>
                </thead>

<?php
            $req = $CHARS->prepare("SELECT * FROM guild ORDER BY level DESC ");
            $req->execute();
            while ($d = $req->fetch(PDO::FETCH_OBJ)) {
?>
                <tr style=" font-size:12px; color: #FFF;">
                    <td> <?php echo ucfirst($d->name);  ?></td>
                    <td> <?php echo $d->level; ?></td>
                    <td> <?php echo getNbrMembersGuild($CHARS,$d->guildid); ?></td>
                    <td> <?php echo getNameGuid($CHARS,$d->leaderguid); ?></td>
                    <td> <?php echo date('j',$d->createdate).' '.getMoth(date('n',$d->createdate)).' '.date('Y',$d->createdate); ?></td>
                </tr>
            <?php  } ?>

        </table>
       </fieldset>
</div>
</div>
