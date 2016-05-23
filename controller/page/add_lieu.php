<?php

/*
 * Script d'ajout d'un Lieu
 * Appelé par le formulaire d'ajout de Lieux de la page add_lieux
 * 
 * Ajout un lieu en base et renvoie sur la page /view/phtml/add_lieux.
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/LieuDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Lieu.php');

//Création d'un Lieu par défaut
$newLieu = new Lieu();

//=====Vérification de ce qui est renvoyé par le formulaire de /view/phtml/gst_lieux====/
$validPays = filter_input(INPUT_POST, 'pays', FILTER_SANITIZE_STRING);
if ($validPays != null)
{
    $newLieu->setPays($validPays);
}

$validVille = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_STRING);
if ($validVille != null)
{
    $newLieu->setVille($validVille);
}

//====Vérification de doublons du Lieu selon le couple (ville;pays)====
if ($newLieu->isUnique() != 0)
{

//=====Insertion=====/
    $validInsertLieu = LieuDAL::insertOnDuplicate($newLieu);

    if ($validInsertLieu != null)
    {
        echo "Ajout du Lieu reussi ! (id:" . $validInsertLieu . ")";
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
    echo "Erreur, le Lieu que vous voulez ajouter existe déjà...";
}