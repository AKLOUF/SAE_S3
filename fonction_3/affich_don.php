<?php
session_start();
require '../connexion/db_connect.php';

// Vérification du rôle
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

// Récupérer les donateurs pour le filtre avec jointure sur PERSONNE
$donateurs = $pdo->query("SELECT p.idPersonne, p.nom, p.prenom FROM DONATEUR d JOIN PERSONNE p ON d.idPersonne = p.idPersonne ORDER BY p.nom ASC")->fetchAll();

$selectedDonateur = isset($_GET['idPersonne']) ? $_GET['idPersonne'] : '';

// Préparer la requête pour récupérer les dons avec jointure sur PERSONNE
if ($selectedDonateur) {
    $stmt = $pdo->prepare("SELECT d.idDon, d.montant, d.date_, p.nom, p.prenom 
                           FROM DON d 
                           JOIN DONATEUR da ON d.idPersonne = da.idPersonne 
                           JOIN PERSONNE p ON da.idPersonne = p.idPersonne
                           WHERE p.idPersonne = ?");
    $stmt->execute([$selectedDonateur]);
} else {
    $stmt = $pdo->query("SELECT d.idDon, d.montant, d.date_, p.nom, p.prenom
                         FROM DON d 
                         JOIN DONATEUR da ON d.idPersonne = da.idPersonne
                         JOIN PERSONNE p ON da.idPersonne = p.idPersonne");
}

$dons = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Historique des Dons</title>
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
                    <li class="nav-item"><a class="nav-link" href="add_don.php">Ajouter un don</a></li>
                    <li class="nav-item"><a class="nav-link" href="affich_meilleurs_donnateurs.php">Voir les meilleurs donateurs</a></li>
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
<h1 class="page-title text-center mb-4 mt-4">Historique des Dons</h1>
<div class="mb-3">
    <a href="export_don.php?type=pdf" class="btn btn-danger">Exporter en PDF</a>
    <a href="export_don.php?type=csv" class="btn btn-danger">Exporter en CSV</a>
</div>

<form method="get" class="mb-4">
    <label>Filtrer par donateur :
        <select name="idPersonne" onchange="this.form.submit()">
            <option value="">-- Tous les donateurs --</option>
            <?php foreach($donateurs as $d): ?>
                <option value="<?= $d['idPersonne'] ?>" <?= ($selectedDonateur == $d['idPersonne']) ? 'selected' : '' ?>><?= htmlspecialchars($d['prenom'] . ' ' . $d['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
</form>

<div class="card-container">
<?php foreach($dons as $don): ?>
    <div class="card">
        <div class="card-header"><h3><?= htmlspecialchars($don['prenom'] . ' ' . $don['nom']) ?></h3></div>
        <ul class="card-content">
            <li><strong>Montant :</strong> <?= htmlspecialchars($don['montant']) ?> €</li>
            <li><strong>Date :</strong> <?= htmlspecialchars($don['date_']) ?></li>
        </ul>
        <div class="card-actions">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>     
            <a href="modify_don.php?id=<?= $don['idDon'] ?>" class="btn-primary btn">Modifier</a>
            <a href="delete_don.php?id=<?= $don['idDon'] ?>" class="btn-danger btn" onclick="return confirm('Voulez-vous vraiment supprimer ce don ?')">Supprimer</a>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>