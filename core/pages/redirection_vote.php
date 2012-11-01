<?php


$points= points;
$link1= link1;
$link2= link2;
$link3= link3;

$verification=false;

$id= $_SESSION['id'];
$top= $_GET['top'];

$sql=  "SELECT * FROM `anti_FakeVote` WHERE `userId` = '$id' AND `top` = '$top'";
$req = $DB->prepare($sql);
$req->execute();

while ($d = $req->fetch(PDO::FETCH_OBJ)) {

if($d->url==$_SESSION['keySec'.$top]){
    $verification=true;
    unset ($_SESSION['keySec'.$top]);
    $id=$d->id;

    $DB->exec("DELETE FROM `anti_FakeVote` WHERE (`id`= $id)");
    }
}

$req->closeCursor();


if($verification==true){


    if (!isset($_GET['top'])) {
        echo '<script language="javascript" type="text/javascript"> window.close(); </script>';
        exit();
    }

    $top = (int) $_GET['top'];
    if (!($top >= 1 && $top <= 3)) {
        echo '<script language="javascript" type="text/javascript"> window.close(); </script>';
        exit();
    }

    $id = $_SESSION['id'];

    if(isset($_SESSION['name']) && isset($_SESSION['accountLevel'])){
        $query = $DB->query("SELECT * FROM users WHERE id=$id");
        $data = $query->fetch();

        if ($top == 1 && (time() - $data['timestamp1']) > 7200) {
            $DB->exec("UPDATE users SET votePoints=votePoints+1, shopPoints=shopPoints+$points, timestamp1=" . time() . " WHERE id='" . $_SESSION['id'] . "'");
            header("Location: $link1");

        } else if ($top == 2 && (time() - $data['timestamp2']) > 7200) {

            $DB->exec("UPDATE users SET votePoints=votePoints+1, shopPoints=shopPoints+$points, timestamp2='" . time() . "' WHERE id='" . $_SESSION['id'] . "'");
            header("Location: $link2");
        } else if ($top == 3 && (time() - $data['timestamp3']) > 3600) {

            $DB->exec("UPDATE users SET votePoints=votePoints+1, shopPoints=shopPoints+$points, timestamp3='" . time() . "'WHERE id='" . $_SESSION['id'] . "'");
            header("Location: $link3");
        }
        else {
            echo '<script language="javascript" type="text/javascript"> window.close(); </script>';
            exit();
        }
    }
}else{
     header('Location: index.php?page=votes');
}
?>