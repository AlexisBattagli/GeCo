<?php

/**
 * Controlleur pour la page web /view/phtml/rapport_defini.php
 *
 * @author AlexisBattagli
 * @date 03 mai 2022
 * @version 0.2
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
	
	/**
	 * Permet de sortir l'état de chaque compte à la date de la fin du Rapport Defini
	 * @param unknown $dateFin
	 */
	public static function calBilanComptes($listES = array(), $dateDebut, $dateFin){
		$listEtatCpt = array(
				'id' => array(),
				'label' => array(),
				'solde' => array(),
				'nbS' => array(),
				'nbE' => array(),
				'totS' => array(),
				'totE' => array(),
				'%S' => array(),
				'%E' => array(),
				'gain' => array()
		);
		
		foreach ($listES as $es){
			$cpt = $es->getCompte();
			$totalS = self::calTotS($listES);
			$totalE = self::calTotE($listES);
				
			if(!in_array($cpt->getId(), $listEtatCpt['id'])){
				//echo "[DEBUG] Ajout du compte ".$cpt->getLabel()."</br>";
				$listSbyCpt = $cpt->getSbyCpt($dateDebut, $dateFin); 
				$listEbyCpt = $cpt->getEbyCpt($dateDebut, $dateFin);
				$totCptS = self::calTotS($listSbyCpt);
				$totCptE = self::calTotE($listEbyCpt);
		
				if($totalS > 0){
					$perCentS = round(($totCptS / $totalS)*100, 2);
				}else{
					$perCentS = 'N/A';
				}
		
				if($totalE > 0){
					$perCentE = round(($totCptE / $totalE)*100, 2);
				}else{
					$perCentE = 'N/A';
				}
		
				array_push($listEtatCpt['id'], $cpt->getId());
				array_push($listEtatCpt['label'], $cpt->getLabel());
				array_push($listEtatCpt['solde'], $cpt->getSoldeTo($dateFin)); 
				array_push($listEtatCpt['nbS'], count($listSbyCpt));
				array_push($listEtatCpt['nbE'], count($listEbyCpt));
				array_push($listEtatCpt['totS'], $totCptS);
				array_push($listEtatCpt['totE'], $totCptE);
				array_push($listEtatCpt['%S'], $perCentS);
				array_push($listEtatCpt['%E'], $perCentE);
				array_push($listEtatCpt['gain'], $totCptE - $totCptS);
			}/*else{
				echo "[DEBUG] Le compte ".$cpt->getLabel()." est déjà présent.</br>";
			}*/
		}
		
		return $listEtatCpt;
	}
	
	/**
	 * 
	 * @param array $listES
	 * @param unknown $dateDebut
	 * @param unknown $dateFin
	 */
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
				
				if($totalS > 0){
					$perCentS = round(($totObjS / $totalS)*100, 2);
				}else{
					$perCentS = 'N/A';
				}
				
				if($totalE > 0){
					$perCentE = round(($totObjE / $totalE)*100, 2);
				}else{
					$perCentE = 'N/A';
				}
				
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
	public static function calTotS($entreesSorties = array()){
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
	public static function calTotE($entreesSorties = array()){
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
