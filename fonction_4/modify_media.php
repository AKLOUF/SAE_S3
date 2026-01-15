<?php
session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

require '../connexion/db_connect.php';

// Vérifier si l'ID du média est passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID du média manquant.");
}

$idMedia = (int)$_GET['id'];

// Récupérer les infos du média
$sql = "SELECT * FROM media WHERE idMedia = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $idMedia]);
$media = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$media) {
    die("Média introuvable.");
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $type = $_POST['type'] ?? '';
    $fichier = $_FILES['media_file'] ?? null;

    // Gestion du fichier si un nouveau est uploadé
    $chemin = $media['url_media']; // conserver l'ancien si aucun upload
    if ($fichier && $fichier['error'] === UPLOAD_ERR_OK) {
        $dossier = 'uploads/';
        if (!is_dir($dossier)) mkdir($dossier, 0755, true);

        $nomFichier = basename($fichier['name']);
        $cheminComplet = $dossier . $nomFichier;

        if (move_uploaded_file($fichier['tmp_name'], $cheminComplet)) {
            $chemin = $cheminComplet;
        } else {
            echo "<p style='color:red;'>Erreur lors du téléchargement du fichier.</p>";
        }
    }

    // Mise à jour dans la base
    $update = "UPDATE media SET nom = :nom, type_media = :type, url_media = :chemin WHERE idMedia = :id";
    $stmt = $pdo->prepare($update);
    $stmt->execute([
        'nom' => $nom,
        'type' => $type,
        'chemin' => $chemin,
        'id' => $idMedia
    ]);

    echo "<p style='color:green;'>Média mis à jour avec succès.</p>";
    // Recharger les nouvelles infos
    $stmt = $pdo->prepare("SELECT * FROM media WHERE idMedia = :id");
    $stmt->execute(['id' => $idMedia]);
    $media = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Média</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>

<h1>✏️ Modifier Média</h1>

<form method="POST" enctype="multipart/form-data">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($media['nom']) ?>" required>

    <label for="type">Type :</label>
    <select name="type" id="type" required>
        <option value="image" <?= $media['type_media'] === 'image' ? 'selected' : '' ?>>Image</option>
        <option value="video" <?= $media['type_media'] === 'video' ? 'selected' : '' ?>>Vidéo</option>
        <option value="audio" <?= $media['type_media'] === 'audio' ? 'selected' : '' ?>>Audio</option>
    </select>

    <label for="media_file">Changer le fichier (optionnel) :</label>
    <input type="file" name="media_file" id="media_file" accept="image/*,video/*,audio/*">

    <?php if ($media['type_media'] === 'image'): ?>
        <img src="<?= htmlspecialchars($media['url_media']) ?>" alt="Aperçu">
    <?php elseif ($media['type_media'] === 'video'): ?>
        <video controls>
            <source src="<?= htmlspecialchars($media['url_media']) ?>">
        </video>
    <?php elseif ($media['type_media'] === 'audio'): ?>
        <audio controls>
            <source src="<?= htmlspecialchars($media['url_media']) ?>">
        </audio>
    <?php endif; ?>   
    <button type="submit">Mettre à jour</button>
</form>
<a href="affich_media.php" class="btn">← Annuler</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>