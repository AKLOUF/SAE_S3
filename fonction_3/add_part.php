<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO PARTENAIRE (nom, type_partenaire, contact, secteur, date_debut_partenariat) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['nom'],
            $_POST['type_partenaire'],
            $_POST['contact'],
            $_POST['secteur'],
            date('Y-m-d') // date du jour
        ]);
        $success = "Partenaire ajouté avec succès.";
    } catch (Exception $e) {
        $error = "Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Partenaire</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
<h1 class="page-title text-center mb-4 mt-3">Ajouter un Partenaire</h1>

<?php if($error) echo "<p class='message-error'>$error</p>"; ?>
<?php if($success) echo "<p class='message-success'>$success</p>"; ?>

<form method="post" class="form-container">
    <div class="form-group">
        <label>Nom du partenaire* :</label>
        <input type="text" name="nom" required class="form-control">
    </div>

    <div class="form-group">
        <label>Type de partenaire* :</label>
        <select name="type_partenaire" required class="form-control">
            <option value="Entreprise">Entreprise</option>
            <option value="Association">Association</option>
            <option value="Institution">Institution</option>
            <option value="Particulier">Particulier</option>
        </select>
    </div>

    <div class="form-group">
        <label>Email* :</label>
        <input type="email" name="contact" required class="form-control">
    </div>

    <div class="form-group">
        <label>Secteur* :</label>
        <select name="secteur" required class="form-control">
            <option value="Santé">Santé</option>
            <option value="Éducation">Éducation</option>
            <option value="Culture">Culture</option>
            <option value="Environnement">Environnement</option>
            <option value="Autre">Autre</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter le partenaire</button>
</form>

<div class="text-center">
    <a href="index.php">⬅ Retour au tableau de bord</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>