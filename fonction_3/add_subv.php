<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

require '../connexion/db_connect.php';

$error = '';
$success = '';

// Récupérer les partenaires pour le select
$partenaires = $pdo->query("SELECT idPart, nom FROM PARTENAIRE ORDER BY nom ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO SUBVENTION (nom_sub, montant, annee) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['nom_sub'],
            $_POST['montant'],
            $_POST['annee']
        ]);

        $idSubvention = $pdo->lastInsertId();

        $stmt2 = $pdo->prepare("INSERT INTO RECOIT_SUBVENTION (idPart, idSub) VALUES (?, ?)");
        $stmt2->execute([
            $_POST['idPart'],
            $idSubvention
        ]);

        $pdo->commit();

        $success = "Subvention ajoutée avec succès.";
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une Subvention</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
<h1 class="mt-3">Ajouter une Subvention</h1>

<?php if($error) echo "<p class='message-error'>$error</p>"; ?>
<?php if($success) echo "<p class='message-success'>$success</p>"; ?>

<form method="post" class="form-container">
    <div class="form-group">
        <label>Nom de la subvention* :</label>
        <input type="text" name="nom_sub" required class="form-control">
    </div>

    <div class="form-group">
        <label>Montant* :</label>
        <input type="number" step="0.01" name="montant" required class="form-control">
    </div>

    <div class="form-group">
        <label>Année* :</label>
        <input type="number" name="annee" required class="form-control">
    </div>

    <div class="form-group">
        <label>Partenaire* :</label>
        <select name="idPart" required class="form-control">
            <option value="">-- Choisir un partenaire --</option>
            <?php foreach($partenaires as $p): ?>
                <option value="<?= $p['idPart'] ?>"><?= htmlspecialchars($p['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter la subvention</button>
</form>

<div class="text-center">
    <a href="affiche_subvention.php">⬅ Retour à la liste des subventions</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>