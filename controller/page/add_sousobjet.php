<?php

/*
 * Script d'ajout d'un Sous-Objet
 * Appelé par le formulaire d'ajout de Sous-Objet de la page add_sousobjet
 * 
 * Ajout un objet en base et renvoie sur la page /view/phtml/gst_sousobjet.
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/SousObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/SousObjet.php');

//Création d'un Objet par défaut
$newSousObjet = new SousObjet();

//======Vérification de ce qui est renvoyé par le formulaire de /view/phtml/gst_objet====/
$validLabel = filter_input(INPUT_POST, 'label', FILTER_SANITIZE_STRING);
if ($validLabel != null)
{
    $newSousObjet->setLabel($validLabel);
}

$validDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
if ($validDescription != null)
{
    $newSousObjet->setDescription($validDescription);
}

$validId = filter_input(INPUT_POST, 'objet_id', FILTER_SANITIZE_STRING);
if ($validId != null)
{
    echo "[DEBUG]L'ID est OK.</br>";
    $validId = (int) $validId;
    if (is_int($validId))
    {
        echo "[DEBUG]L'ID de l'objet a bien ete caste en int (". $validId .") --> OK</br>";
        $newSousObjet->setObjet($validId);
    }
    else
    {
        echo "[DEBUG]Erreur, l'ID n'a pas été casté en int...</br>";
    }
}
else
{
    echo "[DEBUG]L'ID renseigne est errone...</br>";
    echo "[WARN]L'ID est: " . $validId . "</br>";
}

//====Vérification de doublons de SousObjet selon le couple (label;objetid)=====/
if ($newSousObjet->isUnique() != 0)
{
    
//====Insertion=====/
    $validInsertSousObjet = SousObjetDAL::insertOnDuplicate($newSousObjet);
    
    if($validInsertSousObjet != null)
    {
        echo "Ajout du Sous-Objet reussi ! (id: ". $validInsertSousObjet . ")";
    }
    else
    {
        echo "insert echec...";
    }
    
    //Renvoie à la page précédante
    echo "<meta http-equiv='refresh' content='1; url=".$_SERVER["HTTP_REFERER"]. "' />";
}
else
{
    echo "Erreur, le Sous-Objet ".$newSousObjet->getLabel()." pour l'Objet ".$newSousObjet->getObjet()->getLabel()." que vous voulez ajouter existe déjà...";
}

?>
