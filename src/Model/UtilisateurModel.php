<?php 

class UtilisateurModel extends AbstractModel {

    /**
     * Retourne un utilisateur à partir de son email
     * @param string $email - L'email de l'utilisateur qu'on cherche
     * @return bool|array - false si l'utilisateur n'est pas trouvé, sinon le tableau associatif contenant les données de l'utilisateur
     */
    function getUserByEmail(string $email) 
    {
        // Préparation de la requête
        $sql = 'SELECT *
                FROM utilisateur
                WHERE email = ?';

        // Récupération d'UN SEUL résultat : un seul utilisateur possède cet email
        return $this->db->getOneResult($sql, [$email]);
    }


     /**
     * Récupère UN utilisateur à partir de son identifiant
     * @param int $idUtilisateur - L'identifiant de l'utilisateur à récupérer
     * @return bool|array - false si l'id n'existe pas, sinon retourne l'artiutilisateur
     */
    function getOneUser(int $idUtilisateur): bool|array
    {
        $sql = 'SELECT *
                FROM utilisateur AS A
                WHERE idUtilisateur = ?';

        return $this->db->getOneResult($sql, [$idUtilisateur]);
    }

     /**
     * Récupère tous les utilisateurs triés par date de création décroissante
     */
    function getAllUsers(): array
    {
        $sql = 'SELECT *
                FROM utilisateur AS A
                ORDER BY A.createdAt DESC';

        return $this->db->getAllResults($sql);
    }

    /**
     * Ajoute un utilisateur
     * @param string $prenom Le prénom de l'utilisateur
     * @param string $nom Le nom de l'utilisateur
     * @param string $email L'email de l'utilisateur
     * @param string $hash Le mot de passe hashé de l'utilisateur
     * @return void
     */
    function addUser(string $prenom, string $nom, string $email, string $hash, string $role)
    {
        $sql = 'INSERT INTO utilisateur (prenom, nom, email, motdepasse, role, actif, commentaire, createdAt)
                VALUES (?,?,?,?,?,?,?,NOW())';

        $this->db->executeQuery($sql, [$prenom, $nom, $email, $hash, $role, 0, 'création']);
    }

    /**
     * Modifie un utilisateur
     * @param string $prenom Le prénom de l'utilisateur
     * @param string $nom Le nom de l'utilisateur
     * @param string $email L'email de l'utilisateur
     * @param string $email Le role de l'utilisateur
     * @param string $email Le statut actif de l'utilisateur
     * @param string $email Le commantaire de l'utilisateur
     * @return void
     */
    function editUtilisateur(string $prenom, string $nom, string $email, string $role, int $actif, string $commentaire, string $idUtilisateur)
    {

        $sql  ='UPDATE utilisateur 
                SET prenom = ?, nom = ?, email = ?, role = ?, actif = ?, commentaire = ?
                WHERE idUtilisateur = ?';

        $this->db->executeQuery($sql, [$prenom, $nom, $email, $role, $actif, $commentaire, $idUtilisateur]);
    }

     /**
     * Supprime un utilisateur à partir de son identifiant
     * @param string $idUtilisateur - L'identifiant de l'utilisateur à supprimer
     */
    function deleteUtilisateur(string $idUtilisateur)
    {
        $sql = 'DELETE FROM utilisateur
                WHERE idUtilisateur = ?';

        $this->db->executeQuery($sql, [$idUtilisateur]);
        
    }

}