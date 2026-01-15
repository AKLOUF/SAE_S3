<?php
session_start();

// Si l'utilisateur est déjà connecté, on bloque l'accès au formulaire
if (isset($_SESSION['idPersonne']) && isset($_SESSION['role'])) {
    header("Location: liste_fonction.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style_form.css">
    <title>Formulaire de connexion</title>
</head>
<body>
    <h1>Formulaire de connexion</h1>
<form method="POST" action="login.php" class="form-container">
    <div class="form-group">
        <label for="pseudo">Nom</label>
        <input type="text" name="login" placeholder="Login" required class="form-control">
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" placeholder="Mot de passe" required class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>
</body>
</html>
