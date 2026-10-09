<?php
require_once 'includes/db_connect.php';

// Gestion de l'acquittement
if (isset($_GET['id_acquitter'])) {
    $update = $pdo->prepare("UPDATE events_api SET acquitte = 1 WHERE id = :id");
    $update->execute([':id' => $_GET['id_acquitter']]);
    header('Location: events.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM events_api ORDER BY horodatage DESC");
$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Journal des événements</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Journal des Événements</h1>
        
        <div class="menu">
            <a href="index.php">Retour à la supervision</a>
        </div>

        <p style="margin-bottom: 20px;">
            <a href="export_csv.php" class="btn btn-green">Exporter l'historique (.csv)</a>
        </p>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date et Heure</th>
                    <th>Type</th>
                    <th>Message</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evenements as $event): ?>
                    <tr style="<?= ($event['acquitte'] == 0) ? 'background-color: #f8d7da;' : '' ?>">
                        <td><?= $event['id'] ?></td>
                        <td><?= htmlspecialchars($event['horodatage']) ?></td>
                        <td><?= htmlspecialchars($event['type_event']) ?></td>
                        <td><?= htmlspecialchars($event['valeur']) ?></td>
                        <td>
                            <?php if ($event['acquitte'] == 0): ?>
                                <a href="events.php?id_acquitter=<?= $event['id'] ?>" class="btn btn-yellow" style="padding: 5px 10px; font-size: 0.9em;">Acquitter</a>
                            <?php else: ?>
                                <span style="color: green; font-weight: bold;">✓ Acquitté</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($evenements)): ?>
                    <tr><td colspan="5" style="text-align: center;">Aucun événement enregistré.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>