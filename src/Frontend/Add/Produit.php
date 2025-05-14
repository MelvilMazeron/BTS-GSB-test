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
    <title>Ajouter un Produit</title>
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
            <h1>Ajouter un Produit</h1>
            <form action="../../Backend/Add/AddProduit.php" method="post">
                <label for="nom">Nom du Produit :</label>
                <input type="text" id="nom" name="nom" placeholder="Entrez le nom du produit" required>

                <label for="date">Date d'Ajout :</label>
                <input type="date" id="date" name="date" max="<?php echo date('Y-m-d'); ?>" required>

                <label for="libele">Libellé :</label>
                <input type="text" id="libele" name="libele" placeholder="Entrez le libellé" required>

                <label for="quantite">Quantité :</label>
                <input type="number" id="quantite" name="quantite" placeholder="Entrez la quantité" required>

                <button type="submit">Ajouter</button>
            </form>
        </section>

        <section class="container">
            <h2>Mettre à jour un Produit</h2>
            <p>Vous souhaitez modifier la quantité d'un produit existant ?</p>
            <a href="../Update/produit.php" class="btn">Mettre à jour un produit</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 GSB Rapports - Tous droits réservés.</p>
    </footer>
</body>

</html>