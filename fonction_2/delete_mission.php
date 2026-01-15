<?php
session_start();
require '../connexion/db_connect.php';
// Vérification de la session
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de la mission manquant.");
}

$idMission = $_GET['id'];

try {
    // Commencer la transaction
    $pdo->beginTransaction();

    // Supprimer les participations liées si nécessaire (exemple : table affectation_benevole)
    $stmt = $pdo->prepare("DELETE FROM AFFECTE_A_MISSION WHERE idMission = ?");
    $stmt->execute([$idMission]);

    // Supprimer la mission
    $stmt = $pdo->prepare("DELETE FROM MISSION WHERE idMission = ?");
    $stmt->execute([$idMission]);

    $pdo->commit();

    header("Location: index.php");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Erreur lors de la suppression de la mission : " . $e->getMessage());
}