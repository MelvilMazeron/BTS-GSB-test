<?php
require_once '../config.php';
session_start(); // Assurez-vous que la session est démarrée

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez que region_id est défini dans la session
    if (!isset($_SESSION['region_id'])) {
        die("Erreur : L'ID de la région n'est pas défini. Veuillez vous reconnecter.");
    }

    $regionId = $_SESSION['region_id']; // Récupération de l'ID de la région
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $codepostal = htmlspecialchars(trim($_POST['codepostal'])); // Récupération du code postal
    $date = htmlspecialchars(trim($_POST['date']));
    $echantillon = intval($_POST['echantillon']);
    $produit = intval($_POST['produit']);
    $visiteur = intval($_POST['visiteur']);
    $practicien = intval($_POST['practicien']);

    // Vérification des champs obligatoires
    if (empty($adresse) || empty($codepostal) || empty($date) || empty($echantillon) || empty($produit) || empty($visiteur) || empty($practicien)) {
        die("Tous les champs sont obligatoires.");
    }

    if (strtotime($date) > time()) {
        die("La date du rapport ne peut pas être ultérieure à la date actuelle.");
    }

    try {
        // Connexion à la base de données
        $bdd = getDatabaseConnection();

        // Préparation de la requête d'insertion
        $stmt = $bdd->prepare("
            INSERT INTO rapport (AdresseRapport, CodePostal, DateRapport, Id_Echantillon, Id_Produit, Id_Visiteur, Id_Practicien, IdRegion)
            VALUES (:adresse, :codepostal, :date, :echantillon, :produit, :visiteur, :practicien, :regionId)
        ");

        // Exécution de la requête avec les données du formulaire
        $stmt->execute([
            ':adresse' => $adresse,
            ':codepostal' => $codepostal, // Ajout du code postal
            ':date' => $date,
            ':echantillon' => $echantillon,
            ':produit' => $produit,
            ':visiteur' => $visiteur,
            ':practicien' => $practicien,
            ':regionId' => $regionId, // Ajout de la région
        ]);

        echo "<script>
            alert('Rapport ajouté avec succès.');
            window.location.href = '../../Frontend/Add/Rapport.php';
        </script>";
    } catch (Exception $e) {
        die("Erreur lors de l'ajout du rapport : " . $e->getMessage());
    }
} else {
    die("Méthode non autorisée.");
}
?>