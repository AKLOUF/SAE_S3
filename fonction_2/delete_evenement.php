<?php
session_start();
require '../connexion/db_connect.php';
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de l'événement manquant.");
}

$idEvenement = $_GET['id'];

try {
    $pdo->beginTransaction();

    // Supprimer les participations liées si nécessaire (exemple : table affectation_benevole)
    $stmt = $pdo->prepare("DELETE FROM PARTICIPE_A_EVENEMENT WHERE idEvenement = ?");
    $stmt->execute([$idEvenement]);

    // Supprimer l'événement
    $stmt = $pdo->prepare("DELETE FROM EVENEMENT WHERE idEvenement = ?");
    $stmt->execute([$idEvenement]);

    $pdo->commit();

    header("Location: index.php");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Erreur lors de la suppression de l'événement : " . $e->getMessage());
}