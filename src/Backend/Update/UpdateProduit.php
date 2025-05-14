<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProduit = intval($_POST['id_produit']);
    $nouvelleQuantite = intval($_POST['quantite']);

    // Vérification des champs obligatoires
    if (empty($idProduit) || empty($nouvelleQuantite)) {
        die("L'ID du produit et la nouvelle quantité sont obligatoires.");
    }

    try {
        // Connexion à la base de données
        $bdd = getDatabaseConnection();

        // Préparation de la requête de mise à jour
        $stmt = $bdd->prepare("
            UPDATE produit
            SET QuantiteProduit = :quantite
            WHERE Id_Produit = :id_produit
        ");

        // Exécution de la requête avec les données du formulaire
        $stmt->execute([
            ':quantite' => $nouvelleQuantite,
            ':id_produit' => $idProduit,
        ]);

        echo "<script>
            alert('Quantité mise à jour avec succès.');
            window.location.href = '../../Frontend/Update/Produit.php';
        </script>";
    } catch (Exception $e) {
        die("Erreur lors de la mise à jour de la quantité : " . $e->getMessage());
    }
} else {
    die("Méthode non autorisée.");
}
?>