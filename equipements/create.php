<?php
require_once '../includes/db_connect.php';

$erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $type = trim($_POST['type']);
    $localisation = trim($_POST['localisation']);
    $numero_serie = trim($_POST['numero_serie']);
    $date_installation = $_POST['date_installation'];

    if (empty($nom) || empty($type)) {
        $erreur = "Le nom et le type de l'équipement sont obligatoires.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO equipements (nom, type, localisation, numero_serie, date_installation) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $type, $localisation, $numero_serie, $date_installation]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un équipement</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un équipement</h1>
        
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
                <label>Nom de l'équipement :</label>
                <input type="text" name="nom" required style="width: 100%; box-sizing: border-box;">
            </div>
            
            <div>
                <label>Type :</label>
                <input type="text" name="type" required style="width: 100%; box-sizing: border-box;">
            </div>
            
            <div>
                <label>Localisation :</label>
                <input type="text" name="localisation" style="width: 100%; box-sizing: border-box;">
            </div>
            
            <div>
                <label>Numéro de série :</label>
                <input type="text" name="numero_serie" style="width: 100%; box-sizing: border-box;">
            </div>
            
            <div>
                <label>Date d'installation :</label>
                <input type="date" name="date_installation" value="<?= date('Y-m-d') ?>" style="width: 100%; box-sizing: border-box;">
            </div>

            <div style="text-align: center; margin-top: 10px;">
                <button type="submit" class="btn btn-green">Enregistrer l'équipement</button>
            </div>
        </form>
    </div>
</body>
</html>