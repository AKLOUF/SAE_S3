<?php
// Informations de connexion à la base de données
$host = 'localhost';       // ou l'adresse de ton serveur MySQL
$dbname = 'SAE_S3'; 
$user = 'root';
$pass = 'Imw26122006@';

// Nom du fichier de sauvegarde avec horodatage
$backupDir = '/Users/imadeddine/SAE-A2/sauvegardes';
$backupFile = $backupDir . '/backup_' . date('Y-m-d_H-i-s') . '.sql';

try {
    // Connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Commande pour exporter la base
    $command = "mysqldump --user=$user --password=$pass --host=$host $dbname > $backupFile";

    // Exécution de la commande
    system($command, $output);

    echo "Sauvegarde réussie ! Fichier généré : $backupFile";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>