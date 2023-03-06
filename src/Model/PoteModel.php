<?php 

class PoteModel extends AbstractModel {

    /**
     * Retourne un pote à partir de son email et du groupe auquel il appartient
     * @param string $email - L'email du pote qu'on cherche
     * @param string $groupe - le groupe du pote 
     * @return bool|array - false si le pote n'est pas trouvé, sinon le tableau associatif contenant le pote
     */
    function getPoteByEmailGroupe(string $email, int $idGroupe) 
    {
        // Préparation de la requête
        $sql = 'SELECT *
                FROM pote
                WHERE emailpote = ?
                AND   groupepote= ?';

        // Récupération d'UN SEUL résultat : un seul pote possède cet email dans ce groupe
        return $this->db->getOneResult($sql, [$email, $idGroupe]);
    }

    /**
     * Retourne les groupes invités à partir de l'email
     * @param string $email - L'email du pote qu'on cherche
     * @return bool|array - false si l'email n'est pas trouvé, sinon le tableau associatif contenant le pote
     */
    function getPoteByEmailJoinGroup(string $email) 
    {
        $reponse = "invitation"; 

        // Préparation de la requête
        $sql = 'SELECT *
                FROM pote AS P
                INNER JOIN groupe AS G 
                ON P.groupepote = G.idGroupe
                INNER JOIN utilisateur AS U 
                ON G.createur = U.idUtilisateur
                WHERE P.emailpote = ?
                AND   P.reponsepote = ?';

        // Récupération de plusieurs résultats : un seul pote possède cet email dans plusieurs groupes
        return $this->db->getAllResults($sql, [$email, $reponse]);
    }


     /**
     * Récupère UN pote à partir de son identifiant
     * @param int $idPote - L'identifiant du pote à récupérer
     * @return bool|array - false si l'id n'existe pas, sinon retourne le pote
     */
    function getOnePote(int $idPote): bool|array
    {
        $sql = 'SELECT *
                FROM pote AS A
                WHERE idPote = ?';

        return $this->db->getOneResult($sql, [$idPote]);
    }

     /**
     * Récupère tous les potes du groupe
     */
    function getAllPotesbyGroupe(int $idGroupe): bool|array
    {
        $sql = 'SELECT *
                FROM pote AS P
                WHERE  P.groupepote= ?
                ORDER BY P.prenompote';

        return $this->db->getAllResults($sql, [$idGroupe]);
    }

    /**
     * Récupère tous les potes triés par prenom
     */
    function getAllPotes():array
    {
        $sql = 'SELECT *
                FROM pote AS P
                ORDER BY P.prenompote';

        return $this->db->getAllResults($sql);
    }

    /**
     * Ajoute un pote
     * @param string $prenompote Le prénom du pote
     * @param string $emailpote L'email du pote
     * @param int    $idGroupe Le'id du groupe
     * @param string $reponsepote initialisé à "ajouté"
     * @return void
     */
    function addPote(string $prenompote, string $emailpote, int $idGroupe)
    {
        $reponse = "ajoute";

        $sql = 'INSERT INTO pote (prenompote, emailpote, reponsepote, groupepote)
                VALUES (?,?,?,?)';

        $this->db->executeQuery($sql, [$prenompote, $emailpote, $reponse, $idGroupe]);
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