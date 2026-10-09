<?php
require_once 'includes/db_connect.php';

$contenu = file_get_contents("data/etat_api.json");
$etat = json_decode($contenu, true);


$timestamp = isset($etat['timestamp']) ? $etat['timestamp'] : date('Y-m-d H:i:s');
$moteur = isset($etat['moteur']) ? $etat['moteur'] : 0;
$convoyeur = isset($etat['convoyeur']) ? $etat['convoyeur'] : 0;
$temperature = isset($etat['temperature']) ? $etat['temperature'] : 0;
$niveau = isset($etat['niveau']) ? $etat['niveau'] : 0;
$alarme = isset($etat['alarme']) ? $etat['alarme'] : "";


if ($alarme != "" && $alarme != "Aucune") {
    $stmt = $pdo->query("SELECT valeur FROM events_api ORDER BY id DESC LIMIT 1");
    $derniere_alarme = $stmt->fetchColumn();

    if ($alarme !== $derniere_alarme) {
        $insert = $pdo->prepare("INSERT INTO events_api (horodatage, type_event, valeur, acquitte) VALUES (?, 'ALARME', ?, 0)");
        $insert->execute([$timestamp, $alarme]);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5">
    <title>Supervision Industrielle SAE 51</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Écran de Supervision SAE 51</h1>
        

        <div class="menu">
            <a href="events.php">Journal des événements</a>
            <a href="equipements/index.php">Équipements</a>
            <a href="interventions/index.php">GMAO</a>
        </div>
        

        <p style="text-align: center; color: gray; font-weight: bold;">
            Dernière mise à jour : <?= htmlspecialchars($timestamp) ?>
        </p>


        <div style="display: flex; gap: 20px; justify-content: center; margin-top: 20px;">
            

            <div style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 45%;">
                <h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px;">Actionneurs</h3>
                
                <div style="font-size: 1.2em; margin-bottom: 10px; font-weight: bold; color: <?= ($moteur == 1) ? 'green' : 'red' ?>;">
                    ● Moteur : <?= ($moteur == 1) ? 'ON' : 'OFF' ?>
                </div>
                
                <div style="font-size: 1.2em; font-weight: bold; color: <?= ($convoyeur == 1) ? 'green' : 'red' ?>;">
                    ● Convoyeur : <?= ($convoyeur == 1) ? 'ON' : 'OFF' ?>
                </div>
            </div>


            <div style="border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 45%;">
                <h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px;">Mesures</h3>
                
                <div style="font-size: 1.2em; margin-bottom: 10px;">
                    Température : <strong><?= htmlspecialchars($temperature) ?> °C</strong>
                </div>
                
                <div style="font-size: 1.2em;">
                    Niveau cuve : <strong><?= htmlspecialchars($niveau) ?> %</strong>
                </div>
            </div>

        </div>

        <div style="margin-top: 30px;">
            <?php if ($alarme != "" && $alarme != "Aucune"): ?>
                <div style="background-color: #dc3545; color: white; padding: 15px; border-radius: 8px; text-align: center; font-size: 1.3em; font-weight: bold;">
                    ALARME : <?= htmlspecialchars($alarme) ?>
                </div>
            <?php else: ?>
                <div style="background-color: #28a745; color: white; padding: 15px; border-radius: 8px; text-align: center; font-size: 1.1em; font-weight: bold;">
                    Système en fonctionnement normal
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>