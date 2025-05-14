<?php
session_start(); // Démarre la session pour accéder aux données utilisateur
$isConnected = isset($_SESSION['user_id']); // Vérifie si l'utilisateur est connecté
require_once '../../Backend/auth.php'; // Vérifie si l'utilisateur est connecté
require_once '../../Backend/config.php';
$bdd = getDatabaseConnection();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à jour un Rapport</title>
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
            <h1>Mettre à jour un Rapport</h1>
            <form action="../../Backend/Update/UpdateRapport.php" method="post">
                <label for="id_rapport">Rapport :</label>
                <select id="id_rapport" name="id_rapport" required>
                    <option value="">Sélectionnez un rapport</option>
                    <?php
                    require_once '../../Backend/config.php';
                    $bdd = getDatabaseConnection();
                    $rapports = $bdd->query('SELECT Id_Rappport, AdresseRapport FROM rapport');
                    foreach ($rapports as $rapport) {
                        echo "<option value=\"{$rapport['Id_Rappport']}\">{$rapport['AdresseRapport']}</option>";
                    }
                    ?>
                </select>

                <label for="adresse">Adresse du Rapport :</label>
                <input type="text" id="adresse" name="adresse" placeholder="Entrez l'adresse du rapport" required>

                <label for="codepostal">Code Postal :</label>
                <input type="text" id="codepostal" name="codepostal" placeholder="Entrez le code postal" required>

                <label for="date">Date du Rapport :</label>
                <input type="date" id="date" name="date" max="<?php echo date('Y-m-d'); ?>" required>

                <label for="echantillon">Échantillon :</label>
                <select id="echantillon" name="echantillon" required>
                    <option value="">Sélectionnez un échantillon</option>
                    <?php
                    $echantillons = $bdd->query('SELECT Id_Echantillon, NomEchantillon FROM echantillon');
                    foreach ($echantillons as $echantillon) {
                        echo "<option value=\"{$echantillon['Id_Echantillon']}\">{$echantillon['NomEchantillon']}</option>";
                    }
                    ?>
                </select>

                <label for="produit">Produit :</label>
                <select id="produit" name="produit" required>
                    <option value="">Sélectionnez un produit</option>
                    <?php
                    $produits = $bdd->query('SELECT Id_Produit, NomProduit FROM produit');
                    foreach ($produits as $produit) {
                        echo "<option value=\"{$produit['Id_Produit']}\">{$produit['NomProduit']}</option>";
                    }
                    ?>
                </select>

                <label for="visiteur">Visiteur :</label>
                <select id="visiteur" name="visiteur" required>
                    <option value="<?php echo $_SESSION['user_id']; ?>"><?php echo $_SESSION['username']; ?></option> <!-- Option "Moi" -->
                    <?php
                    $visiteurs = $bdd->query('SELECT Id_Utilisateur, PrenomUtilisateur FROM utilisateur WHERE Role = "visiteur"');
                    foreach ($visiteurs as $visiteur) {
                        echo "<option value=\"{$visiteur['Id_Utilisateur']}\">{$visiteur['PrenomUtilisateur']}</option>";
                    }
                    ?>
                </select>

                <label for="practicien">Praticien :</label>
                <select id="practicien" name="practicien" required>
                    <option value="">Sélectionnez un praticien</option>
                    <?php
                    $practiciens = $bdd->query('SELECT Id_Practicien, EmailPracticien FROM practicien');
                    foreach ($practiciens as $practicien) {
                        echo "<option value=\"{$practicien['Id_Practicien']}\">{$practicien['EmailPracticien']}</option>";
                    }
                    ?>
                </select>

                <button type="submit">Mettre à jour</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 GSB Rapports - Tous droits réservés.</p>
    </footer>
</body>

</html>