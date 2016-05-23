<?php

/*
 * Class Solde correspondant à la table solde de la BDD
 * avec les attributs interne id, valeur, date
 * avec les attributs externe compte(id)
 * @author Alexis BATTAGLI
 * @version 0.1
 * 
 * Cette class permet de gèrer les attributs de la table solde
 * Ainsi que les méthodes lié aux manipulations sur ses attributs.
 * Cette table permet de gèrer la sauvegarde de l'état des comptes
 * à une date donnée.
 */

class Solde {

/* 
   ==============================
   ========= ATTRIBUTS ==========
   ============================== 
*/ 
    /*
     * Id du solde dans la table solde
     * @var int 
     */
    private $id;
    
    /*
     * Valeur du solde
     * @var double
     */
    private $valeur;
    
    /*
     * Date de création de l'ajout du solde
     * @var date
     */
    private $date;
    
    /*
     * Compte associé au solde
     * @var Compte
     */
    private $compte;
    
/* 
   ==============================
   ======== CONSTRUCTEUR ========
   ============================== 
*/ 

    /*
     * Constructeur par défaut de Solde
     */
    public function Solde($id = -1, $compte = null, $valeur = 0, $date = "1994-03-08")
    {
        $this->id = $id;
        $this->compte = $compte;
        $this->valeur = $valeur;
        $this->date = $date;
    }

    /* 
   ==============================
   ========== METHODES ==========
   ============================== 
*/ 
  
    /*
     * Methodes d'hydratation d'un Solde
     * Utilisé le plus souvent lorsqeue l'on place le résultat d'une recherche en base 
     * dans un objet Solde créer par défaut
     * 
     * ATTENTION, les champs entre simple cote représente les nom de colonne dans la requête.
     * ex : dataSet contient une entrée en base de donnée avec les idifférents champs, 
     * pour accèder à la valeur contenue dans la colonne nommé attribut_1 il faut indiquer
     * dataSet['attribut_1']
     */
    public function hydrate($dataSet)
    {
        $this->id = $dataSet['id'];
        $this->compte = $dataSet['compte_id'];
        $this->valeur = $dataSet['valeur'];
        $this->date = $dataSet['date'];
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
    
  //date
    public function setDate($date)
    {
        if (is_string($date))
        {
            $this->date = $date;
        }
    }

    public function getDate()
    {
        return $this->date;
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

  //compte
    public function setCompte($compte)
    {
        if (is_string($compte))
        {
            $compte = (int) $compte;
            $this->compte = CompteDAL::findById($compte);
        }
        else if (is_int($compte))
        {
            $this->compte = CompteDAL::findById($compte);
        }
        else if (is_a($compte, "Compte"))
        {
            $this->compte = $compte;
        }
    }

    public function getCompte()
    {
        $compte = null;
        if (is_int($this->compte))
        {
            $compte = CompteDAL::findById($this->compte);
            $this->compte = $compte;
        }
        else if (is_a($this->compte, "Compte"))
        {
            $compte = $this->compte;
        }
        return $compte;
    }    
    
}
