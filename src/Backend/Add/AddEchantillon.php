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
        die("La date de distribution ne peut pas être ultérieure à la date actuelle.");
    }

    try {
        // Connexion à la base de données
        $bdd = getDatabaseConnection();

        // Préparation de la requête d'insertion
        $stmt = $bdd->prepare("
            INSERT INTO echantillon (NomEchantillon, DateDistributionEchantillon, Libele, QuantiteEchantillon)
            VALUES (:nom, :date, :libele, :quantite)
        ");

        // Exécution de la requête avec les données du formulaire
        $stmt->execute([
            ':nom' => $nom,
            ':date' => $date,
            ':libele' => $libele,
            ':quantite' => $quantite,
        ]);

        echo "<script>
            alert('Échantillon ajouté avec succès.');
            window.location.href = '../../Frontend/Add/Echantillon.php';
        </script>";
    } catch (Exception $e) {
        die("Erreur lors de l'ajout de l'échantillon : " . $e->getMessage());
    }
} else {
    die("Méthode non autorisée.");
}
?>