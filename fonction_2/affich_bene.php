<?php
session_start();
require '../connexion/db_connect.php';
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
/* Vérification des paramètres */
if (!isset($_GET['type'], $_GET['id'])) {
    die("❌ Paramètres manquants");
}

$type = $_GET['type'];
$id = (int) $_GET['id'];

/* Requête selon mission ou événement (conforme au MCD) */
if ($type === 'mission') {
    $sql = "
        SELECT p.nom, p.prenom, p.mail, p.telephone
        FROM AFFECTE_A_MISSION am
        JOIN BENEVOLE b ON am.idPersonne = b.idPersonne
        JOIN PERSONNE p ON b.idPersonne = p.idPersonne
        WHERE am.idMission = ?
    ";
} elseif ($type === 'evenement') {
    $sql = "
        SELECT p.nom, p.prenom, p.mail, p.telephone
        FROM PARTICIPE_A_EVENEMENT pe
        JOIN BENEVOLE b ON pe.idPersonne = b.idPersonne
        JOIN PERSONNE p ON b.idPersonne = p.idPersonne
        WHERE pe.idEvenement = ?
    ";
} else {
    die('❌ Type invalide');
}

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$benevoles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bénévoles inscrits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <link rel="icon" type="image/png" href="../logo/asso-logo.png">
</head>
<body class="container mt-4">
<div class="container mt-5 pt-4">
<h2 class="mb-4">👥 Bénévoles inscrits à cette <?= htmlspecialchars($type) ?>
</h2>
<?php if (count($benevoles) === 0): ?>
    <p>
        Aucun bénévole inscrit pour le moment.</p>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($benevoles as $b): ?>
                <tr>
                    <td><?= htmlspecialchars($b['nom']) ?></td>
                    <td><?= htmlspecialchars($b['prenom']) ?></td>
                    <td><?= htmlspecialchars($b['mail']) ?></td>
                    <td><?= htmlspecialchars($b['telephone']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</div>
<a href="index.php" class="btn btn-secondary mt-3">⬅ Retour</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>