<?php

/*
 * Script d'ajout d'un Compte
 * Appelé par le formulaire d'ajout de Compte de la page add_lieux
 * 
 * Ajout un lieu en base et renvoie sur la page /view/phtml/add_lieux.
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/CompteDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Compte.php');

//Création d'un Compte par défaut
$newCompte = new Compte();

//Création d'un Solde par défaut
$newSolde = new Solde();

//=====Vérification de ce qui est renvoyé par le formulaire de /view/phtml/gst_compte====/
$validLabel = filter_input(INPUT_POST, 'label', FILTER_SANITIZE_STRING);
if ($validLabel != null)
{
    echo "[INFO]Label: " . $validLabel . "</br>";
    $newCompte->setLabel($validLabel);
}
else
{
    echo "[DEBUG]Le label indiquer n'est pas de type string...</br>";
}

$validBanque = filter_input(INPUT_POST, 'banque', FILTER_SANITIZE_STRING);
if ($validBanque != null)
{
    echo "[INFO]Banque: " . $validBanque . "</br>";
    $newCompte->setBanque($validBanque);
}
else
{
    echo "[DEBUG]Le nom de banque indiquer n'est pas de type string...</br>";
}

$validInformation = filter_input(INPUT_POST, 'information', FILTER_SANITIZE_STRING);
if ($validInformation != null)
{
    echo "[INFO]Informations: " . $validInformation . "</br>";
    $newCompte->setInformation($validInformation);
}
else
{
    echo "[DEBUG]Les informations indiquees ne sont pas de type string...</br>";
}

$validIdentifiant = filter_input(INPUT_POST, 'identifiant', FILTER_SANITIZE_STRING);
if ($validIdentifiant != null)
{
    echo "[INFO]Identifiant: " . $validIdentifiant . "</br>";
    $newCompte->setIdentifiant($validIdentifiant);
}
else
{
    echo "[DEBUG]L'identifiant indique n'est pas de type string...</br>";
}

$validSolde = filter_input(INPUT_POST, 'solde', FILTER_SANITIZE_STRING);
if ($validSolde != null)
{
    $validSolde = (double) $validSolde;
    echo "[INFO]Solde: " . $validSolde . "</br>";
    $newSolde->setValeur($validSolde);
}
else
{
    echo "[DEBUG]Le solde indique n'est pas de type string...</br>";
}

//=====Vérification des doublons de Compte selon (label,banque)===/
if ($newCompte->isUnique() != 0)
{
    //====INSERTION COMPTE====/
    $validInsertCompte = CompteDAL::insertOnDuplicate($newCompte);
    if ($validInsertCompte != null)
    {

        $compteId = $validInsertCompte;
        echo "[INFO]Ajout du Compte reussi ! (id:" . $compteId . ")</br>";

        //===INSERTION SOLDE===/
        $newCompte = CompteDAL::findById($compteId);
        $newSolde->setCompte($newCompte);
        $validInsertSolde = SoldeDAL::insertOnDuplicate($newSolde);
        if ($validInsertSolde !== null)
        {
            $soldeId = $validInsertSolde;
            echo "[INFO]Ajout du Solde reussi ! (id:" . $soldeId . ")</br>";
            //Renvoie à la page précédante
            echo "<meta http-equiv='refresh' content='1; url=" . $_SERVER["HTTP_REFERER"] . "' />";
        }
        else
        {
            echo "[DEBUG]Insert du Solde associe echec...</br>";
        }
    }
    else
    {
        echo "[DEBUG]Insert du Compte echec...</br>";
    }
}
else
{
    echo "[WARN] Erreur, le Compte que vous voulez ajouter existe déjà...";
}