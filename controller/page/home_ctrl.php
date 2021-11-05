<?php

/**
 * Controlleur pour la page web /view/phtml/home.php
 *
 * @author AlexisBattagli
 * @date 5 novembre 2021
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
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/DAL/CompteDAL.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/class/Compte.php');

class HomeCtrl {

	/*
	 * Récupère l'état des comptes sous la forme d'un tableau composé de:
	 * nom du compte, solde actuel, solde du mois M-1, diff solde actuel - solde M-1, solde du mois M-2, diff solde actuel - solde M-2
	 * Ne récupère pas les comptes commençant par 'OLD'
	 */
	public static function getEtatComptes(){
		$etatComptes = array(
			'id' => array(),
			'label' => array(),
			'solde' => array(),
			'soldeM1' => array(),
			'soldeM2' => array(),
			'soldeM6' => array(),
			'soldeM12' => array(),
			'diffM1' => array(),
			'diffM2' => array(),
			'diffM6' => array(),
			'diffM12' => array()
		);

		$currentMonth = date('m');
		$currentYear = date('Y');
		//echo "[DEBUG] Date: ".$currentYear."/".$currentMonth."</br>";
		$dateM1 = date("Y-m-d", mktime(0, 0, 0, $currentMonth, 0, $currentYear));
		$dateM2 = date("Y-m-d", mktime(0, 0, 0, $currentMonth-1, 0, $currentYear));
		$dateM6 = date("Y-m-d", mktime(0, 0, 0, $currentMonth-5, 0, $currentYear));
		$dateM12 = date("Y-m-d", mktime(0, 0, 0, $currentMonth-11, 0, $currentYear));

		$comptes = CompteDAL::findAllActif();
		foreach ($comptes as $compte){
			$idCpt = $compte->getId();
			$labelCpt = $compte->getLabel();
			
			$currentSolde = SoldeDAL::findLast($idCpt);
			if (!is_null($currentSolde)){
				$solde = $currentSolde->getValeur();
                        } else { $solde = 0; }
			
			$soldeM1 = SoldeDAL::findOldLast($dateM1, $idCpt);
			if (!is_null($soldeM1)){
				$soldeValeurM1 = $soldeM1->getValeur();
			} else { $soldeValeurM1 = 0; }
			$soldeM2 = SoldeDAL::findOldLast($dateM2,$idCpt);
			if (!is_null($soldeM2)){
				$soldeValeurM2 = $soldeM2->getValeur();
			} else { $soldeValeurM2 = 0; }
			$soldeM6 = SoldeDAL::findOldLast($dateM6,$idCpt); 
			if (!is_null($soldeM6)){
                        	$soldeValeurM6 = $soldeM6->getValeur();
			} else { $soldeValeurM6 = 0; }
			$soldeM12 = SoldeDAL::findOldLast($dateM12,$idCpt);
			if (!is_null($soldeM12)){
				$soldeValeurM12 = $soldeM12->getValeur();
			} else { $soldeValeurM12 = 0; }

			$diffM1 = $solde - $soldeValeurM1;
			$diffM2 = $solde - $soldeValeurM2;
			$diffM6 = $solde - $soldeValeurM6;
			$diffM12 = $solde - $soldeValeurM12;
			
			/*
			echo "[DEBUG] Compte: ".$labelCpt.", valeur ".$solde."</br>";
			echo "[DEBUG] Solde-M1 (".$dateM1.") : ".$soldeValeurM1." (diff ".$diffM1.")</br>";	
		        echo "[DEBUG] Solde-M2 (".$dateM2."): ".$soldeValeurM2." (diff ".$diffM2.")</br>";	
		        echo "[DEBUG] Solde-M6 (".$dateM6."): ".$soldeValeurM6." (diff ".$diffM6.")</br>";	
		        echo "[DEBUG] Solde-M12 (".$dateM12."): ".$soldeValeurM12." (diff ".$diffM12.")</br>";	
			*/

			array_push($etatComptes['id'],$idCpt);
			array_push($etatComptes['label'],$labelCpt);
			array_push($etatComptes['solde'],$solde);
			array_push($etatComptes['soldeM1'],$soldeValeurM1);
                        array_push($etatComptes['soldeM2'],$soldeValeurM2);
                        array_push($etatComptes['soldeM6'],$soldeValeurM6);
                        array_push($etatComptes['soldeM12'],$soldeValeurM12);
                        array_push($etatComptes['diffM1'],$diffM1);
                        array_push($etatComptes['diffM2'],$diffM2);
                        array_push($etatComptes['diffM6'],$diffM6);
                        array_push($etatComptes['diffM12'],$diffM12);
		}

		return $etatComptes;
	}

	/*
	 * Récupère les statistique d'ES du mois en cours, qui sont:
	 * le nombre d'Entrée, le nombre de Sortie, la somme des sorties, la somme des entrées
	 *
	 */
	public static function getStatCurrentMonth(){
		$statCurrentMonth = array(
			'nbE' => array(),
			'nbS' => array(),
			'sommeE' => array(),
			'sommeS' => array()
		);

		return $statCurrentMonth;
	}

	/*
	 * Récupère les x dernière Entree OU Sortie dans un tableau
	 * Le nombre d'entrée ou sortie est désigné par la var $nbLastES, compris entre 1 et 10
	 * Le choix d'entrée ou sortie est désigné par la va $natureES, qui peut prendre une valeur entre 'e' ou 's'
	 * @param int $nbLastES, string $natureES
	 */
	public static function getLastEntreeSortie($nbLastES, $natureES){
		$lastES = array(
			'id' => array(),
			'es' => array(),
			'date' => array(),
			'valeur' => array(),
			'objet_label' => array(),
			'info' => array(),
			'lieux' => array(),
			'compte' => array()
		);

		return $lastES;
	}
}

?>
