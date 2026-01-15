<?php
session_start();
require '../connexion/db_connect.php';
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Identifiant du bénévole manquant.";
    exit();
}

$id = $_GET['id'];

try {
    // Commencer une transaction
    $pdo->beginTransaction();
    // Supprimer les enregistrements liés dans les tables dépendantes si nécessaire
    // Ici, on suppose que les contraintes de clé étrangère sont en place avec ON DELETE CASCADE,
    // sinon il faudrait supprimer manuellement les enregistrements liés dans d'autres tables.
    // Supprimer le bénévole dans la table BENEVOLE
    $stmt = $pdo->prepare("DELETE FROM BENEVOLE WHERE idPersonne = :id");
    $stmt->execute([':id' => $id]);
    // Supprimer la personne dans la table PERSONNE
    $stmt = $pdo->prepare("DELETE FROM PERSONNE WHERE idPersonne = :id");
    $stmt->execute([':id' => $id]);
    // Valider la transaction
    $pdo->commit();

    header("Location: index.php");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erreur lors de la suppression du bénévole : " . htmlspecialchars($e->getMessage());
    exit();
}
?>