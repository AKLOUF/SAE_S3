<?php
require '../connexion/db_connect.php';
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
$message = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);

    if (!empty($titre) && !empty($contenu)) {
        $sql = "INSERT INTO actualite (titre, contenu, date_publication)
                VALUES (:titre, :contenu, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titre' => $titre,
            ':contenu' => $contenu
        ]);

        // redirection après ajout
        header("Location: index.php");
        exit;
    } else {
        $message = "⚠️ Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une actualité</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>

<div class="container">
    <h1 class="mt-3">➕ Ajouter une actualité</h1>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="post">
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" required>

        <label for="contenu">Contenu</label>
        <textarea name="contenu" id="contenu" required></textarea>
        <button type="submit" class="btn-primary">Ajouter</button>
    </form>
</div>
<a type="button" href='index.php' class="btn-danger">&larr; Annuler</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>