<?php
session_start();

// Supprimer toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion
header("Location: ../page_d'acceuil/acceuil.html");
require '../fonction_6/sauvegarde.php';
exit();