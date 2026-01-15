<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des données du formulaire
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $mail = trim($_POST['mail'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $code_postal = trim($_POST['code_postal'] ?? '');
    $regime = trim($_POST['regime'] ?? '');
    $problemes = trim($_POST['problemes'] ?? '');
    $competences = trim($_POST['competences'] ?? '');
    $profession = trim($_POST['profession'] ?? '');
    $date_naissance = trim($_POST['date_naissance'] ?? '');
    $disponibilites = trim($_POST['disponibilites'] ?? '');

    // Validation simple
    if (
        empty($nom) || empty($prenom) || empty($mail) || empty($telephone) || empty($adresse) ||
        empty($ville) || empty($regime) || empty($profession) || empty($date_naissance)
    ) {
        $error = "Veuillez remplir tous les champs obligatoires.";
    } else {
        try {
            $pdo->beginTransaction();

            // Insérer dans PERSONNE
            $stmt = $pdo->prepare("INSERT INTO PERSONNE (nom, prenom, mail, telephone, adresse, ville, code_postal, date_naissance, profession)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $nom, $prenom, $mail, $telephone, $adresse, $ville, $code_postal, $date_naissance, $profession
            ]);
            $idPersonne = $pdo->lastInsertId();
            // Insérer dans BENEVOLE
            $stmt = $pdo->prepare("INSERT INTO BENEVOLE (idPersonne, regime_alimentaire, limitation_physique, competence, disponibilite, date_adhesion, statut_actif)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $idPersonne, $regime, $problemes, $competences, $disponibilites, date('Y-m-d'), 1
            ]);

            $pdo->commit();
            $success = "Bénévole ajouté avec succès !";
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = "Erreur lors de l'ajout : " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un bénévole</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../style_form.css">
    <link rel="icon" type="image/x-icon" href="../logo/asso-logo.png">
</head>
<body>
    <h1>Ajouter un bénévole</h1>
    <?php if ($error): ?>
        <div class="message error"><?= $error ?></div>
    <?php elseif ($success): ?>
        <div class="message success"><?= $success ?></div>
    <?php endif; ?>
    <form method="post" class="form-container">
        <div class="form-group">
            <label>Nom :
                <input type="text" name="nom" required class="form-control" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Prénom :
                <input type="text" name="prenom" required class="form-control" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Mail :
                <input type="email" name="mail" required class="form-control" value="<?= htmlspecialchars($_POST['mail'] ?? '') ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Téléphone :
                <input type="text" name="telephone" required class="form-control" value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Adresse :
                <input type="text" name="adresse" required class="form-control" value="<?= htmlspecialchars($_POST['adresse'] ?? '') ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Ville :
                <input type="text" name="ville" required class="form-control" value="<?= htmlspecialchars($_POST['ville'] ?? '') ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Code postal :
                <input type="text" name="code_postal" class="form-control" value="<?= htmlspecialchars($_POST['code_postal'] ?? '') ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Régime alimentaire* :
                <select name="regime" required class="form-control">
                    <option value="">-- Choisir un régime --</option>
                    <option value="Omnivore" <?= (($_POST['regime'] ?? '') === 'Omnivore') ? 'selected' : '' ?>>Omnivore</option>
                    <option value="Végétarien" <?= (($_POST['regime'] ?? '') === 'Végétarien') ? 'selected' : '' ?>>Végétarien</option>
                    <option value="Vegan" <?= (($_POST['regime'] ?? '') === 'Vegan') ? 'selected' : '' ?>>Vegan</option>
                    <option value="Sans gluten" <?= (($_POST['regime'] ?? '') === 'Sans gluten') ? 'selected' : '' ?>>Sans gluten</option>
                </select>
            </label>
        </div>
        <div class="form-group">
            <label>Problèmes physiques :
                <textarea name="problemes" class="form-control"><?= htmlspecialchars($_POST['problemes'] ?? '') ?></textarea>
            </label>
        </div>
        <div class="form-group">
            <label>Compétences :
                <textarea name="competences" class="form-control"><?= htmlspecialchars($_POST['competences'] ?? '') ?></textarea>
            </label>
        </div>
        <div class="form-group">
            <label>Profession :
                <input type="text" name="profession" required class="form-control" value="<?= htmlspecialchars($_POST['profession'] ?? '') ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Date de naissance :
                <input type="date" name="date_naissance" required class="form-control" value="<?= htmlspecialchars($_POST['date_naissance'] ?? '') ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Disponibilités :
                <textarea name="disponibilites" class="form-control"><?= htmlspecialchars($_POST['disponibilites'] ?? '') ?></textarea>
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <div class="text-center">
        <a href="index.php">&larr; Retour au tableau de bord</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>