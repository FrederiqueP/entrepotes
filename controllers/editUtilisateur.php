<?php

// Vérification du rôle
if (!hasRole(ROLE_ADMIN)) {
    http_response_code(403);
    echo 'Accès interdit';
    exit;
}

// Traitements

// Initialisations
$errors = [];

/////////////////////
// STEP #1 : on va chercher les données de l'utilisateur pour pré remplir le formulaire

// Validation du paramètre id de l'URL
if (!array_key_exists('id', $_GET) || !$_GET['id']) {
    http_response_code(404);
    echo 'Utilisateur introuvable';
    exit; // Si pas d'id dans l'URL => message d'erreur et on arrête tout ! 
}

// On récupère l'id de l'utilisateur à afficher depuis la chaîne de requête
$idUtilisateur = $_GET['id'];

// On va chercher l'utilisateur correspondant
$utilisateurModel = new UtilisateurModel();
$utilisateur = $utilisateurModel->getOneUser($idUtilisateur);

// On vérifie qu'on a bien récupéré un utilisateur, sinon => 404
if (!$utilisateur) {
    http_response_code(404);
    echo 'Utilisateur introuvable';
    exit; // Si pas d'utilisateur => message d'erreur et on arrête tout ! 
}

// Initialisation des variables qui vont servir à pré remplir le formulaire
$prenom      = $utilisateur['prenom'];
$nom         = $utilisateur['nom'];
$email       = $utilisateur['email'];
$role        = $utilisateur['role'];
$actif       = $utilisateur['actif'];
$commentaire = $utilisateur['commentaire'];

/////////////////////
// STEP #2 : Traitements des données du formulaire en cas de soumission
if (!empty($_POST)) {

    // On récupère les données du formulaire
    $prenom      = strip_tags(trim($_POST['prenom']));
    $nom         = strip_tags(trim($_POST['nom']));
    $email       = strip_tags(trim($_POST['email']));
    $role        = strip_tags(trim($_POST['role']));
    $actif       = intval(strip_tags(trim($_POST['actif'])));
    $commentaire = strip_tags(trim($_POST['commentaire']));

    // On valide les données (prenom, nom et email contenu obligatoires)
    if (!strlen($prenom)) {
        $errors['prenom'] = 'Le champ "Prénom" est obligatoire';
    }

    if (!strlen($nom)) {
        $errors['nom'] = 'Le champ "Nom" est obligatoire';
    }

    if (!strlen($email)) {
        $errors['email'] = 'Le champ "Email" est obligatoire';
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email invalide';
    }
    elseif ($utilisateurModel->getUserByEmail($email)) {
        // test si meme mail que l'utilisateur encours 
        $meme= $utilisateurModel->getUserByEmail($email);
        if ($meme['idUtilisateur'] != $idUtilisateur) {
            $errors['email'] = 'Un compte existe déjà avec cet email';
        }
    }

    // Si tout est OK (pas d'erreurs)...
    if (empty($errors)) {

        // On modifie l'utilisateur
        $utilisateurModel->editUtilisateur($prenom, $nom, $email, $role, $actif, $commentaire, $idUtilisateur);
     
        // On redirige l'internaute (pour l'instant vers une page de confirmation)
        header('Location: ' . buildUrl('admin'));
        exit;
    }
}

// Affichage : inclusion du fichier de template
$template = 'editUtilisateur';
include '../templates/base_admin.phtml';