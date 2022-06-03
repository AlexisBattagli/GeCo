<?php

/*
 * Class Payement correspondant à la table payement de la BDD
 * avec les attributs internes id et moyen
 * avec aucun attributs externe
 * @author Alexis BATTAGLI
 * @version 0.1
 * 
 * Cette class permet de gèrer les attributs de la table payement
 * Ainsi que les méthodes lié aux manipulations sur ses attributs.
 * Cette classe représente le moyen de payement utilisé pour une ES
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');

class Payement {
    /*
      ==============================
      ========= ATTRIBUTS ==========
      ==============================
     */
    /*
     * Id du moyen de payement dans la table payement
     * @var int 
     */

    private $id;

    /*
     * Moyen du Payement
     * @var string
     */
    private $moyen;

    /*
      ==============================
      ======== CONSTRUCTEUR ========
      ==============================
     */

    /*
     * Constructeur par défaut de Payement
     */

    public function __construct($id = -1, $moyen = "Moyen non définie...")
    {
        $this->id = $id;
        $this->moyen = $moyen;
    }

    /*
      ==============================
      ========== METHODES ==========
      ==============================
     */

    /*
     * Methodes d'hydratation d'un moyen de Payement
     * Utilisé le plus souvent lorsqeue l'on place le résultat d'une recherche en base 
     * dans un objet Payement créer par défaut
     * 
     * ATTENTION, les champs entre simple cote représente les nom de colonne dans la requête.
     * ex : dataSet contient une entrée en base de donnée avec les idifférents champs, 
     * pour accèder à la valeur contenue dans la colonne nommé attribut_1 il faut indiquer
     * dataSet['attribut_1']
     */

    public function hydrate($dataSet)
    {
        $this->id = $dataSet['id'];
        $this->moyen = $dataSet['moyen'];
    }

    /*
     * Méthode vérifiant à partir du moyen
     * qu'un Payement n'existe pas déjà en base
     * 
     * Retourne 0 si le moyen existe déjà, sinon 1
     * 
     * @return int
     */

    public function isUnique()
    {
        $result = 0; //par défaut on considère qu'il existe déjà
        $moyen = $this->getMoyen();

        $payement = PayementDAL::findByMoyen($moyen);
        if ($payement->getId() == -1) //s'il y a un id par défaut retourner
        {
            $result = 1; //alors c'est qu'il existe pas
        }
        return $result;
    }
    
    /*
     * Regarde si le payement est lié à des es
     * s'il l'est alors il n'est pas deletable, sinon il est deletable
     */
    public function isDeletable(){
    	$deletable = 0; //Par défaut le payement n'est pas deletable
    	 
    	$id = $this->getId();
    	$esLiees = EntreeSortieDAL::findByPayement($id);
    	 
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

    //moyen
    public function setMoyen($moyen)
    {
        if (is_string($moyen))
        {
            $this->moyen = $moyen;
        }
    }

    public function getMoyen()
    {
        return $this->moyen;
    }

}
