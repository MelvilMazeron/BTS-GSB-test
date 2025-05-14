<?php
require_once  '../config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $nom = htmlspecialchars(trim($_POST['nom']));
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $mail = htmlspecialchars(trim($_POST['mail']));
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $region = intval($_POST['region']);
    $password = htmlspecialchars(trim($_POST['password']));

    // Vérification des champs obligatoires
    if (empty($prenom) || empty($nom) || empty($adresse) || empty($mail) || empty($telephone) || empty($region) || empty($password)) {
        die("Tous les champs sont obligatoires.");
    }

    try {
        // Connexion à la base de données
        $bdd = getDatabaseConnection();

        // Préparation de la requête d'insertion
        $stmt = $bdd->prepare("
            INSERT INTO utilisateur (MotDePasse, NomUtilisateur, Role, PrenomUtilisateur, NumeroTelephoneUtilisateur, MailUtilisateur, IdRegion)
            VALUES (:password, :nom, 'visiteur', :prenom, :telephone, :mail, :region)
        ");

        // Exécution de la requête avec les données du formulaire
        $stmt->execute([
            ':password' => password_hash($password, PASSWORD_DEFAULT), // Hachage du mot de passe
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':telephone' => $telephone,
            ':mail' => $mail,
            ':region' => $region,
        ]);

        echo "<script>
            alert('Visiteur ajouté avec succès.');
            window.location.href = '../../Frontend/Add/Visiteur.php';
        </script>";
    } catch (Exception $e) {
        die("Erreur lors de l'ajout du visiteur : " . $e->getMessage());
    }
} else {
    die("Méthode non autorisée.");
}
?>