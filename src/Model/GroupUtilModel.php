<?php 

class GroupUtilModel extends AbstractModel {

    /**
     * Récupère tous les identifiants groupes-utilisateurs
     */
    function getAllGroupUtils(): array
    {
        $sql = 'SELECT *
                FROM groupeutilisateur AS GU
                ORDER BY GU.idUtilisateur DESC';

        return $this->db->getAllResults($sql);
    }

  
    /**
     * Récupère UNe clé groupe-utilisateur à partir de leurs identifiants
     * @param int $idGroupe - L'identifiant du groupe à récupérer
     * @param int $idUtilisateur - L'identifiant de l'utilisateur à récupérer
     * @return bool|array - false si l'id n'existe pas, sinon retourne le groupe-utilisateur
     */
    function getOneGroupUtil(int $idGroupe, int $idUtilisateur): bool|array
    {
        $sql = 'SELECT *
                FROM groupeutilisateur AS GU
                WHERE idGroupe = ?
                AND   idUtilisateur = ?';

        return $this->db->getOneResult($sql, [$idGroupe, $idUtilisateur]);
    }

    /**
     * Récupère UNe clé groupe à partir de son identifiant et on lit tous les utilisateurs
     * @param int $idGroupe - L'identifiant du groupe à récupérer
     * @param int $idUtilisateur - L'identifiant de l'utilisateur à récupérer
     * @return bool|array - false si l'id n'existe pas, sinon retourne le groupe-utilisateur
     */
    function getGroupJoinUtil(int $idGroupe): bool|array
    {
        $sql = 'SELECT *
                FROM groupeutilisateur AS GU
                INNER JOIN utilisateur AS U
                ON U.idUtilisateur = GU.idUtilisateur 
                WHERE GU.idGroupe = ?';

        return $this->db->getAllResults($sql, [$idGroupe]);
    }

     /**
     * Récupère UNe clé utilisateur à partir de son identifiant et on lit tous les groupes
     * @param int $idUtilisateur - L'identifiant de l'utilisateur à récupérer
     * @param int $idGroupe - L'identifiant du groupe à récupérer
     * @return bool|array - false si l'id n'existe pas, sinon retourne le utilisateur
     */
    function getUtilJoinGroup(int $idUtilisateur): bool|array
    {
        $sql = 'SELECT *
                FROM groupeutilisateur AS GU
                INNER JOIN groupe AS G 
                ON G.idGroupe = GU.idGroupe
                WHERE GU.idUtilisateur = ?';

        return $this->db->getAllResults($sql, [$idUtilisateur]);
    }



    /**
     * Ajoute un groupe
     * @param string $nomgroupe Le nom du groupe
     * @param string $couleur La couleur du groupe calculée en aléatoire
     * @param string $createdAt La date de création du groupe Le contenu de l'article
     * @param string $createur L'id utilisateur du créateur du groupe
     * @return void
     */
    function addGroupUtil(string $idGroupe, int $idUtilisateur)
    {
        $sql = 'INSERT INTO groupeutilisateur (idGroupe, idUtilisateur)
                VALUES (?,?)';

        $this->db->executeQuery($sql, [$idGroupe, $idUtilisateur]);
       
    }

    /**
     * Récupère l'id du dernier groupe ajouté
     * avec PDO::lastInsertId
     * @return string
     */
    function dernierAjout()
    {
        return $this->db->lastInsertId();
    }

    
    


    

    /**
     * Modifie un article
     * @param string $title Le titre de l'article
     * @param string $abstract Le résumé de l'article
     * @param string $content Le contenu de l'article
     * @param string $title Le nom du fichier image de l'article
     * @return void
     */
    function editArticle(string $title, string $abstract, string $content, string $image, string $idArticle)
    {
        $sql  ='UPDATE article 
                SET title = ?, content = ?, abstract = ?, image = ?
                WHERE idArticle = ?';

        $this->db->executeQuery($sql, [$title, $content, $abstract, $image, $idArticle]);
    }

    /**
     * Supprime un article à partir de son identifiant
     * @param string $idArticle - L'identifiant de l'article à supprimer
     */
    function deleteArticle(string $idArticle)
    {
        $sql = 'DELETE FROM article
                WHERE idArticle = ?';

        $this->db->executeQuery($sql, [$idArticle]);
    }

}