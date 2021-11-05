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
			'diffM1' => array(),
			'diffM2' => array(),
			'diffM6' => array(),
		);

		return $etatComptes;
	}
}

?>
