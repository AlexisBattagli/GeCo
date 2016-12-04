<?php

/*
 * Script de Modification d'un Budget
 * Appelé par le formulaire de Modification d'un Budget de la page mod_unBudget
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/BudgetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Budget.php');

//Création d'un Budget par défaut
$modBudget = new Budget();

//=====Vérification de ce qui est renvoyé par le formulaire de /view/phtml/mod_unBudget====/
$validId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
if ($validId != null)
{
    echo "[DEBUG]L'ID est OK.</br>";
    $validId = (int) $validId;
    if (is_int($validId))
    {
        echo "[DEBUG]L'ID a bien été casté en int --> OK</br>";
        $modBudget = BudgetDAL::findById($validId);
        echo "[INFO]L'ID est: " . $modBudget->getId() . "</br>";
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

$validValeur = filter_input(INPUT_POST, 'valeur', FILTER_SANITIZE_STRING);
if ($validValeur != null)
{
	$validValeur = (double) $validValeur;
    echo "[DEBUG]La valeur est OK.</br>";
    $modBudget->setValeur($validValeur);
    echo "[INFO]La valeur est: " . $modBudget->getValeur() . "</br>";
}
else
{
    echo "[DEBUG]La valeur renseignée est érronée...</br>";
}

//===Pas dde vérification de doublon car il n'y a que la valeur du budget qui peut-être modifiée===
BudgetDAL::insertOnDuplicate($modBudget);

//Renvoie à la page de gestion des Budget
echo "<meta http-equiv='refresh' content='1; url=http://geco/view/phtml/gst_budget.php' />";


?>