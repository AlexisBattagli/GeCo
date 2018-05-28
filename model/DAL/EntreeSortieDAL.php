<?php

/**
 * La class EntreeSortieDAL hérite de la class EntreeSortie.
 * Elle possède donc tous ces attributs et méthodes
 *
 * @author Alexis
 * @version 0.3
 *  Histo:
 *      0.2 - Ajout de sous_objet dans la table entre_sortie
 *      0.3 - Ajout de l'attribut externe Payement
 * 
 * Cette class permet de faire,
 * recherche, ajout, modification et suppression d'ES en base.
 */

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

require_once('BaseSingleton.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/EntreeSortie.php');

class EntreeSortieDAL {
    /*
     * Retourne l'ES correspondant à l'id donnée
     * 
     * @param int $id Identifiant de l'es à trouver
     * @return EntreeSortie
     */

    public static function findById($id)
    {
        $data = BaseSingleton::select('SELECT entree_sortie.id as id, '
                        . 'entree_sortie.valeur as valeur, '
                        . 'entree_sortie.es as es, '
                        . 'entree_sortie.information as information, '
                        . 'entree_sortie.date as date, '
                        . 'entree_sortie.lieu_id as lieu_id, '
                        . 'entree_sortie.objet_id as objet_id, '
                        . 'entree_sortie.compte_id as compte_id, '
                        . 'entree_sortie.etiquette_id as etiquette_id, '
                        . 'entree_sortie.sous_objet_id as sous_objet_id, '
                        . 'entree_sortie.payement_id as payement_id '
                        . ' FROM entree_sortie'
                        . ' WHERE entree_sortie.id = ?', array('i', &$id));
        
        $entreeSortie = new EntreeSortie();
        if (sizeof($data) > 0)
        {
            $entreeSortie->hydrate($data[0]);
        }
        else
        {
            $entreeSortie = null;
        }
        return $entreeSortie;
    }
    
    /*
     * Retourne un tableau d'ES lié à un sous-objet défini par son ID
     * 
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */
    public static function findBySousObjet($sousObjetId){
    	
    	$mesES = array();
    	
    	$data = BaseSingleton::select('SELECT entree_sortie.id as id, '
                        . 'entree_sortie.valeur as valeur, '
                        . 'entree_sortie.es as es, '
                        . 'entree_sortie.information as information, '
                        . 'entree_sortie.date as date, '
                        . 'entree_sortie.lieu_id as lieu_id, '
                        . 'entree_sortie.objet_id as objet_id, '
                        . 'entree_sortie.compte_id as compte_id, '
                        . 'entree_sortie.etiquette_id as etiquette_id, '
                        . 'entree_sortie.sous_objet_id as sous_objet_id, '
                        . 'entree_sortie.payement_id as payement_id '
                        . ' FROM entree_sortie'
                        . ' WHERE entree_sortie.sous_objet_id = ?', array('i', &$sousObjetId));
    	
    	foreach ($data as $row)
        {
            $entreeSortie = new EntreeSortie();
            $entreeSortie->hydrate($row);
            $mesES[] = $entreeSortie;
        }

        return $mesES;
    }
    
    /*
     * Retourne un tableau d'ES lié à un sous-objet défini par son ID sur un interval de temps donné
     *
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */
    public static function findBySousObjetByTime($sousObjetId, $dateDebut, $dateFin){
    	 
    	$mesES = array();
    	 
    	$data = BaseSingleton::select('SELECT entree_sortie.id as id, '
    			. 'entree_sortie.valeur as valeur, '
    			. 'entree_sortie.es as es, '
    			. 'entree_sortie.information as information, '
    			. 'entree_sortie.date as date, '
    			. 'entree_sortie.lieu_id as lieu_id, '
    			. 'entree_sortie.objet_id as objet_id, '
    			. 'entree_sortie.compte_id as compte_id, '
    			. 'entree_sortie.etiquette_id as etiquette_id, '
    			. 'entree_sortie.sous_objet_id as sous_objet_id, '
    			. 'entree_sortie.payement_id as payement_id '
    			. ' FROM entree_sortie'
    			. ' WHERE entree_sortie.sous_objet_id = ?'
    			. '  AND entree_sortie.date BETWEEN ? AND ?', array('iss', &$sousObjetId, &$dateDebut, &$dateFin));
    	 
    	foreach ($data as $row)
    	{
    		$entreeSortie = new EntreeSortie();
    		$entreeSortie->hydrate($row);
    		$mesES[] = $entreeSortie;
    	}
    
    	return $mesES;
    }
    
    /*
     * Retourne un tableau d'ES lié à un objet défini par son ID
     *
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */
    public static function findByObjet($objetId){
    	 
    	$mesES = array();
    	 
    	$data = BaseSingleton::select('SELECT entree_sortie.id as id, '
    			. 'entree_sortie.valeur as valeur, '
    			. 'entree_sortie.es as es, '
    			. 'entree_sortie.information as information, '
    			. 'entree_sortie.date as date, '
    			. 'entree_sortie.lieu_id as lieu_id, '
    			. 'entree_sortie.objet_id as objet_id, '
    			. 'entree_sortie.compte_id as compte_id, '
    			. 'entree_sortie.etiquette_id as etiquette_id, '
    			. 'entree_sortie.sous_objet_id as sous_objet_id, '
    			. 'entree_sortie.payement_id as payement_id '
    			. ' FROM entree_sortie'
    			. ' WHERE entree_sortie.objet_id = ?', array('i', &$objetId));
    	 
    	foreach ($data as $row)
    	{
    		$entreeSortie = new EntreeSortie();
    		$entreeSortie->hydrate($row);
    		$mesES[] = $entreeSortie;
    	}
    
    	return $mesES;
    }
    
    /*
     * Retourne un tableau de Sortie liées à un compte défini par son ID sur un temps donné
     *
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */
    public static function findSByCompteByTime($debut, $fin, $compteId){
    
    	$mesES = array();
    
    	$data = BaseSingleton::select('SELECT entree_sortie.id as id, '
    			. 'entree_sortie.valeur as valeur, '
    			. 'entree_sortie.es as es, '
    			. 'entree_sortie.information as information, '
    			. 'entree_sortie.date as date, '
    			. 'entree_sortie.lieu_id as lieu_id, '
    			. 'entree_sortie.objet_id as objet_id, '
    			. 'entree_sortie.compte_id as compte_id, '
    			. 'entree_sortie.etiquette_id as etiquette_id, '
    			. 'entree_sortie.sous_objet_id as sous_objet_id, '
    			. 'entree_sortie.payement_id as payement_id '
    			. ' FROM entree_sortie'
    			. ' WHERE entree_sortie.compte_id = ?'
    			. ' AND entree_sortie.date BETWEEN ? AND ?'
    			. ' AND entree_sortie.es = "S"', array('iss', &$compteId, &$debut, &$fin));
    
    	foreach ($data as $row)
    	{
    		$entreeSortie = new EntreeSortie();
    		$entreeSortie->hydrate($row);
    		$mesES[] = $entreeSortie;
    	}
    
    	return $mesES;
    }
    
    /*
     * Retourne un tableau de Sortie liées à un compte défini par son ID sur un temps donné
     *
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */
    public static function findEByCompteByTime($debut, $fin, $compteId){
    
    	$mesES = array();
    
    	$data = BaseSingleton::select('SELECT entree_sortie.id as id, '
    			. 'entree_sortie.valeur as valeur, '
    			. 'entree_sortie.es as es, '
    			. 'entree_sortie.information as information, '
    			. 'entree_sortie.date as date, '
    			. 'entree_sortie.lieu_id as lieu_id, '
    			. 'entree_sortie.objet_id as objet_id, '
    			. 'entree_sortie.compte_id as compte_id, '
    			. 'entree_sortie.etiquette_id as etiquette_id, '
    			. 'entree_sortie.sous_objet_id as sous_objet_id, '
    			. 'entree_sortie.payement_id as payement_id '
    			. ' FROM entree_sortie'
    			. ' WHERE entree_sortie.compte_id = ?'
    			. ' AND entree_sortie.date BETWEEN ? AND ?'
    			. ' AND entree_sortie.es = "E"', array('iss', &$compteId, &$debut, &$fin));
    
    	foreach ($data as $row)
    	{
    		$entreeSortie = new EntreeSortie();
    		$entreeSortie->hydrate($row);
    		$mesES[] = $entreeSortie;
    	}
    
    	return $mesES;
    }
    
    
    /*
     * Retourne un tableau de Sortie liées à un objet défini par son ID sur un temps donné
     *
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */
    public static function findSByObjetByTime($debut, $fin, $objetId){
    
    	$mesES = array();
    
    	$data = BaseSingleton::select('SELECT entree_sortie.id as id, '
    			. 'entree_sortie.valeur as valeur, '
    			. 'entree_sortie.es as es, '
    			. 'entree_sortie.information as information, '
    			. 'entree_sortie.date as date, '
    			. 'entree_sortie.lieu_id as lieu_id, '
    			. 'entree_sortie.objet_id as objet_id, '
    			. 'entree_sortie.compte_id as compte_id, '
    			. 'entree_sortie.etiquette_id as etiquette_id, '
    			. 'entree_sortie.sous_objet_id as sous_objet_id, '
    			. 'entree_sortie.payement_id as payement_id '
    			. ' FROM entree_sortie'
    			. ' WHERE entree_sortie.objet_id = ?'
    			. ' AND entree_sortie.date BETWEEN ? AND ?'
    			. ' AND entree_sortie.es = "S"', array('iss', &$objetId, &$debut, &$fin));
    
    	foreach ($data as $row)
    	{
    		$entreeSortie = new EntreeSortie();
    		$entreeSortie->hydrate($row);
    		$mesES[] = $entreeSortie;
    	}
    
    	return $mesES;
    }
    
    /*
     * Retourne un tableau d'Entrée lié à un objet défini par son ID sur un temps donné
     *
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */
    public static function findEByObjetByTime($debut, $fin, $objetId){
    
    	$mesES = array();
    
    	$data = BaseSingleton::select('SELECT entree_sortie.id as id, '
    			. 'entree_sortie.valeur as valeur, '
    			. 'entree_sortie.es as es, '
    			. 'entree_sortie.information as information, '
    			. 'entree_sortie.date as date, '
    			. 'entree_sortie.lieu_id as lieu_id, '
    			. 'entree_sortie.objet_id as objet_id, '
    			. 'entree_sortie.compte_id as compte_id, '
    			. 'entree_sortie.etiquette_id as etiquette_id, '
    			. 'entree_sortie.sous_objet_id as sous_objet_id, '
    			. 'entree_sortie.payement_id as payement_id '
    			. ' FROM entree_sortie'
    			. ' WHERE entree_sortie.objet_id = ?'
    			. ' AND entree_sortie.date BETWEEN ? AND ?'
    			. ' AND entree_sortie.es = "E"', array('iss', &$objetId, &$debut, &$fin));
    
    	foreach ($data as $row)
    	{
    		$entreeSortie = new EntreeSortie();
    		$entreeSortie->hydrate($row);
    		$mesES[] = $entreeSortie;
    	}
    
    	return $mesES;
    }
    
    /*
     * Retourne un tableau d'ES lié à un lieu défini par son ID
     *
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */
    public static function findByLieu($lieuId){
    
    	$mesES = array();
    
    	$data = BaseSingleton::select('SELECT entree_sortie.id as id, '
    			. 'entree_sortie.valeur as valeur, '
    			. 'entree_sortie.es as es, '
    			. 'entree_sortie.information as information, '
    			. 'entree_sortie.date as date, '
    			. 'entree_sortie.lieu_id as lieu_id, '
    			. 'entree_sortie.objet_id as objet_id, '
    			. 'entree_sortie.compte_id as compte_id, '
    			. 'entree_sortie.etiquette_id as etiquette_id, '
    			. 'entree_sortie.sous_objet_id as sous_objet_id, '
    			. 'entree_sortie.payement_id as payement_id '
    			. ' FROM entree_sortie'
    			. ' WHERE entree_sortie.lieu_id = ?', array('i', &$lieuId));
    
    	foreach ($data as $row)
    	{
    		$entreeSortie = new EntreeSortie();
    		$entreeSortie->hydrate($row);
    		$mesES[] = $entreeSortie;
    	}
    
    	return $mesES;
    }
    
    /*
     * Retourne un tableau d'ES lié à un compte défini par son ID
     *
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */
    public static function findByCompte($compteId){
    
    	$mesES = array();
    
    	$data = BaseSingleton::select('SELECT entree_sortie.id as id, '
    			. 'entree_sortie.valeur as valeur, '
    			. 'entree_sortie.es as es, '
    			. 'entree_sortie.information as information, '
    			. 'entree_sortie.date as date, '
    			. 'entree_sortie.lieu_id as lieu_id, '
    			. 'entree_sortie.objet_id as objet_id, '
    			. 'entree_sortie.compte_id as compte_id, '
    			. 'entree_sortie.etiquette_id as etiquette_id, '
    			. 'entree_sortie.sous_objet_id as sous_objet_id, '
    			. 'entree_sortie.payement_id as payement_id '
    			. ' FROM entree_sortie'
    			. ' WHERE entree_sortie.compte_id = ?', array('i', &$compteId));
    	
    	foreach ($data as $row)
    	{
    		$entreeSortie = new EntreeSortie();
    		$entreeSortie->hydrate($row);
    		$mesES[] = $entreeSortie;
    	}
    	return $mesES;
    }
    
    /*
     * Retourne un tableau d'ES lié à un payement défini par son ID
     *
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */
    public static function findByPayement($payementId){
    
    	$mesES = array();
    
    	$data = BaseSingleton::select('SELECT entree_sortie.id as id, '
    			. 'entree_sortie.valeur as valeur, '
    			. 'entree_sortie.es as es, '
    			. 'entree_sortie.information as information, '
    			. 'entree_sortie.date as date, '
    			. 'entree_sortie.lieu_id as lieu_id, '
    			. 'entree_sortie.objet_id as objet_id, '
    			. 'entree_sortie.compte_id as compte_id, '
    			. 'entree_sortie.etiquette_id as etiquette_id, '
    			. 'entree_sortie.sous_objet_id as sous_objet_id, '
    			. 'entree_sortie.payement_id as payement_id '
    			. ' FROM entree_sortie'
    			. ' WHERE entree_sortie.payement_id = ?', array('i', &$payementId));
    
    	foreach ($data as $row)
    	{
    		$entreeSortie = new EntreeSortie();
    		$entreeSortie->hydrate($row);
    		$mesES[] = $entreeSortie;
    	}
    
    	return $mesES;
    }
    
    /*
     * Retourne un tableau d'entree et sortie, compris dans un intervalle de temps donné en paramètre
     * 
     * @return array[EntreeSortie]
     */
    public static function findByIntervalDate($startingDate, $endingDate)
    {
    	$mesES = array();
    	
    	$data = BaseSingleton::select('SELECT entree_sortie.id as id, '
    			. 'entree_sortie.valeur as valeur, '
    			. 'entree_sortie.es as es, '
    			. 'entree_sortie.information as information, '
    			. 'entree_sortie.date as date, '
    			. 'entree_sortie.lieu_id as lieu_id, '
    			. 'entree_sortie.objet_id as objet_id, '
    			. 'entree_sortie.compte_id as compte_id, '
    			. 'entree_sortie.etiquette_id as etiquette_id, '
    			. 'entree_sortie.sous_objet_id as sous_objet_id, '
    			. 'entree_sortie.payement_id as payement_id '
    			. ' FROM entree_sortie'
    			. ' WHERE date BETWEEN ? and ?'
    			. ' ORDER BY date ASC', array('ss', &$startingDate, &$endingDate));

    	foreach ($data as $row){
    		$entreeSortie = new EntreeSortie();
    		$entreeSortie->hydrate($row);
    		$mesES[] = $entreeSortie;
    	}
    	
    	return $mesES;
    }

    /*
     * Retourne l'ensemble des ES qui sont en base
     * 
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */

    public static function findAll()
    {
        $mesES = array();

        $data = BaseSingleton::select('SELECT entree_sortie.id as id, '
                        . 'entree_sortie.valeur as valeur, '
                        . 'entree_sortie.es as es, '
                        . 'entree_sortie.information as information, '
                        . 'entree_sortie.date as date, '
                        . 'entree_sortie.lieu_id as lieu_id, '
                        . 'entree_sortie.objet_id as objet_id, '
                        . 'entree_sortie.compte_id as compte_id, '
                        . 'entree_sortie.etiquette_id as etiquette_id, '
                        . 'entree_sortie.sous_objet_id as sous_objet_id, '
                        . 'entree_sortie.payement_id as payement_id '
                        . ' FROM entree_sortie');

        foreach ($data as $row)
        {
            $entreeSortie = new EntreeSortie();
            $entreeSortie->hydrate($row);
            $mesES[] = $entreeSortie;
        }

        return $mesES;
    }
    
    /**
     * Liste les année où il y a des ES
     */
    public static function listAnnees(){
    	$annees = array();
    	$annees = null;
    	$data = BaseSingleton::select('SELECT YEAR(entree_sortie.date) as annee 
    									FROM entree_sortie 
    									GROUP BY annee;');
    	
    	foreach ($data as $row){
    		$annees[] = $row['annee'];
    	}

    	return $annees;
    }
    
    /**
     * Liste les mois d'une année donnée, où il y a des ES
     */
    public static function listMois($annee){
    	$mois = array();
    	$mois = null;
    	$data = BaseSingleton::select('SELECT MONTH(entree_sortie.date) as mois
    									FROM entree_sortie
										WHERE YEAR(entree_sortie.date)=?
    									GROUP BY mois;', array('i', &$annee));
    	 
    	foreach ($data as $row){
    		$mois[] = $row['mois'];
    	}
    
    	return $mois;
    }

    /*
     * Insère ou met à jour l'ES donnée en paramètre.
     * 
     * @param EntreeSortie es
     * @return int id
     * L'id de l'objet inséré en base. False si ça a planté
     */

    public static function insertOnDuplicate($entreeSortie)
    {
        //Récupère les valeurs de l'objet entreeSortie passé en para.
        $id = $entreeSortie->getId();
        $valeur = $entreeSortie->getValeur(); //double
        $es = $entreeSortie->getEs(); //string
        $information = $entreeSortie->getInformation(); //string
        $date = $entreeSortie->getDate(); //string
        $lieuId = $entreeSortie->getLieu()->getId(); //int
        $compteId = $entreeSortie->getCompte()->getId(); //int
        $objetId = $entreeSortie->getObjet()->getId(); //int
        $etiquetteId = $entreeSortie->getEtiquette()->getId(); //int
        $sousObjetId = $entreeSortie->getSousObjet()->getId(); //int
        $payementId = $entreeSortie->getPayement()->getId(); //int
        
        if ($id < 0)
        {
            //Prépare la requête Insertion/Mise à Jour
            $sql = "INSERT INTO entree_sortie (valeur, es, information, date, lieu_id, "
                    . " objet_id, compte_id, etiquette_id, sous_objet_id, payement_id) "
                    . " VALUES (?,?,?,DATE_FORMAT(?,'%Y-%m-%d'),?,?,?,?,?,?) ";
            $params = array('dsssiiiiii',
                &$valeur,
                &$es,
                &$information,
                &$date,
                &$lieuId,
                &$objetId,
            	&$compteId,
                &$etiquetteId,
                &$sousObjetId,
                &$payementId
            );
        }
        else
        {
            $sql = 'UPDATE entree_sortie '
                    . ' SET valeur = ?, '
                    . ' es = ?, '
                    . ' information = ?, '
                    . ' date = DATE_FORMAT(?,"%Y-%m-%d"), '
                    . ' lieu_id = ?, '
                    . ' objet_id = ?, '
                    . ' etiquette_id = ?, '
                    . ' sous_objet_id = ?, '
                    . ' payement_id = ? '
                    . ' WHERE id = ?';
            $params = array('dsssiiiiiii',
                &$valeur,
                &$es,
                &$information,
                &$date,
                &$lieuId,
                &$objetId,
            	&$compteId,
                &$etiquetteId,
                &$sousObjetId,
                &$payementId,
                &$id
            );
        }

        //Exec la requête
        $idInsert = BaseSingleton::insertOrEdit($sql, $params);
        return $idInsert;
    }

    /*
     * Supprime l'ES correspondant à l'id donné en paramètre
     * 
     * @param int $id
     * @return bool
     * True si la ligne a bien été supprimée, False sinon
     */

    public static function delete($id)
    {
        $deleted = BaseSingleton::delete('DELETE FROM entree_sortie WHERE id = ?', array('i', &$id));
        return $deleted;
    }

}
