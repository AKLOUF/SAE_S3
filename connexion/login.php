<?php
session_start();

// Si l'utilisateur est déjà connecté et n'envoie pas le formulaire
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && isset($_SESSION['idPersonne']) && isset($_SESSION['role'])) {
    header("Location: liste_fonction.html");
    exit();
}

require 'db_connect.php';

// traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM COMPTE WHERE login = :login AND actif = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['login' => $login]);
    $compte = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($compte && password_verify($password, $compte['mot_de_passe_hash']) && ($compte['role'] == 'bureau' || $compte['role'] == 'admin')) {

        // création de la session
        $_SESSION['idPersonne'] = $compte['idPersonne'];
        $_SESSION['role'] = $compte['role'];

        // redirection après connexion
        header("Location: liste_fonction.html");
        exit();

    } else {
        // échec connexion
        header("Location: form.php?erreur=1");
        exit();
    }
}
