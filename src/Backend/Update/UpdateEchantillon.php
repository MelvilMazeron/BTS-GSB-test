<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEchantillon = intval($_POST['id_echantillon']);
    $nouvelleQuantite = intval($_POST['quantite']);

    // Vérification des champs obligatoires
    if (empty($idEchantillon) || empty($nouvelleQuantite)) {
        die("L'ID de l'échantillon et la nouvelle quantité sont obligatoires.");
    }

    try {
        // Connexion à la base de données
        $bdd = getDatabaseConnection();

        // Préparation de la requête de mise à jour
        $stmt = $bdd->prepare("
            UPDATE echantillon
            SET QuantiteEchantillon = :quantite
            WHERE Id_Echantillon = :id_echantillon
        ");

        // Exécution de la requête avec les données du formulaire
        $stmt->execute([
            ':quantite' => $nouvelleQuantite,
            ':id_echantillon' => $idEchantillon,
        ]);

        echo "<script>
            alert('Quantité mise à jour avec succès.');
            window.location.href = '../../Frontend/Update/Echantillon.php';
        </script>";
    } catch (Exception $e) {
        die("Erreur lors de la mise à jour de la quantité : " . $e->getMessage());
    }
} else {
    die("Méthode non autorisée.");
}
?>