<?php

/*
 * Script d'ajout d'un Budget
 * Appelé par le formulaire d'ajout de Budget de la page add_budget
 *
 * Ajout un Budget en base et renvoie sur la page /view/phtml/gst_budget.
 *
 * @author Alexis BATTAGLI
 * @version 0.1
 */


require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/BudgetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Budget.php');

//Création d'un Budget par défaut
$newBudget = new Budget();

//======Vérification de ce qui est renvoyé par le formulaire de /view/phtml/gst_budget====/
$validAnnee = filter_input(INPUT_POST, 'annee', FILTER_SANITIZE_STRING);
if ($validAnnee != null)
{
	$validAnnee = (int) $validAnnee;
	echo "[INFO]Annee: " . $validAnnee . "</br>";
	$newBudget->setAnnee($validAnnee);
}

$validValeur = filter_input(INPUT_POST, 'valeur', FILTER_SANITIZE_STRING);
if ($validValeur != null)
{
	$validValeur = (double) $validValeur;
	echo "[INFO]Valeur: " . $validValeur . "€</br>";
	$newBudget->setValeur($validValeur);
}

$validId = filter_input(INPUT_POST, 'objet_id', FILTER_SANITIZE_STRING);
if ($validId != null)
{
	echo "[DEBUG]L'ID est OK.</br>";
	$validId = (int) $validId;
	if (is_int($validId))
	{
		echo "[DEBUG]L'ID de l'objet a bien été casté en int (". $validId .") --> OK</br>";
		$newBudget->setObjet($validId);
	}
	else
	{
		echo "[DEBUG]Erreur, l'ID n'a pas été casté en int...</br>";
	}
}
else
{
	echo "[DEBUG]L'ID renseigné est érroné...</br>";
	echo "[WARN]L'ID est: " . $validId . "</br>";
}

//====Vérification de doublons du Budget selon le couple (annee;objetId)=====/
if ($newBudget->isUnique() != 0)
{

	//====Insertion=====/
	$validInsertBudget = BudgetDAL::insertOnDuplicate($newBudget);

	if($validInsertBudget != null)
	{
		echo "Ajout du Budget reussi ! (id: ". $validInsertBudget . ")";
	}
	else
	{
		echo "Insert echec...";
	}

	//Renvoie à la page précédante
	echo "<meta http-equiv='refresh' content='1; url=".$_SERVER["HTTP_REFERER"]. "' />";
}
else
{
	echo "Erreur, le Budget de l'année ".$newBudget->getAnnee()." pour l'Objet ".$newBudget->getObjet()->getLabel()." que vous voulez ajouter existe déjà...";
}

?>
