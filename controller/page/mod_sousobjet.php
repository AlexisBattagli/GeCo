<?php

/*
 * Script de Modification d'un Sous-Objet
 * Appelé par le formulaire de Modification d'un Sous-Objet de la page mod_unSousObjet
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/SousObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/SousObjet.php');

//Création d'un Sous-Objet par défaut
$modSousObjet = new SousObjet();

//=====Vérification de ce qui est renvoyé par le formulaire de /view/phtml/mod_unSousObjet====/
$validId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
if ($validId != null)
{
    echo "[DEBUG]L'ID est OK.</br>";
    $validId = (int) $validId;
    if (is_int($validId))
    {
        echo "[DEBUG]L'ID a bien ete caste en int --> OK</br>";
        $modSousObjet->setId($validId);
        echo "[INFO]L'ID est: " . $modSousObjet->getId() . "</br>";
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
    $modSousObjet->setLabel($validLabel);
    echo "[INFO]Le label est: " . $modSousObjet->getLabel() . "</br>";
}
else
{
    echo "[DEBUG]Le label renseigne est errone...</br>";
}

$validDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
if ($validDescription != null)
{
    echo "[DEBUG]La description est OK.</br>";
    $modSousObjet->setDescription($validDescription);
    echo "[INFO]La description est: " . $modSousObjet->getDescription() . "</br>";
}
else
{
    echo "[DEBUG]La description renseignee est erronee...</br>";
}

//====Vérification de doublons de Sous-Objet selon le label====
// OU que le Label est inchangé
if ($modSousObjet->isUnique() != 0 || $modSousObjet->getLabel() == SousObjetDAL::findById($validId)->getLabel())
{
    echo "[DEBUG]Ce label est bien unique.</br>";
    SousObjetDAL::insertOnDuplicate($modSousObjet);
    echo "<meta http-equiv='refresh' content='1; url=http://geco/view/phtml/gst_sousobjet.php' />";
}
else
{
    echo "[DEBUG]Ce Sous-Objet avec ce Label existe deja pour cet Objet, aucune modification apporté.</br>";
    //Renvoie à la page de gestion des Objets
    echo "<meta http-equiv='refresh' content='1; url=http://geco/view/phtml/gst_sousobjet.php' />";
}

?>