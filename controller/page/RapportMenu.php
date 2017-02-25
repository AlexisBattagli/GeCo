<?php

/**
 * Controlleur pour la page web /view/phtml/rapport_menu.php
 * 
 * @author AlexisBattagli
 * @date 24 févire 2017
 * @version 0.1
 */

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');

class RapportMenu {
	
	/**
	 * Retourne un tableau de l'ensemble des années mentionnée dans els date des ES existant. 
	 */
	public static function listAnnees() {
		$annees =  EntreeSortieDAL::listAnnees();		
		return $annees;
	}
	
	/**
	 * Retourne un tableau des mois où il y a au moins une ES pour une année donnée
	 * @param unknown $annee
	 */
	public static function listMois($annee) {
		return EntreeSortieDAL::listMois($annee);		
	}
}
