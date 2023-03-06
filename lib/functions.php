<?php 

// Constantes
const ROLE_USER = 'USER';
const ROLE_ADMIN = 'ADMIN';

/////////////////////////////////////////
///////// FONCTIONS UTILITAIRES /////////
/////////////////////////////////////////

/**
 * Construit l'URL d'une page à partir du nom de la page et d'un tableau de paramètres
 * @param string $page Le nom de la page dont on veut construire l'URL
 * @param array $params Un tableau associatif de paramètres à ajouter dans la chaîne de requête
 * @return string L'URL de la page avec les éventuels paramètres
 */
function buildUrl(string $page, array $params = []): string
{
    return 'index.php?' . http_build_query(['page' => $page, ...$params]);
}

/**
 * Vérifie les identifiants de l'utilisateur
 * @param string $email L'email rentré par l'utilisateur
 * @param string $password Le mot de passe rentré par l'utilisateur
 */
function checkUser(string $email, string $password)
{
    // On récupère l'utilisateur à partir de son email
    $userModel = new UtilisateurModel();
    $user = $userModel->getUserByEmail($email);

    // Si on trouve bien un utilisateur...
    if ($user) {

        // On vérifie son mot de passe
        if (password_verify($password, $user['motdepasse'])) {

            // Tout est ok, on retourne l'utilisateur
            return $user;
        }
    }

    // Si l'email ou le mot de passe est incorrect...
    return false;
}

/**
 * Enregistre les données d el'utilisateur en session
 */
function registerUser(string $id, string $firstname, string $lastname, string $email, string $role)
{
    // On commence par vérifier qu'une session est bien démarrée
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Puis on enregistre les données de l'utilisateur en session
    $_SESSION['user'] = [
        'id' => $id,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'role' => $role
    ];
}

/**
 * Détermine si l'utilisateur est connecté ou non
 * @return bool - true si l'utilisateur est connecté, false sinon
 */
function isConnected(): bool
{
    // On commence par vérifier qu'une session est bien démarrée
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    return array_key_exists('user', $_SESSION) && isset($_SESSION['user']);
}

/**
 * Déconnecte l'utilisateur
 */
function logout()
{
    // Si l'utilisateur est connecté...
    if (isConnected()) {

        // On efface nos données en session
        $_SESSION['user'] = null;

        // On ferme la session 
        session_destroy();
    }
}

/**
 * Retourne l'id de l'utilisateur connecté
 */
function getUserId()
{
    // Si l'utilisateur est connecté...
    if (!isConnected()) {
        return null;
    }

    return $_SESSION['user']['id'];
}

/**
 * Retourne le prénom de l'utilisateur connecté
 */
function getUserFirstname()
{
    // Si l'utilisateur est connecté...
    if (!isConnected()) {
        return null;
    }

    return $_SESSION['user']['firstname'];
}

/**
 * Retourne le nom de l'utilisateur connecté
 */
function getUserLastname()
{
    // Si l'utilisateur est connecté...
    if (!isConnected()) {
        return null;
    }

    return $_SESSION['user']['lastname'];
}

/**
 * Retourne l'email de l'utilisateur connecté
 */
function getUserEmail()
{
    // Si l'utilisateur est connecté...
    if (!isConnected()) {
        return null;
    }

    return $_SESSION['user']['email'];
}

/**
 * Retourne le rôle de l'utilisateur connecté
 */
function getUserRole()
{
    // Si l'utilisateur est connecté...
    if (!isConnected()) {
        return null;
    }

    return $_SESSION['user']['role'];
}

/**
 * Vérifie si l'utilisateur possède un rôle particulier
 */
function hasRole(string $role)
{
    if (!isConnected()) {
        return false;
    }

    return getUserRole() == $role;
}

/**
 * Calcul couleur aléatoire pour la création de groupe
 */
function randColor() {
    // hsl color
    $hue = mt_rand(1, 360);
    $pastel = 'hsl(' . $hue .', 100%, 87.5%)';
    return $pastel;
}

