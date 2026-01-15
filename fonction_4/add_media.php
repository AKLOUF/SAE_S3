<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php';

/*
⚠️ Sécurité (optionnel mais recommandé)
Décommente si tu gères les rôles
*/
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     exit('Accès refusé');
// }

$message = "";

/* Récupération des actualités pour l'association */
$sqlActu = "SELECT idActu, titre FROM actualite ORDER BY date_publication DESC";
$actus = $pdo->query($sqlActu)->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_FILES['media']['name'])) {

        $type = $_POST['type_media'];
        $role = $_POST['nom'];
        $idActu = !empty($_POST['idActu']) ? $_POST['idActu'] : null;

        /* Dossier d'upload */
        $uploadDir = "../uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['media']['name']);
        $filePath = $uploadDir . $fileName;

        /* Sécurisation du type */
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'video/mp4', 'audio/mpeg'];
        if (!in_array($_FILES['media']['type'], $allowedTypes)) {
            $message = "❌ Format de fichier non autorisé.";
        } else {

            if (move_uploaded_file($_FILES['media']['tmp_name'], $filePath)) {

                /* Insertion média */
                $sql = "INSERT INTO media (url_media, type_media, nom)
                        VALUES (:url, :type, :nom)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':url' => $filePath,
                    ':type' => $type,
                    ':nom' => $role
                ]);

                $idMedia = $pdo->lastInsertId();

                /* Lien avec une actualité (optionnel) */
                if ($idActu) {
                    $sqlLink = "INSERT INTO actualite_media (idMedia, idActu)
                                VALUES (:idMedia, :idActu)";
                    $stmtLink = $pdo->prepare($sqlLink);
                    $stmtLink->execute([
                        ':idMedia' => $idMedia,
                        ':idActu' => $idActu
                    ]);
                }

                header("Location: affich_media.php");
                exit;

            } else {
                $message = "❌ Erreur lors de l’upload du fichier.";
            }
        }
    } else {
        $message = "❌ Aucun fichier sélectionné.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un média</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>

<h1 style="text-align:center;">➕ Ajouter un média</h1>

<form method="POST" enctype="multipart/form-data">

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <label>Fichier (image ou vidéo)</label>
    <input type="file" name="media" required>

    <label>Type de média</label>
    <select name="type_media" required>
        <option value="image">Image</option>
        <option value="video">Vidéo</option>
        <option value="audio">Audio</option>
    </select>

    <label>Rôle du média</label>
    <input type="text" name="nom" placeholder="couverture, illustration..." required>

    <label>Associer à une actualité (optionnel)</label>
    <select name="idActu">
        <option value="">-- Aucune --</option>
        <?php foreach ($actus as $actu): ?>
            <option value="<?= $actu['idActu'] ?>">
                <?= htmlspecialchars($actu['titre']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Ajouter le média</button>
</form>
<a href="affich_media.php" class="btn-cancel">↩ Annuler</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>