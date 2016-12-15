<?php

/**
 * La class SousObjetDAL hérite de la class SousObjet.
 * Elle possède donc tous ces attributs et méthodes
 *
 * @author Alexis
 * @version 0.1
 * 
 * Cette class permet de faire,
 * recherche, ajout, modification et suppression de SousObjet en base.
 */

require_once('BaseSingleton.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Objet.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/SousObjet.php');

class SousObjetDAL {

    /*
     * Retourne le SousObjet correspondant à l'id donnée
     * 
     * @param int $id Identifiant du sousObjet à trouver
     * @return SousObjet
     */
    public static function findById($id)
    {
        $data = BaseSingleton::select('SELECT sous_objet.id as id, '
                                            . 'sous_objet.objet_id as objet_id, '
                                            . 'sous_objet.label as label, '
                                            . 'sous_objet.description as description '
                                    . ' FROM sous_objet '
                                    . ' WHERE sous_objet.id = ?', array('i',&$id));
        $sousObjet = new SousObjet();
        if (sizeof($data) > 0)
        {
        	$sousObjet->hydrate($data[0]);
        }else {
        	$sousObjet = null;
        }
        	return $sousObjet;
    }
    
    /*
     * Retourne les SousObjet correspondant à l'objet donnée
     *
     * @param int $idObjet Identifiant du sousObjet à trouver
     * @return SousObjet[]
     */
    public static function findByObjet($idObjet)
    {
    	$mesSousObjets = array();
    	$data = BaseSingleton::select('SELECT sous_objet.id as id, '
    			. 'sous_objet.objet_id as objet_id, '
    			. 'sous_objet.label as label, '
    			. 'sous_objet.description as description '
    			. ' FROM sous_objet '
    			. ' WHERE sous_objet.objet_id = ?', array('i',&$idObjet));
    	
    	foreach ($data as $row){	
    		$sousObjet = new SousObjet();
    		$sousObjet->hydrate($row);
    		$mesSousObjets[] = $sousObjet;
    	}
    	
    	return $mesSousObjets;
    }
    
   /*
     * Retourne l'ensemble des SousObjet qui sont en base
     * 
     * @return array[SousObjet] Toutes les SousObjet sont placées dans un Tableau
     */
    public static function findAll()
    {
        $mesSousObjets = array();
        
        $data = BaseSingleton::select('SELECT sous_objet.id as id, '
                        . 'sous_objet.objet_id as objet_id, '
                        . 'sous_objet.label as label, '
                        . 'sous_objet.description as description '
                        . ' FROM sous_objet');
        
        foreach ($data as $row)
        {
        	$sousObjet = new SousObjet();
            $sousObjet->hydrate($row);
            $mesSousObjets[] = $sousObjet;
        }
        
        return $mesSousObjets;
    }
    
    /*
     * Retourne le Sous-Objet correspondant au label et objet passer en paramètre
     * Ce Label est forcément unique, il est recherche sans tenir compte de la casse
     * 
     * @param string label
     * @return Objet
     */

    public static function findByLO($label, $objet)
    {
        $objetId = $objet->getId();
        $data = BaseSingleton::select('SELECT sous_objet.id as id, '
                        . 'sous_objet.objet_id as objet_id, '
                        . 'sous_objet.label as label, '
                        . 'sous_objet.description as description '
                        . ' FROM sous_objet'
                        . ' WHERE LOWER(sous_objet.label) = LOWER(?) AND sous_objet.objet_id = ?', array('si', &$label, &$objetId));
        $sousobjet = new SousObjet();

        if (sizeof($data) > 0)
        {
            $sousobjet->hydrate($data[0]);
        }
        
        return $sousobjet;
    }
    
    /*
     * Insère ou met à jour le sous objet donné en paramètre.
     * 
     * @param SousObjet sousObjet
     * @return int id
     * L'id du sousObjet inséré en base. False si ça a planté
     */
    public static function insertOnDuplicate($sousObjet)
    {
        //Récupère les valeurs de l'objet entreeSortie passé en para.
        $id = $sousObjet->getId(); 
        $objetId = $sousObjet->getObjet()->getId(); //int
        $label = $sousObjet->getLabel(); //string
        $description = $sousObjet->getDescription(); //string
        if ($id<0)
        {
            //Prépare la requête Insertion/Mise à Jour
            $sql = 'INSERT INTO sous_objet (objet_id, label, description) '
                . ' VALUES(?,?,?) ';
            $params = array('iss',
                &$objetId,
                &$label,
                &$description
            );
        }
        else
        {
            $sql = 'UPDATE sous_objet '
                    . ' SET objet_id = ?, '
                        . ' label = ?, '
                        . ' description = ? '
                    . ' WHERE id = ?';
            $params = array('issi',
                &$objetId,
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
     * Supprime le SousObjet correspondant à l'id donné en paramètre
     * 
     * @param int $id
     * @return bool
     * True si la ligne a bien été supprimée, False sinon
     */
    public static function delete($id)
    {
        $deleted = BaseSingleton::delete('DELETE FROM sous_objet WHERE id = ?', array('i', &$id));
        return $deleted;
    }
}
