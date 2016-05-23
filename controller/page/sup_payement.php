<?php

/*
 * Script de suppression d'un Payement
 * Appelé par le lien de suppression de Payement de la page gst_payement
 * Transfert via l'URL et GET l'id du Payement à supprimer
 * 
 * Supprime un payement en base et renvoie sur la page /view/phtml/gst_lieux.
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/PayementDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Payement.php');

//=====Vérification de ce qui est renvoyé par l'URL en GET===/
$validId = filter_input(INPUT_GET, 'idPayement', FILTER_SANITIZE_STRING);
if ($validId != null)
{
    echo "Validation de l'ID --> OK </br>";

    //converie l'id envoyer par l'url (string), en id exploitable (int)
    $validId = (int) $validId;
    if (is_int($validId))
    {
        echo "[INFO]Cast de l'ID en int --> OK </br>";
        echo "[INFO]valeur d'ID transmise: " . $validId . "</br>";
        echo "[INFO]Suppression du Lieu en Cours. </br>";
        PayementDAL::delete($validId);

        echo "[INFO]Verification du success de la suppression. </br>";
        $isDead = new Payement();
        $isDead = PayementDAL::findById($validId);
        if (is_null($isDead))
        {
            echo "[INFO]Suppression reussi --> OK </br>";
            //Renvoie à la page précédante
            echo "<meta http-equiv='refresh' content='1; url=" . $_SERVER["HTTP_REFERER"] . "' />";
        }
        else
        {
            echo "[DEBUG]Echec de la suppression...</br>";
            echo "[DEBUG]La recherche par id apres lancement de suppression a trouver le moyen de payement suivant </br>";
            echo $isDead;
        }
    }
    else
    {
        echo "[DEBUG]L'ID n'a pas ete caste en int et est toujours en string... </br>";
        echo "[DEBUG]valeur transmise: " . $validId . " )";
    }
}
else
{
    echo "[DEBUG]Aucun ID correct renseigné dans ce lien... </br>";
    echo "(valeur transmise: " . $validId . " )";
}