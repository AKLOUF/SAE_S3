<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

require '../connexion/db_connect.php';

// Vérifier la présence de l'id de l'actualité
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID d'actualité invalide.");
}

$idActu = (int) $_GET['id'];

try {
    // ⚠️ Supprimer d'abord les liaisons dans actualite_media
    $sqlMedia = "DELETE FROM actualite_media WHERE idActu = :idActu";
    $stmtMedia = $pdo->prepare($sqlMedia);
    $stmtMedia->execute(['idActu' => $idActu]);

    // Supprimer l'actualité
    $sqlActu = "DELETE FROM actualite WHERE idActu = :idActu";
    $stmtActu = $pdo->prepare($sqlActu);
    $stmtActu->execute(['idActu' => $idActu]);

    // Redirection après suppression
    header("Location: index.php?delete=success");
    exit;

} catch (PDOException $e) {
    die("Erreur lors de la suppression : " . $e->getMessage());
}