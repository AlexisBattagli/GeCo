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
				'%S' => array(),
				'%E' => array(),
				'gain' => array()
		);
		 
		foreach ($listES as $es){
			$objet = $es->getObjet();
			$totalS = self::calTotS($listES);
			$totalE = self::calTotE($listES);
			
			if(!in_array($objet->getId(), $listBO['id'])){
				//echo "[DEBUG] Ajout de l'objet ".$es->getObjet()->getLabel()."</br>";
				$listSbyObjet = $objet->getSbyObjet($dateDebut, $dateFin);
				$listEbyObjet = $objet->getEbyObjet($dateDebut, $dateFin);
				$totObjS = self::calTotS($listSbyObjet);
				$totObjE = self::calTotE($listEbyObjet);
				$perCentS = round(($totObjS / $totalS)*100, 2);
				$perCentE = round(($totObjE / $totalE)*100, 2);
				
				array_push($listBO['id'],$es->getObjet()->getId());
				array_push($listBO['label'], $es->getObjet()->getLabel());
				array_push($listBO['nbS'], count($listSbyObjet));
				array_push($listBO['nbE'], count($listEbyObjet));
				array_push($listBO['totS'], $totObjS);
				array_push($listBO['totE'], $totObjE);
				array_push($listBO['%S'], $perCentS);
				array_push($listBO['%E'], $perCentE);
				array_push($listBO['gain'], $totObjE - $totObjS);
			}/*else{
				echo "[DEBUG] L'objet ".$es->getObjet()->getLabel()." est déjà présent.</br>";
				
			}*/
		}
		 
		return $listBO;
	}
	
	/*
	 * Retourne la somme total de sortie d'une liste d'ES
	 */
	public function calTotS($entreesSorties = array()){
		$totS = 0;
		foreach ($entreesSorties as $es){
			if($es->isS()){
				$totS += $es->getValeur();
			}
		}
		return $totS;
	}
	
	/*
	 * Retourne la somme total d'entrée d'une liste d'ES
	 */
	public function calTotE($entreesSorties = array()){
		$totE = 0;
		foreach ($entreesSorties as $es){
			if($es->isE()){
				$totE += $es->getValeur();
			}
		}
		return $totE;
	}
}

?>