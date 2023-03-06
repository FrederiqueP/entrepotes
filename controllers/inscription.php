<?php 

// Initialisations
$errors = [];
$prenom = '';
$nom = '';
$email = '';
$motdepasse = '';
$motdepasseConfirme = '';


// Création des modèles
$utilisateurModel = new UtilisateurModel();

// @TODO je ne devrais pas être ici si je suis connecté

// Si le formulaire est soumis...
if (!empty($_POST)) {

    // On récupère les données du formulaire
    $prenom = strip_tags(trim($_POST['prenom']));
    $nom = strip_tags(trim($_POST['nom']));
    $email = strip_tags(trim($_POST['email']));
    $motdepasse = $_POST['motdepasse'];
    $motdepasseConfirme = $_POST['motdepasse-confirme'];

    // On valide les données (titre et contenu obligatoires)
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
        $errors['email'] = 'Un compte existe déjà avec cet email';
    }

    if (strlen($motdepasse) < 8) {
        $errors['motdepasse'] = 'Le mot de passe doit comporter au moins 8 caractères';
    }
    elseif ($motdepasse != $motdepasseConfirme) {
        $errors['motdepasse-confirme'] = 'Le mot de passe de confirmation ne correspond pas';
    }

    // Si tout est OK (pas d'erreurs)...
    if (empty($errors)) {

        // Hashage du mot de passe
        $hash = password_hash($motdepasse, PASSWORD_DEFAULT);

        // On enregistre l'utilisateur
        $utilisateurModel->addUser($prenom, $nom, $email, $hash, 'USER');
        // @TODO stocker 'USER' dans une constante de configuration 


        // On redirige l'internaute (pour l'instant vers une page de confirmation)
        header('Location: ' . buildUrl('accueil'));
        exit;
    }
}

// Inclusion du template
$template = 'inscription';
include "../templates/base.phtml";