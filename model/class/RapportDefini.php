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
   ==============================
   ======== CONSTRUCTEUR ========
   ============================== 
*/ 

/* 
   ==============================
   ========== METHODES ==========
   ============================== 
*/ 
  
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
}
