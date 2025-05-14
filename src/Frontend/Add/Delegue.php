<?php
session_start(); // Démarre la session pour accéder aux données utilisateur
$isConnected = isset($_SESSION['user_id']); // Vérifie si l'utilisateur est connecté
require_once __DIR__ . '/../../Backend/Get/generateRegions.php';
require_once __DIR__ . '/../../Backend/auth.php'; // Vérifie si l'utilisateur est connecté
require_once __DIR__ . '/../../Backend/config.php';
$bdd = getDatabaseConnection();

// Vérifie si l'utilisateur a le rôle "responsable"
if (!hasRole('responsable')) {
    header('Location: ../ajout.php'); // Redirige vers une page accessible
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Délégué</title>
    <link rel="stylesheet" href="../../../public/css/form.css" />
</head>

<body>
    <header>
        <img src="../../../public/img/GSB-Logo.png" />
        <div class="menu">
            <a href="/">Home</a>
            <a href="../liste.php">Liste</a>
            <a href="../ajout.php">Ajout</a>
            <?php if ($isConnected): ?>
                <form action="../../Backend/logout.php" method="post" style="display: inline;">
                    <button type="submit" style="background: none; border: none; color: white; font-weight: bold; cursor: pointer;">Déconnexion</button>
                </form>
            <?php else: ?>
                <a href="../connexion.html">Se connecter</a>
            <?php endif; ?>
        </div>
    </header>

    <main>
        <section class="container">
            <h1>Ajouter un Délégué</h1>
            <form action="../../Backend/Add/AddDelegue.php" method="post">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" placeholder="Entrez le prénom" required>

                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" placeholder="Entrez le nom" required>

                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse" placeholder="Entrez l'adresse" required>

                <label for="mail">Email :</label>
                <input type="email" id="mail" name="mail" placeholder="Entrez l'email" required>

                <label for="telephone">Téléphone :</label>
                <input type="tel" id="telephone" name="telephone" placeholder="Entrez le numéro de téléphone" required>

                <label for="region">Région :</label>
                <select id="region" name="region" required>
                    <?php echo generateRegionOptions(); ?>
                </select>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" placeholder="Entrez un mot de passe" required>

                <button type="submit">Ajouter</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 GSB Rapports - Tous droits réservés.</p>
    </footer>
</body>

</html>