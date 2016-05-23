<?php

/*
 * Script de Modification d'un Lieu
 * Appelé par le formulaire de Modification de Lieux de la page mod_unLieux
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/LieuDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Lieu.php');

//Création d'un Lieu par défaut
$modLieu = new Lieu();

//=====Vérification de ce qui est renvoyé par le formulaire de /view/phtml/mod_unlieux====/
$validId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
if ($validId != null)
{
    echo "[DEBUG]L'ID est OK.</br>";
    $validId = (int) $validId;
    if (is_int($validId))
    {
        echo "[DEBUG]L'ID a bien ete caste en int --> OK</br>";
        $modLieu->setId($validId);
        echo "[INFO]L'ID est: " . $modLieu->getId() . "</br>";
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

$validPays = filter_input(INPUT_POST, 'pays', FILTER_SANITIZE_STRING);
if ($validPays != null)
{
    echo "[DEBUG]Le pays est OK.</br>";
    $modLieu->setPays($validPays);
    echo "[INFO]Le pays est: " . $modLieu->getPays() . "</br>";
}
else
{
    echo "[DEBUG]Le pays renseigne est errone...</br>";
}

$validVille = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_STRING);
if ($validVille != null)
{
    echo "[DEBUG]La ville est OK.</br>";
    $modLieu->setVille($validVille);
    echo "[INFO]La ville est: " . $modLieu->getVille() . "</br>";
}
else
{
    echo "[DEBUG]La ville renseignee est erronee...</br>";
}

//====Vérification de doublons du Lieu selon le couple (ville;pays)====
if ($modLieu->isUnique() != 0)
{
    echo "[DEBUG]Ce couple Pays/Ville est bien unique.</br>";
    LieuDAL::insertOnDuplicate($modLieu);
    echo "<meta http-equiv='refresh' content='1; url=http://geco.ab/view/phtml/gst_lieux.php' />";
}
else
{
    echo "[DEBUG]Ce couple Pays/Ville existe deja, aucune modification apporte.</br>";
    //Renvoie à la page de gestion des Lieux
    echo "<meta http-equiv='refresh' content='1; url=http://geco.ab/view/phtml/gst_lieux.php' />";
}
?>

