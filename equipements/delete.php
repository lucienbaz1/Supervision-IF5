<?php
require_once '../includes/db_connect.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    try {
        $delete = $pdo->prepare("DELETE FROM equipements WHERE id = :id");
        $delete->execute([':id' => $id]);
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        // Erreur 23000 = Violation de contrainte d'intégrité (clé étrangère)
        if ($e->getCode() == '23000') {
            die("<strong>Erreur :</strong> Impossible de supprimer cet équipement car des interventions de maintenance y sont déjà liées. <br><br><a href='index.php'>Retour</a>");
        } else {
            die("Erreur de suppression : " . $e->getMessage());
        }
    }
} else {
    header('Location: index.php');
    exit;
}  
?>