<?php

/**
 * La class BudgetDAL hérite de la class Budget.
 * Elle possède donc tous ces attributs et méthodes
 *
 * @author Alexis
 * @version 0.1
 * 
 * Cette class permet de faire,
 * recherche, ajout, modification et suppression de Budget en base.
 */

require_once('BaseSingleton.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Budget.php');

class BudgetDAL {

    /*
     * Retourne le budget correspondant à l'id donnée
     * 
     * @param int $id Identifiant du budget à trouver
     * @return Budget
     */
    
    public static function findById($id)
    {
        $data = BaseSingleton::select('SELECT budget.id as id, '
                                            . 'budget.objet_id as objet_id, '
                                            . 'budget.valeur as valeur, '
                                            . 'budget.annee as annee '
                                    . ' FROM budget '
                                    . ' WHERE budget.id = ?', array('i',&$id));
        $budget = new Budget();
        if (sizeof($data) > 0)
        {
        	$budget->hydrate($data[0]);
        } else {
        	$budget = null;
        }
        return $budget;
    }
    
    /*
     * Retourne l'ensemble des Budget qui sont en base
     * 
     * @return array[Budget] Toutes les Budget sont placées dans un Tableau
     */
    public static function findAll()
    {
        $mesBudgets = array();
        
        $data = BaseSingleton::select('SELECT budget.id as id, '
                                            . 'budget.objet_id as objet_id, '
                                            . 'budget.valeur as valeur, '
                                            . 'budget.annee as annee '
                                    . ' FROM budget ');
        
        foreach ($data as $row)
        {
            $budget = new Budget();
            $budget->hydrate($row);
            $mesBudgets[] = $budget;
        }
        
        return $mesBudgets;
    }
    
    
    /*
     * Retourne la liste des budgets pour une année donnée
     * 
     * @param int annee
     * @return array[Budget]
     */
    public static function findByYear($annee){
    	$mesBudgets = array();
    	$data = BaseSingleton::select('SELECT budget.id as id, '
                                     . 'budget.objet_id as objet_id, '
                                     . 'budget.valeur as valeur, '
                                     . 'budget.annee as annee '
                                    . ' FROM budget '
                                    . ' WHERE budget.annee = ?', array('i',&$annee));

    	foreach ($data as $row){
    		$budget = new Budget();
    		$budget->hydrate($row);
    		$mesBudgets[] = $budget;
    	}

    	return $mesBudgets;
    }
    
    /*
     * Retourne la liste des année où des budgets ont été définis
     */
    public static function findYears(){
    	$years = array();
    	$data = BaseSingleton::select('SELECT budget.annee as annee '
    								. 'FROM budget '
    								. ' GROUP BY annee '
    								. ' ORDER BY annee DESC');

    	foreach ($data as $row){
    		$year = $row['annee'];
    		$years[] = $year;
    	}
    	
    	return $years;
    }
    
    /*
     * Permet de recherché un Budget unique défini par le couple Année et Objet
     */
    public static function findByAO($annee,$objet){
    	$objetId = $objet->getId();
    	$data = BaseSingleton::select('SELECT budget.id as id, '
                                            . 'budget.objet_id as objet_id, '
                                            . 'budget.valeur as valeur, '
                                            . 'budget.annee as annee '
                                    . ' FROM budget '
                                    . ' WHERE budget.annee = ? AND budget.objet_id = ?', array('ii',&$annee, &$objetId));
    	$budget = new Budget();
    	
    	if (sizeof($data) > 0)
    	{
    		$budget->hydrate($data[0]);
    	}
    	
    	return $budget;
    }
    
    /*
     * Permet de retourner la liste des budget liés à un objet
     * ATTENTION: cela ne prend pas en compte l'année prochaine.
     */
    public static function findByObjet($idObjet){
    	$mesBudgets = array();
    	$currentYear = date('Y');
    	$data = BaseSingleton::select('SELECT budget.id as id, '
    									.' budget.objet_id as objet_id, '
    									.' budget.valeur as valeur, '
    									.' budget.annee as annee '
    								.' FROM budget '
    								.' WHERE objet_id = ? AND annee <= ?', array('ii', &$idObjet, &$currentYear));
    	foreach ($data as $row){
    		$budget = new Budget();
    		$budget->hydrate($row);
    		$mesBudgets[] = $budget;
    	}
    	
    	return $mesBudgets;
    }
    
    /*
     * Retourne le budget lié à un objet pour l'année prochaine
     */
    public static function findNextByObjet($idObjet){
    	$nextYear = date('Y')+1;
    	$data = BaseSingleton::select('SELECT budget.id as id, '
    			.' budget.objet_id as objet_id, '
    			.' budget.valeur as valeur, '
    			.' budget.annee as annee '
    			.' FROM budget '
    			.' WHERE objet_id = ? AND annee <= ?', array('ii', &$idObjet, &$nextYear));
    	
    	$budget = new Budget();
    	if (sizeof($data) > 0)
    	{
    		$budget->hydrate($data[0]);
    	} else {
    		$budget = null;
    	}
    	 
    	return $budget;
    }
    
    
    
    /*
     * Insère ou met à jour le sous objet donné en paramètre.
     * 
     * @param Budget budget
     * @return int id
     * L'id du budget inséré en base. False si ça a planté
     */
    public static function insertOnDuplicate($budget)
    {
        //Récupère les valeurs de l'objet entreeSortie passé en para.
        $id = $budget->getId(); 
        $objetId = $budget->getObjet()->getId(); //int
        $valeur = $budget->getValeur(); //double
        $annee = $budget->getAnnee(); //int
        if ($id<0)
        {
            //Prépare la requête Insertion/Mise à Jour
            $sql = 'INSERT INTO budget (objet_id, valeur, annee) '
                . ' VALUES(?,?,?) ';
            $params = array('idi',
                &$objetId,
                &$valeur,
                &$annee
            );
        }
        else
        {
            $sql = 'UPDATE budget '
                    . ' SET objet_id = ?, '
                        . ' valeur = ?, '
                        . ' annee = ?'
                    . ' WHERE id = ?';
            $params = array('idii',
                &$objetId,
                &$valeur,
                &$annee,
                &$id
            );
        }

        //Exec la requête
        $idInsert = BaseSingleton::insertOrEdit($sql, $params);
        
        return $idInsert;
    }
    
    /*
     * Supprime le Budget correspondant à l'id donné en paramètre
     * 
     * @param int $id
     * @return bool
     * True si la ligne a bien été supprimée, False sinon
     */
    public static function delete($id)
    {
        $deleted = BaseSingleton::delete('DELETE FROM budget WHERE id = ?', array('i', &$id));
        return $deleted;
    }
}
