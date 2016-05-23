<?php

/*
 * Script de Modification d'un Payement
 * Appelé par le formulaire de Modification de Payement de la page mod_unPayement
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/PayementDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Payement.php');

//Création d'un Payement par défaut
$modPayement = new Payement();

//=====Vérification de ce qui est renvoyé par le formulaire de /view/phtml/mod_unPayement====/
$validId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
if ($validId != null)
{
    echo "[INFO]L'ID est OK.</br>";
    $validId = (int) $validId;
    if (is_int($validId))
    {
        echo "[INFO]L'ID a bien ete caste en int --> OK</br>";
        $modPayement->setId($validId);
        echo "[INFO]L'ID est: " . $modPayement->getId() . "</br>";
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

$validMoyen = filter_input(INPUT_POST, 'moyen', FILTER_SANITIZE_STRING);
if ($validMoyen != null)
{
    echo "[INFO]Le moyen est OK.</br>";
    $modPayement->setMoyen($validMoyen);
    echo "[INFO]Le moyen est: " . $modPayement->getMoyen() . "</br>";
}
else
{
    echo "[DEBUG]Le moyen renseigne est errone...</br>";
}

//====Vérification de doublons du Payement selon le moyen====
if ($modPayement->isUnique() != 0)
{
    echo "[INFO]Ce moyen est bien unique.</br>";
    PayementDAL::insertOnDuplicate($modPayement);
    echo "<meta http-equiv='refresh' content='1; url=http://geco.ab/view/phtml/gst_payement.php' />";
}
else
{
    echo "[DEBUG]Ce moyen existe deja, aucune modification apporte.</br>";
    //Renvoie à la page de gestion des Lieux
    echo "<meta http-equiv='refresh' content='1; url=http://geco.ab/view/phtml/gst_payement.php' />";
}
?>
