<?php
session_start();
include_once '../includes/conf.php';
$MYSECRETKEY = 'FGHKLPOUT@dsajas67jhkads76';

  $docId              = (int) $_GET['docId'];
  $userId             = addslashes($_GET['uid']);
  $points             = (int) $_GET['awards'];
  $idRefTransaction   = $_GET['trId'];
  $promoId            = ((isset($_GET['promoId'])) ? (int) $_GET['promoId'] : 0 );
  $hash               = $_GET['hash'];
    
# check hash value
  
if (md5($userId . $points . $idRefTransaction . $MYSECRETKEY) == $hash) {

    $rs = $DB->query('SELECT COUNT(1) AS NB FROM logs_achat_points WHERE refTransaction = \'' . addslashes($idRefTransaction) . '\'');
    $ifFindTr = (int) $rs->fetchColumn();
    unset($rs);

    if ($ifFindTr == 0) {
        # all is OK
        # we can add awards to the user and save transaction

        $DB->exec(" UPDATE users SET shopPoints=shopPoints+$points WHERE id=$userId ");
        $DB->query('INSERT INTO logs_achat_points (docId, userId, pointsR, refTransaction, promoId, date) '
                . 'VALUE(' . $docId . ', \'' . addslashes($userId) . '\', ' . $points . ', \'' . addslashes($idRefTransaction) . '\', ' . $promoId . ', NOW())');
        header('Location:index.php?page=boutique');
    } else {

        $DB->query('INSERT INTO logs_erreurs_achat_points (docId, userId, error, refTransaction, promoId, date) '
                . 'VALUE(' . $docId . ', \'' . addslashes($userId) . '\', \'Tentative de duplication de achat\', \'' . addslashes($idRefTransaction) . '\', ' . $promoId . ', NOW())');
        header('Location:index.php');
    }
} else {
    $DB->query('INSERT INTO logs_erreurs_achat_points (docId, userId, error, refTransaction, promoId, date) '
            . 'VALUE(' . $docId . ', \'' . addslashes($userId) . '\', \'Hash incorrect tentative de fraude\', \'' . addslashes($idRefTransaction) . '\', ' . $promoId . ', NOW())');
    header('Location:index.php');
}
?>