<?php

/**
 * La class EtiquetteDAL hérite de la class Etiquette.
 * Elle possède donc tous ces attributs et méthodes
 *
 * @author Alexis
 * @version 0.1
 * 
 * Cette class permet de faire,
 * recherche, ajout, modification et suppression d'Etiquette en base.
 */
require_once('BaseSingleton.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Etiquette.php');

class EtiquetteDAL {
    /*
     * Retourne l'Etiquette correspondant à l'id donnée
     * 
     * @param int $id Identifiant de l'Etiquette à trouver
     * @return Compte
     */

    public static function findById($id)
    {
        $data = BaseSingleton::select('SELECT etiquette.id as id, '
                        . 'etiquette.label as label, '
                        . 'etiquette.description as description '
                        . ' FROM etiquette'
                        . ' WHERE etiquette.id = ?', array('i', &$id));
        $etiquette = new Etiquette();
        if (sizeof($data) > 0)
        {
            $etiquette->hydrate($data[0]);
        }
        else
        {
            $etiquette = null;
        }
        return $etiquette;
    }

    /*
     * Retourne l'ensemble des Etiquette qui sont en base
     * 
     * @return array[Etiquette] Toutes les etiquettes sont placées dans un Tableau
     */

    public static function findAll()
    {
        $mesEtiquettes = array();

        $data = BaseSingleton::select('SELECT etiquette.id as id, '
                        . 'etiquette.label as label, '
                        . 'etiquette.description as description '
                        . ' FROM etiquette '
                        . ' ORDER BY etiquette.label ASC');

        foreach ($data as $row)
        {
            $etiquette = new Etiquette();
            $etiquette->hydrate($row);
            $mesEtiquettes[] = $etiquette;
        }

        return $mesEtiquettes;
    }

    /*
     * Retourne l'Etiquette correspondant au label passer en paramètre
     * Ce Label est forcément unique, il est recherche sans tenir compte de la casse
     * 
     * @param string label
     * @return Etiquette
     */

    public static function findByLabel($label)
    {
        $data = BaseSingleton::select('SELECT etiquette.id as id, '
                        . 'etiquette.label as label, '
                        . 'etiquette.description as description '
                        . ' FROM etiquette'
                        . ' WHERE LOWER(etiquette.label) = LOWER(?)', array('s', &$label));
        $etiquette = new Etiquette();

        if (sizeof($data) > 0)
        {
            $etiquette->hydrate($data[0]);
        }
        return $etiquette;
    }

    /*
     * Insère ou met à jour l'etiquette donnée en paramètre.
     * Pour cela on vérifie si l'id de l'etiquette transmis est sup ou inf à 0.
     * Si l'id est inf à 0 alors il faut insèrer, sinon update à l'id transmis.
     * 
     * @param Etiquette
     * @return int
     * L'id de l'objet inséré en base. False si ça a planté
     */

    public static function insertOnDuplicate($etiquette)
    {

        //Récupère les valeurs de l'objet etiquette passé en para de la méthode
        $label = $etiquette->getLabel(); //string
        $description = $etiquette->getDescription(); //string
        $id = $etiquette->getId();
        if ($id < 0)
        {
            $sql = 'INSERT INTO etiquette (label, description) '
                    . ' VALUES (?,?) ';

            //Prépare les info concernant les type de champs
            $params = array('ss',
                &$label,
                &$description
            );
        }
        else
        {
            $sql = 'UPDATE etiquette '
                    . 'SET label = ?, '
                    . 'description = ? '
                    . 'WHERE id = ? ';

            //Prépare les info concernant les type de champs
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
     * Supprime l'Etiquette correspondant à l'id donné en paramètre
     * 
     * @param int $id
     * @return bool
     * True si la ligne a bien été supprimée, False sinon
     */

    public static function delete($id)
    {
        $deleted = BaseSingleton::delete('DELETE FROM etiquette WHERE id = ?', array('i', &$id));
        return $deleted;
    }

}
