<div id="membre" class="news">
            <div class="headNews"> 
                <span>Administration</span>
            </div>
    <div class="middleNews">

 <?php   
    if(verifPermissionAccess($REALM,$_SESSION['id'],levelAccessAdministration)){

        header('Location: index.php?page=admin');

    }else{
         header('Location: index.php');
    }
?>

</div>

</div>
