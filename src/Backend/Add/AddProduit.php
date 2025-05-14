<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $date = htmlspecialchars(trim($_POST['date']));
    $libele = htmlspecialchars(trim($_POST['libele']));
    $quantite = intval($_POST['quantite']);

    // Vérification des champs obligatoires
    if (empty($nom) || empty($date) || empty($libele) || empty($quantite)) {
        die("Tous les champs sont obligatoires.");
    }

    if (strtotime($date) > time()) {
        die("La date d'ajout ne peut pas être ultérieure à la date actuelle.");
    }

    try {
        // Connexion à la base de données
        $bdd = getDatabaseConnection();

        // Préparation de la requête d'insertion
        $stmt = $bdd->prepare("
            INSERT INTO produit (NomProduit, DateAjoutProduit, Libele, QuantiteProduit)
            VALUES (:nom, :date, :libele, :quantite)
        ");

        // Exécution de la requête avec les données du formulaire
        $stmt->execute([
            ':nom' => $nom,
            ':date' => $date,
            ':libele' => $libele,
            ':quantite' => $quantite,
        ]);

        // permet de rediriger l'utilisateur vers la page d'ajout avec un message de succès
        echo "<script>
            alert('Produit ajouté avec succès.');
            window.location.href = '../../Frontend/Add/Produit.php';
        </script>";
    } catch (Exception $e) {
        die("Erreur lors de l'ajout du produit : " . $e->getMessage());
    }
} else {
    die("Méthode non autorisée.");
}
?>