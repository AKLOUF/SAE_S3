<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php';

// Récupérer l'id du donateur depuis l'URL
if (!isset($_GET['idPersonne'])) {
    echo "Aucun donateur sélectionné.";
    exit();
}

$idDonateur = $_GET['idPersonne'];

// Récupérer les informations du donateur
$stmtDonateur = $pdo->prepare("SELECT p.nom, p.prenom FROM PERSONNE p 
                               JOIN DONATEUR d ON p.idPersonne = d.idPersonne
                               WHERE d.idPersonne = ?");
$stmtDonateur->execute([$idDonateur]);
$donateur = $stmtDonateur->fetch();

if (!$donateur) {
    echo "Donateur introuvable.";
    exit();
}

// Récupérer tous les dons du donateur
$stmtDons = $pdo->prepare("SELECT d.idDon, d.montant, d.date_, d.type_don
                           FROM DON d
                           WHERE d.idPersonne = ?
                           ORDER BY d.date_ DESC");
$stmtDons->execute([$idDonateur]);
$dons = $stmtDons->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dons de <?= htmlspecialchars($donateur['prenom'] . ' ' . $donateur['nom']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body class="container mt-4">
<div class="container mt-5 pt-4">
<h2 class="mb-4">Dons de <?= htmlspecialchars($donateur['prenom'] . ' ' . $donateur['nom']) ?></h2>
    <?php if(count($dons) === 0): ?>
        <p>Aucun don enregistré pour ce donateur.</p>
    <?php else: ?>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID Don</th>
                    <th>Montant (€)</th>
                    <th>Date</th>
                    <th>Type de don</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dons as $don): ?>
                <tr>
                    <td><?= htmlspecialchars($don['idDon']) ?></td>
                    <td><?= htmlspecialchars($don['montant']) ?></td>
                    <td><?= htmlspecialchars($don['date_']) ?></td>
                    <td><?= htmlspecialchars($don['type_don']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<a href="affich_meilleurs_donnateurs.php" class="btn btn-secondary mt-3">⬅ Retour aux donateurs</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>