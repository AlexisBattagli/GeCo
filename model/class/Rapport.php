<?php

/*
 * Class Rapport ne correspond à aucune table de la bdd.
 * avec les attributs, nbSortie, nbEntree, totSortie, totEntree, moySortie, moyEntree, gain
 * @author: Alexis BATTAGLI
 * @version 0.1
 * 
 * Cette class est une class-mère pour les class RapportMensuel, RapportAnnuel, RappportDefini
 * elle permet de gèrer les attributs de base que l'on doit retrouver dans un rapports. 
 */

class Rapport {
    
/* 
   ==============================
   ========= ATTRIBUTS ==========
   ============================== 
*/
    /*
     * Nombre de Sortie
     * @var int
     */
    private $nbSortie;
    
    /*
     * Nombre d'Entrée
     * @var int
     */
    private $nbEntree;
    
    /*
     * Valeur total des Sorties
     * @var double
     */
    private $totSortie;
    
    /*
     * Valeur total des Endtrées
     * @var double
     */
    private $totEntree;
    
    /*
     * Moyenne des Sorties
     * @var double
     */
    private $moySortie;
    
    /*
     * Moyenne des Entrées
     * @var double
     */
    private $moyEntree;
    
    /*
     * Gain, totE-totS
     * @var double
     */
    private $gain;
    
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
    * nbSortie
    * doit être entier et positif
    */
    public function setNbSortie($nbS)
    {
        if(is_int($nbS) && $nbS>=0)
        {
            $this->nbSortie = $nbS;
        }
    }
    
    public function getNbSortie()
    {
        return $this->nbSortie;
    }
    
   /*
    * nbEntree
    * doit être entier et positif
    */
    public function setNbEntree($nbE)
    {
        if(is_int($nbE) && $nbE>=0)
        {
            $this->nbEntree = $nbE;
        }
    }
    
    public function getNbEntree()
    {
        return $this->nbEntree;
    }
    
   /*
    * totSortie
    */
    public function setTotSortie($totS)
    {
        if(is_double($totS))
        {
            $this->totSortie = $totS;
        }
    }
    
    public function getTotSortie()
    {
        return $this->totSortie;
    }
    
   /*
    * totEntree
    */
    public function setTotEntree($totE)
    {
        if(is_double($totE))
        {
            $this->totEntree = $totE;
        }
    }
    
    public function getTotEntree()
    {
        return $this->totEntree;
    }
    
   /*
    * moySortie
    * doit être positif ou nul
    */
    public function setMoySortie($moyS)
    {
        if(is_double($moyS) && $moyS>=0)
        {
            $this->moySortie = $moyS;
        }
    }
    
    public function getMoySortie()
    {
        return $this->moySortie;
    }
    
   /*
    * moyEntree
    * doit être positif ou nul
    */
    public function setMoyEntree($moyE)
    {
        if(is_double($moyE) && $moyE>=0)
        {
            $this->moyEntree = $moyE;
        }
    }
    
    public function getMoyEntree()
    {
        return $this->moyEntree;
    }
    
   /*
    * gain
    */
    public function setGain($gain)
    {
        if(is_double($gain))
        {
            $this->gain = $gain;
        }
    }
    
    public function getGain()
    {
        return $this->gain;
    }
    
}
