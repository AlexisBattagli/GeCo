<?php

/*
 * Script de Modification d'un Objet
 * Appelé par le formulaire de Modification d'un Objet de la page mod_unObjet
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Objet.php');

//Création d'un Objet par défaut
$modObjet = new Objet();

//=====Vérification de ce qui est renvoyé par le formulaire de /view/phtml/mod_unObjet====/
$validId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
if ($validId != null)
{
    echo "[DEBUG]L'ID est OK.</br>";
    $validId = (int) $validId;
    if (is_int($validId))
    {
        echo "[DEBUG]L'ID a bien ete caste en int --> OK</br>";
        $modObjet->setId($validId);
        echo "[INFO]L'ID est: " . $modObjet->getId() . "</br>";
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
    $modObjet->setLabel($validLabel);
    echo "[INFO]Le label est: " . $modObjet->getLabel() . "</br>";
}
else
{
    echo "[DEBUG]Le label renseigne est errone...</br>";
}

$validDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
if ($validDescription != null)
{
    echo "[DEBUG]La description est OK.</br>";
    $modObjet->setDescription($validDescription);
    echo "[INFO]La description est: " . $modObjet->getDescription() . "</br>";
}
else
{
    echo "[DEBUG]La description renseignee est erronee...</br>";
}

//====Vérification de doublons d'Etiquette selon le label====
// OU que le Label est inchangé
if ($modObjet->isUnique() != 0 || $modObjet->getLabel() == ObjetDAL::findById($validId)->getLabel())
{
    echo "[DEBUG]Ce label est bien unique.</br>";
    ObjetDAL::insertOnDuplicate($modObjet);
    echo "<meta http-equiv='refresh' content='1; url=http://geco/view/phtml/gst_objet.php' />";
}
else
{
    echo "[DEBUG]Cet Objet avec ce Label existe deja, aucune modification apporte.</br>";
    //Renvoie à la page de gestion des Objets
    echo "<meta http-equiv='refresh' content='1; url=http://geco/view/phtml/gst_objet.php' />";
}

?>