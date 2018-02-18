<?php
/*
 * Script de suppression d'un Sous-Objet
 * Appelé par le lien de suppression de Sous-Objet de la page gst_sousobjet
 * Transfert via l'URL et GET l'id du Sous-Objet à supprimer
 *
 * Supprime un payement en base et renvoie sur la page /view/phtml/gst_sousobjet.
 *
 * @author Alexis BATTAGLI
 * @version 0.1
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/SousObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/SousObjet.php');

//=====Vérification de ce qui est renvoyé par l'URL en GET===/
$validId = filter_input(INPUT_GET, 'idSousObjet', FILTER_SANITIZE_STRING);
if ($validId != null)
{
	echo "Validation de l'ID --> OK </br>";

	//converie l'id envoyer par l'url (string), en id exploitable (int)
	$validId = (int) $validId;
	if (is_int($validId))
	{
		echo "[INFO]Cast de l'ID en int --> OK </br>";
		echo "[INFO]valeur d'ID transmise: " . $validId . "</br>";
		echo "[INFO]Suppression du Sous-Objet en Cours. </br>";
		SousObjetDAL::delete($validId);

		echo "[INFO]Verification du success de la suppression. </br>";
		$isDead = new SousObjet();
		$isDead = SousObjetDAL::findById($validId);
		if (is_null($isDead) || $isDead->getId()==-1)
		{
			echo "[INFO]Suppression reussi --> OK </br>";
			//Renvoie à la page précédante
			echo "<meta http-equiv='refresh' content='1; url=" . $_SERVER["HTTP_REFERER"] . "' />";
		}
		else
		{
			echo "[DEBUG]Echec de la suppression...</br>";
			echo "[DEBUG]La recherche par id apres lancement de suppression a trouver le sous-objet suivant </br>";
			echo $isDead->getId();
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

?>