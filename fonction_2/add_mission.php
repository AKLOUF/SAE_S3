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
        $stmt = $pdo->prepare("
            INSERT INTO MISSION (nom_mission, date_debut, date_fin, idlieu, budget, categorie, responsable, materiel_necessaire, description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $_POST['nom_mission'],
            $_POST['date_debut'],
            $_POST['date_fin'],
            $_POST['idlieu'],
            $_POST['budget'],
            $_POST['categorie'],
            $_SESSION['idPersonne'],
            $_POST['materiel_necessaire'],
            $_POST['description']
        ]);
        $success = "Mission ajoutée avec succès.";
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
    <title>Ajouter une Mission</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="../logo/asso-logo.png">
</head>
<body>
<h1 class="mt-3">Ajouter une Mission</h1>

<?php if($error) echo "<p class='message-error'>$error</p>"; ?>
<?php if($success) echo "<p class='message-success'>$success</p>"; ?>

<form method="post" class="form-container">
    <div class="form-group">
        <label>Nom de la mission* :</label>
        <input type="text" name="nom_mission" required class="form-control">
    </div>

    <div class="form-group">
        <label>Date début* :</label>
        <input type="date" name="date_debut" required class="form-control">
    </div>

    <div class="form-group">
        <label>Date fin :</label>
        <input type="date" name="date_fin" class="form-control">
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
        <input type="text" name="materiel_necessaire" class="form-control">
    </div>

    <div class="form-group">
        <label>Description :</label>
        <input type="text" name="description" class="form-control">
    </div>

    <div class="form-group">
        <label>Catégorie :</label>
        <select name="categorie" class="form-control">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
        </select>
    </div>
                
    <button type="submit" class="btn btn-primary">Ajouter la mission</button>
</form>

<div class="text-center">
    <a href="index.php">⬅ Retour au tableau de bord</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>