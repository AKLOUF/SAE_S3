<?php
session_start();
require '../connexion/db_connect.php';

// Vérification du rôle
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

// Récupérer les meilleurs donateurs (total des dons par donateur)
$stmt = $pdo->query("SELECT p.idPersonne, p.nom, p.prenom, SUM(d.montant) AS total_dons, COUNT(d.idDon) AS nb_dons
                     FROM DON d
                     JOIN DONATEUR da ON d.idPersonne = da.idPersonne
                     JOIN PERSONNE p ON da.idPersonne = p.idPersonne
                     GROUP BY p.idPersonne, p.nom, p.prenom
                     ORDER BY total_dons DESC");

$donateurs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Meilleurs Donateurs</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
<nav class="navbar navbar-dark navbar-custom fixed-top navbar-expand-lg">
        <div class="container-fluid">

            <a class="navbar-brand" href="../page_d'acceuil/acceuil.html">
                <img src="../logo/asso-logo.png" class="logo" alt="">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="affich_subv.php">Voir subventions</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php">Voir partenaires</a></li>
                </ul>

                <div class="d-flex gap-2">
                    <a href="../connexion/liste_fonction.html" class="btn btn-outline-light">Voir autre fonctionnalité</a>
                    <a href="../connexion/logout.php" class="btn btn-outline-light">Déconnexion</a>
                </div>
        </div>
    </div>
</nav>
<h1 class="page-title text-center mb-4">Meilleurs Donateurs</h1>

<div class="card-container">
<?php foreach($donateurs as $d): ?>
    <div class="card">
        <div class="card-header"><h3><?= htmlspecialchars($d['prenom'] . ' ' . $d['nom']) ?></h3></div>
        <ul class="card-content">
            <li><strong>Total des dons :</strong> <?= htmlspecialchars($d['total_dons']) ?> €</li>
            <li><strong>Nombre de dons :</strong> <?= htmlspecialchars($d['nb_dons']) ?></li>
        </ul>
        <div class="card-actions">
            <a href="affich_don_donnateur.php?idPersonne=<?= $d['idPersonne'] ?>" class="btn btn-success">Voir dons</a>
        </div>
    </div>
<?php endforeach; ?>
</div>

<div class="text-center">
    <a href="affiche_don.php" class="back-link">⬅ Retour à l'historique des dons</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>