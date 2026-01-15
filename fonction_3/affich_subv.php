<?php
session_start();
require '../connexion/db_connect.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

// Récupérer les partenaires pour le filtre
$partenaires = $pdo->query("SELECT idPart, nom FROM PARTENAIRE ORDER BY nom ASC")->fetchAll();

$selectedPartenaire = isset($_GET['idPart']) ? $_GET['idPart'] : '';

// Préparer la requête pour récupérer les subventions
if ($selectedPartenaire) {
    $stmt = $pdo->prepare("SELECT s.idSub, s.nom_sub, s.montant, s.annee, p.nom AS partenaire_nom 
                           FROM SUBVENTION s 
                           JOIN RECOIT_SUBVENTION r ON s.idSub = r.idSub 
                           JOIN PARTENAIRE p ON r.idPart = p.idPart 
                           WHERE p.idPart = ?");
    $stmt->execute([$selectedPartenaire]);
} else {
    $stmt = $pdo->query("SELECT s.idSub, s.nom_sub, s.montant, s.annee, p.nom AS partenaire_nom 
                         FROM SUBVENTION s 
                         JOIN RECOIT_SUBVENTION r ON s.idSub = r.idSub 
                         JOIN PARTENAIRE p ON r.idPart = p.idPart");
}

$subventions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Subventions</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
<body class="container mt-4">
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
                    <li class="nav-item"><a class="nav-link" href="add_subv.php">Ajouter une subvention</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php">Voir partenaires</a></li>
                    <li class="nav-item"><a class="nav-link" href="affich_don.php">Voir dons</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="../connexion/liste_fonction.html" class="btn btn-outline-light">Voir autre fonctionnalité</a>
                    <a href="../connexion/logout.php" class="btn btn-outline-light">Déconnexion</a>
                </div>
        </div>
    </div>
</nav>
<h1 class="page-title text-center mb-4">Liste des Subventions</h1>
<form class="row-3 g-3 page-actions" method="get">
    <label>Filtrer :</label>
    <select name="idPart" onchange="this.form.submit()">
        <option value="">-- Tous les partenaires --</option>
        <?php foreach($partenaires as $p): ?>
            <option value="<?= $p['idPart'] ?>" <?= ($selectedPartenaire == $p['idPart']) ? 'selected' : '' ?>><?= htmlspecialchars($p['nom']) ?></option>
        <?php endforeach; ?>
    </select>
</form>

<div class="card-container ">
<?php foreach($subventions as $s): ?>
    <div class="card subv-card">
        <h3 class="card-header"><?= htmlspecialchars($s['nom_sub']) ?></h3>
        <ul>
            <li><strong>Montant :</strong> <?= htmlspecialchars($s['montant']) ?> €</li>
            <li><strong>Année :</strong> <?= htmlspecialchars($s['annee']) ?></li>
            <li><strong>Partenaire :</strong> <?= htmlspecialchars($s['partenaire_nom']) ?></li>
        </ul>
        <div class="card-actions">
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>     
        <a href="modify_subv.php?id=<?= $s['idSub'] ?>" class="btn btn-primary">Modifier</a>   
            <a href="delete_subv.php?id=<?= $s['idSub'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette subvention ?');">Supprimer</a>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>