<?php

/*
 * Class Budget correspondant à la table budget de la BDD
 * avec les attributs internes id, valeur, annee, mois
 * avec l'attribut externe objet(id)
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 * 
 * Cette class permet de gèrer les attributs de la table budget
 * Ainsi que les méthodes lié aux manipulations sur ses attributs.
 * Cette classe représente le budget mensuel pour un objet,
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/BudgetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php');
class Budget {
   
/* 
   ==============================
   ========= ATTRIBUTS ==========
   ============================== 
*/ 
    /*
     * Id du budget dans la table budget
     * @var int 
     */
    private $id;
    
    /*
     * Budget définie pour tel objet
     * @var Objet
     */
    private $objet;
    
    /*
     * Valeur de ce budget
     * @var double
     */
    private $valeur;
    
    /*
     * Budget définie pour tel annee
     * @var int
     */
    private $annee;
    
/* 
   ==============================
   ======== CONSTRUCTEUR ========
   ============================== 
*/ 

    /*
     * Constructeur par défaut de Budget
     */
    public function Budget($id = -1, $objet = null, $valeur = 0.0, $annee = 1994)
    {
    	$this->id = $id;
        if (is_null($objet))
        {
            $this->objet = new Objet();
        }
        else
        {
            $this->objet = $objet;
        }
    	
        $this->valeur = $valeur;
        $this->annee = $annee;
    }
    
/* 
   ==============================
   ========== METHODES ==========
   ============================== 
*/ 
 
    /*
     * Methodes d'hydratation d'un Budget
     * Utilisé le plus souvent lorsqeue l'on place le résultat d'une recherche en base 
     * dans un objet Budget créer par défaut
     * 
     * ATTENTION, les champs entre simple cote représente les nom de colonne dans la requête.
     * ex : dataSet contient une entrée en base de donnée avec les idifférents champs, 
     * pour accèder à la valeur contenue dans la colonne nommé attribut_1 il faut indiquer
     * dataSet['attribut_1']
     */
    public function hydrate($dataSet)
    {
        $this->id = $dataSet['id'];
        $this->objet = $dataSet['objet_id'];
        $this->valeur = $dataSet['valeur'];
        $this->annee = $dataSet['annee'];
    } 
    
    
    public function isUnique(){
    	$result=0; //par défaut on considère qu'il existe déjà
    	$annee = $this->getAnnee();
    	$objet = $this->getObjet();
    	
    	$budget = BudgetDAL::findByAO($annee,$objet);
    	
    	if($budget->getId()==-1) //s'il y a un id par défaut retourner
    	{
    		$result=1; //alors c'est qu'il n'existe pas
    	}
    	return $result;
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
    
  //objet
    public function setObjet($objet)
    {
        if (is_string($objet))
        {
            $objet = (int) $objet;
            $this->objet = ObjetDAL::findById($objet);
        }
        else if (is_int($objet))
        {
            $this->objet = ObjetDAL::findById($objet);
        }
        else if (is_a($objet, "Objet"))
        {
            $this->objet = $objet;
        }
    }

    public function getObjet()
    {
        $objet = null;
        if (is_int($this->objet))
        {
            $objet = ObjetDAL::findById($this->objet);
            $this->objet = $objet;
        }
        else if (is_a($this->objet, "Objet"))
        {
            $objet = $this->objet;
        }
        return $objet;
    }
    
  //valeur
    public function setValeur($valeur)
    {
        if (is_double($valeur))
        {
            $this->valeur = $valeur;
        }
    }

    public function getValeur()
    {
        return $this->valeur;
    } 
    
  //annee
    public function setAnnee($annee)
    {
        if (is_int($annee))
        {
            $this->annee = $annee;
        }
    }

    public function getAnnee()
    {
        return $this->annee;
    }
}
