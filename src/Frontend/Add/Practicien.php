<?php
session_start(); // Démarre la session pour accéder aux données utilisateur
$isConnected = isset($_SESSION['user_id']); // Vérifie si l'utilisateur est connecté
require_once __DIR__ . '/../../Backend/Get/generateRegions.php';
require_once '../../Backend/auth.php'; // Vérifie si l'utilisateur est connecté
require_once '../../Backend/config.php';
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
    <title>Ajouter un Praticien</title>
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
            <h1>Ajouter un Praticien</h1>
            <form action="../../Backend/Add/AddPracticien.php" method="post">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" placeholder="Entrez l'email" required>

                <label for="specialite">Spécialité :</label>
                <input type="text" id="specialite" name="specialite" placeholder="Entrez la spécialité" required>

                <label for="description">Description :</label>
                <textarea id="description" name="description" placeholder="Entrez une description" required></textarea>

                <label for="cabinet">Cabinet :</label>
                <input type="text" id="cabinet" name="cabinet" placeholder="Entrez le cabinet" required>

                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse" placeholder="Entrez l'adresse" required>

                <label for="codepostal">Code Postal :</label>
                <input type="text" id="codepostal" name="codepostal" placeholder="Entrez le code postal" required>

                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" placeholder="Entrez la ville" required>

                <label for="region">Région :</label>
                <select id="region" name="region" required>
                    <?php echo generateRegionOptions(); ?>
                </select>

                <button type="submit">Ajouter</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 GSB Rapports - Tous droits réservés.</p>
    </footer>
</body>

</html>