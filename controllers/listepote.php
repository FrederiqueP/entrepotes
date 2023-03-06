<?php 
////////////////////////////////////////////////
// Récupération de l'id du groupe dans l'URL
////////////////////////////////////////////////

// Validation du paramètre id de l'URL : si le paramètre n'existe pas, n'a pas de valeur ou a une valeur qui comporte autre chose que des chiffres...
if (!array_key_exists('idGroupe', $_GET) || !$_GET['idGroupe'] || !ctype_digit($_GET['idGroupe'])) {
    // ... on fait une erreur 404 NOT FOUND
    http_response_code(404);
    echo 'Groupe introuvable';
    exit; // Si pas d'id dans l'URL => message d'erreur et on arrête tout ! 
}

// On récupère l'id du groupe à afficher depuis la chaîne de requête
$idGroupe = (int) $_GET['idGroupe'];

// On vérifie qu'on a bien récupéré un groupe, sinon => 404
if (!$idGroupe) {
    http_response_code(404);
    echo 'Groupe introuvable';
    exit; // Si pas de groupe => message d'erreur et on arrête tout ! 
}

// Création des modèles
$grouputilModel = new GroupUtilModel();

// Aller chercher les utilsateurs associés au groupe
$groupeutils =  $grouputilModel->getGroupJoinUtil($idGroupe);



include '../templates/listepote.phtml';