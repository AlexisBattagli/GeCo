<?php

/**
 * La class LieuDAL hérite de la class Lieu.
 * Elle possède donc tous ces attributs et méthodes
 *
 * @author Alexis
 * @version 0.1
 * 
 * Cette class permet de faire,
 * recherche, ajout, modification et suppression de Lieu en base.
 */
require_once('BaseSingleton.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Lieu.php');

class LieuDAL {
    /*
     * Retourne l'Lieu correspondant à l'id donnée
     * 
     * @param int $id Identifiant de l'Lieu à trouver
     * @return Lieu (si trouvé) | null (sinon)
     */

    public static function findById($id)
    {
        $data = BaseSingleton::select('SELECT lieu.id as id, '
                        . 'lieu.pays as pays, '
                        . 'lieu.ville as ville '
                        . ' FROM lieu'
                        . ' WHERE lieu.id = ?', array('i', &$id));
        $lieu = new Lieu();
        if (sizeof($data) > 0)
        {
            $lieu->hydrate($data[0]);
        }
        else
        {
            $lieu = null;
        }
        return $lieu;
    }

    /*
     * Retourne l'ensemble des Lieux qui sont en base
     * 
     * @return array[Lieu] Toutes les lieux sont placées dans un Tableau
     */

    public static function findAll()
    {
        $mesLieux = array();

        $data = BaseSingleton::select('SELECT lieu.id as id, '
                        . 'lieu.pays as pays, '
                        . 'lieu.ville as ville '
                        . ' FROM lieu '
                        . ' ORDER BY lieu.pays ASC, lieu.ville ASC');

        foreach ($data as $row)
        {
            $lieu = new Lieu();
            $lieu->hydrate($row);
            $mesLieux[] = $lieu;
        }

        return $mesLieux;
    }

    /*
     * Retourne le Lieu correspondant au couple Pays;Ville passer en paramètre
     * Ce couple est forcément unique, il est recherche sans tenir compte de la casse
     * 
     * @param string pays, string ville
     * @return Lieu
     */

    public static function findByPV($pays, $ville)
    {
        $data = BaseSingleton::select('SELECT lieu.id as id, '
                        . 'lieu.pays as pays, '
                        . 'lieu.ville as ville '
                        . ' FROM lieu'
                        . ' WHERE LOWER(lieu.pays) = LOWER(?) AND LOWER(lieu.ville) = LOWER(?)', array('ss', &$pays, &$ville));
        $lieu = new Lieu();

        if (sizeof($data) > 0)
        {
            $lieu->hydrate($data[0]);
        }
        return $lieu;
    }

    /*
     * Insère ou met à jour l'lieu donnée en paramètre.
     * Pour cela on vérifie si l'id de le lieu transmis est sup ou inf à 0.
     * Si l'id est inf à 0 alors il faut insèrer, sinon update à l'id transmis.
     * 
     * @param Lieu
     * @return int
     * L'id de le lieu inséré en base. False si ça a planté
     */

    public static function insertOnDuplicate($lieu)
    {

        //Récupère les valeurs de le lieu lieu passé en para de la méthode
        $pays = $lieu->getPays(); //string
        $ville = $lieu->getVille(); //string
        $id = $lieu->getId();
        
        if ($id < 0)
        {
            $sql = 'INSERT INTO lieu (pays, ville) '
                    . ' VALUES (?,?) ';

            //Prépare les info concernant les type de champs
            $params = array('ss',
                &$pays,
                &$ville
            );
        }
        else
        {
            $sql = 'UPDATE lieu '
                    . 'SET pays = ?, '
                    . 'ville = ? '
                    . 'WHERE id = ? ';

            //Prépare les info concernant les types de champs
            $params = array('ssi',
                &$pays,
                &$ville,
                &$id
            );
        }

        //Exec la requête
        $idInsert = BaseSingleton::insertOrEdit($sql, $params);

        return $idInsert;
    }

    /*
     * Supprime l'Lieu correspondant à l'id donné en paramètre
     * 
     * @param int $id
     * @return bool
     * True si la ligne a bien été supprimée, False sinon
     */

    public static function delete($id)
    {
        $deleted = BaseSingleton::delete('DELETE FROM lieu WHERE id = ?', array('i', &$id));
        return $deleted;
    }

}
