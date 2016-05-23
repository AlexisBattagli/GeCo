<?php

/*
 * Script d'ajout d'un Moyen de Payement
 * Appelé par le formulaire d'ajout de Payement de la page add_payement
 * 
 * Ajout un moyen de payement en base et renvoie sur la page /view/phtml/add_payement.
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/PayementDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Payement.php');

//Création d'un Payement par défaut
$newPayement = new Payement();

//=====Vérification de ce qui est renvoyé par le formulaire de /view/phtml/gst_lieux====/
$validMoyen = filter_input(INPUT_POST, 'moyen', FILTER_SANITIZE_STRING);
if ($validMoyen != null)
{
    $newPayement->setMoyen($validMoyen);
}

//====Vérification de doublons du moyen de payement selon le moyen====
if ($newPayement->isUnique() != 0)
{

//=====Insertion=====/
    //echo "[DEBUG]moyen: " . $newPayement->getMoyen(); OK
    $validInsertPayement = PayementDAL::insertOnDuplicate($newPayement);

    if ($validInsertPayement != null)
    {
        echo "Ajout du Payement reussi ! (id:" . $validInsertPayement . ")";
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
    echo "Erreur, le Moyen de Payement que vous voulez ajouter existe déjà...";
}


