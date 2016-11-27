<?php

/**
 * La class PayementDAL hérite de la class Payement.
 * Elle possède donc tous ces attributs et méthodes
 *
 * @author Alexis
 * @version 0.1
 * 
 * Cette class permet de faire,
 * recherche, ajout, modification et suppression de Payement en base.
 */
require_once('BaseSingleton.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Payement.php');

class PayementDAL {
    /*
     * Retourne le moeyn de Payement correspondant à l'id donnée
     * 
     * @param int $id Identifiant du moyen de payement à trouver
     * @return Payement (si trouvé) | null (sinon)
     */

    public static function findById($id)
    {
        $data = BaseSingleton::select('SELECT payement.id as id, '
                        . 'payement.moyen as moyen '
                        . ' FROM payement'
                        . ' WHERE payement.id = ?', array('i', &$id));
        $payement = new Payement();
        if (sizeof($data) > 0)
        {
            $payement->hydrate($data[0]);
        }
        else
        {
            $payement = null;
        }
        return $payement;
    }

    /*
     * Retourne l'ensemble des moyens de Payement qui sont en base
     * 
     * @return array[Payement] Toutes les moyen de payement sont placées dans un Tableau
     */

    public static function findAll()
    {
        $mesPayement = array();

        $data = BaseSingleton::select('SELECT payement.id as id, '
                        . 'payement.moyen as moyen '
                        . ' FROM payement'
                        . ' ORDER BY payement.moyen ASC');

        foreach ($data as $row)
        {
            $payement = new Payement();
            $payement->hydrate($row);
            $mesPayement[] = $payement;
        }

        return $mesPayement;
    }

    /*
     * Retourne le Payement correspondant au Moyen passer en paramètre
     * Ce Moyen est forcément unique, il est recherche sans tenir compte de la casse
     * 
     * @param string moyen
     * @return Payement
     */

    public static function findByMoyen($moyen)
    {
        $data = BaseSingleton::select('SELECT payement.id as id, '
                        . 'payement.moyen as moyen '
                        . ' FROM payement'
                        . ' WHERE LOWER(payement.moyen) = LOWER(?)', array('s', &$moyen));
        $payement = new Payement();

        if (sizeof($data) > 0)
        {
            $payement->hydrate($data[0]);
        }
        return $payement;
    }

    /*
     * Insère ou met à jour le moyen de payement donnée en paramètre.
     * Pour cela on vérifie si l'id du Payement transmis est sup ou inf à 0.
     * Si l'id est inf à 0 alors il faut insèrer, sinon update à l'id transmis.
     * 
     * @param Payement
     * @return int
     * L'id de le Payement inséré en base. False si ça a planté
     */

    public static function insertOnDuplicate($payement)
    {

        //Récupère les valeurs du payement passé en para de la méthode
        $moyen = $payement->getMoyen(); //string
        $id = $payement->getId(); //int
        if ($id < 0)
        {
            $sql = 'INSERT INTO payement (moyen) '
                    . ' VALUES (?) ';

            //Prépare les info concernant les type de champs
            $params = array('s',
                &$moyen
            );
        }
        else
        {
            $sql = 'UPDATE payement '
                    . 'SET moyen = ? '
                    . 'WHERE id = ? ';

            //Prépare les info concernant les types de champs
            $params = array('si',
                &$moyen,
                &$id
            );
        }

        //Exec la requête
        $idInsert = BaseSingleton::insertOrEdit($sql, $params);

        return $idInsert;
    }

    /*
     * Supprime le Payement correspondant à l'id donné en paramètre
     * 
     * @param int $id
     * @return bool
     * True si la ligne a bien été supprimée, False sinon
     */

    public static function delete($id)
    {
        $deleted = BaseSingleton::delete('DELETE FROM payement WHERE id = ?', array('i', &$id));
        return $deleted;
    }

}
