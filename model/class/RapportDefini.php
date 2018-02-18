<?php

/*
 * Class RapportDefini, ne correspond à aucune table de la bdd.
 * Elle hérite de sa class mère, Rapport, et importe donc tous ces attributs.
 * ses attributs interne sont, dateDeb et dateFin
 * @author Alexis BATTAGLI
 * @version 0.1
 * 
 * Cette class permet de gènèrer un rapport sur la période souhaité.
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/EntreeSortie.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Rapport.php');

class RapportDefini extends Rapport{

/* 
   ==============================
   ========= ATTRIBUTS ==========
   ============================== 
*/
    
    /*
     * Date du début de la période voulu
     * @var date
     */
    private $dateDebut;
    
    /*
     * Date de fin de la période voulu
     * @var date
     */
    private $dateFin;
    
    /*
     * Liste d'ES du mois donné
     * @var EntreeSortie[]
     */
    private $entreesSorties;
    
    /*
     * Listes des Objet du rapport
     * @var Objet[]
     */
    private $bilanObjets;
    
/* 
   ==============================
   ======== CONSTRUCTEUR ========
   ============================== 
*/ 

    public function RapportDefini($dateDebut = "1994-03-08", $dateFin = "1994-03-08"){
    	
    	$this->dateDebut = $dateDebut;
    	$this->dateFin = $dateFin;
    	$this->entreesSorties = EntreeSortieDAL::findByIntervalDate($dateDebut, $dateFin);
    	parent::Rapport($this->entreesSorties); //les attributs d'un rapport sont calculés avec des méthodes propre à la classe Rapport, à partir uniquement du tableau d'entr&ées et sorties !!
    	$this->bilanObjets = $this->calBilanObjets(); //TODO
    }
/* 
   ==============================
   ========== METHODES ==========
   ============================== 
*/ 
  
    /*
     * Récupère la liste des ES du rapport Defini
     */
    public function getES(){
    	return parent::getEntreesSorties();
    }
    
    /*
     * Recupère les objets d'un tableau d'EntreeSortie
     */
    public function calBilanObjets() //TODO ici ajouter les stat pour calculer les gain par objets avec comparaison du budget
    {
    	$listBO = array(
    			'id' => array(),
    			'label' => array(),
    			'nbS' => array(),
    			'nbE' => array(),
    			'totS' => array(),
    			'totE' => array(),
    			'gain' => array(),
    			'budget' => array()
    	);
    	
    	$listES = $this->getES();
    	
    	foreach ($listES as $es){
    		if(!in_array($es->getObjet()->getId(), $listBO['id'])){
    			//echo "[DEBUG] Ajout de l'objet ".$es->getObjet()->getLabel()."</br>";
    			array_push($listBO['id'],$es->getObjet()->getId());
    			array_push($listBO['label'], $es->getObjet()->getLabel());
    			array_push($listBO['nbS'], $es->calNbS($this->getDateDebut(), $this->getDateFin(), $es->getObjet()->getId()));
    			//TODO calculer ici les différent element du tableau par Objet de la view rapport_defini
    		}
    	}
    	
    	echo '<pre>';
    	var_dump($listBO);
    	echo '</pre>';
    	
    	return $listBO;
    }
    
/* 
   ==============================
   ======= GETTER/SETTER ========
   ============================== 
*/ 
    
    /*
     * Date de début de période de recherche
     */
    public function setDateDebut($dateDebut)
    {
        if(is_string($dateDebut))
        {
            $this->dateDebut = $dateDebut;
        }
    }
    
    public function getDateDebut()
    {
        return $this->dateDebut;
    }
    
    /*
     * Date de fin de période de recherche
     */
    public function setDateFin($dateFin)
    {
        if(is_string($dateFin))
        {
            $this->dateFin = $dateFin;
        }
    }
    
    public function getDateFin()
    {
        return $this->dateFin;
    }
    
    /*
     * objets
     */
    public function setBilanObjets($bilanObjets)
    {
    	if(is_array($bilanObjets))
    	{
    		$this->bilanObjets = $bilanObjets;
    	}
    }
    
    public function getBilanObjets()
    {
    	return $this->bilanObjets;
    }
}
