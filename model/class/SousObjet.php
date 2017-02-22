<?php

/*
 * Class SousObjet correspondant à la table sous_objet de la BDD
 * avec les attributs internes id, label, description
 * avec l'attribut externe objet(id)
 * @author Alexis BATTAGLI
 * @version 0.1
 * 
 * Cette class permet de gèrer les attributs de la table sous_objet
 * Ainsi que les méthodes lié aux manipulations sur ses attributs.
 * Cette classe représente les sous-objet possible pour un objet,
 *  permet d'affiner l'objet de l'ES.
 * 
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');

class SousObjet {
    
/* 
   ==============================
   ========= ATTRIBUTS ==========
   ============================== 
*/ 
    /*
     * Id du sous-objet dans la table sous_objet
     * @var int 
     */
    private $id;
    
    /*
     * Label du sous-objet
     * @var string
     */
    private $label;
    
    /*
     * Description du sous-objet
     * @var string
     */
    private $description;
    
    /*
     * Objet affiné par ce sous-sobjet
     * @var Objet
     */
    private $objet;
    
/* 
   ==============================
   ======== CONSTRUCTEUR ========
   ============================== 
*/ 

    /*
     * Constructeur par défaut de SousObjet
     */
    public function SousObjet($id = -1, $objet = null, $label = "Label Default", $description = "Aucune description pour ce sous-objet")
    {
    	if (is_null($objet))
        {
            $this->objet = new Objet();
        }
        else
        {
            $this->objet = $objet;
        }
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
     * Methodes d'hydratation d'un SousObjet
     * Utilisé le plus souvent lorsqeue l'on place le résultat d'une recherche en base 
     * dans un objet SousObjet créer par défaut
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
        $this->label = $dataSet['label'];
        $this->description = $dataSet['description'];
    } 
    
    /*
     * Méthode vérifiant à partir du label et de l'objet
     * qu'un sous-objet n'existe pas déjà en base
     * 
     * Retourne 0 si le couple(label, id_objet) existe déjà, sinon 1
     * 
     * @return int
     */
    public function isUnique()
    {
        $result=0; //par défaut on considère qu'il existe déjà
        $label = $this->getLabel();
        $objet = $this->getObjet();
        
        $sousobjet = SousObjetDAL::findByLO($label,$objet);
        
        if($sousobjet->getId()==-1) //s'il y a un id par défaut retourner
        {
            $result=1; //alors c'est qu'il existe pas
        }
        return $result;
    }
    
    /*
     * Regarde si le sous-objet est lié à des es
     * s'il l'est alors il n'est pas deletable, sinon il est deletable
     */
    public function isDeletable(){
    	$deletable = 0; //Par défaut le sous-objet n'est pas deletable
    	
    	$id = $this->getId();
    	$esLiees = EntreeSortieDAL::findBySousObjet($id);
    	
    	if(sizeof($esLiees)==0){
    		$deletable = 1;
    	}
    	return $deletable;
    }
    
    /*
     * Méthode permettant d'affichier les valeur de chaque attribut du sous-objet
     * Utile pour le debug
     */
    public function toString(){
    	echo "test tostring";
    	return "Caractéristique du sous-objet d'id ".$this->getId()."</br>"
    			. "label : ". $this->getLabel()."</br>"
    			. "description : ". $this->getDescription()."</br>"
    			. "Id de l'objet lié : ". $this->getObjet()->getId()."</br>";
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
}
