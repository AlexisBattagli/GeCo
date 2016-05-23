<?php

/**
 * La class SoldeDAL hérite de la class Solde.
 * Elle possède donc tous ces attributs et méthodes
 *
 * @author Alexis
 * @version 0.1
 * 
 * Cette class permet de faire,
 * recherche, ajout, modification et suppression de Solde en base.
 */
require_once('BaseSingleton.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Solde.php');

class SoldeDAL {
    /*
     * Retourne le Solde correspondant à l'id donnée
     * 
     * @param int $id Identifiant du solde à trouver
     * @return Solde
     */

    public static function findById($id)
    {
        $data = BaseSingleton::select('SELECT solde.id as id, '
                        . 'solde.compte_id as compte_id, '
                        . 'solde.valeur as valeur, '
                        . 'solde.date as date '
                        . ' FROM solde '
                        . ' WHERE solde.id = ?', array('i', &$id));
        $solde = new Solde();
        $solde->hydrate($data[0]);
        return $solde;
    }

    /*
     * Retourne l'ensemble des Soldes qui sont en base
     * 
     * @return array[Solde] Toutes les Soldes sont placées dans un Tableau
     */

    public static function findAll()
    {
        $mesSoldes = array();

        $data = BaseSingleton::select('SELECT solde.id as id, '
                        . 'solde.compte_id as compte_id, '
                        . 'solde.valeur as valeur, '
                        . 'solde.date as date '
                        . ' FROM solde ');

        foreach ($data as $row)
        {
            $solde = new Solde();
            $solde->hydrate($row);
            $mesSoldes[] = $solde;
        }

        return $mesSoldes;
    }

    /*
     * Retourne le solde le plus récent pour un compte donnée
     * 
     * @return Solde
     */

    public static function findByCompte($idCompte)
    {
        $data = BaseSingleton::select('SELECT solde.id as id, '
                        . 'solde.compte_id as compte_id, '
                        . 'solde.valeur as valeur, '
                        . 'solde.date as date '
                        . ' FROM solde '
                        . ' WHERE solde.date = (SELECT MAX(solde.date) FROM solde WHERE solde.compte_id = ?)', array('i', &$idCompte));
        $solde = new Solde();
        if (sizeof($data) > 0)
        {
            $solde->hydrate($data[0]);
        }
        else
        {
            $solde = null;
        }
        return $solde;
    }

    /*
     * Insère ou met à jour le solde donné en paramètre.
     * 
     * @param Solde solde
     * @return int id
     * L'id de l'objet inséré en base. False si ça a planté
     */

    public static function insertOnDuplicate($solde)
    {
        //Récupère les valeurs de l'objet entreeSortie passé en para.
        $id = $solde->getId();
        $compteId = $solde->getCompte()->getId(); //int
        $valeur = $solde->getValeur(); //double
        $date = $solde->getDate(); //string
        if ($id < 0)
        {
            //Prépare la requête Insertion/Mise à Jour
            $sql = 'INSERT INTO solde (compte_id, valeur, date) '
                    . ' VALUES(?,?,NOW()) ';
            $params = array('id',
                &$compteId,
                &$valeur,
            );
        }
        else
        {
            $sql = 'UPDATE solde '
                    . ' SET compte_id = ?, '
                    . ' valeur = ?, '
                    . ' date = DATE_FORMAT(?,"%Y/%m/%d") '
                    . ' WHERE id = ?';
            $params = array('idsi',
                &$compteId,
                &$valeur,
                &$date,
                &$id
            );
        }

        //Exec la requête
        $idInsert = BaseSingleton::insertOrEdit($sql, $params);

        return $idInsert;
    }

    /*
     * Supprime le Solde correspondant à l'id donné en paramètre
     * 
     * @param int $id
     * @return bool
     * True si la ligne a bien été supprimée, False sinon
     */

    public static function delete($id)
    {
        $deleted = BaseSingleton::delete('DELETE FROM solde WHERE id = ?', array('i', &$id));
        return $deleted;
    }

}
