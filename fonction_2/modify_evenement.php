<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de l'événement manquant.");
}

$idEvenement = $_GET['id'];
$error = '';
$success = '';

// Récupérer l'événement existant
$stmt = $pdo->prepare("SELECT * FROM EVENEMENT WHERE idEvenement = ?");
$stmt->execute([$idEvenement]);
$evenement = $stmt->fetch();

if (!$evenement) {
    die("Événement introuvable.");
}

// Récupérer les lieux pour le select
$lieux = $pdo->query("SELECT idLieu, ville, code_postal, region, adresse_detail FROM LIEU")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("UPDATE EVENEMENT SET nom_evenement = ?, date_heure = ?, idlieu = ?, budget = ?, materiel_necessaire = ?, description = ?, type_evenement = ? WHERE idEvenement = ?");
        $stmt->execute([
            $_POST['nom_evenement'],
            $_POST['date_heure'],
            $_POST['idlieu'],
            $_POST['budget'],
            $_POST['materiel'],
            $_POST['description'],
            $_POST['type_evenement'],
            $idEvenement
        ]);
        $success = "Événement modifié avec succès.";

        // Recharger les données
        $stmt = $pdo->prepare("SELECT * FROM EVENEMENT WHERE idEvenement = ?");
        $stmt->execute([$idEvenement]);
        $evenement = $stmt->fetch();
    } catch (Exception $e) {
        $error = "Erreur lors de la modification : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Événement</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="../logo/asso-logo.png">
</head>
<body>
<h1 class="mt-3">Modifier un Événement</h1>

<?php if($error) echo "<p class='message-error'>$error</p>"; ?>
<?php if($success) echo "<p class='message-success'>$success</p>"; ?>

<form method="post">
    <label>Nom de l'événement* :
        <input type="text" name="nom_evenement" value="<?= htmlspecialchars($evenement['nom_evenement']) ?>" required>
    </label>

    <label>Date et heure* :
        <input type="datetime-local" name="date_heure" value="<?= htmlspecialchars($evenement['date_heure']) ?>" required>
    </label>

    <label>Lieu* :
        <select name="idlieu" required>
            <option value="">-- Choisir un lieu --</option>
            <?php foreach($lieux as $l): ?>
                <option value="<?= $l['idLieu'] ?>" <?= ($l['idLieu'] == $evenement['idLieu']) ? 'selected' : '' ?>><?= htmlspecialchars($l['ville']) ?> - <?= htmlspecialchars($l['adresse_detail']) ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>Budget :
        <input type="number" name="budget" step="0.01" value="<?= htmlspecialchars($evenement['budget']) ?>">
    </label>

    <label>Matériel nécessaire :
        <input type="text" name="materiel" value="<?= htmlspecialchars($evenement['materiel_necessaire']) ?>">
    </label>

    <label>Description :
        <input type="text" name="description" value="<?= htmlspecialchars($evenement['description']) ?>">
    </label>

    <label>Type d'événement :
        <select name="type_evenement" required>
            <option value="Conférence" <?= ($evenement['type_evenement'] == 'Conférence') ? 'selected' : '' ?>>Conférence</option>
            <option value="Atelier" <?= ($evenement['type_evenement'] == 'Atelier') ? 'selected' : '' ?>>Atelier</option>
            <option value="Séminaire" <?= ($evenement['type_evenement'] == 'Séminaire') ? 'selected' : '' ?>>Séminaire</option>
            <option value="Autre" <?= ($evenement['type_evenement'] == 'Autre') ? 'selected' : '' ?>>Autre</option>
        </select>
    </label>

    <button type="submit">Enregistrer les modifications</button>
</form>

<a href="index.php">⬅ Retour au tableau de bord</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>