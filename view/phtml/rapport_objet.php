<?php

/**
 * Page affichant les ES lié à une catégorie d'objet sur une période donnée 
 * 
 * @author AlexisBattagli
 * @date 24 mai 2018
 * @version 0.1
 */

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

//require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/EntreeSortie.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Objet.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/SousObjet.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/controller/page/rapport_obj_ctrl.php');

//======Vérification de ce qui est renvoyé par le lien du tableau des objet dans la page /view/phtml/rapport_defini.php====/
echo "[DEBUG] Vérifie la date de début reçue</br>";
$validDateDebut = filter_input(INPUT_GET, 'debut', FILTER_SANITIZE_STRING);
if (!is_null($validDateDebut))
{
	echo "[DEBUG] Le champ debut est ok et vaut :".$validDateDebut."</br>";
	$debut = $validDateDebut;
}
else {
	echo "[ERROR] Le champ debut est erroné... il vaut :".$validDateDebut."</br>";
}

echo "[DEBUG] Vérifie la date de fin reçue </br>";
$validDateFin = filter_input(INPUT_GET, 'fin', FILTER_SANITIZE_STRING);
if (!is_null($validDateFin))
{
	echo "[DEBUG] Le champ fin est ok et vaut :".$validDateFin."</br>";
	$fin = $validDateFin;
}
else {
	echo "[ERROR] Le champ fin est erroné... il vaut :".$validDateFin."</br>";
}

echo "[DEBUG] Vérifie l'id de l'objet reçue </br>";
$validIdObjet = filter_input(INPUT_GET, 'idObjet', FILTER_SANITIZE_STRING);
if (!is_null($validIdObjet))
{
	echo "[DEBUG] Le champ idObjet est ok et vaut :".$validIdObjet."</br>";
	$idObjet = $validIdObjet;
}
else {
	echo "[ERROR] Le champ idObjet est erroné... il vaut :".$validIdObjet."</br>";
}


$bilanSousObjets = RapportObjCtrl::bilanSousObjets($idObjet, $debut, $fin);

//TODO A afficher !






