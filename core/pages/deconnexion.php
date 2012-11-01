<?php

if($_SESSION['name'] && $_SESSION['accountLevel']){
        $_SESSION['id'] = false;
        $_SESSION['name'] = '';
        $_SESSION['mainPseudo'] = '';
        $_SESSION['mail'] = '';
        $_SESSION['accountLevel'] = '';
        $_SESSION['ipAdress'] = '';
        $_SESSION['lastConection'] = '';
        $_SESSION['idParrain'] = '';
        session_destroy();
        header('Location: index.php');
    session_destroy();
}else{
      header('Location: index.php');
}
