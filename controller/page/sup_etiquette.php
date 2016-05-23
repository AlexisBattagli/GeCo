<?php

/*
 * Script de suppression d'une Etiquette
 * Appelé par le lien de suppression de Etiquette de la page gst_etiquette
 * Transfert via l'URL en GET l'id de l'Etiquette à supprimer
 * 
 * Supprime une etiquette en base et renvoie sur la page /view/phtml/gst_etiquette.
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EtiquetteDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Etiquette.php');

//=====Vérification de ce qui est renvoyé par l'URL en GET===/
$validId = filter_input(INPUT_GET, 'idEtiquette', FILTER_SANITIZE_STRING);
if ($validId != null)
{
    
    echo "Validation de l'ID --> OK </br>";

    //converie l'id envoyer par l'url (string), en id exploitable (int)
    $validId = (int) $validId;
    if (is_int($validId))
    {
        echo "Cast de l'ID en int --> OK </br>";
        echo "valeur d'ID transmise: " . $validId . "</br>";
        echo "Suppression de l'Etiquette en Cours. </br>";
        EtiquetteDAL::delete($validId);
        
        echo "Verification du success de la suppression. </br>";
        $isDead = new Etiquette();
        $isDead = EtiquetteDAL::findById($validId);
        if (is_null($isDead))
        {
            echo "Suppression reussi --> OK </br>";
            //Renvoie à la page précédante
            echo "<meta http-equiv='refresh' content='1; url=" . $_SERVER["HTTP_REFERER"] . "' />";
        }
        else
        {
            echo "Echec de la suppression...</br>";
            echo "La recherche par id apres lancement de suppression a trouver l'etiquette suivants </br>";
            echo $isDead;
        }
    }
    else
    {
        echo "L'ID n'a pas ete caste en int et est toujours en string... </br>";
        echo "(valeur transmise: " . $validId . " )";
    }
}
else
{
    echo "Aucun ID correct renseigné dans ce lien... </br>";
    echo "(valeur transmise: " . $validId . " )";
}
    
?>

