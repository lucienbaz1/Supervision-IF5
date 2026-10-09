<?php
require_once '../includes/db_connect.php';

// Récupération de tous les équipements
$stmt = $pdo->query("SELECT * FROM equipements ORDER BY id DESC");
$equipements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Équipements</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Référentiel des Équipements</h1>
        
        <div class="menu">
            <a href="../index.php">Retour à la supervision</a>
        </div>
        
        <a href="create.php" class="btn btn-green" style="margin-bottom: 20px; display: inline-block;">+ Ajouter un équipement</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Localisation</th>
                    <th>Numéro de série</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipements as $eq): ?>
                    <tr>
                        <td><?= $eq['id'] ?></td>
                        <td><?= htmlspecialchars($eq['nom']) ?></td>
                        <td><?= htmlspecialchars($eq['type']) ?></td>
                        <td><?= htmlspecialchars($eq['localisation']) ?></td>
                        <td><?= htmlspecialchars($eq['numero_serie']) ?></td>
                        <td>
                            <a href="update.php?id=<?= $eq['id'] ?>" class="btn btn-blue" style="padding: 5px 10px; font-size: 0.9em;">Modifier</a>
                            <a href="delete.php?id=<?= $eq['id'] ?>" class="btn btn-red" style="padding: 5px 10px; font-size: 0.9em;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet équipement ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($equipements)): ?>
                    <tr><td colspan="6" style="text-align: center;">Aucun équipement enregistré.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>