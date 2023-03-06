<?php

if (isConnected()):
    // utilisateur connecté 

    // Traitements : récupérer les invitations pour cet utilisateur
    // On vérifie s'il a reçu des invitations à l'aide de son email
    $email = $_SESSION['user']['email'];

    // Création des modèles
    $poteModel = new PoteModel();
    $potegroupesinvites = $poteModel->getPoteByEmailJoinGroup($email);
    // var_dump($potegroupesinvites);



endif;
// Traitements : récupérer les articles
// $articleModel = new ArticleModel();
// $articles = $articleModel->getAllArticles();

// Affichage : inclusion du template
$template = 'accueil';
// ajout lien javascript quand utilisé
// $script = '<script src="js/accueil.js" defer></script>';
include '../templates/base.phtml';
