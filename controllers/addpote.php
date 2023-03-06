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

// Création des modèles
$groupeModel = new GroupeModel();
$createurModel = new UtilisateurModel();
$poteModel = new PoteModel();

$groupe =  $groupeModel->getOneGroupe($idGroupe);
// envoie la couleur du groupe à javascript
// echo json_encode(['couleur' => $groupe['couleur']]);
// --> echo se fait dans le phtml

// recupere les données de l'utilisateur-createur
$createur = $createurModel->getOneUser($groupe['createur']);


////////////////////////////////////////////////
// Gestion du formulaire d'ajout des potes
////////////////////////////////////////////////

// Initialisations
$errors = [];
$prenompote = '';
$emailpote = '';

if (!empty($_POST)) {

    // Si l'utilisateur n'est pas connecté, on le redirige vers la connexion
    $idUser = getUserId();
    if ($idUser == null) {
        header('Location: ' . buildUrl('connexion'));
        exit;
    }

    // Récupération des données du formulaire
    $prenompote = strip_tags(trim($_POST['prenompote']));
    $emailpote = strip_tags(trim($_POST['emailpote']));
    // On valide les données (prenom et email obligatoires)
    if (!strlen($prenompote)) {
        $errors['prenompote'] = 'Le champ "Prénom" est obligatoire';
    }

    if (!strlen($emailpote)) {
        $errors['emailpote'] = 'Le champ "Email" est obligatoire';
    }
    elseif (!filter_var($emailpote, FILTER_VALIDATE_EMAIL)) {
        $errors['emailpote'] = 'Email invalide';
    }
    elseif ($poteModel->getPoteByEmailGroupe($emailpote, $idGroupe)) {
        $errors['emailpote'] = 'Cet email a déjà été utilisé pour ce groupe';
    }

    // S'il n'y a pas d'erreurs
    if (empty($errors)) {

        // On enregistre le pote 
        $poteModel->addPote($prenompote, $emailpote, $idGroupe);
      
        // Redirection pour perdre les données en POST et revenir en GET pour ne pas insérer plusieurs fois le même commentaire si l'internaute fait F5
        header('Location: ' . buildUrl('addpote', ['idGroupe' => $idGroupe]));
        exit;
    }
    
}
////////////////////////////////////////////////
// Affichage : groupe, potes
////////////////////////////////////////////////

// On a le groupe dans l'URL ,  $idGroupe


// On vérifie qu'on a bien récupéré un groupe, sinon => 404
if (!$idGroupe) {
    http_response_code(404);
    echo 'Groupe introuvable';
    exit; // Si pas de groupe => message d'erreur et on arrête tout ! 
}

// Aller chercher les potes associés au groupe
$potes = $poteModel->getAllPotesbyGroupe($idGroupe);
// Inclusion du template

$template = 'addpote';
$script = '<script src="js/addpote.js" defer></script>';
include '../templates/base.phtml';