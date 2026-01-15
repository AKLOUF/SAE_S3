<?php
session_start();
require '../connexion/db_connect.php';

// Vérification du rôle
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'bureau' && $_SESSION['role'] !== 'admin' )) {
    header("Location: ../connexion/form.php");
    exit();
}

// Vérifier le type d'export demandé
$type = isset($_GET['type']) ? $_GET['type'] : 'pdf'; // pdf ou csv

// Récupérer tous les dons
$stmt = $pdo->query("
    SELECT d.montant, d.date_, p.nom, p.prenom
    FROM DON d
    JOIN DONATEUR da ON d.idPersonne = da.idPersonne
    JOIN PERSONNE p ON da.idPersonne = p.idPersonne
    ORDER BY d.date_ DESC
");
$dons = $stmt->fetchAll();

// Export CSV
if($type === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=dons.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Nom', 'Prénom', 'Montant', 'Date'], ';', '"', '\\');
    
    foreach ($dons as $don) {
        fputcsv(
            $output,
            [$don['nom'], $don['prenom'], $don['montant'], $don['date_']],
            ';',
            '"',
            '\\'
        );
    }
    fclose($output);
    exit();
}

// Export PDF
if($type === 'pdf') {
    require_once __DIR__ . '/../vendor/autoload.php';
    if (!class_exists('TCPDF')) {
        die('❌ TCPDF non chargé');
    }

    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    $html = '<h1>Historique des Dons</h1><table border="1" cellpadding="5">
                <tr>
                    <th>Nom</th><th>Prénom</th><th>Montant</th><th>Date</th>
                </tr>';

    foreach($dons as $don) {
        $html .= '<tr>
                    <td>'.htmlspecialchars($don['nom']).'</td>
                    <td>'.htmlspecialchars($don['prenom']).'</td>
                    <td>'.htmlspecialchars($don['montant']).'</td>
                    <td>'.htmlspecialchars($don['date_']).'</td>
                  </tr>';
    }
    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('dons.pdf', 'D'); // D = téléchargement
    exit();
}

// Si aucun type valide
echo "Type d'export non valide.";