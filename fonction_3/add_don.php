<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php';

/* Récupérer les donateurs avec nom et prénom */
$stmtDonateurs = $pdo->query("
    SELECT d.idPersonne, p.nom, p.prenom 
    FROM DONATEUR d
    JOIN PERSONNE p ON d.idPersonne = p.idPersonne
");
$donateurs = $stmtDonateurs->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idDonateur = $_POST['idPersonne'];
    $montant = $_POST['montant'];
    $date_don = $_POST['date_'];
    $type_don = $_POST['type_don'];

    $stmt = $pdo->prepare("INSERT INTO DON (idDon, montant, date_, type_don,idPersonne) VALUES (NULL, ?, ?, ?, ?)");
    $stmt->execute([$montant, $date_don, $type_don, $idDonateur]);

    $idDon = $pdo->lastInsertId();

    $message = "Don ajouté avec succès !";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un don</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
<h1 class="page-title text-center mb-4 mt-3">Ajouter un don</h1>
<div class="container">
    <?php if(isset($message)) echo "<div class='alert alert-success'>$message</div>"; ?>
    <form method="post">
        <div class="mb-3">
            <label for="idPersonne" class="form-label">Donateur</label>
            <select class="form-select" name="idPersonne" required>
                <option value="">Sélectionnez un donateur</option>
                <?php foreach($donateurs as $d): ?>
                    <option value="<?= $d['idPersonne'] ?>"><?= htmlspecialchars($d['nom'].' '.$d['prenom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="montant" class="form-label">Montant (€)</label>
            <input type="number" step="0.01" name="montant" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="date_" class="form-label">Date du don</label>
            <input type="date" name="date_" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="type_don" class="form-label">Type de don</label>
            <select class="form-select" name="type_don" required>
                <option value="">Sélectionnez le type de don</option>
                <option value="Ponctuel">Ponctuel</option>
                <option value="Mensuel">Mensuel</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
<div class="text-center">
    <a href="index.php">⬅ Retour au tableau de bord</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>