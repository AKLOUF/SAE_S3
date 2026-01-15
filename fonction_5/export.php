<?php
session_start();
require '../connexion/db_connect.php';
require_once __DIR__ . '/../vendor/autoload.php';

// Vérification de TCPDF
if (!class_exists('TCPDF')) {
    die('❌ TCPDF non chargé');
}

// --- Récupération des données ---
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// Nombre de bénévoles actifs
$nbBenevoles = $pdo->query("SELECT COUNT(*) AS nb FROM BENEVOLE WHERE statut_actif = 1")->fetch()['nb'];

// Nombre de donneurs
$nbDonateurs = $pdo->query("SELECT COUNT(*) AS nb FROM DONATEUR")->fetch()['nb'];

// Répartition par âge
$ageDataStmt = $pdo->query("
    SELECT 
      CASE 
        WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) <= 18 THEN '0-18'
        WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) <= 35 THEN '19-35'
        WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) <= 50 THEN '36-50'
        ELSE '51+'
      END AS tranche_age,
      COUNT(*) AS nb
    FROM PERSONNE
    GROUP BY tranche_age
");
$ageData = $ageDataStmt->fetchAll();

// Répartition par profession
$profDataStmt = $pdo->query("
    SELECT profession, COUNT(*) AS nb
    FROM PERSONNE Pe
    GROUP BY profession
");
$profData = $profDataStmt->fetchAll();

// Total dons et cotisations
$totalDons = $pdo->query("SELECT SUM(montant) AS total FROM DON")->fetch()['total'];
$totalCotisation = $pdo->query("SELECT SUM(montant) AS total FROM COTISATION")->fetch()['total'];

// Nombre de missions et participations
$nbMissions = $pdo->query("SELECT COUNT(*) AS nb FROM MISSION")->fetch()['nb'];
$nbParticipations = $pdo->query("SELECT COUNT(*) AS nb FROM AFFECTE_A_MISSION")->fetch()['nb'];

// --- Création du PDF ---
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = '<h1>Tableau de bord - Indicateurs clés</h1>';

$html .= "<p><b>Nombre de bénévoles actifs :</b> $nbBenevoles</p>";
$html .= "<p><b>Nombre de donateurs :</b> $nbDonateurs</p>";
$html .= "<p><b>Total des dons :</b> $totalDons €</p>";
$html .= "<p><b>Total des cotisations :</b> $totalCotisation €</p>";
$html .= "<p><b>Nombre de missions :</b> $nbMissions</p>";
$html .= "<p><b>Nombre de participations :</b> $nbParticipations</p>";

// Tableau répartition par âge
$html .= '<h2>Répartition par âge</h2><table border="1" cellpadding="5"><tr><th>Tranche</th><th>Nombre</th></tr>';
foreach($ageData as $row) {
    $html .= "<tr><td>{$row['tranche_age']}</td><td>{$row['nb']}</td></tr>";
}
$html .= '</table>';

// Tableau répartition par profession
$html .= '<h2>Répartition par profession</h2><table border="1" cellpadding="5"><tr><th>Profession</th><th>Nombre</th></tr>';
foreach($profData as $row) {
    $html .= "<tr><td>{$row['profession']}</td><td>{$row['nb']}</td></tr>";
}
$html .= '</table>';

// Génération et téléchargement
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('dashboard.pdf', 'D');
exit();