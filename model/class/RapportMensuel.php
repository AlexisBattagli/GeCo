<?php

/*
 * Class RapportMensuel, ne correspond à aucune table de la bdd.
 * Elle hérite de sa class mère, Rapport, et importe donc tous ces attributs.
 * ses attributs interne sont, mois
 * @author Alexis BATTAGLI
 * @version 0.1
 * 
 * Cette class permet de gènèrer un rapport en ne prenant en compte que le mois souhaité.
 * Le mois doit être compris entree 1 et 12
 */

class RapportMensuel extends Rapport{

/* 
   ==============================
   ========= ATTRIBUTS ==========
   ============================== 
*/
    
    /*
     * Mois du rapport voulu
     * @var int
     */
    private $mois;
    
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
     * Mois
     * doit être entier ET compris entre 1 et 12 inclu
     */
    public function setMois($mois)
    {
        if(is_int($mois) && $mois>=1 && $mois<=12)
        {
            $this->mois = $mois;
        }
    }
    
    public function getMois()
    {
        return $this->mois;
    }

}
