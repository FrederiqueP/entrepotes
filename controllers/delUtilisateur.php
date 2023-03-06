<?php 

// Vérification du rôle
if (!hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    echo 'Accès interdit';
    exit;
}

// Initialisations
$errors = [];

// Validation et récupération de l'id de l'article à supprimer dans l'URL
if (!array_key_exists('id', $_GET) || !$_GET['id']) {

    http_response_code(404);
    echo 'Utilisateur introuvable';
    exit; // Si pas d'id dans l'URL => message d'erreur et on arrête tout ! 
}

// On récupère l'id de l'article à afficher depuis la chaîne de requête
$idUtilisateur = $_GET['id'];

// On va chercher l'utilisateur correspondant
$utilisateurModel = new UtilisateurModel();
$utilisateur = $utilisateurModel->getOneUser($idUtilisateur);

// $errors['groupe'] = 'Au moins un groupe existe pour cet utilisateur : ' . $utilisateur['prenom'];

// $errors['sortie'] = 'Au moins une sortie existe pour cet utilisateur : '. $utilisateur['prenom'];


// On vérifie qu'on a bien récupéré un utilisateur, sinon => 404
if (!$utilisateur) {
    http_response_code(404);
    echo 'Utilisateur introuvable';
    exit; // Si pas d'utilisateur => message d'erreur et on arrête tout ! 
}

// Si tout est OK (pas d'erreurs)...
if (empty($errors)) {

    // Suppression de l'article
    // $utilisateurModel->deleteUtilisateur($idUtilisateur);

    // On redirige l'internaute (pour l'instant vers une page de confirmation)
    header('Location: ' . buildUrl('admin'));
    exit;
}

// Affichage : inclusion du fichier de template
$template = 'delUtilisateur';
include '../templates/base_admin.phtml';
