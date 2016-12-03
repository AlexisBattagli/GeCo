<?php

/*
 * Class Compte correspondant à la table compte de la BDD
 * avec les attributs internes id, label, banque, information
 * avec aucun attributs externe
 * @author Alexis BATTAGLI
 * @version 0.2
 *  Histo:
 *      0.2 - Ajout de l'attribut identifiant
 * 
 * Cette class permet de gèrer les attributs de la table comtpte
 * Ainsi que les méthodes lié aux manipulations sur ses attributs
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/SoldeDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');

class Compte {
    /*
      ==============================
      ========= ATTRIBUTS ==========
      ==============================
     */
    /*
     * Id du compte dans la table compte
     * @var int 
     */

    private $id;

    /*
     * Label du compte 
     * @var string
     */
    private $label;

    /*
     * Banque où ce trouve le compte
     * @var string
     */
    private $banque;

    /*
     * Information sur le compte
     * @var string
     */
    private $information;

    /*
     * Numéro d'identification du Compte
     * @var string
     */
    private $identifiant;

    /*
      ==============================
      ======== CONSTRUCTEUR ========
      ==============================
     */

    /*
     * Constructeur par défaut de Compte
     */

    public function Compte($id = -1, $label = "Label du Compte par défaut.", $banque = "Ce compte n'est placé dans aucune banque.", $information = "Aucune information renseignée pour ce compte", $identifiant = "0000")
    {
        $this->id = $id;
        $this->label = $label;
        $this->banque = $banque;
        $this->information = $information;
        $this->identifiant = $identifiant;
    }

    /*
      ==============================
      ========== METHODES ==========
      ==============================
     */

    /*
     * Methodes d'hydratation d'un Compte
     * Utilisé le plus souvent lorsqeue l'on place le résultat d'une recherche en base 
     * dans un objet Compte créer par défaut
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
        $this->banque = $dataSet['banque'];
        $this->information = $dataSet['information'];
        $this->identifiant = $dataSet['identifiant'];
    }

    /*
     * Méthode vérifiant à partir du label et de la banque 
     * qu'un compte n'existe pas déjà en base
     * 
     * Retourne 0 si le couple Label/Banque existe déjà, sinon 1
     * 
     * @return int
     */

    public function isUnique()
    {
        $result = 0; //par défaut on considère qu'il existe déjà
        $label = $this->getLabel();
        $banque = $this->getBanque();
        
        $compte = CompteDAL::findByLB($label,$banque);
        if($compte->getId()==-1) //s'il y a un id par défaut retourner
        {
            $result=1; //alors c'est qu'il existe pas
        }
        return $result;
    }
    
    /*
     * Regarde si le compte est lié à des es
     * s'il l'est alors il n'est pas deletable, sinon il est deletable
     */
    public function isDeletable(){
    	$deletable = 0; //Par défaut le sous-objet n'est pas deletable
    	 
    	$id = $this->getId();
    	$esLiees = EntreeSortieDAL::findByCompte($id);
    	 
    	if(sizeof($esLiees)==0){
    		$deletable = 1;
    	}
    	return $deletable;
    }

    /*
     * Méthode qui retourne le solde actuel du compte
     * 
     * @return double
     */

    public function getSolde()
    {
        $valeur = 0;
        $idCompte = $this->getId();
        $solde = SoldeDAL::findByCompte($idCompte); //recupre le solde avec la date la plus haute, pour un cmpte donnée
        if (is_null($solde))
        {
            $valeur = null;
        }
        else
        {
            $valeur = $solde->getValeur();
        }
        return $valeur;
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

    //banque
    public function setBanque($banque)
    {
        if (is_string($banque))
        {
            $this->banque = $banque;
        }
    }

    public function getBanque()
    {
        return $this->banque;
    }

    //information
    public function setInformation($information)
    {
        if (is_string($information))
        {
            $this->information = $information;
        }
    }

    public function getInformation()
    {
        return $this->information;
    }

    //identifiant
    public function setIdentifiant($identifiant)
    {
        if (is_string($identifiant))
        {
            $this->identifiant = $identifiant;
        }
    }

    public function getIdentifiant()
    {
        return $this->identifiant;
    }

}
