<?php

/*
 * Class Objet correspondant à la table objet de la BDD
 * avec les attributs internes id, label, description
 * avec aucun attributs externe
 * @author Alexis BATTAGLI
 * @version 0.1
 * 
 * Cette class permet de gèrer les attributs de la table objet
 * Ainsi que les méthodes lié aux manipulations sur ses attributs.
 * Cette classe représente les objet des différentes ES
 */

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/BudgetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/SousObjetDAL.php');

class Objet {
    
/* 
   ==============================
   ========= ATTRIBUTS ==========
   ============================== 
*/ 
    /*
     * Id de l'objet dans la table objet
     * @var int 
     */
    private $id;
    
    /*
     * Label de l'objet
     * @var string
     */
    private $label;
    
    /*
     * Description de l'objet
     * @var string
     */
    private $description;
    
/* 
   ==============================
   ======== CONSTRUCTEUR ========
   ============================== 
*/ 

    /*
     * Constructeur par défaut de Objet
     */
    public function __construct($id= -1, $label= "Label de l'etiquette par défaut.", $description= "Aucune description renseignée pour cette etiquette")
    {
        $this->id = $id;
        $this->label = $label;
        $this->description = $description;
    }
    
/* 
   ==============================
   ========== METHODES ==========
   ============================== 
*/ 
 
    /*
     * Methodes d'hydratation d'une Objet
     * Utilisé le plus souvent lorsqeue l'on place le résultat d'une recherche en base 
     * dans un objet Objet créer par défaut
     * 
     * ATTENTION, les champs entre simple cote représente les nom de colonne dans la requête.
     * ex : dataSet contient une entrée en base de donnée avec les idifférents champs, 
     * pour accèder à la valeur contenue dans la colonne nommé attribut_1 il faut indiquer
     * dataSet['attribut_1']
     */
    public function hydrate($dataSet)
    {
        $this->id = $dataSet['id'];
        $this->label = $dataSet['label'];
        $this->description = $dataSet['description'];
    }
 
    /*
     * Méthode vérifiant à partir du label
     * qu'un objet n'existe pas déjà en base
     * 
     * Retourne 0 si le label existe déjà, sinon 1
     * 
     * @return int
     */
    public function isUnique()
    {
        $result=0; //par défaut on considère qu'il existe déjà
        $label = $this->getLabel();
        
        $objet = ObjetDAL::findByLabel($label);
        if($objet->getId()==-1) //s'il y a un id par défaut retourner
        {
            $result=1; //alors c'est qu'il existe pas
        }
        return $result;
    }
    
    /*
     * Regarde si l'objet n'apprtient à aucune ES ET aucun budget de l'année en cours ou précédante.
     */
    public function isDeletable() {
    	$deletable = 0; //Par défaut le sous-objet n'est pas deletable
    	
    	$id = $this->getId();
    	$esLiees = EntreeSortieDAL::findByObjet($id);
    	$budgetLies = BudgetDAL::findByObjet($id);
    	
    	if(sizeof($esLiees)==0 && sizeof($budgetLies)==0){
    		$deletable = 1;
    	}
    	return $deletable;
    }
    
    /*
     * Regarde si l'objet est un transfert
     */
    public function isTrf(){
    	$result = false;
    	if($this->getLabel() == "Transfert"){
    		$result = true;
    	}
    	return $result;
    }
    
    /*
     * Retourne le nombre de fois où un objet donnée a été associé à une sortie sur une période de temps donnée
     */
    public function getSbyObjet($start, $end){
    	return EntreeSortieDAL::findSbyObjetByTime($start, $end, $this->getId());
    }
    
    /*
     * Retourne le nombre de fois où un objet donnée a été associé à une entrée sur une période de temps donnée
     */
    public function getEbyObjet($start, $end){
    	return EntreeSortieDAL::findEbyObjetByTime($start, $end, $this->getId());
    }
    
    /*
     * Retourne la liste des Sous-Objet, array() vide si n'en a pas
     */
    public function listSousObjets(){
    	return SousObjetDAL::findByObjet($this->getId());
    }
    
    
/* 
   ==============================
   ======= GETTER/SETTER ========
   ============================== 
*/ 
  
  //id
    public function setId($id)
    {
        if (is_int($id))
        {
            $this->id = $id;
        }
    }

    public function getId()
    {
        return $this->id;
    }
    
  //label
    public function setLabel($label)
    {
        if (is_string($label))
        {
            $this->label = $label;
        }
    }

    public function getLabel()
    {
        return $this->label;
    }    
    
  //description
    public function setDescription($description)
    {
        if (is_string($description))
        {
            $this->description = $description;
        }
    }

    public function getDescription()
    {
        return $this->description;
    }    
}
