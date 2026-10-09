<?php
require_once 'includes/db_connect.php';

// 1. On force le navigateur à télécharger un fichier CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=historique_alarmes_' . date('Y-m-d') . '.csv');

// 2. On ouvre la sortie standard de PHP (comme si on écrivait dans un fichier)
$output = fopen('php://output', 'w');

// 3. On ajoute la ligne d'en-tête du tableau (les titres des colonnes)
// On utilise le point-virgule (;) comme séparateur car c'est le standard pour Excel en français
fputcsv($output, ['ID', 'Date et Heure', 'Type', 'Message (Valeur)', 'Acquitté'], ';');

// 4. On récupère toutes les alarmes dans la base de données
$stmt = $pdo->query("SELECT * FROM events_api ORDER BY horodatage DESC");

// 5. On boucle sur les résultats pour les écrire ligne par ligne dans le fichier
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // On transforme le 0 ou 1 en "Non" ou "Oui" pour que ce soit lisible
    $etat_acquitte = ($row['acquitte'] == 1) ? 'Oui' : 'Non';
    
    // On écrit la ligne
    fputcsv($output, [
        $row['id'], 
        $row['horodatage'], 
        $row['type_event'], 
        $row['valeur'], 
        $etat_acquitte
    ], ';');
}

// 6. On ferme le fichier et on arrête le script
fclose($output);
exit;
?>