<?php
require_once 'getRegions.php'; // Assurez-vous que ce fichier existe et fonctionne correctement

function generateRegionOptions() {
    $regions = getRegions(); // Cette fonction doit retourner un tableau des régions
    $options = '';

    if (!empty($regions)) {
        foreach ($regions as $region) {
            $options .= "<option value=\"" . htmlspecialchars($region['IdRegion']) . "\">" . htmlspecialchars($region['NomRegion']) . "</option>";
        }
    } else {
        $options .= "<option value=\"\">Aucune région disponible</option>";
    }

    return $options;
}
?>