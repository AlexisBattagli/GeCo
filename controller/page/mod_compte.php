<?php

/*
 * Script de Modification d'un Compte
 * Appelé par le formulaire de Modification de Compte de la page mod_unCompte
 * 
 * Supprime un lieu en base et renvoie sur la page /view/phtml/gst_compte.php.
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/CompteDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Compte.php');

//Création d'un compte par défaut
$modCompte = new Compte();

//Variable vérifiant qu'il y a bien besoin de faire une modification
$modif = false; //De base pas besoin de faire un Update
//=====Vérification de ce qui est renvoyé par le formulaire de /view/phtml/mod_unCompte====/
//ID
$validId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
if ($validId != null)
{
    echo "[DEBUG]L'ID est OK.</br>";
    $validId = (int) $validId;
    if (is_int($validId))
    {
        echo "[DEBUG]L'ID a bien ete caste en int --> OK</br>";
        $modCompte->setId($validId);
        echo "[INFO]L'ID est: " . $modCompte->getId() . "</br>";

        //Création du Compte pour comparer les modifications
        $oldCompte = CompteDAL::findById($validId);
    }
    else
    {
        echo "[DEBUG]Erreur, l'ID n'a pas ete caste en int...</br>";
    }
}
else
{
    echo "[DEBUG]L'ID renseigne est errone...</br>";
    echo "[WARN]L'ID est: " . $validId . "</br>";
}

//LABEL
$validLabel = filter_input(INPUT_POST, 'label', FILTER_SANITIZE_STRING);
if ($validLabel != null)
{
    echo "[DEBUG]Le Label est OK.</br>";
    $modCompte->setLabel($validLabel);
    echo "[INFO]Le Label est: " . $modCompte->getLabel() . "</br>";
}
else
{
    echo "[DEBUG]Le Label renseigne est errone...</br>";
}

//BANQUE
$validBanque = filter_input(INPUT_POST, 'banque', FILTER_SANITIZE_STRING);
if ($validBanque != null)
{
    echo "[DEBUG]Le nom de Banque est OK.</br>";
    $modCompte->setBanque($validBanque);
    echo "[INFO]La Banque est: " . $modCompte->getBanque() . "</br>";
}
else
{
    echo "[DEBUG]Le nom de Banque renseigne est errone...</br>";
}

//INFORMATION
$validInformation = filter_input(INPUT_POST, 'information', FILTER_SANITIZE_STRING);
if ($validInformation != null)
{
    echo "[DEBUG]Les infos sont OK.</br>";
    $modCompte->setInformation($validInformation);
    echo "[INFO]Les infos sont: " . $modCompte->getInformation() . "</br>";

    if ($modCompte->getInformation() != $oldCompte->getInformation())
    {
        echo "[INFO]Les info ont été changees.</br>";
        $modif = true;
    }
}
else
{
    echo "[DEBUG]Les infos renseignees est errone...</br>";
}

//IDENTIFIANT
$validIdentifiant = filter_input(INPUT_POST, 'identifiant', FILTER_SANITIZE_STRING);
if ($validIdentifiant != null)
{
    echo "[DEBUG]L'identifiant est OK.</br>";
    $modCompte->setIdentifiant($validIdentifiant);
    echo "[INFO]L'identifiant est: " . $modCompte->getIdentifiant() . "</br>";

    if ($modCompte->getIdentifiant() != $oldCompte->getIdentifiant())
    {
        echo "[INFO]L'identifiant a été changes.</br>";
        $modif = true;
    }
}
else
{
    echo "[DEBUG]L'identifiant renseigne est errone...</br>";
}

//====Vérification de doublons du Compte selon le couple (label;banque)====
if ($modCompte->isUnique() != 0 || $modif)
{
    echo "[DEBUG]Ce couple Label/Banque est bien unique.</br>";
    CompteDAL::insertOnDuplicate($modCompte);
    echo "<meta http-equiv='refresh' content='1; url=http://geco.ab/view/phtml/gst_compte.php' />";
}
else
{
    if ($modCompte->isUnique())
    {
        echo "[DEBUG]Ce couple Label/Banque existe deja, aucune modification apporte.</br>";
    }
    if (!$modif)
    {
        echo "[DEBUG]Aucune modification apportees.</br>";
    }
    //Renvoie à la page de gestion des Lieux
    echo "<meta http-equiv='refresh' content='1; url=http://geco.ab/view/phtml/gst_compte.php' />";
}