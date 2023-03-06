<?php

if (isConnected()): 
    // utilisateur connecté
    $idUtilisateur = $_SESSION['user']['id'];

    // Traitements : récupérer les groupes pour cet utilisateur

    // Création des modèles
    // $groupeModel = new GroupeModel();
    $grouputilModel = new GroupUtilModel();

    // $groupes = $groupeModel->getAllGroupes();
    // $groupesJSON = json_encode($groupes); // pas utilisé
    
    // Aller chercher les groupes associés à l'utilisateur connecté
    $utilgroupes = $grouputilModel->getUtilJoinGroup($idUtilisateur);

    // Aller chercher les utilisateurs associés au groupe
    // $groupeutils =  $grouputilModel->getGroupJoinUtil($idGroupe);

    

endif;

// Affichage : inclusion du template
$template = 'tableau';
// ajout lien javascript quand utilisé
$script = '<script src="js/tableau.js" defer></script>';
include '../templates/base.phtml';
