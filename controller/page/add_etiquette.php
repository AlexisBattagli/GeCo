<?php

/*
 * Script d'ajout d'une Etiquette
 * Appelé par le formulaire d'ajout d'Etiquette de la page add_etiquette
 * 
 * Ajout une etiquette en base et renvoie sur la page /view/phtml/add_etiquette.
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EtiquetteDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Etiquette.php');

//Création d'une Etiquette par défaut
$newEtiquette = new Etiquette();

//======Vérification de ce qui est renvoyé par le formulaire de /view/phtml/gst_etiquette====/
$validLabel = filter_input(INPUT_POST, 'label', FILTER_SANITIZE_STRING);
if ($validLabel != null)
{
    $newEtiquette->setLabel($validLabel);
}

$validDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
if ($validDescription != null)
{
    $newEtiquette->setDescription($validDescription);
}

//====Vérification de doublons de l'Etiquette selon le label=====/
if ($newEtiquette->isUnique() != 0)
{
    
//====Insertion=====/
    $validInsertEtiquette = EtiquetteDAL::insertOnDuplicate($newEtiquette);
    
    if($validInsertEtiquette != null)
    {
        echo "Ajout de l'Etiquette reussi ! (id: ". $validInsertEtiquette . ")";
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
    echo "Erreur, l'Etiquette que vous voulez ajouter existe déjà...";
}

?>