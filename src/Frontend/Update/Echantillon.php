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
    <title>Mettre à jour la quantité d'un Échantillon</title>
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
            <h1>Mettre à jour la quantité d'un Échantillon</h1>
            <form action="../../Backend/Update/UpdateEchantillon.php" method="post">
                <label for="id_echantillon">Échantillon :</label>
                <select id="id_echantillon" name="id_echantillon" required>
                    <option value="">Sélectionnez un échantillon</option>
                    <?php
                    require_once '../../Backend/config.php';
                    $bdd = getDatabaseConnection();
                    $echantillons = $bdd->query('SELECT Id_Echantillon, NomEchantillon FROM echantillon');
                    foreach ($echantillons as $echantillon) {
                        echo "<option value=\"{$echantillon['Id_Echantillon']}\">{$echantillon['NomEchantillon']}</option>";
                    }
                    ?>
                </select>

                <label for="quantite">Nouvelle Quantité :</label>
                <input type="number" id="quantite" name="quantite" placeholder="Entrez la nouvelle quantité" required>

                <button type="submit">Mettre à jour</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 GSB Rapports - Tous droits réservés.</p>
    </footer>
</body>

</html>