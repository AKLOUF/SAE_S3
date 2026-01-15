<?php
session_start();
require '../connexion/db_connect.php';

// Vérification du rôle
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID du partenaire manquant.");
}

$idPartenaire = $_GET['id'];

try {
    // Supprimer le partenaire
    $stmt = $pdo->prepare("DELETE FROM PARTENAIRE WHERE idPart = ?");
    $stmt->execute([$idPartenaire]);

    header("Location: affiche_partenaire.php");
    exit();
} catch (Exception $e) {
    die("Erreur lors de la suppression du partenaire : " . $e->getMessage());
}