<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php';

/*
Récupération des médias avec leurs actualités associées
*/
$sql = "
SELECT 
    m.idMedia,
    m.url_media AS chemin,
    m.type_media AS type,
    m.nom,
    a.idActu,
    a.titre
FROM media m
LEFT JOIN actualite_media am ON m.idMedia = am.idMedia
LEFT JOIN actualite a ON am.idActu = a.idActu
";

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Regrouper les actualités par média
$medias = [];
foreach ($rows as $row) {
    $idMedia = $row['idMedia'];
    if (!isset($medias[$idMedia])) {
        $medias[$idMedia] = [
            'idMedia' => $idMedia,
            'chemin' => $row['chemin'],
            'type' => $row['type'],
            'nom' => $row['nom'],
            'actualites' => []
        ];
    }
    if ($row['idActu']) {
        $medias[$idMedia]['actualites'][] = [
            'idActu' => $row['idActu'],
            'titre' => $row['titre']
        ];
    }
}

// Réindexer pour avoir un tableau simple
$medias = array_values($medias);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Galerie médias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
    <link rel="stylesheet" href="../styles.css" />
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
<nav class="navbar navbar-dark navbar-custom fixed-top navbar-expand-lg">
        <div class="container-fluid">

            <a class="navbar-brand" href="../page_d'acceuil/acceuil.html">
                <img src="../logo/asso-logo.png" class="logo" alt="">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="add_media.php">Ajouter un média</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php">Voir actualités</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="../connexion/liste_fonction.html" class="btn btn-outline-light">Voir autre fonctionnalité</a>
                    <a href="../connexion/logout.php" class="btn btn-outline-light">Déconnexion</a>
                </div>
        </div>
    </div>
</nav>
<div class="container mt-5 pt-4">
    <h1 class="page-title text-center mb-4">🖼️ Galerie médias</h1>

    <?php if (count($medias) === 0): ?>
        <p class="text-center">Aucun média disponible.</p>
    <?php else: ?>

    <ul class="nav nav-tabs mb-4" id="mediaTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="video-tab" data-bs-toggle="tab" data-bs-target="#video" type="button" role="tab" aria-controls="video" aria-selected="true">Vidéo</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image" type="button" role="tab" aria-controls="image" aria-selected="false">Image</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="audio-tab" data-bs-toggle="tab" data-bs-target="#audio" type="button" role="tab" aria-controls="audio" aria-selected="false">Audio</a>
        </li>
    </ul>

    <?php
    $medias_by_type = ['video'=>[], 'image'=>[], 'audio'=>[]];
    foreach ($medias as $media) {
        if (isset($medias_by_type[$media['type']])) {
            $medias_by_type[$media['type']][] = $media;
        }
    }
    ?>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="video" role="tabpanel" aria-labelledby="video-tab">
            <?php if (count($medias_by_type['video']) === 0): ?>
                <p>Aucun vidéo disponible.</p>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach ($medias_by_type['video'] as $media): ?>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header text-center">
                                    <video controls class="w-100">
                                        <source src="<?= htmlspecialchars($media['chemin']) ?>" />
                                        Votre navigateur ne supporte pas la vidéo.
                                    </video>
                                </div>
                                <div class="card-body">
                                    <p><strong>Type :</strong> <?= htmlspecialchars($media['type']) ?></p>
                                    <p class="role mb-2">Nom : <?= htmlspecialchars($media['nom']) ?></p>
                                    <?php if (count($media['actualites']) > 0): ?>
                                        <p>Actualités associées :</p>
                                        <ul>
                                            <?php foreach ($media['actualites'] as $actu): ?>
                                                <li><?= htmlspecialchars($actu['titre']) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p>Aucune actualité</p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'):?>     
                                <a href="modify_media.php?id=<?= $media['idMedia'] ?>" class="btn btn-primary btn-sm">Modifier</a>  
                                    <a href="delete_media.php?id=<?= $media['idMedia'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce média ?');">Supprimer</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="tab-pane fade" id="image" role="tabpanel" aria-labelledby="image-tab">
            <?php if (count($medias_by_type['image']) === 0): ?>
                <p>Aucun image disponible.</p>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach ($medias_by_type['image'] as $media): ?>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header text-center">
                                    <img src="<?= htmlspecialchars($media['chemin']) ?>" alt="<?= htmlspecialchars($media['nom']) ?>" class="img-fluid" />
                                </div>
                                <div class="card-body">
                                    <p><strong>Type :</strong> <?= htmlspecialchars($media['type']) ?></p>
                                    <p class="role mb-2">Nom : <?= htmlspecialchars($media['nom']) ?></p>
                                    <?php if (count($media['actualites']) > 0): ?>
                                        <p>Actualités associées :</p>
                                        <ul>
                                            <?php foreach ($media['actualites'] as $actu): ?>
                                                <li><?= htmlspecialchars($actu['titre']) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p>Aucune actualité</p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>     
                                <a href="modify_media.php?id=<?= $media['idMedia'] ?>" class="btn btn-primary btn-sm">Modifier</a>
                                    <a href="delete_media.php?id=<?= $media['idMedia'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce média ?');">Supprimer</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="tab-pane fade" id="audio" role="tabpanel" aria-labelledby="audio-tab">
            <?php if (count($medias_by_type['audio']) === 0): ?>
                <p>Aucun audio disponible.</p>
            <?php else: ?>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach ($medias_by_type['audio'] as $media): ?>
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-header text-center">
                                    <audio controls class="w-100">
                                        <source src="<?= htmlspecialchars($media['chemin']) ?>" />
                                        Votre navigateur ne supporte pas l'audio.
                                    </audio>
                                </div>
                                <div class="card-body">
                                    <p><strong>Type :</strong> <?= htmlspecialchars($media['type']) ?></p>
                                    <p class="role mb-2">Nom : <?= htmlspecialchars($media['nom']) ?></p>
                                    <?php if (count($media['actualites']) > 0): ?>
                                        <p>Actualités associées :</p>
                                        <ul>
                                            <?php foreach ($media['actualites'] as $actu): ?>
                                                <li><?= htmlspecialchars($actu['titre']) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p>Aucune actualité</p>
                                    <?php endif; ?>
                                </div>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?> 
                                <div class="card-footer d-flex justify-content-between">
                                    
                                    <a href="modify_media.php?id=<?= $media['idMedia'] ?>" class="btn btn-primary">Modifier</a>
                                    <a href="delete_media.php?id=<?= $media['idMedia'] ?>" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce média ?');">Supprimer</a>
                                
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php endif; ?>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>