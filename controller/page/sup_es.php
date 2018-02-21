<?php

/*
 * Controller appelé pour la suppression d'une ES
 * 
 * @author Alexis BATTAGLI	
 * @date 20/02/2018
 * @version 0.1
 */

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/DAL/SoldeDAL.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/class/Solde.php');

//======Vérification de ce qui est renvoyé par la demande de suppression d'ES====/
echo "[DEBUG] Vérifie la date de début reçue</br>";
$validDateDebut = filter_input(INPUT_GET, 'debut', FILTER_SANITIZE_STRING);
if (!is_null($validDateDebut))
{
	echo "[DEBUG] Le champ debut est ok et vaut :".$validDateDebut."</br>";
	$debut = $validDateDebut;
}
else {
	echo "[ERROR] Le champ debut est vide... il vaut :".$validDateDebut."</br>";
}

echo "[DEBUG] Vérifie la date de fin reçue </br>";
$validDateFin = filter_input(INPUT_GET, 'fin', FILTER_SANITIZE_STRING);
if (!is_null($validDateFin))
{
	echo "[DEBUG] Le champ fin est ok et vaut :".$validDateFin."</br>";
	$fin = $validDateFin;
}
else {
	echo "[ERROR] Le champ fin est vide... il vaut :".$validDateFin."</br>";
}

echo "[DEBUG] Vérifie l'id de l'ES à supprimer </br>";
$valideIdES = filter_input(INPUT_GET, 'idES', FILTER_SANITIZE_NUMBER_INT);
if (!is_null($valideIdES)){
	echo "[DEBUG] Le champ idES est ok et vaut :".$valideIdES."</br>";
	$idES = $valideIdES;
}else {
	echo "[ERROR] Le champ idES est vide... il vaut :".$valideIdES."</br>";
}

echo "</br>";

//Récupère l'ES (Get EntreeSortie)
$es = EntreeSortieDAL::findById($idES);

//Récupère la valeur de l'ES (Get EntreeSortie)
$typeES = $es->getEs();
echo "[DEBUG] Le type de l'ES est ".$typeES.'.</br>';
if($typeES=='S'){
	$valeurES = 0 - $es->getValeur();
}else{
	$valeurES = $es->getValeur();
}
echo "[DEBUG] La valeur de l'ES est de ".$valeurES.'€. </br>';

//Récupère la date l'ES
$dateES = $es->getDate();
echo "[DEBUG] Cette ES date du ".$dateES.".</br>";

//Récupère le compte de l'ES (Get Compte)
$compte = $es->getCompte();
echo "[DEBUG] Le compte rattaché à cette ES est ".$compte->getLabel().".</br>";

//Récupère les soldes du compte impactés par l'ES (SELECT Solde)


//Met à jour chaque solde de ce compte (UPDATE Solde)

//Supprime l'ES en base (DELETE EntreeSortie



?>