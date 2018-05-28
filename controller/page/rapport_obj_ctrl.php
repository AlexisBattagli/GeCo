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
			$bilanSO = array();
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
	public static function bilanSousObjets($idObjet, $debut, $fin){
		
		$resultSousObjet = array(
				'label' => array(),
				'es' => array(
						'date' => array(),
						'valeur' => array(),
						'type' => array(),
						'info' => array() 
					),
				'totS' => array(),
				'totE' => array()
		);
		
		$myObjet = ObjetDAL::findById($idObjet);
		if(!is_null($myObjet)){
			echo "[DEBUG] L'objet '".$myObjet->getLabel()."', d'id ".$idObjet." a bien été trouvé.</br>";
		
			$listSousObjet = $myObjet->listSousObjets();
			if(!empty($listSousObjet)){
				echo "[DEBUG] Cet Objet possède ".count($listSousObjet)." sous-objet(s).</br>";
				foreach ($listSousObjet as $sousObjet){
					$bilanSousObjet = self::bilanSousObjet($sousObjet->getId(), $debut, $fin);
					if(!empty($bilanSousObjet)){
						array_push($resultSousObjet['label'], $bilanSousObjet['label']);
						array_push($resultSousObjet['totS'], $bilanSousObjet['totS']);
						array_push($resultSousObjet['totE'], $bilanSousObjet['totE']); 
						
						$nbES = count($bilanSousObjet['es']);
						for ($i = 0; $i < $nbES; $i++){ //Pour chaque ES de ce sous-objet on récupère ses stats
							array_push($resultSousObjet['es']['date'], $bilanSousObjet['es'][$i]['date']);
							array_push($resultSousObjet['es']['valeur'], $bilanSousObjet['es'][$i]['valeur']);
							array_push($resultSousObjet['es']['type'], $bilanSousObjet['es'][$i]['type']);
							array_push($resultSousObjet['es']['info'], $bilanSousObjet['es'][$i]['info']);
						}
						
					}else{ // Il n'y a aucune ES pour ce sous-objet
						echo "[DEBUG] Aucun bilan a établir pour ce sous-objet.</br>";
					}
				}
			}else{
				echo "[DEBUG] Cet Objet ne possède aucun sous objet.</br>";
				$resultSousObjet = array();
			}
		}else{
			echo "[ERROR] L'objet d'id ".$idObjet." n'a pas été trouvé en base...</br>";
		}
		
		echo '<pre>';
		var_dump($resultSousObjet);
		echo '</pre>';
		
		return $resultSousObjet;
	}
	

}