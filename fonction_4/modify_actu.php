<?php
session_start();
require '../connexion/db_connect.php';
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}


// 1️⃣ Vérification de l'ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de l'actualité manquant.");
}

$idActu = (int) $_GET['id'];

// 2️⃣ Récupération de l'actualité
$sql = "SELECT titre, contenu, date_publication 
        FROM actualite 
        WHERE idActu = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $idActu]);
$actu = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$actu) {
    die("Actualité introuvable.");
}

// 3️⃣ Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);
    $date = !empty($_POST['date_publication']) ? $_POST['date_publication'] : null;

    if (!empty($titre) && !empty($contenu)) {
        $sqlUpdate = "UPDATE actualite 
                      SET titre = :titre,
                          contenu = :contenu,
                          date_publication = :date
                      WHERE idActu = :id";

        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([
            'titre' => $titre,
            'contenu' => $contenu,
            'date' => $date,
            'id' => $idActu
        ]);

        header("Location: index.php");
        exit;
    } else {
        $erreur = "Tous les champs obligatoires doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une actualité</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>

<div class="container">
    <h1>✏️ Modifier l’actualité</h1>

    <?php if (!empty($erreur)): ?>
        <p class="error"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="titre">Titre *</label>
        <input type="text" name="titre" id="titre"
               value="<?= htmlspecialchars($actu['titre']) ?>" required>

        <label for="contenu">Contenu *</label>
        <textarea name="contenu" id="contenu" required><?= htmlspecialchars($actu['contenu']) ?></textarea>

        <label for="date_publication">Date de publication</label>
        <input type="date" name="date_publication" id="date_publication"
               value="<?= !empty($actu['date_publication']) ? date('Y-m-d', strtotime($actu['date_publication'])) : '' ?>">

        <button type="submit" class="btn-save">💾 Enregistrer</button>
    </form>
</div>
<a href="index.php" class="btn-cancel">↩ Annuler</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>