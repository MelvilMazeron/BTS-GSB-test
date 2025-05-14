<?php
session_start(); // Démarre la session pour accéder aux données utilisateur
$isConnected = isset($_SESSION['user_id']); // Vérifie si l'utilisateur est connecté
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
    <title>Ajouter un Échantillon</title>
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
            <h1>Ajouter un Échantillon</h1>
            <form action="../../Backend/Add/AddEchantillon.php" method="post">
                <label for="nom">Nom de l'Échantillon :</label>
                <input type="text" id="nom" name="nom" placeholder="Entrez le nom de l'échantillon" required>

                <label for="date">Date de Distribution :</label>
                <input type="date" id="date" name="date" max="<?php echo date('Y-m-d'); ?>" required>

                <label for="libele">Libellé :</label>
                <input type="text" id="libele" name="libele" placeholder="Entrez le libellé" required>

                <label for="quantite">Quantité :</label>
                <input type="number" id="quantite" name="quantite" placeholder="Entrez la quantité" required>

                <button type="submit">Ajouter</button>
            </form>
        </section>

        <section class="container">
            <h2>Mettre à jour un Échantillon</h2>
            <p>Vous souhaitez modifier la quantité d'un échantillon existant ?</p>
            <a href="../Update/Echantillon.php" class="btn">Mettre à jour un Échantillon</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 GSB Rapports - Tous droits réservés.</p>
    </footer>
</body>

</html>