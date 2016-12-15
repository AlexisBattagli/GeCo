<?php

//import
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/SousObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/SousObjet.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php');

//Définition du message renvoyé
$message = "error";

//Checker de où il vient
//=====Vérification de ce qui est renvoyé par le formulaire
$validIdObjet = filter_input(INPUT_POST, 'idObjet', FILTER_SANITIZE_STRING);
$objet = ObjetDAL::findById($validIdObjet);

//Récupération des sous-objets de l'objet.
$sousobjets = SousObjetDAL::findByObjet($validIdObjet);
$sousobjetsJson = [];
foreach ($sousobjets as $sousobjet) {
	$sousobjetsJson[$sousobjet->getId()]['id'] = $sousobjet->getId();
	$sousobjetsJson[$sousobjet->getId()]['label'] = $sousobjet->getLabel();
}

//Envoi des sous-objets récupérés
$json = json_encode($sousobjetsJson);
echo $json;

?>