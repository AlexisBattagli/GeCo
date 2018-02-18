<?php

/*
 * Classe EntreeSortie correspondant à la table entree_sortie de la bdd
 * avec les attributs interne id, valeur, es, information, date
 * avec les attributs externe etiquettes(id), compte(id), lieu(id), objet(id)
 * 
 * @author: Alexis BATTAGLI
 * @version 0.3
 *  Histo:
 *      0.2 - Ajout de sous_objet dans la table entre_sortie
 *      0.3 - Ajout de l'attribut "Payement" avec ces getter/setter, dans hydrat et constructeur
 *
 * Cette class permet de gèrer l'ensemble des attributs d'une ES,
 * ainsi que faire des opération sur les ES
 */

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Lieu.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/LieuDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Objet.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Etiquette.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EtiquetteDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Compte.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/CompteDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Payement.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/PayementDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/SousObjet.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/SousObjetDAL.php');

class EntreeSortie {
    /*
      ==============================
      ========= ATTRIBUTS ==========
      ==============================
     */
    /*
     * Id de l'es dans la table entree_sortie
     * @var int
     */

    private $id;

    /*
     * Somme débiter ou créditer
     * @var double
     */
    private $valeur;

    /*
     * Entrée (E) | Sortie (S)
     * @var string
     */
    private $es;

    /*
     * Détail sur l'entrée/sortie
     * @var string
     */
    private $information;

    /*
     * Date de l'opération
     * @var string
     */
    private $date;

    /*
     * Lieu où a été faite l'es
     * @var Lieu
     */
    private $lieu;

    /*
     * Objet de l'es (la raison)
     * @var Objet
     */
    private $objet;

    /*
     * Compte affecter par l'es
     * @var Compte
     */
    private $compte;

    /*
     * Evenement liier à l'es
     * @var Etiquette
     */
    private $etiquette;

    /*
     * Complément de l'Objet de l'ES
     * @var SousObjet
     */
    private $sousObjet;

    /*
     * Moyen de Payement de l'ES
     * @var Payement
     */
    private $payement;

    /*
      ==============================
      ======== CONSTRUCTEUR ========
      ==============================
     */

    /*
     * Constructeur par défaut d'EntreeSortie
     */

    public function EntreeSortie($id = -1, $valeur = 0, $es = "e", $information = "Aucune information renseignée pour cette ES", $date = "1994-03-08", $lieu = null, $objet = null, $compte = null, $etiquette = null, $sousObjet = null, $payement = null)
    {
        $this->id = $id;
        $this->valeur = $valeur;
        $this->es = $es;
        $this->information = $information;
        $this->date = $date;
        if (is_null($lieu))
        {
			$this->lieu = new Lieu();
        }
        else
        {
            $this->lieu = $lieu;
        }

        if (is_null($objet))
        {
            $this->objet = new Objet();
        }
        else
        {
            $this->objet = $objet;
        }

        if (is_null($compte))
        {
            $this->compte = new Compte();
        }
        else
        {
            $this->compte = $compte;
        }

        if (is_null($etiquette))
        {
            $this->etiquette = new Etiquette();
        }
        else
        {
            $this->etiquette = $etiquette;
        }

        if (is_null($sousObjet))
        {
            $this->sousObjet = new SousObjet();
        }
        else
        {
            $this->sousObjet = $sousObjet;
        }

        if (is_null($payement))
        {
            $this->payement = new Payement();
        }
        else
        {
            $this->payement = $payement;
        }
    }

    /*
      ==============================
      ========== METHODES ==========
      ==============================
     */

    /*
     * Methodes d'hydratation d'une ES
     * Utilisé le plus souvent lorsqeue l'on place le résultat d'une recherche en base 
     * dans un objet EntreeSortie créer par défaut
     * 
     * ATTENTION, les champs entre simple cote représente les nom de colonne dans la requête.
     * ex : dataSet contient une entrée en base de donnée avec les idifférents champs, 
     * pour accèder à la valeur contenue dans la colonne nommé attribut_1 il faut indiquer
     * dataSet['attribut_1']
     */

    public function hydrate($dataSet)
    {
        $this->id = $dataSet['id'];
        $this->valeur = $dataSet['valeur'];
        $this->es = $dataSet['es'];
        $this->information = $dataSet['information'];
        $this->date = $dataSet['date'];
        $this->lieu = $dataSet['lieu_id'];
        $this->objet = $dataSet['objet_id'];
        $this->compte = $dataSet['compte_id'];
        $this->etiquette = $dataSet['etiquette_id'];
        $this->sousObjet = $dataSet['sous_objet_id'];
        $this->payement = $dataSet['payement_id'];
    }

    public function getMois()
    {
    	$date = $this->getDate();
    	$datePars = explode('-', $date);    	
    	return $datePars[1];
    }
    
    public function getAnnee()
    {
    	$date = $this->getDate();
    	$datePars = explode('-', $date);
    	return $datePars[0];
    }
    
    /*
     * Indique si une es est une sorti (true) ou pas (false)
     */
    public function isS(){
    	return $this->getEs()=='S';
    }
    
    /*
     * Indique si une es est une entrée (true) ou pas (false)
     */
    public function isE(){
    	return $this->getEs()=='E';
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

    //es
    public function setEs($es)
    {
        if (is_string($es))
        {
            $this->es = $es;
        }
    }

    public function getEs()
    {
        return $this->es;
    }

    //etiquette
    public function setEtiquette($etiquette)
    {
        if (is_string($etiquette))
        {
            $etiquette = (int) $etiquette;
            $this->etiquette = EtiquetteDAL::findById($etiquette);
        }
        else if (is_int($etiquette))
        {
            $this->etiquette = EtiquetteDAL::findById($etiquette);
        }
        else if (is_a($etiquette, "Etiquette"))
        {
            $this->etiquette = $etiquette;
        }
    }

    public function getEtiquette()
    {
        $etiquette = null;
        if (is_int($this->etiquette))
        {
            $etiquette = EtiquetteDAL::findById($this->etiquette);
            $this->etiquette = $etiquette;
        }
        else if (is_a($this->etiquette, "Etiquette"))
        {
            $etiquette = $this->etiquette;
        }
        return $etiquette;
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

    //lieu
    public function setLieu($lieu)
    {
        if (is_string($lieu))
        {
            $lieu = (int) $lieu;
            $this->lieu = LieuDAL::findById($lieu);
        }
        else if (is_int($lieu))
        {
            $this->lieu = LieuDAL::findById($lieu);
        }
        else if (is_a($lieu, "Lieu"))
        {
            $this->lieu = $lieu;
        }
    }

    public function getLieu()
    {
        $lieu = null;
        if (is_int($this->lieu))
        {
            $lieu = LieuDAL::findById($this->lieu);
            $this->lieu = $lieu;
        }
        else if (is_a($this->lieu, "Lieu"))
        {
            $lieu = $this->lieu;
        }
        return $lieu;
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

    //sous_objet
    public function setSousObjet($sousObjet)
    {
        if (is_string($sousObjet))
        {
            $sousObjet = (int) $sousObjet;
            $this->sousObjet = SousObjetDAL::findById($sousObjet);
        }
        else if (is_int($sousObjet))
        {
            $this->sousObjet = SousObjetDAL::findById($sousObjet);
        }
        else if (is_a($sousObjet, "SousObjet"))
        {
            $this->sousObjet = $sousObjet;
        }
    }

    public function getSousObjet()
    {
        $sousObjet = null;
        if (is_int($this->sousObjet))
        {
            $sousObjet = SousObjetDAL::findById($this->sousObjet);
            $this->sousObjet = $sousObjet;
        }
        else if (is_a($this->sousObjet, "SousObjet"))
        {
            $sousObjet = $this->sousObjet;
        }
        return $sousObjet;
    }
    
   //payement
    public function setPayement($payement)
    {
        if (is_string($payement))
        {
            $payement = (int) $payement;
            $this->payement = PayementDAL::findById($payement);
        }
        else if (is_int($payement))
        {
            $this->payement = PayementDAL::findById($payement);
        }
        else if (is_a($payement, "Payement"))
        {
            $this->payement = $payement;
        }
    }

    public function getPayement()
    {
        $payement = null;
        if (is_int($this->payement))
        {
            $payement = PayementDAL::findById($this->payement);
            $this->payement = $payement;
        }
        else if (is_a($this->payement, "Payement"))
        {
            $payement = $this->payement;
        }
        return $payement;
    }

}
