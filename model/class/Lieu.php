<?php

/*
 * Class Lieu correspondant à la table lieu de la BDD
 * avec les attributs internes id, pays, ville
 * avec aucun attributs externe
 * @author Alexis BATTAGLI
 * @version 0.1
 * 
 * Cette class permet de gèrer les attributs de la table lieu
 * Ainsi que les méthodes lié aux manipulations sur ses attributs.
 * Cette classe représente le lieu où a été réalisé une ES
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');

class Lieu {
/* 
   ==============================
   ========= ATTRIBUTS ==========
   ============================== 
*/ 
    /*
     * Id du lieu dans la table lieu
     * @var int 
     */
    private $id;
    
    /*
     * Pays du lieu
     * @var string
     */
    private $pays;
    
    /*
     * Ville du lieu
     * @var string
     */
    private $ville;
    
/* 
   ==============================
   ======== CONSTRUCTEUR ========
   ============================== 
*/ 

    /*
     * Constructeur par défaut de Lieu
     */
    public function Lieu($id= -1, $pays= "NoWhere", $ville= "NoWhere")
    {
        $this->id = $id;
        $this->pays = $pays;
        $this->ville = $ville;
    }
    
/* 
   ==============================
   ========== METHODES ==========
   ============================== 
*/ 
  
    /*
     * Methodes d'hydratation d'une Lieu
     * Utilisé le plus souvent lorsqeue l'on place le résultat d'une recherche en base 
     * dans un objet Lieu créer par défaut
     * 
     * ATTENTION, les champs entre simple cote représente les nom de colonne dans la requête.
     * ex : dataSet contient une entrée en base de donnée avec les idifférents champs, 
     * pour accèder à la valeur contenue dans la colonne nommé attribut_1 il faut indiquer
     * dataSet['attribut_1']
     */
    public function hydrate($dataSet)
    {
        $this->id = $dataSet['id'];
        $this->pays = $dataSet['pays'];
        $this->ville = $dataSet['ville'];
    }
    
    /*
     * Méthode vérifiant à partir de la ville et du pays
     * qu'un lieu n'existe pas déjà en base
     * 
     * Retourne 0 si le couple Pays;Ville existe déjà, sinon 1
     * 
     * @return int
     */
    public function isUnique()
    {
        $result=0; //par défaut on considère qu'il existe déjà
        $pays = $this->getPays();
        $ville = $this->getVille();
        
        $lieu = LieuDAL::findByPV($pays,$ville);
        if($lieu->getId()==-1) //s'il y a un id par défaut retourner
        {
            $result=1; //alors c'est qu'il existe pas
        }
        return $result;
    }
    
    /*
     * Regarde si le lieu est lié à des es
     * s'il l'est alors il n'est pas deletable, sinon il est deletable
     */
    public function isDeletable(){
    	$deletable = 0; //Par défaut le sous-objet n'est pas deletable
    	 
    	$id = $this->getId();
    	$esLiees = EntreeSortieDAL::findByLieu($id);
    	 
    	if(sizeof($esLiees)==0){
    		$deletable = 1;
    	}
    	return $deletable;
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
    
  //pays
    public function setPays($pays)
    {
        if (is_string($pays))
        {
            $this->pays = $pays;
        }
    }

    public function getPays()
    {
        return $this->pays;
    }   

  //Ville
    public function setVille($ville)
    {
        if (is_string($ville))
        {
            $this->ville = $ville;
        }
    }

    public function getVille()
    {
        return $this->ville;
    }       
}
