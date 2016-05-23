<?php

/*
 * Class Etiquette correspondant à la table etiquette de la BDD
 * avec les attributs internes id, label, description
 * avec aucun attributs externe
 * @author Alexis BATTAGLI
 * @version 0.1
 * 
 * Cette class permet de gèrer les attributs de la table etiquette
 * Ainsi que les méthodes lié aux manipulations sur ses attributs.
 * Cette classe représente l'événement lié à une ES
 */

class Etiquette {
    /*
      ==============================
      ========= ATTRIBUTS ==========
      ==============================
     */
    /*
     * Id de l'etiquette dans la table etiquette
     * @var int 
     */

    private $id;

    /*
     * Label de l'étiquette
     * @var string
     */
    private $label;

    /*
     * Description de l'étiquette
     * @var string
     */
    private $description;

    /*
      ==============================
      ======== CONSTRUCTEUR ========
      ==============================
     */

    /*
     * Constructeur par défaut de Etiquette
     */

    public function Etiquette($id = -1, $label = "Label de l'etiquette par défaut.", $description = "Aucune description renseignée pour cette etiquette")
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
     * Methodes d'hydratation d'une Etiquette
     * Utilisé le plus souvent lorsqeue l'on place le résultat d'une recherche en base 
     * dans un objet Etiquette créer par défaut
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
