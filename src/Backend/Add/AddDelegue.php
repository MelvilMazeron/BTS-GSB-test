<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $nom = htmlspecialchars(trim($_POST['nom']));
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $mail = htmlspecialchars(trim($_POST['mail']));
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $region = intval($_POST['region']);
    $password = htmlspecialchars(trim($_POST['password']));

    // Validation des champs
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('L\'adresse e-mail est invalide.'); window.history.back();</script>";
        exit;
    }

    if (!preg_match('/^\+?[0-9\s\-]+$/', $telephone)) {
        echo "<script>alert('Le numéro de téléphone est invalide.'); window.history.back();</script>";
        exit;
    }

    if (strlen($password) < 8) {
        echo "<script>alert('Le mot de passe doit contenir au moins 8 caractères.'); window.history.back();</script>";
        exit;
    }

    try {
        $bdd = getDatabaseConnection();
        if (!$bdd) {
            throw new Exception("Impossible de se connecter à la base de données.");
        }

        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Création de l'utilisateur avec le rôle "délégué" et l'ID de la région
        $req = $bdd->prepare('
            INSERT INTO utilisateur (NomUtilisateur, PrenomUtilisateur, NumeroTelephoneUtilisateur, MailUtilisateur, MotDePasse, Role, IdRegion)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ');
        $req->execute([$nom, $prenom, $telephone, $mail, $hashedPassword, 'delegue', $region]);

        // Affichage d'une popup de réussite et redirection
        echo "<script>
            alert('Délégué ajouté avec succès.');
            window.location.href = '../../Frontend/Add/AddDelegue.php';
        </script>";
    } catch (Exception $e) {
        echo "<script>alert('Erreur : " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
    }
}
?>