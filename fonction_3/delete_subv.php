<?php
session_start();
require '../connexion/db_connect.php';

// Vérification du rôle
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de la subvention manquant.");
}

$idSub = $_GET['id'];

try {
    // Commencer une transaction pour l'intégrité
    $pdo->beginTransaction();

    // Supprimer la relation avec le partenaire
    $stmt = $pdo->prepare("DELETE FROM RECOIT_SUBVENTION WHERE idSub = ?");
    $stmt->execute([$idSub]);

    // Supprimer la subvention
    $stmt = $pdo->prepare("DELETE FROM SUBVENTION WHERE idSub = ?");
    $stmt->execute([$idSub]);

    $pdo->commit();

    header("Location: affich_subv.php");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Erreur lors de la suppression de la subvention : " . $e->getMessage());
}