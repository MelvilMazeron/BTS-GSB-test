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
      <a href="liste.php">Liste</a>
      <?php if (isset($_SESSION['user_id'])): ?>
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
      <h1>Ajouter</h1>
      <p>Que souhaitez-vous ajouter aujourd'hui ?</p>
    </div>
    <section>
      <?php if (hasRole('delegue')): ?>
        <a href="./Add/Visiteur.php" class="lg-container">
          <img src="../../public/img/VisiteurCard.png" alt="Visiteur" />
          <h3>Visiteur</h3>
          <p>Ajouter un visiteur dans une région</p>
        </a>
      <?php endif; ?>

      <?php if (hasRole('responsable')): ?>
        <a href="./Add/Delegue.php" class="lg-container">
          <img src="../../public/img/Delegue.png" alt="Délégué" />
          <h3>Délégué</h3>
          <p>Ajouter un délégué dans une région</p>
        </a>
      <?php endif; ?>

      <a href="./Add/Rapport.php" class="lg-container">
        <img src="../../public/img/Rapport.png" alt="Rapports" />
        <h3>Rapport</h3>
        <p>Ajouter un rapport dans une région</p>
      </a>

      <?php if (hasRole('responsable')): ?>
        <a href="./Add/Practicien.php" class="lg-container">
          <img src="" alt="Practicien" />
          <h3>Practitien</h3>
          <p>Ajouter un Practicien</p>
        </a>
      <?php endif; ?>

      <?php if (hasRole('responsable')): ?>
        <a href="./Add/Produit.php" class="lg-container">
          <img src="" alt="Produit" />
          <h3>Produit</h3>
          <p>Ajouter un produit</p>
        </a>
      <?php endif; ?>

      <?php if (hasRole('responsable')): ?>
        <a href="./Add/Echantillon.php" class="lg-container">
          <img src="" alt="échantillon" />
          <h3>Échantillon</h3>
          <p>Ajouter un échantillon</p>
        </a>
      <?php endif; ?>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 GSB Rapports - Tous droits réservés.</p>
  </footer>
</body>

</html>