<?php

/*
 * Class RapportAnnuel, ne correspond à aucune table de la bdd.
 * Elle hérite de sa class mère, Rapport, et importe donc tous ces attributs.
 * ses attributs interne sont, annee
 * @author Alexis BATTAGLI
 * @version 0.1
 * 
 * Cette class permet de gènèrer un rapport en ne prenant en compte que l'année souhaitée.
 * L'année doit être au moins de 2014, puisque le logiciel n'existait pas avant...
 */

class RapportAnnuel extends Rapport {
    
/* 
   ==============================
   ========= ATTRIBUTS ==========
   ============================== 
*/
    
    /*
     * Année du rapport voulu
     * @var int
     */
    private $annee;
    
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
     * Année
     * doit être entière supérieur à 2014
     */
    public function setAnnee($annee)
    {
        if(is_int($annee) && $annee>=2014)
        {
            $this->annee = $annee;
        }
    }
    
    public function getAnnee()
    {
        return $this->annee;
    }
   
}
