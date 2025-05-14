<?php


// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../Frontend/connexion.html');
    exit();
}

// Fonction pour vérifier les rôles
function hasRole($requiredRole) {
    // Hiérarchie des rôles
    $rolesHierarchy = ['visiteur' => 1, 'delegue' => 2, 'responsable' => 3];
    $userRole = $_SESSION['role'] ?? null;

    // Vérifie si l'utilisateur a un rôle valide et si son rôle est supérieur ou égal au rôle requis
    if ($userRole && isset($rolesHierarchy[$userRole]) && isset($rolesHierarchy[$requiredRole])) {
        return $rolesHierarchy[$userRole] >= $rolesHierarchy[$requiredRole];
    }
    return false;
}
?>