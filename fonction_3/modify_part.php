<?php
session_start();
require '../connexion/db_connect.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID du partenaire manquant.");
}

$idPart = $_GET['id'];
$error = '';
$success = '';

// Récupérer le partenaire existant
$stmt = $pdo->prepare("SELECT * FROM PARTENAIRE WHERE idPart = ?");
$stmt->execute([$idPart]);
$partenaire = $stmt->fetch();

if (!$partenaire) {
    die("Partenaire introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("UPDATE PARTENAIRE SET nom = ?, type_partenaire = ?, contact = ?, secteur = ? WHERE idPart = ?");
        $stmt->execute([
            $_POST['nom'],
            $_POST['type_partenaire'],
            $_POST['contact'],
            $_POST['secteur'],
            $idPart
        ]);
        $success = "Partenaire modifié avec succès.";

        // Recharger les données
        $stmt = $pdo->prepare("SELECT * FROM PARTENAIRE WHERE idPart = ?");
        $stmt->execute([$idPart]);
        $partenaire = $stmt->fetch();
    } catch (Exception $e) {
        $error = "Erreur lors de la modification : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Partenaire</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
<h1 class="mt-3">Modifier un Partenaire</h1>

<?php if($error) echo "<p class='message-error'>$error</p>"; ?>
<?php if($success) echo "<p class='message-success'>$success</p>"; ?>

<form method="post">
    <label>Nom du partenaire* :
        <input type="text" name="nom" value="<?= htmlspecialchars($partenaire['nom']) ?>" required>
    </label>

    <label>Type de partenaire* :
        <select name="type_partenaire" required>
            <option value="Entreprise" <?= ($partenaire['type_partenaire'] == 'Entreprise') ? 'selected' : '' ?>>Entreprise</option>
            <option value="Association" <?= ($partenaire['type_partenaire'] == 'Association') ? 'selected' : '' ?>>Association</option>
            <option value="Institution" <?= ($partenaire['type_partenaire'] == 'Institution') ? 'selected' : '' ?>>Institution</option>
            <option value="Particulier" <?= ($partenaire['type_partenaire'] == 'Particulier') ? 'selected' : '' ?>>Particulier</option>
        </select>
    </label>

    <label>Email* :
        <input type="email" name="contact" value="<?= htmlspecialchars($partenaire['contact']) ?>" required>
    </label>

    <label>Secteur* :
        <select name="secteur" required>
            <option value="Santé" <?= ($partenaire['secteur'] == 'Santé') ? 'selected' : '' ?>>Santé</option>
            <option value="Éducation" <?= ($partenaire['secteur'] == 'Éducation') ? 'selected' : '' ?>>Éducation</option>
            <option value="Culture" <?= ($partenaire['secteur'] == 'Culture') ? 'selected' : '' ?>>Culture</option>
            <option value="Environnement" <?= ($partenaire['secteur'] == 'Environnement') ? 'selected' : '' ?>>Environnement</option>
            <option value="Autre" <?= ($partenaire['secteur'] == 'Autre') ? 'selected' : '' ?>>Autre</option>
        </select>
    </label>

    <button type="submit">Enregistrer les modifications</button>
</form>
<a href="affiche_partenaire.php">⬅ Retour à la liste des partenaires</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>