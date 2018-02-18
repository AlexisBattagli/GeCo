<?php

/**
 * Controlleur pour la page web /view/phtml/rapport_defini.php
 *
 * @author AlexisBattagli
 * @date 18 février 2018
 * @version 0.1
 */

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/class/EntreeSortie.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/class/Objet.php');

class RapportDefCtrl {

	/*
	 * Récupère le flux total d'entrée et sortie, comprenant les transferts.
	 * Utilisé dans la view rapport_defini.php
	 */
	public static function getFlux($dateDebut, $dateFin){
		return EntreeSortieDAL::findByIntervalDate($dateDebut, $dateFin);
	}
	
	public static function calBilanObjets($listES = array(), $dateDebut, $dateFin){
		$listBO = array(
				'id' => array(),
				'label' => array(),
				'nbS' => array(),
				'nbE' => array(),
				'totS' => array(),
				'totE' => array(),
				'gain' => array(),
				'budget' => array()
		);
		 
		foreach ($listES as $es){
			if(!in_array($es->getObjet()->getId(), $listBO['id'])){
				//echo "[DEBUG] Ajout de l'objet ".$es->getObjet()->getLabel()."</br>";
				array_push($listBO['id'],$es->getObjet()->getId());
				array_push($listBO['label'], $es->getObjet()->getLabel());
				array_push($listBO['nbS'], $es->calNbS($dateDebut, $dateFin, $es->getObjet()->getId()));
				//TODO calculer ici les différent element du tableau par Objet de la view rapport_defini
			}
		}
		 
		echo '<pre>';
		var_dump($listBO);
		echo '</pre>';
		 
		return $listBO;
	}
}

?>