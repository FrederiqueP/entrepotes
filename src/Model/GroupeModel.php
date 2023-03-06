<?php 

class GroupeModel extends AbstractModel {

    /**
     * Récupère tous les groupes triés par date de création décroissante
     */
    function getAllGroupes(): array
    {
        $sql = 'SELECT *
                FROM groupe AS G
                ORDER BY G.createdAt DESC';

        return $this->db->getAllResults($sql);
    }


    /**
     * Récupère tous les groupes appartenant à un utilisateur 
     * triés par date de création décroissante
     */
    function getAllGroupesUtil($idUtilisateur): array
    {
        $sql = 'SELECT *
                FROM groupe AS G
                WHERE idUtilisateur = ?
                ORDER BY G.createdAt DESC';

        return $this->db->getAllResults($sql, [$idUtilisateur]);
    }

    /**
     * Récupère UN groupe à partir de son identifiant
     * @param int $idGroupe - L'identifiant du groupe à récupérer
     * @return bool|array - false si l'id n'existe pas, sinon retourne le groupe
     */
    function getOneGroupe(int $idGroupe): bool|array
    {
        $sql = 'SELECT *
                FROM groupe AS AG
                WHERE idGroupe = ?';

        return $this->db->getOneResult($sql, [$idGroupe]);
    }


    /**
     * Récupère UN groupe avec  à partir de son nom et du créateur
     * @param string $nomgroupe Le nom du groupe
     * @param int $idUser - L'identifiant du createur du groupe
     * @return bool|array - false si nomgroupe-createur  n'existe pas, sinon retourne le groupe
     */
    function getNomCreateur(string $nomgroupe,int $idUser): bool|array
    {
        $sql = 'SELECT *
                FROM groupe AS G
                WHERE nomgroupe = ?
                AND   createur = ?';

        return $this->db->getOneResult($sql, [$nomgroupe, $idUser]);
    }

    /**
     * Ajoute un groupe
     * @param string $nomgroupe Le nom du groupe
     * @param string $couleur La couleur du groupe calculée en aléatoire
     * @param string $createdAt La date de création du groupe Le contenu de l'article
     * @param string $createur L'id utilisateur du créateur du groupe
     * @return void
     */
    function addGroupe(string $nomgroupe, int $idUser)
    {
        // calcul couleur aléatoire pour ce groupe
        $couleur = randColor();

        $sql = 'INSERT INTO groupe (nomgroupe, couleur, createdAt, createur)
                VALUES (?,?,NOW(),?)';

        $this->db->executeQuery($sql, [$nomgroupe, $couleur, $idUser]);
       
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