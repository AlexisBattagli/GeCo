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
                                            . 'budget.annee as annee, '
                                            . 'budget.mois as mois '
                                    . ' FROM budget '
                                    . ' WHERE budget.id = ?', array('i',&$id));
        $budget = new Budget();
        $budget->hydrate($data[0]);
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
                                            . 'budget.annee as annee, '
                                            . 'budget.mois as mois '
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
        $mois = $budget->getMois(); //int
        if ($id<0)
        {
            //Prépare la requête Insertion/Mise à Jour
            $sql = 'INSERT INTO budget (objet_id, valeur, annee, mois) '
                . ' VALUES(?,?,?,?) ';
            $params = array('idii',
                &$objetId,
                &$valeur,
                &$annee,
                &$mois
            );
        }
        else
        {
            $sql = 'UPDATE budget '
                    . ' SET objet_id = ?, '
                        . ' valeur = ?, '
                        . ' annee = ?,'
                        . ' mois = ? '
                    . ' WHERE id = ?';
            $params = array('idiii',
                &$objetId,
                &$valeur,
                &$annee,
                &$mois,
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
