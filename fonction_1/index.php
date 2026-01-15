<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php';
// Gestion des filtres
$where = [];
$params = [];

if(!empty($_GET['ville'])) {
    $where[] = "p.ville = :ville";
    $params[':ville'] = $_GET['ville'];
}
if(!empty($_GET['profession'])) {
    $where[] = "p.profession = :profession";
    $params[':profession'] = $_GET['profession'];
}
if(!empty($_GET['age_min'])) {
    $where[] = "TIMESTAMPDIFF(YEAR, p.date_naissance, CURDATE()) >= :age_min";
    $params[':age_min'] = $_GET['age_min'];
}
if(!empty($_GET['age_max'])) {
    $where[] = "TIMESTAMPDIFF(YEAR, p.date_naissance, CURDATE()) <= :age_max";
    $params[':age_max'] = $_GET['age_max'];
}
if(!empty($_GET['disponibilite'])) {
    $where[] = "b.disponibilite LIKE :disponibilite";
    $params[':disponibilite'] = '%' . $_GET['disponibilite'] . '%';
}

// Requête principale
$sql = "
SELECT p.idPersonne, p.nom, p.prenom, p.date_naissance, p.ville, p.adresse, p.profession,p.telephone,p.mail,p.code_postal,TIMESTAMPDIFF(YEAR, p.date_naissance, CURDATE()) AS age,b.competence,
       b.regime_alimentaire, b.limitation_physique, b.date_adhesion, b.statut_actif, b.disponibilite,
       GROUP_CONCAT(DISTINCT m.nom_mission SEPARATOR ', ') AS missions_realisees,
       GROUP_CONCAT(DISTINCT CONCAT(co.montant, '€ pour l\'année ', vc.annee) SEPARATOR ' | ') AS cotisations
FROM BENEVOLE b
JOIN PERSONNE p ON b.idPersonne = p.idPersonne
LEFT JOIN AFFECTE_A_MISSION am ON am.idPersonne = b.idPersonne
LEFT JOIN MISSION m ON m.idMission = am.idMission
LEFT JOIN VERSE_COTISATION vc ON vc.idPersonne = b.idPersonne
LEFT JOIN COTISATION co ON vc.idCot = co.idCot
";

if($where) {
    $sql .= " WHERE " . implode(' AND ', $where);
}

$sql .= " GROUP BY p.idPersonne ORDER BY p.nom, p.prenom";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$benevoles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord des bénévoles</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
                    <li class="nav-item"><a class="nav-link" href="add_benevole.php">Ajouter un bénévole</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_cotisation.php">Ajouter une cotisation</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="../connexion/liste_fonction.html" class="btn btn-outline-light">Voir autre fonctionnalité</a>
                    <a href="../connexion/logout.php" class="btn btn-outline-light">Déconnexion</a>
                </div>
        </div>
    </div>
</nav>

<h1 class="page-title text-center mb-4">👥 Liste des bénévoles</h1>

<form method="get" class="row g-3 mb-4">
    <div class="col-md-2">
        <input type="text" name="ville" class="form-control" placeholder="Ville" value="<?= htmlspecialchars($_GET['ville'] ?? '') ?>">
    </div>
    <div class="col-md-2">
        <input type="text" name="profession" class="form-control" placeholder="Profession" value="<?= htmlspecialchars($_GET['profession'] ?? '') ?>">
    </div>
    <div class="col-md-2">
        <input type="number" name="age_min" class="form-control" placeholder="Âge min" value="<?= htmlspecialchars($_GET['age_min'] ?? '') ?>">
    </div>
    <div class="col-md-2">
        <input type="number" name="age_max" class="form-control" placeholder="Âge max" value="<?= htmlspecialchars($_GET['age_max'] ?? '') ?>">
    </div>
    <div class="col-md-3">
        <input type="text" name="disponibilite" class="form-control" placeholder="Disponibilité" value="<?= htmlspecialchars($_GET['disponibilite'] ?? '') ?>">
    </div>
    <div class="col-md-1 d-grid">
        <button class="btn btn-primary" type="submit">Filtrer</button>
    </div>
</form>
<div class="card-container">

<?php foreach ($benevoles as $b): ?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><?= htmlspecialchars($b['prenom']) ?> <?= htmlspecialchars($b['nom']) ?></h3>
            <span class="badge bg-secondary"><?= htmlspecialchars($b['statut_actif'] ? 'Actif' : 'Inactif') ?></span>
        </div>

        <ul class="card-content">
            <li><strong>Mail :</strong> <?= htmlspecialchars($b['mail']) ?: '—' ?></li>
            <li><strong>Téléphone :</strong> <?= htmlspecialchars($b['telephone']) ?: '—' ?></li>
            <li><strong>Ville :</strong> <?= htmlspecialchars($b['ville']) ?></li>
            <li><strong>Code postal :</strong> <?= htmlspecialchars($b['code_postal']) ?></li>
            <li><strong>Profession :</strong> <?= htmlspecialchars($b['profession']) ?></li>
            <li><strong>Âge :</strong> <?= htmlspecialchars($b['age']) ?> ans</li>
            <li><strong>Régime :</strong> <?= htmlspecialchars($b['regime_alimentaire']) ?></li>
            <li><strong>Compétences :</strong> <?= htmlspecialchars($b['competence']) ?></li>
            <li><strong>Disponibilités :</strong> <?= htmlspecialchars($b['disponibilite']) ?></li>
        </ul>
        <?php if ($_SESSION['role'] === "admin"): ?> 
        <div class="card-actions">
            <a href="modify_benevole.php?id=<?= $b['idPersonne'] ?>" class="btn btn-primary">Modifier</a>
            <a href="delete_benevole.php?id=<?= $b['idPersonne'] ?>" class="btn btn-danger"
            onclick="return confirm('Voulez-vous supprimer ce bénévole ?');">Supprimer</a>
        </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>