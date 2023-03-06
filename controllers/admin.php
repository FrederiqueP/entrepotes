<?php 

// Vérification du rôle
if (!hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    echo 'Accès interdit';
    exit;
}

// Traitements : récupérer les articles
$userModel = new UtilisateurModel();
$users = $userModel->getAllUsers();

// Affichage : inclusion du fichier de template
$template = 'admin';
$script = '<script src="js/admin.js" defer></script>';
include '../templates/base_admin.phtml';




