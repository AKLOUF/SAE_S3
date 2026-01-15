<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

require '../connexion/db_connect.php';


// Récupérer tous les partenaires
$partenaires = $pdo->query("SELECT * FROM PARTENAIRE ORDER BY nom ASC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Partenaires</title>
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
                    <li class="nav-item"><a class="nav-link" href="add_part.php">Ajouter un partenaire</a></li>
                    <li class="nav-item"><a class="nav-link" href="affich_subv.php">Voir subventions</a></li>
                    <li class="nav-item"><a class="nav-link" href="affich_don.php">Voir dons</a></li>
                </ul>

                <div class="d-flex gap-2">
                    <a href="../connexion/liste_fonction.html" class="btn btn-outline-light">Voir autre fonctionnalité</a>
                    <a href="../connexion/logout.php" class="btn btn-outline-light">Déconnexion</a>
                </div>
        </div>
    </div>
</nav>
<h1 class="page-title text-center mb-4 mt-3">Liste des partenaires</h1>
<hr>
<div class="card-container mt-4">
<?php foreach($partenaires as $p): ?>
    <div class="card">
        <div class="card-header">
            <h3><?= htmlspecialchars($p['nom']) ?></h3>
            <span class="badge text-dark"><?= htmlspecialchars($p['type_partenaire']) ?></span>
        </div>

        <ul class="card-content">
            <li><strong>Email :</strong> <?= htmlspecialchars($p['contact']) ?></li>
            <li><strong>Secteur :</strong> <?= htmlspecialchars($p['secteur']) ?></li>
            <li><strong>Date de début du partenariat :</strong> <?= htmlspecialchars($p['date_debut_partenariat']) ?></li>
        </ul>

        <div class="card-actions">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>     
            <a href="modify_part.php?id=<?= $p['idPart'] ?>" class="btn btn-primary">Modifier</a>
            <a href="delete_part.php?id=<?= $p['idPart'] ?>" class="btn btn-danger"
               onclick="return confirm('Voulez-vous vraiment supprimer ce partenaire ?')">Supprimer</a>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>