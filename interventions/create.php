<?php
require_once '../includes/db_connect.php';

// 1. Récupération de la liste des équipements pour le menu déroulant
$stmt = $pdo->query("SELECT id, nom FROM equipements ORDER BY nom ASC");
$equipements = $stmt->fetchAll(PDO::FETCH_ASSOC);

$erreur = "";

// 2. Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['id_equipement'])) {
        $erreur = "Veuillez sélectionner un équipement.";
    } else {
        $insert = $pdo->prepare("INSERT INTO interventions (id_equipement, date_intervention, technicien, type_intervention, commentaire, statut) 
                                 VALUES (:id_eq, :date_int, :tech, :type_int, :comm, 'En cours')");
        $insert->execute([
            ':id_eq' => $_POST['id_equipement'],
            ':date_int' => date('Y-m-d H:i:s'), // Date et heure actuelles
            ':tech' => $_POST['technicien'],
            ':type_int' => $_POST['type_intervention'],
            ':comm' => $_POST['commentaire']
        ]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle intervention</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Saisir une intervention</h1>
        
        <div class="menu">
            <a href="index.php">Retour à la liste</a>
        </div>

        <?php if (!empty($erreur)): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center; font-weight: bold;">
                <?= $erreur ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div>
                <label>Équipement concerné :</label>
                <select name="id_equipement" required>
                    <option value="">-- Choisir un équipement --</option>
                    <?php foreach ($equipements as $eq): ?>
                        <option value="<?= $eq['id'] ?>"><?= htmlspecialchars($eq['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label>Nom du technicien :</label>
                <input type="text" name="technicien" required>
            </div>
            
            <div>
                <label>Type d'intervention :</label>
                <select name="type_intervention" required>
                    <option value="Préventive">Préventive (Entretien)</option>
                    <option value="Curative">Curative (Réparation)</option>
                </select>
            </div>
            
            <div>
                <label>Commentaire / Travaux réalisés :</label>
                <textarea name="commentaire" rows="4"></textarea>
            </div>
            
            <div style="text-align: center; margin-top: 10px;">
                <button type="submit" class="btn btn-green">Enregistrer l'intervention</button>
            </div>
        </form>
    </div>
</body>
</html>