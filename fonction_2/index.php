<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php';

/* Récupération des missions */
$stmtMissions = $pdo->query("
    SELECT m.idMission, m.nom_mission, m.date_debut, m.date_fin, l.ville, l.code_postal, l.region, l.adresse_detail, m.budget, m.materiel_necessaire, m.description
    FROM MISSION m
    JOIN LIEU l ON m.idlieu = l.idLieu
    ORDER BY m.date_debut DESC
");
$missions = $stmtMissions->fetchAll();

/* Récupération des événements */
$stmtEvenements = $pdo->query("
    SELECT e.idEvenement, e.nom_evenement, e.date_heure, l.ville, l.code_postal, l.region, l.adresse_detail, e.budget, e.materiel_necessaire, e.description
    FROM EVENEMENT e
    JOIN LIEU l ON e.idlieu = l.idLieu
    ORDER BY e.date_heure DESC
");
$evenements = $stmtEvenements->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Missions & Événements</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="../logo/asso-logo.png">
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
                    <li class="nav-item"><a class="nav-link" href="add_evenement.php">Ajouter un evenement</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_mission.php">Ajouter une mission</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="../connexion/liste_fonction.html" class="btn btn-outline-light">Voir autre fonctionnalité</a>
                    <a href="../connexion/logout.php" class="btn btn-outline-light">Déconnexion</a>
                </div>
        </div>
    </div>
</nav>
<h1 class="page-title text-center mb-4">📅 Missions & Événements</h1>

<ul class="nav nav-tabs mb-4">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" onclick="openTab(event, 'evenements')">EVENEMENT</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" onclick="openTab(event , 'missions')">MISSION</a>
  </li>
</ul>

<!-- Onglet Événements -->

<div id="evenements" class="tab-content" style="display: block;">
    <div class="card-container">
    <?php foreach ($evenements as $e): ?>
        <div class="card">
            <div class="card-header">
                <h3><?= htmlspecialchars($e['nom_evenement']) ?></h3>
                <span class="badge text-dark">Événement</span>
            </div>

            <ul class="card-content">
                <li><strong>Date :</strong> <?= htmlspecialchars($e['date_heure']) ?></li>
                <li><strong>Lieu :</strong> <?= htmlspecialchars($e['ville']) ?>, <?= htmlspecialchars($e['code_postal']) ?>, <?= htmlspecialchars($e['region']) ?>, <?= htmlspecialchars($e['adresse_detail']) ?></li>
                <li><strong>Budget :</strong> <?= htmlspecialchars($e['budget']) ?> €</li>
                <li><strong>Matériel :</strong> <?= htmlspecialchars($e['materiel_necessaire']) ?></li>
                <li><strong>Description :</strong> <?= htmlspecialchars($e['description']) ?></li>
            </ul>
            <div class="card-actions">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>    
            <a href="modify_evenement.php?id=<?= $e['idEvenement'] ?>" class="btn btn-primary">Modifier</a>
                <a href="delete_evenement.php?id=<?= $e['idEvenement'] ?>" class="btn btn-danger"
                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">Supprimer</a>
                <?php endif; ?>
                <a href="affich_bene.php?type=evenement&id=<?= $e['idEvenement'] ?>" class="btn btn-info">Bénévoles</a>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<!-- Onglet Missions -->

<div id="missions" class="tab-content" style="display: none;">
    <div class="card-container">
    <?php foreach ($missions as $e): ?>
        <div class="card">
            <div class="card-header">
                <h3><?= htmlspecialchars($e['nom_mission']) ?></h3>
                <span class="badge text-dark">Mission</span>
            </div>

            <ul class="card-content">
                <li><strong>Date début :</strong> <?= htmlspecialchars($e['date_debut']) ?></li>
                <li><strong>Date fin :</strong> <?= htmlspecialchars($e['date_fin']) ?></li>
                <li><strong>Lieu :</strong> <?= htmlspecialchars($e['ville']) ?>, <?= htmlspecialchars($e['code_postal']) ?>, <?= htmlspecialchars($e['region']) ?>, <?= htmlspecialchars($e['adresse_detail']) ?></li>
                <li><strong>Budget :</strong> <?= htmlspecialchars($e['budget']) ?> €</li>
                <li><strong>Matériel :</strong> <?= htmlspecialchars($e['materiel_necessaire']) ?></li>
                <li><strong>Description :</strong> <?= htmlspecialchars($e['description']) ?></li>
            </ul>

            <div class="card-actions">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="modify_mission.php?id=<?= $e['idMission'] ?>" class="btn btn-primary">Modifier</a>
                <a href="delete_mission.php?id=<?= $e['idMission'] ?>" class="btn btn-danger"
                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette mission ?');">Supprimer</a>
                <?php endif; ?>
                <a href="affich_bene.php?type=mission&id=<?= $e['idMission'] ?>" class="btn btn-info">Bénévoles</a>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<div class="page-actions">
    
    
</div>
<script src="../tab.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>