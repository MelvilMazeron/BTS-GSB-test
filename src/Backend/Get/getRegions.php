<?php
require_once __DIR__ . '/../config.php'; // __DIR__ pour un chemin absolu

function getRegions() {
    try {
        $bdd = getDatabaseConnection();
        $regions = $bdd->query('SELECT * FROM region');
        return $regions->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
        return [];
    }
}
?>