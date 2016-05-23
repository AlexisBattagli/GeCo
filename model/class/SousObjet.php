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
            $this->objet = ObjetDAL::findDefaultObjet();
        }
        else
        {
            $this->objet = $objet;
        }
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
    protected function hydrate($dataSet)
    {
        $this->id = $dataSet['id'];
        $this->objet = $dataSet['objet_id'];
        $this->label = $dataSet['label'];
        $this->description = $dataSet['description'];
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
