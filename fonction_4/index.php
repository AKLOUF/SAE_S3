<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

require '../connexion/db_connect.php';

// récupération des actualités
$sql = "SELECT idActu, titre, contenu, date_publication
        FROM actualite
        ORDER BY date_publication DESC";

$stmt = $pdo->query($sql);
$actualites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Actualités</title>
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
                    <li class="nav-item"><a class="nav-link" href="add_actu.php">Ajouter une actualité</a></li>
                    <li class="nav-item"><a class="nav-link" href="affich_media.php">Voir média</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="../connexion/liste_fonction.html" class="btn btn-outline-light">Voir autre fonctionnalité</a>
                    <a href="../connexion/logout.php" class="btn btn-outline-light">Déconnexion</a>
                </div>
        </div>
    </div>
</nav>
<h1 class="page-title text-center mb-4">📰 Actualités</h1>
<div class="card-container mt-4">
<?php if (count($actualites) === 0): ?>
    <p>Aucune actualité disponible.</p>
<?php else: ?>
    <?php foreach ($actualites as $actu): ?>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><?= htmlspecialchars($actu['titre']) ?></h3>
            </div>
            <ul class="card-content mt-2">
                <li class="meta">
                    <?php if (!empty($actu['date_publication'])): ?>
                        Publié le <?= date("d/m/Y", strtotime($actu['date_publication'])) ?>
                    <?php else: ?>
                        Date de publication non définie
                    <?php endif; ?>
                </li>
            <li><?= nl2br(htmlspecialchars($actu['contenu'])) ?></li>

            </ul>
            <div class="card-actions">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>     
                <a href="modify_actu.php?id=<?= $actu['idActu'] ?>" class="btn btn-primary">✏️ Modifier</a>
                <a href="delete_actu.php?id=<?= $actu['idActu'] ?>"
                   class="btn btn-danger"
                   onclick="return confirm('Voulez-vous vraiment supprimer cette actualité ?');">
                   🗑 Supprimer
                </a>
            <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>