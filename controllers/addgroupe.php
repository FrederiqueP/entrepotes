<?php 

var_dump($_SESSION);

// Initialisations
$errors = [];
$nomgroupe = '';

// Création de l'objet GroupModel
$groupeModel = new GroupeModel();

// Si le formulaire est soumis...
if (!empty($_POST)) {

    // On récupère les données du formulaire
    $nomgroupe = strip_tags(trim($_POST['nomgroupe']));
    
    // On valide les données (nom groupe obligatoire)
    if (!strlen($nomgroupe)) {
        $errors['nomgroupe'] = 'Donnez un nom de groupe';
    }

    $idUser = getUserId();
    if ($groupeModel->getNomCreateur($nomgroupe, $idUser)) {
        $errors['nomgroupe'] = 'Ce nom de groupe a déjà été créé';
    }
 
    // Si tout est OK (pas d'erreurs)...
    if (empty($errors)) {

        $idUser = getUserId();

        // On enregistre le groupe
        $groupeModel = new GroupeModel();
        $groupeModel->addGroupe($nomgroupe, $idUser);
        // On récupère l'ID du groupe qui vient d'être inséré
        $idGroupe = $groupeModel->dernierAjout();

        // On ajoute un enregistrement à la table pont groupe-utilisateur
        $grouputilModel = new GroupUtilModel();
        $grouputilModel->addGroupUtil($idGroupe, $idUser);

        // On redirige l'internaute (vers une page ajout des potes)
        header('Location: ' . buildUrl('addpote', ['idGroupe' => intval($idGroupe)] ));
        exit;
    }
}

// Inclusion du template
$template = 'addgroupe';
include '../templates/base.phtml';