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
	 * Return true(1) false(0), selon si la date passer en paramètre pour le comppte donné possède un solde supérieur ou égale à son plus ancien solde.
	 */
	public static function isYounger($compteId, $date){
		$isYounger = 0;
		
		$data = BaseSingleton::select('SELECT solde.id as id, '
				. 'solde.compte_id as compte_id, '
				. 'solde.valeur as valeur, '
				. 'solde.date as date '
				. ' FROM solde '
				. ' WHERE solde.compte_id = ? AND solde.date <= ?', array('is', &$compteId,&$date));

		if (sizeof($data) > 0) 
		{
			$isYounger = 1;
		}
		return $isYounger;
		
	}
	
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
	 * Retourne le solde d'un compte pour un moi et une annee données
	 * 
	 * @param string $mois, string $annee, int $compte_id
	 */
    public static function findByDate($mois, $annee, $compteId)
    {
    	$data = BaseSingleton::select('SELECT solde.id as id, '
                        . 'solde.compte_id as compte_id, '
                        . 'solde.valeur as valeur, '
                        . 'solde.date as date '
                        . ' FROM solde '
                        . ' WHERE solde.compte_id = ? AND MONTH(solde.date) = ? AND YEAR(solde.date) = ?', array('iss', &$compteId,&$mois,&$annee));
    	
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
     * Retourne le solde d'un comtpe le plus récent
     */
    public static function findLast($compteId)
    {
    	$data = BaseSingleton::select('SELECT solde.id as id, '
    			. 'solde.compte_id as compte_id, '
    			. 'solde.valeur as valeur, '
    			. 'solde.date as date '
    			. ' FROM solde '
    			. ' WHERE solde.compte_id = ?'
    			. ' ORDER BY YEAR(date) DESC, MONTH(date) DESC', array('i', &$compteId));
    	 
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
     * Retourne le solde d'un comtpe le plus récent strictement antérieur à une date donnée
     */
    public static function findOldLast($date, $compteId)
    {
    	$data = BaseSingleton::select('SELECT solde.id as id, '
    			. 'solde.compte_id as compte_id, '
    			. 'solde.valeur as valeur, '
    			. 'solde.date as date '
    			. ' FROM solde '
    			. ' WHERE solde.compte_id = ? AND date <= ? '
    			. ' ORDER BY YEAR(date) DESC, MONTH(date) DESC', array('is', &$compteId, &$date));

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
     * Retourne l'ensemble des solde compris entre le mois suivant de la date actuelle et la date actuelle, pour un compte donnée
     */
    public static function findByIntervalDateSup($date, $compteId)
    {
    	$mesSoldes = array();
    	
    	$data = BaseSingleton::select('SELECT solde.id as id, '
    			. 'solde.compte_id as compte_id, '
    			. 'solde.valeur as valeur, '
    			. 'solde.date as date '
    			. ' FROM solde '
    			. ' WHERE solde.compte_id = ? AND DATE_FORMAT(solde.date, "%Y-%m") > DATE_FORMAT(?, "%Y-%m")', array('is', &$compteId,&$date));

    	foreach ($data as $row)
    	{
    		$solde = new Solde();
    		$solde->hydrate($row);
    		$mesSoldes[] = $solde;
    	}
    	
    	return $mesSoldes;
    }
    
    /*
     * Retourne l'ensemble des solde compris entre la date indiquée et la date actuelle sans regarder le jour, pour un compte donnée
     */
    public static function findByIntervalDateMoisSupEq($date, $compteId)
    {
    	$mesSoldes = array();
    	 
    	$data = BaseSingleton::select('SELECT solde.id as id, '
    			. 'solde.compte_id as compte_id, '
    			. 'solde.valeur as valeur, '
    			. 'solde.date as date '
    			. ' FROM solde '
    			. ' WHERE solde.compte_id = ? AND DATE_FORMAT(solde.date, "%Y-%m") >= DATE_FORMAT(?, "%Y-%m")', array('is', &$compteId,&$date));
    
    	foreach ($data as $row)
    	{
    		$solde = new Solde();
    		$solde->hydrate($row);
    		$mesSoldes[] = $solde;
    	}
    	 
    	return $mesSoldes;
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
                        . ' WHERE solde.date = (SELECT MAX(solde.date) FROM solde WHERE solde.compte_id = ?) AND solde.compte_id = ?', array('ii', &$idCompte, &$idCompte));
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
                    . ' VALUES(?,?,DATE_FORMAT(?,"%Y-%m-%d")) ';
            $params = array('ids',
                &$compteId,
                &$valeur,
            	&$date
            );
        }
        else
        {
            $sql = 'UPDATE solde '
                    . ' SET compte_id = ?, '
                    . ' valeur = ?, '
                    . ' date = DATE_FORMAT(?,"%Y-%m-%d") '
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
