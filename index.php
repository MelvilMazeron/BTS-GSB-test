<?php
session_start(); // Démarre la session pour accéder aux données utilisateur
$isConnected = isset($_SESSION['user_id']); // Vérifie si l'utilisateur est connecté
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GSB Rapports - Accueil</title>
    <link rel="stylesheet" href="./public/css/Index.css" />
  </head>
  <body>
    <header>
      <img src="./public/img/GSB-Logo.png" />
      <div class="menu">
        <a href="./src/Frontend/liste.php">Liste</a>
        <a href="./src/Frontend/ajout.php">Ajout</a>
        <?php if ($isConnected): ?>
          <form action="./src/Backend/logout.php" method="post" style="display: inline;">
            <button type="submit" style="background: none; border: none; color: white; font-weight: bold; cursor: pointer;">Déconnexion</button>
          </form>
        <?php else: ?>
          <a href="./src/Frontend/connexion.html">Se connecter</a>
        <?php endif; ?>
      </div>
    </header>

    <main>
      <aside>
        <img src="./public/img/visiteur.png" alt="logo-GSB" />
        <h1>Espace Visiteurs</h1>
      </aside>
      <aside>
        <h2>Nos services</h2>
        <p>Gérer les clients dans les meilleures conditions possibles</p>
        <article>
          <a href="./src/Frontend/liste.php" class="container">
            <img src="./public/img/Search.png" alt="Search" />
            <h3>Liste</h3>
            <p>Listes des rapports</p>
          </a>
          <a href="./src/Frontend/ajout.php" class="container">
            <img src="./public/img/Heal.png" alt="Add Rapports" />
            <h3>Ajout</h3>
            <p>Ajouter des Rapports</p>
          </a>
        </article>
      </aside>
    </main>

    <footer>
      <p>&copy; 2025 GSB Rapports - Tous droits réservés.</p>
    </footer>
  </body>
</html>