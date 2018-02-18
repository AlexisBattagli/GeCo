<?php

/*
 * Script de suppression d'un Objet
 * Appelé par le lien de suppression d'Objet de la page gst_objet
 * Transfert via l'URL e GET l'id de l'Objet à supprimer
 * 
 * Supprime un Objet en base et renvoie sur la page /view/phtml/gst_objet.
 * 
 * @author Alexis BATTAGLI
 * @version 0.1
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Objet.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/BudgetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Budget.php');

//=====Vérification de ce qui est renvoyé par l'URL en GET===/
$validId = filter_input(INPUT_GET, 'idObjet', FILTER_SANITIZE_STRING);
if ($validId != null)
{
    echo "Validation de l'ID --> OK </br>";
    //converie l'id envoyer par l'url (string), en id exploitable (int)
    $validId = (int) $validId;
    if (is_int($validId))
    {
        echo "Cast de l'ID en int --> OK </br>";
        echo "Valeur d'ID transmise: " . $validId . "</br>";

        echo "Recherche l'existance d'un Budget pour l'année prochaine lié à cet Objet.</br>";
        $budgetLie = BudgetDAL::findNextByObjet($validId);
        if(!is_null($budgetLie)){
        	echo "Le budget d'ID ".$budgetLie->getId()." a été trouvé pour cet Objet. Suppression en cours de ce Budget...</br>";
        	BudgetDAL::delete($budgetLie->getId());
        }
        
        echo "Suppression de l'Objet en Cours. </br>";
        ObjetDAL::delete($validId);

        echo "Verification du success de la suppression. </br>";
        $isDead = new Objet();
        $isDead = ObjetDAL::findById($validId);
        if (is_null($isDead) || $isDead->getId()==-1)
        {
            echo "Suppression reussi --> OK </br>";
            //Renvoie à la page précédante
            echo "<meta http-equiv='refresh' content='1; url=" . $_SERVER["HTTP_REFERER"] . "' />";
        }
        else
        {
            echo "Echec de la suppression...</br>";
            echo "La recherche par id apres lancement de suppression a trouver l'Objet suivant </br>";
            echo $isDead->getId();
        }
    }
    else
    {
        echo "L'ID n'a pas été casté en int et est toujours en string... </br>";
        echo "(valeur transmise: " . $validId . " )";
    }
}
else
{
    echo "Aucun ID correct renseigné dans ce lien... </br>";
    echo "(valeur transmise: " . $validId . " )";
}

?>