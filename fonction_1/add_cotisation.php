<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php'; // Assure-toi que ce fichier contient la connexion PDO

// Récupérer les bénévoles pour la liste déroulante
$stmt = $pdo->query("SELECT b.idPersonne, p.nom, p.prenom 
                     FROM BENEVOLE b 
                     JOIN PERSONNE p ON b.idPersonne = p.idPersonne");
$benevoles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une cotisation</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
<h1 class="mt-2">Ajouter une cotisation</h1>

<form method="post" action="save_cotisation.php" class="form-container">
    <div class="form-group">
        <label for="idBenevole">Bénévole:</label>
        <select id="idBenevole" name="idBenevole" required class="form-control">
            <?php foreach($benevoles as $b): ?>
                <option value="<?= $b['idPersonne'] ?>">
                    <?= htmlspecialchars($b['nom'] . ' ' . $b['prenom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="montant">Montant:</label>
        <input type="number" step="0.01" id="montant" name="montant" required class="form-control">
    </div>

    <div class="form-group">
        <label for="annee">Année:</label>
        <input type="number" id="annee" name="annee" required class="form-control">
    </div>

    <div class="form-group">
        <label for="date_paiement">Date paiement:</label>
        <input type="date" id="date_paiement" name="date_paiement" required class="form-control">
    </div>

    <div class="form-group">
        <label for="date_echeance">Date échéance:</label>
        <input type="date" id="date_echeance" name="date_echeance" required class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>
<div class="text-center">
    <a href="index.php">&larr; Retour au tableau de bord</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>