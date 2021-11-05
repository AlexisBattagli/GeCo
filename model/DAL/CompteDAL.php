<?php

/**
 * La class CompteDAL hérite de la class Compte.
 * Elle possède donc tous ces attributs et méthodes
 *
 * @author Alexis
 * @version 0.2
 *  Histo:
 *      0.2 - Ajout de l'attribut identifiant
 * 
 * Cette class permet de faire,
 * recherche, ajout, modification et suppression de Compte en base.
 */
require_once('BaseSingleton.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Compte.php');

class CompteDAL extends Compte {
    /*
     * Retourne le Compte correspondant à l'id donnée
     * 
     * @param int $id Identifiant du Compte à trouver
     * @return Compte
     */

    public static function findById($id)
    {
        $data = BaseSingleton::select('SELECT compte.id as id, '
                        . 'compte.label as label, '
                        . 'compte.banque as banque, '
                        . 'compte.information as information, '
                        . 'compte.identifiant as identifiant '
                        . ' FROM compte'
                        . ' WHERE compte.id = ?', array('i', &$id));
        $compte = new Compte();
        if (sizeof($data) > 0)
        {
            $compte->hydrate($data[0]);
        }
        else
        {
            $compte = null;
        }
        return $compte;
    }

    /*
     * Retourne l'ensemble des Comptes qui sont en base
     * 
     * @return array[Compte] Tous les compte sont placés dans un Tableau
     */
    public static function findAll()
    {
        $mesComptes = array();

        $data = BaseSingleton::select('SELECT compte.id as id, '
                        . 'compte.label as label, '
                        . 'compte.banque as banque, '
                        . 'compte.information as information, '
                        . 'compte.identifiant as identifiant'
                        . ' FROM compte '
                . ' ORDER BY compte.banque ASC, compte.label ASC');

        foreach ($data as $row)
        {
            $compte = new Compte();
            $compte->hydrate($row);
            $mesComptes[] = $compte;
        }

        return $mesComptes;
    }


    /*
     * Retourne l'ensemble des Comptes Actifs
     * C'est-à-dire les comptes dont le label NE commence PAS par 'OLD'
     * @return array[Compte]
     */
    public static function findAllActif()
    {
	$mesComptesActifs = array();
	
	$data = BaseSingleton::select('SELECT compte.id as id, '
		. 'compte.label as label, '
                . 'compte.banque as banque, '
                . 'compte.information as information, '
                . 'compte.identifiant as identifiant'
                . ' FROM compte '
		. ' WHERE compte.label not REGEXP "^OLD" '
		. ' ORDER BY compte.banque ASC, compte.label ASC');
	foreach ($data as $row)
	{
	    $compte = new Compte();
            $compte->hydrate($row);
            $mesComptesActifs[] = $compte;
	}

	return $mesComptesActifs;
    }


    /*
     * Retourne le compte correspondant au couple Label/Banque
     * Ce couple étant unique, il n'y qu'une seul ligne retourner.
     * Il est rechercher sans tenir compte de la casse
     * 
     * @param string label, string banque
     * @return Compte
     */
    public static function findByLB($label, $banque)
    {
        $data = BaseSingleton::select('SELECT compte.id as id, '
                        . 'compte.label as label, '
                        . 'compte.banque as banque, '
                        . 'compte.information as information, '
                        . 'compte.identifiant as identifiant'
                        . ' FROM compte'
                        . ' WHERE LOWER(compte.label) = LOWER(?) AND LOWER(compte.banque) = LOWER(?)', array('ss', &$label, &$banque));
        $compte = new Compte();

        if (sizeof($data) > 0)
        {
            $compte->hydrate($data[0]);
        }
        return $compte;
    }

    /*
     * Insère ou met à jour le Compte donnée en paramètre.
     * Pour cela on vérifie si l'id du compte transmis est sup ou inf à 0.
     * Si l'id est inf à 0 alors il faut insèrer, sinon update à l'id transmis.
     * 
     * @param Compte
     * @return int
     * L'id de l'objet inséré en base. False si ça a planté
     */

    public static function insertOnDuplicate($compte)
    {

        //Récupère les valeurs de l'objet compte passé en para de la méthode
        $label = $compte->getLabel(); //string
        $banque = $compte->getBanque(); //string
        $information = $compte->getInformation(); //string
        $identifiant = $compte->getIdentifiant(); //string
        $id = $compte->getId();
        if ($id < 0)
        {
            $sql = 'INSERT INTO compte (label, banque, information, identifiant) '
                    . ' VALUES (?,?,?,?) ';

            //Prépare les info concernant les type de champs
            $params = array('ssss',
                &$label,
                &$banque,
                &$information,
                &$identifiant
            );
        }
        else
        {
            $sql = 'UPDATE compte '
                    . 'SET label = ?, '
                    . 'banque = ?, '
                    . 'information = ?, '
                    . 'identifiant = ? '
                    . 'WHERE id = ? ';

            //Prépare les info concernant les type de champs
            $params = array('ssssi',
                &$label,
                &$banque,
                &$information,
                &$identifiant,
                &$id
            );
        }

        //Exec la requête
        $idInsert = BaseSingleton::insertOrEdit($sql, $params);

        return $idInsert;
    }

    /*
     * Supprime le Compte correspondant à l'id donné en paramètre
     * 
     * @param int $id
     * @return bool
     * True si la ligne a bien été supprimée, False sinon
     */

    public static function delete($id)
    {
        $deleted = BaseSingleton::delete('DELETE FROM compte WHERE id = ?', array('i', &$id));
        return $deleted;
    }

}
