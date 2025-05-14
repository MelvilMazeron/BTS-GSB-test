<?php
require_once '../config.php';
session_start(); // Assurez-vous que la session est démarrée

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez que region_id est défini dans la session
    if (!isset($_SESSION['region_id']) || !isset($_SESSION['user_id'])) {
        die("Erreur : L'ID de la région ou de l'utilisateur n'est pas défini. Veuillez vous reconnecter.");
    }

    $regionId = $_SESSION['region_id']; // Récupération de l'ID de la région
    $userId = $_SESSION['user_id']; // Récupération de l'ID de l'utilisateur connecté

    // Récupération des données du formulaire
    $idRapport = intval($_POST['id_rapport']);
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $codepostal = htmlspecialchars(trim($_POST['codepostal']));
    $date = htmlspecialchars(trim($_POST['date']));
    $echantillon = intval($_POST['echantillon']);
    $produit = intval($_POST['produit']);
    $visiteur = ($_POST['visiteur'] == $userId) ? $userId : intval($_POST['visiteur']); // Vérification de l'option "Moi"
    $practicien = intval($_POST['practicien']);

    // Vérification des champs obligatoires
    if (empty($idRapport) || empty($adresse) || empty($codepostal) || empty($date) || empty($echantillon) || empty($produit) || empty($visiteur) || empty($practicien)) {
        die("Tous les champs sont obligatoires.");
    }

    if (strtotime($date) > time()) {
        die("La date du rapport ne peut pas être ultérieure à la date actuelle.");
    }

    try {
        // Connexion à la base de données
        $bdd = getDatabaseConnection();

        // Préparation de la requête de mise à jour
        $stmt = $bdd->prepare("
            UPDATE rapport
            SET AdresseRapport = :adresse,
                CodePostal = :codepostal,
                DateRapport = :date,
                Id_Echantillon = :echantillon,
                Id_Produit = :produit,
                Id_Visiteur = :visiteur,
                Id_Practicien = :practicien,
                IdRegion = :regionId
            WHERE Id_Rappport = :idRapport
        ");

        // Exécution de la requête avec les données du formulaire
        $stmt->execute([
            ':adresse' => $adresse,
            ':codepostal' => $codepostal,
            ':date' => $date,
            ':echantillon' => $echantillon,
            ':produit' => $produit,
            ':visiteur' => $visiteur,
            ':practicien' => $practicien,
            ':regionId' => $regionId,
            ':idRapport' => $idRapport,
        ]);

        echo "<script>
            alert('Rapport mis à jour avec succès.');
            window.location.href = '../../Frontend/Update/Rapport.php';
        </script>";
    } catch (Exception $e) {
        die("Erreur lors de la mise à jour du rapport : " . $e->getMessage());
    }
} else {
    die("Méthode non autorisée.");
}
?>