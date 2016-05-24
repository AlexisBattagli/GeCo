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
    public function Objet($id= -1, $label= "Label de l'etiquette par défaut.", $description= "Aucune description renseignée pour cette etiquette")
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