<?php
session_start();
require '../connexion/db_connect.php';
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO EVENEMENT (nom_evenement, date_heure, idlieu, budget, materiel_necessaire, description, type_evenement) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['nom_evenement'],
            $_POST['date_heure'],
            $_POST['idlieu'],
            $_POST['budget'],
            $_POST['materiel'],
            $_POST['description'],
            $_POST['type_evenement']
        ]);
        $success = "Événement ajouté avec succès.";
    } catch (Exception $e) {
        $error = "Erreur lors de l'ajout : " . $e->getMessage();
    }
}

// Récupérer les lieux pour le select
$lieux = $pdo->query("SELECT idLieu, ville, code_postal, region, adresse_detail FROM LIEU")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Événement</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="../logo/asso-logo.png">
</head>
<body>
<h1 class="mt-3">Ajouter un Événement</h1>

<?php if($error) echo "<p class='message-error'>$error</p>"; ?>
<?php if($success) echo "<p class='message-success'>$success</p>"; ?>

<form method="post" class="form-container">
    <div class="form-group">
        <label>Nom de l'événement* :</label>
        <input type="text" name="nom_evenement" required class="form-control">
    </div>

    <div class="form-group">
        <label>Date et heure* :</label>
        <input type="datetime-local" name="date_heure" required class="form-control">
    </div>

    <div class="form-group">
        <label>Lieu* :</label>
        <select name="idlieu" required class="form-control">
            <option value="">-- Choisir un lieu --</option>
            <?php foreach($lieux as $l): ?>
                <option value="<?= $l['idLieu'] ?>"><?= htmlspecialchars($l['ville']) ?> - <?= htmlspecialchars($l['adresse_detail']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Budget :</label>
        <input type="number" name="budget" step="0.01" class="form-control">
    </div>

    <div class="form-group">
        <label>Matériel nécessaire :</label>
        <input type="text" name="materiel" class="form-control">
    </div>

    <div class="form-group">
        <label>Description :</label>
        <input type="text" name="description" class="form-control">
    </div>

    <div class="form-group">
        <label>Type d'événement :</label>
        <select name="type_evenement" required class="form-control">
            <option value="">-- Choisir un type --</option>
            <option value="Conférence">Conférence</option>
            <option value="Atelier">Atelier</option>
            <option value="Séminaire">Séminaire</option>
            <option value="Autre">Autre</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter l'événement</button>
</form>

<div class="text-center">
    <a href="index.php">⬅ Retour au tableau de bord</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>