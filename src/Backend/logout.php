<?php
session_start();
session_destroy(); // Détruit toutes les données de la session
header('Location: ../Frontend/connexion.html'); // Redirige vers la page de connexion
exit();
?>