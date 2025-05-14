<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $mdp = htmlspecialchars(trim($_POST['mdp']));
    $confmdp = htmlspecialchars(trim($_POST['confmdp']));
    $mail = htmlspecialchars(trim($_POST['mail']));
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $role = htmlspecialchars(trim($_POST['role']));

    // Vérification des mots de passe
    if ($mdp !== $confmdp) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    // Validation du numéro de téléphone
    if (!preg_match('/^\+?[0-9\s\-]+$/', $telephone)) {
        echo "Le numéro de téléphone est invalide.";
        exit;
    }

    // Validation de l'adresse e-mail
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse e-mail est invalide.";
        exit;
    }

    // Validation du rôle
    $rolesAutorises = ['visiteur', 'delegue', 'responsable'];
    if (!in_array($role, $rolesAutorises)) {
        echo "Le rôle spécifié est invalide.";
        exit;
    }

    try {
        // Vérification de la connexion à la base de données
        $bdd = getDatabaseConnection();
        if (!$bdd) {
            throw new Exception("Impossible de se connecter à la base de données.");
        }

        // Hachage du mot de passe
        $hashed_password = password_hash($mdp, PASSWORD_DEFAULT);

        // Insertion des données dans la base de données
        $req = $bdd->prepare('INSERT INTO utilisateur (MotDePasse, NomUtilisateur, PrenomUtilisateur, NumeroTelephoneUtilisateur, MailUtilisateur, `Role`) VALUES (?, ?, ?, ?, ?, ?)');
        $req->execute([$hashed_password, $nom, $prenom, $telephone, $mail, $role]);

        echo "Inscription réussie. <a href='../Frontend/connexion.html'>Se connecter</a>";
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>