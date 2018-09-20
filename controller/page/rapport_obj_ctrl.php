<?php

/*
* Controlleur pour la page web /view/phtml/rapport_objet.php
*
* @author AlexisBattagli
* @date 28 mai 2018
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
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/DAL/SousObjetDAL.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/class/SousObjet.php');

class RapportObjCtrl {
	
	
	/*
	 * Réalise le bilan à partir d'un objet ou de sous-objet
	 */
	public static function makeResult($bilan, $result){
		if(!empty($bilan)){
			array_push($result['label'], $bilan['label']);
			array_push($result['totS'], $bilan['totS']);
			array_push($result['totE'], $bilan['totE']);
			array_push($result['nbES'], $bilan['nbES']);
			$nbES = count($bilan['es']);
			for ($i = 0; $i < $nbES; $i++){ //Pour chaque ES de ce sous-objet on récupère ses stats
				array_push($result['es']['date'], $bilan['es'][$i]['date']);
				array_push($result['es']['valeur'], $bilan['es'][$i]['valeur']);
				array_push($result['es']['type'], $bilan['es'][$i]['type']);
				array_push($result['es']['info'], $bilan['es'][$i]['info']);
			}
		
		}else{ // Il n'y a aucune ES pour ce sous-objet
			echo "[DEBUG] Aucun bilan a établir pour ce sous-objet.</br>";
		}
		
		return $result;
	}
	
	/*
	 * Retourne les statistique d'un Objet sur uen période de temps donnée (pour un objet n'ayant pas de sous objet)
	 */
	public static function bilanObjet($objet, $debut, $fin){
	
		//Initialise les variable
		$totS = 0;
		$totE = 0;
	
		//Tableau de bilan d'UN sous-objet à multiple ES
		$bilanO = array(
				'label' => "--",
				'es' => array()
		);
	
		//Recupère la liste des ES de ce sous-objet
		$listES = EntreeSortieDAL::findByObjetByTime($objet->getId(), $debut, $fin);
		if(!empty($listES)){ //S'il y a des ES pour ce sous-objet alors établie le bilan
			echo "[DEBUG] L'objet '".$objet->getLabel()."' possède des ES entre le ".$debut." et le ".$fin.".</br>";
			foreach ($listES as $es){
				$statsES = array(
						'date' => $es->getDate(),
						'valeur' => $es->trueValeur(),
						'type' => $es->getEs(),
						'info' => $es->getInformation()
				);
				array_push($bilanO['es'], $statsES);
	
				if($es->isE()){
					$totE += $es->getValeur();
				}else{
					$totS += $es->getValeur();
				}
			}
				
			$bilanO['nbES'] = count($listES);
			$bilanO['totS'] = $totS; // ajout la key 'totS' au tableau bilan de ce sous-objet
			$bilanO['totE'] = $totE; // ajout la key 'totE' au tableau bilan de ce sous-objet
				
		}else{// S'il n'y a aucunes ES renvoi un tableau vide
			echo "[DEBUG] L'objet '".$objet->getLabel()."' ne possède aucunes ES entre le ".$debut." et le ".$fin.".</br>";
			$bilanO['nbES'] = 0;
		}
	
		/* DEBUG
			echo '<pre>';
			var_dump($bilanO);
			echo '</pre>';
			*/
	
		return $bilanO;
	}
	
	
	/*
	 * Retourne les statistique d'un Sous-Objet sur uen période de temps donnée
	 */
	public static function bilanSousObjet($idSousObjet, $debut, $fin){
		
		//Initialise les variable et recupère le SOus-Objet correspondant
		$sousObjet = SousObjetDAL::findById($idSousObjet);
		$totS = 0;
		$totE = 0;
		
		//Tableau de bilan d'UN sous-objet à multiple ES
		$bilanSO = array(
				'label' => $sousObjet->getLabel(),
				'es' => array()
				// 'totS' IL ne faut pas faire comme ça, il faut l'ajouter plus tard si ce n'est pas un tableau
				);
		
		//Recupère la liste des ES de ce sous-objet
		$listES = EntreeSortieDAL::findBySousObjetByTime($idSousObjet, $debut, $fin);
		if(!empty($listES)){ //S'il y a des ES pour ce sous-objet alors établie le bilan
			echo "[DEBUG] Le sous-objet '".$sousObjet->getLabel()."' possède des ES entre le ".$debut." et le ".$fin.".</br>";
			
			$bilanSO['nbES'] = count($listES);
			
			foreach ($listES as $es){
				$statsES = array(
					'date' => $es->getDate(),
					'valeur' => $es->trueValeur(),
					'type' => $es->getEs(),
					'info' => $es->getInformation()
				);
				array_push($bilanSO['es'], $statsES);
				
				if($es->isE()){
					$totE += $es->getValeur();
				}else{
					$totS += $es->getValeur();
				}
			}
			
			$bilanSO['totS'] = $totS; // ajout la key 'totS' au tableau bilan de ce sous-objet
			$bilanSO['totE'] = $totE; // ajout la key 'totE' au tableau bilan de ce sous-objet
			
		}else{// S'il n'y a aucunes ES renvoi un tableau vide
			echo "[DEBUG] Le sous-objet '".$sousObjet->getLabel()."' ne possède aucunes ES entre le ".$debut." et le ".$fin.".</br>";
			$bilanSO['nbES'] = 0;
		}
		
		/* DEBUG
		echo '<pre>';
		var_dump($bilanSO);
		echo '</pre>';
		*/
		
		return $bilanSO;
	}
	
	
	/*
	 * Retourne la liste des Sous-Objet d'un objet donnée et ses stats sur une période de temps 
	 */
	public static function calcBilan($idObjet, $debut, $fin){
		
		$resultSousObjet = array(
				'label' => array(),
				'es' => array(
						'date' => array(),
						'valeur' => array(),
						'type' => array(),
						'info' => array() 
					),
				'totS' => array(),
				'totE' => array(),
				'nbES' => array()
		);
		
		$myObjet = ObjetDAL::findById($idObjet);
		if(!is_null($myObjet)){
			echo "[DEBUG] L'objet '".$myObjet->getLabel()."', d'id ".$idObjet." a bien été trouvé.</br>";
		
			$listSousObjet = $myObjet->listSousObjets();
			if(!empty($listSousObjet)){
				echo "[DEBUG] Cet Objet possède ".count($listSousObjet)." sous-objet(s).</br>";
				foreach ($listSousObjet as $sousObjet){
					$bilanSousObjet = self::bilanSousObjet($sousObjet->getId(), $debut, $fin);
					$resultSousObjet = self::makeResult($bilanSousObjet, $resultSousObjet);
				}
			}else{
				echo "[DEBUG] Cet Objet ne possède aucun sous objet.</br>";
				$bilanObjet = self::bilanObjet($myObjet, $debut, $fin);
				$resultSousObjet = self::makeResult($bilanObjet, $resultSousObjet);
			}
		}else{
			echo "[ERROR] L'objet d'id ".$idObjet." n'a pas été trouvé en base...</br>";
		}
		
		/* DEBUG
		echo '<pre>';
		var_dump($resultSousObjet);
		echo '</pre>';
		*/
		
		return $resultSousObjet;
	}
	

}