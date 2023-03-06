<?php 

// Inclusion du fichier d'autoload de composer
// autoloading nous permet d'inclure les classes dès que l'on en a besoin
// require '../vendor/autoload.php';

// On démarre la session pour être certain qu'elle est démarrée
session_start();

// Inclusion des dépendances
include '../app/config.php';
include '../src/Core/Database.php';
include '../src/Core/AbstractModel.php';
include '../src/Model/UtilisateurModel.php';
include '../src/Model/GroupeModel.php';
include '../src/Model/GroupUtilModel.php';
include '../src/Model/PoteModel.php';
// include '../src/Model/ArticleModel.php';
// include '../src/Model/CommentModel.php';
// include '../src/Model/UserModel.php';
include '../lib/functions.php';

//////////////////////////////////
///////////// ROUTING

// Inclusion du fichier de routes
$routes = include '../app/routes.php';

// // On initialise une variable $page avec une valeur par défaut 'accueil'
$page = 'accueil';

// // On regarde si dans l'URL (dans la chaîne de requête) il existe un paramètre 'page' 
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}


// Routing : appeler un contrôleur spécifique à la page qu'on souhaite afficher en fonction de l'information contenue dans l'URL

// Si la page n'existe pas on fait une erreur 404
if (!array_key_exists($page, $routes)) {
    http_response_code(404);
    echo 'Page introuvable';
    exit;
}

// On va chercher le contrôleur associé à la page
$controllerFile = $routes[$page];
include '../controllers/' . $controllerFile;