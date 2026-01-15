<?php
session_start();
require '../connexion/db_connect.php';

// Vérification du rôle
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

// Vérifier si idDon est fourni
if (!isset($_GET['id'])) {
    echo "Aucun don sélectionné.";
    exit();
}

$idDon = $_GET['id'];

// Récupérer les informations du don
$stmt = $pdo->prepare("SELECT * FROM DON WHERE idDon = ?");
$stmt->execute([$idDon]);
$don = $stmt->fetch();

if (!$don) {
    echo "Don introuvable.";
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $montant = $_POST['montant'];
    $date = $_POST['date_'];
    $type_don = $_POST['type_don'];

    // Mise à jour du don
    $update = $pdo->prepare("UPDATE DON SET montant = ?, date_ = ?, type_don = ? WHERE idDon = ?");
    $update->execute([$montant, $date, $type_don, $idDon]);

    header("Location: affich_don.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier Don</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
<div class="container mt-5">
    <h1 class="page-title text-center mb-4 mt-3">Modifier le don</h1>
    <form method="post">
        <div class="mb-3">
            <label>Montant (€) :</label>
            <input type="number" step="0.01" name="montant" class="form-control" value="<?= htmlspecialchars($don['montant']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Date :</label>
            <input type="date" name="date_" class="form-control" value="<?= htmlspecialchars($don['date_']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Type de don :</label>
            <select name="type_don" class="form-control" required>
                <option value="ponctuel" <?= $don['type_don'] === 'ponctuel' ? 'selected' : '' ?>>Ponctuel</option>
                <option value="mensuel" <?= $don['type_don'] === 'mensuel' ? 'selected' : '' ?>>Mensuel</option>
            </select>
        </div>
        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Modifier</button>
            <button type="button" class="btn btn-danger" onclick="window.location.href='affich_don.php'">Annuler</button>
        </div>
    </form>
</div>
<a href="affich_don.php">⬅ Retour à la liste des dons</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>