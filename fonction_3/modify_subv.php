<?php
session_start();
require '../connexion/db_connect.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de la subvention manquant.");
}

$idSub = $_GET['id'];
$error = '';
$success = '';

// Récupérer la subvention existante
$stmt = $pdo->prepare("SELECT s.idSub, s.nom_sub, s.montant, s.annee, r.idPart 
                       FROM SUBVENTION s 
                       JOIN RECOIT_SUBVENTION r ON s.idSub = r.idSub 
                       WHERE s.idSub = ?");
$stmt->execute([$idSub]);
$subvention = $stmt->fetch();

if (!$subvention) {
    die("Subvention introuvable.");
}

// Récupérer les partenaires pour le select
$partenaires = $pdo->query("SELECT idPart, nom FROM PARTENAIRE ORDER BY nom ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Mettre à jour la subvention
        $stmt = $pdo->prepare("UPDATE SUBVENTION SET nom_sub = ?, montant = ?, annee = ? WHERE idSub = ?");
        $stmt->execute([
            $_POST['nom_sub'],
            $_POST['montant'],
            $_POST['annee'],
            $idSub
        ]);

        // Mettre à jour le partenaire dans RECOIT_SUBVENTION
        $stmt = $pdo->prepare("UPDATE RECOIT_SUBVENTION SET idPart = ? WHERE idSub = ?");
        $stmt->execute([
            $_POST['idPart'],
            $idSub
        ]);

        $success = "Subvention modifiée avec succès.";

        // Recharger les données
        $stmt = $pdo->prepare("SELECT s.idSub, s.nom_sub, s.montant, s.annee, r.idPart 
                               FROM SUBVENTION s 
                               JOIN RECOIT_SUBVENTION r ON s.idSub = r.idSub 
                               WHERE s.idSub = ?");
        $stmt->execute([$idSub]);
        $subvention = $stmt->fetch();

    } catch (Exception $e) {
        $error = "Erreur lors de la modification : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier une Subvention</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
<h1 class="mt-3">Modifier une Subvention</h1>

<?php if($error) echo "<p class='message-error'>$error</p>"; ?>
<?php if($success) echo "<p class='message-success'>$success</p>"; ?>

<form method="post">
    <label>Nom de la subvention* :
        <input type="text" name="nom_sub" value="<?= htmlspecialchars($subvention['nom_sub']) ?>" required>
    </label>

    <label>Montant* :
        <input type="number" step="0.01" name="montant" value="<?= htmlspecialchars($subvention['montant']) ?>" required>
    </label>

    <label>Année* :
        <input type="number" name="annee" value="<?= htmlspecialchars($subvention['annee']) ?>" required>
    </label>

    <label>Partenaire* :
        <select name="idPart" required>
            <?php foreach($partenaires as $p): ?>
                <option value="<?= $p['idPart'] ?>" <?= ($subvention['idPart'] == $p['idPart']) ? 'selected' : '' ?>><?= htmlspecialchars($p['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <button type="submit">Enregistrer les modifications</button>
</form>

<a href="affich_subv.php">⬅ Retour à la liste des subventions</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>