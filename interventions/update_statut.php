<?php
require_once '../includes/db_connect.php';

// On vérifie qu'on a bien reçu un ID dans l'URL (syntaxe compatible toutes versions PHP)
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // On met à jour le statut à "Terminée"
    $update = $pdo->prepare("UPDATE interventions SET statut = 'Terminée' WHERE id = :id");
    $update->execute([':id' => $id]);
}

// On redirige immédiatement et silencieusement vers la liste
header('Location: index.php');
exit;
?>