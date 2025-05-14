<?php
session_start(); // Démarre la session pour accéder aux données utilisateur
$isConnected = isset($_SESSION['user_id']); // Vérifie si l'utilisateur est connecté
require_once '../../Backend/auth.php'; // Vérifie si l'utilisateur est connecté
require_once '../../Backend/config.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['region_id'])) {
    die("Vous devez être connecté pour accéder à cette page.");
}

$regionId = $_SESSION['region_id']; // Récupère l'ID de la région de l'utilisateur connecté

try {
    $bdd = getDatabaseConnection();
    $stmt = $bdd->prepare("
        SELECT 
            r.AdresseRapport, 
            r.CodePostal, 
            r.DateRapport, 
            p.NomProduit, 
            e.NomEchantillon, 
            v.PrenomUtilisateur AS Visiteur, 
            pr.EmailPracticien AS Practicien
        FROM rapport r
        JOIN produit p ON r.Id_Produit = p.Id_Produit
        JOIN echantillon e ON r.Id_Echantillon = e.Id_Echantillon
        JOIN utilisateur v ON r.Id_Visiteur = v.Id_Utilisateur
        JOIN practicien pr ON r.Id_Practicien = pr.Id_Practicien
        WHERE r.IdRegion = :regionId
    ");
    $stmt->execute([':regionId' => $regionId]);
    $reports = $stmt->fetchAll();
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

// Vérifie si l'utilisateur a le rôle "responsable"
if (!hasRole('delegue')) {
    header('Location: ../liste.php'); // Redirige vers une page accessible
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports par Région</title>
    <link rel="stylesheet" href="../../../public/css/table.css">
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
            <h1>Rapports par Région</h1>
            <table>
                <thead>
                    <tr>
                        <th>Adresse</th>
                        <th>Code Postal</th>
                        <th>Date</th>
                        <th>Produit</th>
                        <th>Échantillon</th>
                        <th>Visiteur</th>
                        <th>Praticien</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reports)): ?>
                        <?php foreach ($reports as $report): ?>
                            <tr>
                                <td><?= htmlspecialchars($report['AdresseRapport']) ?></td>
                                <td><?= htmlspecialchars($report['CodePostal']) ?></td>
                                <td><?= htmlspecialchars($report['DateRapport']) ?></td>
                                <td><?= htmlspecialchars($report['NomProduit']) ?></td>
                                <td><?= htmlspecialchars($report['NomEchantillon']) ?></td>
                                <td><?= htmlspecialchars($report['Visiteur']) ?></td>
                                <td><?= htmlspecialchars($report['Practicien']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">Aucun rapport trouvé pour cette région.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 GSB Rapports - Tous droits réservés.</p>
    </footer>
</body>

</html>