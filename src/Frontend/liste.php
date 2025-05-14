<?php
session_start(); // Démarre la session pour accéder aux données utilisateur
$isConnected = isset($_SESSION['user_id']); // Vérifie si l'utilisateur est connecté
require_once '../Backend/auth.php'; // Vérifie si l'utilisateur est connecté
require_once '../Backend/config.php';
$bdd = getDatabaseConnection();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GSB Rapports - Accueil</title>
  <link rel="stylesheet" href="../../public/css/ajout.css" />
</head>

<body>
  <header>
    <img src="../../public/img/GSB-Logo.png" />
    <div class="menu">
      <a href="/">Home</a>
      <a href="ajout.php">Ajout</a>
      <?php if ($isConnected): ?>
        <form action="../Backend/logout.php" method="post" style="display: inline;">
          <button type="submit" style="background: none; border: none; color: white; font-weight: bold; cursor: pointer;">Déconnexion</button>
        </form>
      <?php else: ?>
        <a href="connexion.html">Se connecter</a>
      <?php endif; ?>
    </div>
  </header>

  <main>
    <div class="title">
      <h1>Liste</h1>
    </div>
    <section>
      <a href="./Tableau/RapportPerso.php" class="lg-container">
        <img src="../../public/img/VisiteurCard.png" alt="Visiteur" />
        <h3>Rapport personelle</h3>
        <p>liste de vos rapports</p>
      </a>

      <?php if (hasRole('delegue')): ?>
        <a href="./Tableau/RapportRegion.php" class="lg-container">
          <img src="../../public/img/Delegue.png" alt="Délégué" />
          <h3>Rapport Régional</h3>
          <p>liste de tout les raports régionaux</p>
        </a>
      <?php endif; ?>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 GSB Rapports - Tous droits réservés.</p>
  </footer>
</body>

</html>