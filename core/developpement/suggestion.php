<?php    
    if(!verifPermissionAccess($REALM,$_SESSION['id'],0) && !isset($_SESSION['Administrateur'])){
       header('Location: index.php');
    }
?>
<div id="projetEnCours">
    <p style =" font-size: 40px; color: #ffebb6;"> DEVELOPPEMENT<span style =" font-size: 16px; color: #c8c8c8;">FAIRE UNE SUGGESTION</span></p><hr style="margin-top: -32px;" />
</div>

<fieldset>   
    <legend>Donnez vous iddées au staff afin qu'elles se réalisent peut-être...</legend>

</fieldset>