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

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/EntreeSortie.php');

class Rapport {
    
/* 
   ==============================
   ========= ATTRIBUTS ==========
   ============================== 
*/
	
	/*
	 * Liste des entrées et sorties du rapport
	 * @var EntreeSortie[]
	 */
	private $entreesSorties;
	
	/*
	 * Liste des transferts du rapport
	 * @var EntreeSortie[]
	 */
	private $transferts;	
	
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
     * Constructeur par défaut
     */
    public function Rapport($flux = array()){
    	echo "[DEBUG] Commence la création de l'objet rapport, à partir du tableau d'entrée sortie.</br>";
    	
    	$this->entreesSorties = $this->listEntreesSorties($flux); 
    	echo "[DEBUG] Il y a ".count($this->getEntreesSorties())." es dans ce rapport.</br>";
    	
    	$this->transferts = $this->listTransferts($flux); 
    	echo "[DEBUG] Il y a ".count($this->getTransferts())." transferts dans ce rapport.</br>";
    	
    	$this->nbSortie = $this->calNbSortie();
    	$this->nbEntree = $this->calNbEntree();
    	$this->totSortie = $this->calTotS();
    	$this->totEntree = $this->calTotE();
    	
    	if($this->getNbSortie()>0){
    		$this->moySortie = round($this->getTotSortie() / $this->getNbSortie(), 2); // arrondi à deux décimales
    	}else if($this->getNbSortie()==0 && $this->getTotSortie()==0){
    		$this->moySortie = 0;
    	}else{
    		$this->moySortie = 0;
    		echo "[ERROR] Nombre de sortie vaut ".$this->getNbSortie().", or le total de sortie est de ".$this->getTotSortie()." € ! </br>";
    	}
    	echo "[DEBUG] La moyenne des sorties est de ".$this->getMoySortie()." €</br>";
    	
    	if($this->getNbEntree()>0){
    		$this->moyEntree = round($this->getTotEntree() / $this->getNbEntree(), 2); // arrondi à deux décimales
    	}else if($this->getNbEntree()==0 && $this->getTotEntree()==0){
    		$this->moyEntree = 0;
    	}else{
    		$this->moyEntree = 0;
    		echo "[ERROR] Nombre d'entrée vaut ".$this->getNbEntree().", or le total de sortie est de ".$this->getTotEntree()." € ! </br>";
    	}
    	echo "[DEBUG] La moyenne des entrées est de ".$this->getMoyEntree()." €</br>";
  
    	$this->gain = $this->getTotEntree() - $this->getTotSortie();
    	echo "[DEBUG] Le gain est de ".$this->getGain()." €</br>";
    	
    }
/* 
   ==============================
   ========== METHODES ==========
   ============================== 
*/
    
    /*
     * Recupère les flux d'argent qui sont uniquement des transfert
     */
    public function listTransferts($flux){
    	$list = array();
    	foreach ($flux as $trf){
    		if($trf->getObjet()->isTrf()){
    			array_push($list, $trf);
    		}
    	}
    	return $list;
    }
    
    /*
     * Recupère les flux d'argent qui sont uniquement des entrées ou sorties, autre que des transfert
     */
    public function listEntreesSorties($flux){
    	$list = array();
    	foreach ($flux as $es){
    		if(!$es->getObjet()->isTrf()){
    			array_push($list, $es);
    		}
    	}
    	return $list;
    }  
    
    /*
     * Calcule à partir d'un tableau d'entrée et de sortie le nombre de sortie
     */
    public function calNbSortie(){
    	$nbS = 0;
    	foreach ($this->getEntreesSorties() as $es){
    		if($es->isS()){
    			$nbS++;
    		}
    	}
    	echo "[DEBUG] On a ".$nbS." sortie(s).</br>";
    	return $nbS;
    }
    
    /*
     * Calcule à partir d'un tableau d'entrée et de sortie le nombre de entrée
     */
    public function calNbEntree(){
    	$nbE = 0;
    	foreach ($this->getEntreesSorties() as $es){
    		if($es->isE()){
    			$nbE++;
    		}
    	}
    	echo "[DEBUG] On a ".$nbE." entrée(s).</br>";
    	return $nbE;
    }
    
    /*
     * Calcule à partir d'un tableau d'ES, la sommme total des sorties
     * 
     * @return int
     */
    public function calTotS(){
    	$totS = 0;
    	foreach ($this->getEntreesSorties() as $es){
    		if($es->isS()){
    			$totS += $es->getValeur(); 
    		}
    	}
    	echo "[DEBUG] La somme des sorties est de ".$totS." €.</br>";
    	return $totS;
    }
    
    /*
     * Calcule à partir d'un tableau d'ES, la sommme total des entrées
     *
     * @return int
     */
    public function calTotE(){
    	$totE = 0;
    	foreach ($this->getEntreesSorties() as $es){
    		if($es->isE()){
    			$totE += $es->getValeur();
    		}
    	}
    	echo "[DEBUG] La somme des entrées est de ".$totE." €.</br>";
    	return $totE;
    }
    
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

    /*
     * entreesSorties
     */
    public function setEntreesSorties($entreesSorties)
    {
    	if(is_array($entreesSorties))
    	{
    		$this->entreesSorties = $entreesSorties;
    	}
    }
    
    public function getEntreesSorties()
    {
    	return $this->entreesSorties;
    }
    
    
    /*
     * transferts
     */
    public function setTransferts($transferts)
    {
    	if(is_array($transferts))
    	{
    		$this->transferts = $transferts;
    	}
    }
    
    public function getTransferts()
    {
    	return $this->transferts;
    }
}
