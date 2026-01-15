<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}
require '../connexion/db_connect.php';

$error = '';
$success = '';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID du bénévole manquant.");
}

$idPersonne = $_GET['id'];

/* ==========================
   Récupération des données
========================== */
$stmt = $pdo->prepare("
    SELECT p.nom, p.prenom, p.mail, p.telephone, p.adresse, p.ville, p.code_postal,
           p.profession, p.date_naissance,
           b.regime_alimentaire, b.limitation_physique, b.competence, b.disponibilite, b.statut_actif
    FROM PERSONNE p
    JOIN BENEVOLE b ON p.idPersonne = b.idPersonne
    WHERE p.idPersonne = ?
");
$stmt->execute([$idPersonne]);
$benevole = $stmt->fetch();

if (!$benevole) {
    die("Bénévole introuvable.");
}

/* ==========================
   Mise à jour
========================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // PERSONNE
        $stmt = $pdo->prepare("
            UPDATE PERSONNE SET
                nom = ?, prenom = ?, mail = ?, telephone = ?, adresse = ?, ville = ?,
                code_postal = ?, profession = ?, date_naissance = ?
            WHERE idPersonne = ?
        ");
        $stmt->execute([
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['mail'] ?: null,
            $_POST['telephone'] ?: null,
            $_POST['adresse'] ?: null,
            $_POST['ville'] ?: null,
            $_POST['code_postal'] ?: null,
            $_POST['profession'] ?: null,
            $_POST['date_naissance'],
            $idPersonne
        ]);

        // BENEVOLE
        $stmt = $pdo->prepare("
            UPDATE BENEVOLE SET
                regime_alimentaire = ?, limitation_physique = ?, competence = ?,
                disponibilite = ?, statut_actif = ?
            WHERE idPersonne = ?
        ");
        $stmt->execute([
            $_POST['regime_alimentaire'] ?: null,
            $_POST['limitation_physique'] ?: null,
            $_POST['competence'] ?: null,
            $_POST['disponibilite'] ?: null,
            isset($_POST['statut_actif']) ? 1 : 0,
            $idPersonne
        ]);

        $pdo->commit();
        $success = "Bénévole modifié avec succès.";
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Erreur lors de la modification : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un bénévole</title>
    <link rel="stylesheet" href="../style_form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="../asso-logo.png">
</head>
<body>

<h1 class="mt-3">Modifier le bénévole</h1>

<?php if ($error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<form method="post">
    <h3>Informations personnelles</h3>
    Nom: <input type="text" name="nom" value="<?= htmlspecialchars($benevole['nom']) ?>" required><br>
    Prénom: <input type="text" name="prenom" value="<?= htmlspecialchars($benevole['prenom']) ?>" required><br>
    Mail: <input type="email" name="mail" value="<?= htmlspecialchars($benevole['mail']) ?>"><br>
    Téléphone: <input type="text" name="telephone" value="<?= htmlspecialchars($benevole['telephone']) ?>"><br>
    Adresse: <input type="text" name="adresse" value="<?= htmlspecialchars($benevole['adresse']) ?>"><br>
    Ville: <input type="text" name="ville" value="<?= htmlspecialchars($benevole['ville']) ?>"><br>
    Code postal: <input type="text" name="code_postal" value="<?= htmlspecialchars($benevole['code_postal']) ?>"><br>
    Profession: <input type="text" name="profession" value="<?= htmlspecialchars($benevole['profession']) ?>"><br>
    Date de naissance: <input type="date" name="date_naissance" value="<?= htmlspecialchars($benevole['date_naissance']) ?>" required><br>

    <h3>Informations bénévolat</h3>
    Régime alimentaire: <input type="text" name="regime_alimentaire" value="<?= htmlspecialchars($benevole['regime_alimentaire']) ?>"><br>
    Problèmes physiques: <input type="text" name="limitation_physique" value="<?= htmlspecialchars($benevole['limitation_physique']) ?>"><br>
    Compétence: <input type="text" name="competence" value="<?= htmlspecialchars($benevole['competence']) ?>"><br>
    Disponibilités: <input type="text" name="disponibilite" value="<?= htmlspecialchars($benevole['disponibilite']) ?>"><br>
    Actif: <input type="checkbox" name="statut_actif" <?= $benevole['statut_actif'] ? 'checked' : '' ?>><br><br>

    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
</form>

<br>
<a href="index.php">⬅ Retour au tableau de bord</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>