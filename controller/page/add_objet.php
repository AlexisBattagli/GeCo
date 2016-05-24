<?php

/*
 * Script d'ajout d'un Objet
 * Appelé par le formulaire d'ajout d'Objet de la page add_objet
 * 
 * Ajout un objet en base et renvoie sur la page /view/phtml/gst_objet.
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Objet.php');

//Création d'un Objet par défaut
$newObjet = new Objet();

//======Vérification de ce qui est renvoyé par le formulaire de /view/phtml/gst_objet====/
$validLabel = filter_input(INPUT_POST, 'label', FILTER_SANITIZE_STRING);
if ($validLabel != null)
{
    $newObjet->setLabel($validLabel);
}

$validDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
if ($validDescription != null)
{
    $newObjet->setDescription($validDescription);
}

//====Vérification de doublons de l'Objet selon le label=====/
if ($newObjet->isUnique() != 0)
{
    
//====Insertion=====/
    $validInsertObjet = ObjetDAL::insertOnDuplicate($newObjet);
    
    if($validInsertObjet != null)
    {
        echo "Ajout de l'Objet reussi ! (id: ". $validInsertObjet . ")";
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
    echo "Erreur, l'Objet que vous voulez ajouter existe déjà...";
}
?>
