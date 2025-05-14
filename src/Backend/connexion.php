<?php
session_start(); // Démarre la session pour stocker les données utilisateur
require_once 'config.php';

// Récupère la connexion à la base de données
$bdd = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['pseudo']));
    $password = htmlspecialchars(trim($_POST['mdp']));

    try {
        // Récupère les informations de l'utilisateur
        $req = $bdd->prepare('SELECT Id_Utilisateur, NomUtilisateur, Role, IdRegion, MotDePasse FROM utilisateur WHERE NomUtilisateur = ?');
        $req->execute([$username]);
        $user = $req->fetch();

        if ($user && password_verify($password, $user['MotDePasse'])) {
            // Stocke les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['Id_Utilisateur'];
            $_SESSION['username'] = $user['NomUtilisateur'];
            $_SESSION['role'] = $user['Role'];
            $_SESSION['region_id'] = $user['IdRegion'];

            echo "<script>
                alert('Connexion réussie. Bienvenue, " . htmlspecialchars($user['NomUtilisateur']) . "!');
                window.location.href = '/';
            </script>";
        } else {
            echo "<script>
                alert('Login ou mot de passe incorrect.');
                window.history.back();
            </script>";
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>