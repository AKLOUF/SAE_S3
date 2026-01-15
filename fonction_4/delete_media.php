<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

require '../connexion/db_connect.php';

/*
🔒 Sécurité (optionnel)
*/
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     exit('Accès refusé');
// }

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: affich_media.php");
    exit;
}

$idMedia = (int) $_GET['id'];

/* Récupération du média */
$sql = "SELECT url_media FROM media WHERE idMedia = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $idMedia]);
$media = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$media) {
    header("Location: affich_media.php");
    exit;
}

/* Suppression du fichier physique */
if (!empty($media['url_media']) && file_exists($media['url_media'])) {
    unlink($media['url_media']);
}

/* Suppression des liens actualité ↔ média */
$sqlLink = "DELETE FROM actualite_media WHERE idMedia = :id";
$stmtLink = $pdo->prepare($sqlLink);
$stmtLink->execute([':id' => $idMedia]);

/* Suppression du média */
$sqlDelete = "DELETE FROM media WHERE idMedia = :id";
$stmtDelete = $pdo->prepare($sqlDelete);
$stmtDelete->execute([':id' => $idMedia]);

header("Location: affich_media.php");
exit;