<?php

/*
 * Script de Modification d'une Etiquette
 * Appelé par le formulaire de Modification d'Etiquette de la page mod_uneEtiquette
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EtiquetteDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Etiquette.php');

//Création d'une Etiquette par défaut
$modEtiquette = new Etiquette();

//=====Vérification de ce qui est renvoyé par le formulaire de /view/phtml/mod_uneEtiquette====/
$validId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
if ($validId != null)
{
    echo "[DEBUG]L'ID est OK.</br>";
    $validId = (int) $validId;
    if (is_int($validId))
    {
        echo "[DEBUG]L'ID a bien ete caste en int --> OK</br>";
        $modEtiquette->setId($validId);
        echo "[INFO]L'ID est: " . $modEtiquette->getId() . "</br>";
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

$validLabel = filter_input(INPUT_POST, 'label', FILTER_SANITIZE_STRING);
if ($validLabel != null)
{
    echo "[DEBUG]Le label est OK.</br>";
    $modEtiquette->setLabel($validLabel);
    echo "[INFO]Le label est: " . $modEtiquette->getLabel() . "</br>";
}
else
{
    echo "[DEBUG]Le label renseigne est errone...</br>";
}

$validDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
if ($validDescription != null)
{
    echo "[DEBUG]La description est OK.</br>";
    $modEtiquette->setDescription($validDescription);
    echo "[INFO]La description est: " . $modEtiquette->getDescription() . "</br>";
}
else
{
    echo "[DEBUG]La description renseignee est erronee...</br>";
}

//====Vérification de doublons d'Etiquette selon le label====
// OU que le Label est inchangé
if ($modEtiquette->isUnique() != 0 || $modEtiquette->getLabel() == EtiquetteDAL::findById($validId)->getLabel())
{
    echo "[DEBUG]Ce label est bien unique.</br>";
    EtiquetteDAL::insertOnDuplicate($modEtiquette);
    echo "<meta http-equiv='refresh' content='1; url=http://geco/view/phtml/gst_etiquette.php' />";
}
else
{
    echo "[DEBUG]Cette Etiquette avec ce Label existe deja, aucune modification apporte.</br>";
    //Renvoie à la page de gestion des Etiquette
    echo "<meta http-equiv='refresh' content='1; url=http://geco/view/phtml/gst_etiquette.php' />";
}
?>