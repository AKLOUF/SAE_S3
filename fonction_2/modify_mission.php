<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de la mission manquant.");
}

$idMission = $_GET['id'];
$error = '';
$success = '';

// Récupérer la mission existante
$stmt = $pdo->prepare("SELECT * FROM MISSION WHERE idMission = ?");
$stmt->execute([$idMission]);
$mission = $stmt->fetch();

if (!$mission) {
    die("Mission introuvable.");
}

// Récupérer les lieux pour le select
$lieux = $pdo->query("SELECT idLieu, ville, code_postal, region, adresse_detail FROM LIEU")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("UPDATE MISSION SET nom_mission = ?, date_debut = ?, date_fin = ?, idlieu = ?, budget = ?, materiel_necessaire = ?, description = ? WHERE idMission = ?");
        $stmt->execute([
            $_POST['nom_mission'],
            $_POST['date_debut'],
            $_POST['date_fin'],
            $_POST['idlieu'],
            $_POST['budget'],
            $_POST['materiel'],
            $_POST['description'],
            $idMission
        ]);
        $success = "Mission modifiée avec succès.";

        // Recharger les données
        $stmt = $pdo->prepare("SELECT * FROM MISSION WHERE idMission = ?");
        $stmt->execute([$idMission]);
        $mission = $stmt->fetch();
    } catch (Exception $e) {
        $error = "Erreur lors de la modification : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier une Mission</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
<h1 class="mt-3">Modifier une Mission</h1>

<?php if($error) echo "<p class='message-error'>$error</p>"; ?>
<?php if($success) echo "<p class='message-success'>$success</p>"; ?>

<form method="post">
    <label>Nom de la mission* :
        <input type="text" name="nom_mission" value="<?= htmlspecialchars($mission['nom_mission']) ?>" required>
    </label>

    <label>Date début* :
        <input type="date" name="date_debut" value="<?= htmlspecialchars($mission['date_debut']) ?>" required>
    </label>

    <label>Date fin :
        <input type="date" name="date_fin" value="<?= htmlspecialchars($mission['date_fin']) ?>">
    </label>

    <label>Lieu* :
        <select name="idlieu" required>
            <option value="">-- Choisir un lieu --</option>
            <?php foreach($lieux as $l): ?>
                <option value="<?= $l['idLieu'] ?>" <?= ($l['idLieu'] == $mission['idLieu']) ? 'selected' : '' ?>><?= htmlspecialchars($l['ville']) ?> - <?= htmlspecialchars($l['adresse_detail']) ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>Budget :
        <input type="number" name="budget" step="0.01" value="<?= htmlspecialchars($mission['budget']) ?>">
    </label>

    <label>Matériel nécessaire :
        <input type="text" name="materiel" value="<?= htmlspecialchars($mission['materiel_necessaire']) ?>">
    </label>

    <label>Description :
        <input type="text" name="description" value="<?= htmlspecialchars($mission['description']) ?>">
    </label>

    <button type="submit">Enregistrer les modifications</button>
</form>

<a href="index.php">⬅ Retour au tableau de bord</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>