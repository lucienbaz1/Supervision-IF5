<?php
require_once '../includes/db_connect.php';

// Requête avec jointure pour récupérer le nom de l'équipement
$sql = "SELECT i.*, e.nom AS nom_equipement 
        FROM interventions i 
        JOIN equipements e ON i.id_equipement = e.id 
        ORDER BY i.date_intervention DESC";
$stmt = $pdo->query($sql);
$interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>GMAO - Interventions</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Gestion de la Maintenance (GMAO)</h1>
        
        <div class="menu">
            <a href="../index.php">Retour à la supervision</a>
        </div>
        
        <a href="create.php" class="btn btn-green" style="margin-bottom: 20px; display: inline-block;">+ Ajouter une intervention</a>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Équipement</th>
                    <th>Technicien</th>
                    <th>Type</th>
                    <th>Commentaire</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($interventions as $inter): ?>
                    <tr>
                        <td><?= htmlspecialchars($inter['date_intervention']) ?></td>
                        <td><?= htmlspecialchars($inter['nom_equipement']) ?></td>
                        <td><?= htmlspecialchars($inter['technicien']) ?></td>
                        <td><?= htmlspecialchars($inter['type_intervention']) ?></td>
                        <td><?= htmlspecialchars($inter['commentaire']) ?></td>
                        <td>
                            <?php if ($inter['statut'] == 'Terminée'): ?>
                                <span style="color: green; font-weight: bold;">Terminée</span>
                            <?php else: ?>
                                <span style="color: orange; font-weight: bold;">En cours</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($inter['statut'] != 'Terminée'): ?>
                                <a href="update_statut.php?id=<?= $inter['id'] ?>" class="btn btn-blue" style="padding: 5px 10px; font-size: 0.9em;">Terminer</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if(empty($interventions)): ?>
                    <tr><td colspan="7" style="text-align: center;">Aucune intervention enregistrée.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>