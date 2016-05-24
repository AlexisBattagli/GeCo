<?php

/**
 * La class ObjetDAL hérite de la class Objet.
 * Elle possède donc tous ces attributs et méthodes
 *
 * @author Alexis
 * @version 0.1
 * 
 * Cette class permet de faire,
 * recherche, ajout, modification et suppression d'Objet en base.
 */

require_once('BaseSingleton.php');

class ObjetDAL {

    /*
     * Retourne l'Objet correspondant à l'id donnée
     * 
     * @param int $id Identifiant de l'Objet à trouver
     * @return Compte
     */
    public static function findById($id)
    {
        $data = BaseSingleton::select('SELECT objet.id as id, '
                                            . 'objet.label as label, '
                                            . 'objet.description as description '
                                    . ' FROM objet'
                                    . ' WHERE objet.id = ?', array('i',&$id));
        $objet = new Objet();
        $objet->hydrate($data[0]);
        return $objet;
    }
    
    /*
     * Retourne l'ensemble des Objet qui sont en base
     * 
     * @return array[Objet] Toutes les objets sont placées dans un Tableau
     */
    public static function findAll()
    {
        $mesObjets = array();
        
        $data = BaseSingleton::select('SELECT objet.id as id, '
                                            . 'objet.label as label, '
                                            . 'objet.description as description '
                                    . ' FROM objet');
        
        foreach ($data as $row)
        {
            $objet = new Objet();
            $objet->hydrate($row);
            $mesObjets[] = $objet;
        }
        
        return $mesObjets;
    }
    
    /*
     * Retourne l'Objet correspondant au label passer en paramètre
     * Ce Label est forcément unique, il est recherche sans tenir compte de la casse
     * 
     * @param string label
     * @return Objet
     */

    public static function findByLabel($label)
    {
        $data = BaseSingleton::select('SELECT objet.id as id, '
                        . 'objet.label as label, '
                        . 'objet.description as description '
                        . ' FROM objet'
                        . ' WHERE LOWER(objet.label) = LOWER(?)', array('s', &$label));
        $objet = new Objet();

        if (sizeof($data) > 0)
        {
            $objete->hydrate($data[0]);
        }
        return $objet;
    }
    
    /*
     * Insère ou met à jour l'objet donnée en paramètre.
     * Pour cela on vérifie si l'id de l'objet transmis est sup ou inf à 0.
     * Si l'id est inf à 0 alors il faut insèrer, sinon update à l'id transmis.
     * 
     * @param Objet
     * @return int
     * L'id de l'objet inséré en base. False si ça a planté
     */
    public static function insertOnDuplicate($objet)
    {
        
        //Récupère les valeurs de l'objet objet passé en para de la méthode
        $label = $objet->getLabel(); //string
        $description = $objet->getDescription(); //string
        $id = $objet->getId();
        if($id<0)
        {
            $sql = 'INSERT INTO objet (label, description) '
                   . ' VALUES (?,?) ';
           
            //Prépare les info concernant les type de champs
            $params = array('ss',
                        &$label, 
                        &$description
            );
        }
        else
        {
            $sql = 'UPDATE objet '
                    . 'SET label = ?, '
                        . 'description = ? '
                    . 'WHERE id = ? ';
            
            //Prépare les info concernant les types de champs
            $params = array('ssi', 
                &$label, 
                &$description,
                &$id
            );
        }
        
        //Exec la requête
        $idInsert = BaseSingleton::insertOrEdit($sql, $params);
        
        return $idInsert;
    }
    
    /*
     * Supprime l'Objet correspondant à l'id donné en paramètre
     * 
     * @param int $id
     * @return bool
     * True si la ligne a bien été supprimée, False sinon
     */
    public static function delete($id)
    {
        $deleted = BaseSingleton::delete('DELETE FROM objet WHERE id = ?', array('i', &$id));
        return $deleted;
    }
}
