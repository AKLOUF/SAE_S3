<?php

// connexion à la base de données
$host = "localhost";
$dbname = "SAE_S3";
$user = "root";
$mot_pass = "Imw26122006@";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $mot_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>