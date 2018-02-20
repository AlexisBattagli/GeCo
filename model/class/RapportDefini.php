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

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

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
   ==============================
   ======== CONSTRUCTEUR ========
   ============================== 
*/ 

    public function RapportDefini($dateDebut = "1994-03-08", $dateFin = "1994-03-08", $flux = array()){
    	
    	$this->dateDebut = $dateDebut;
    	$this->dateFin = $dateFin;
    	parent::Rapport($flux); //les attributs d'un rapport sont calculés avec des méthodes propre à la classe Rapport, à partir uniquement du tableau d'entr&ées et sorties !!
    }
/* 
   ==============================
   ========== METHODES ==========
   ============================== 
*/ 
  
    /*
     * Récupère la liste des ES du rapport Defini (hors Transfert)
     */
    public function getES(){
    	return parent::getEntreesSorties();
    }
    
    /*
     * Récupère la liste des ES du rapport Defini (hors Transfert)
     
    public function getTotS(){
    	return parent::getTotS();
    }
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
