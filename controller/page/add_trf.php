<?php

/*
 * Script d'ajout d'un Transfert d'argent
 * Appelé par le formulaire d'ajout de Transfert de la page /view/phtml/add_trf.php
 *
 * Ajout une entrée ou sortie en base et renvoie sur la page /view/phtml/add_trf.php.
 *
 * @author Alexis BATTAGLI
 * @date 21 Février 2017
 * @version 0.1
 */

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/class/EntreeSortie.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/DAL/CompteDAL.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/class/Compte.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/DAL/SoldeDAL.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/class/Solde.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/class/SousObjet.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/model/class/Etiquette.php');

// Attribut par défaut, non utilisé pour un transfert d'argent
$defaultSousObjet = new SousObjet();
$defaultSousObjet->setId(0);
$defaultEtiquette = new Etiquette();
$defaultEtiquette->setId(0);

// Création des deux ES, in et out.
$newTrfIn = new EntreeSortie(); // Entrée d'argent pour le compte crédité
$newTrfIn->setEs('E');
$newTrfIn->setSousObjet($defaultSousObjet);
$newTrfIn->setEtiquette($defaultEtiquette);

$newTrfOut = new EntreeSortie(); // Sortie d'argent pour le compte débité
$newTrfOut->setEs('S');
$newTrfOut->setSousObjet($defaultSousObjet);
$newTrfOut->setEtiquette($defaultEtiquette);

// ======Vérification de ce qui est renvoyé par le formulaire de /view/phtml/add_trf.php====/
echo "[DEBUG] Vérifie la date reçu</br>";
$validDate = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
if ($validDate != null) {
	echo "[DEBUG] Le champ date est ok et vaut :" . $validDate . "</br>";
	$newTrfIn->setDate($validDate);
	$newTrfOut->setDate($validDate);
}

echo "[DEBUG] vérifie la valeur reçu</br>";
$validValeur = filter_input(INPUT_POST, 'valeur', FILTER_SANITIZE_STRING);
if ($validValeur != null) {
	echo "[DEBUG] Le champ valeur est ok et vaut :" . $validValeur . "</br>";
	echo "[DEBUG] Cast la valeur en double.</br>";
	$validValeur = (double)$validValeur;
	$newTrfIn->setValeur($validValeur);
	$newTrfOut->setValeur($validValeur);
}

echo "[DEBUG] vérifie l'id du lieu reçu</br>";
$validLieu = filter_input(INPUT_POST, 'lieu_id', FILTER_SANITIZE_STRING);
if ($validLieu != null) {
	echo "[DEBUG] Le champ lieu_id est ok et vaut :" . $validLieu . "</br>";
	$newTrfIn->setLieu($validLieu);
	$newTrfOut->setLieu($validLieu);
}

echo "[DEBUG] Vérifie le label de l'objet</br>";
$validObjet = filter_input(INPUT_POST, 'objet', FILTER_SANITIZE_STRING);
if ($validObjet != null) {
	echo "[DEBUG] Le champ objet est ok et vaut :" . $validObjet . "</br>";
	if ($validObjet == 'Transfert') {
		echo "[DEBUG] Recherche l'objet de label 'Transfert' en base...</br>";
		$validTrfObjet = ObjetDAL::findByLabel($validObjet);
		if ($validTrfObjet != null) {
			echo "[DEBUG] L'objet Transfert a été correctement trouvé.</br>";
			$newTrfIn->setObjet($validTrfObjet);
			$newTrfOut->setObjet($validTrfObjet);
		} else {
			echo "[DEBUG] L'objet de label 'Transfert' n'existe pas en base, création en cours...</br>";
			$ObjetTrf = new Objet();
			$ObjetTrf->setLabel('Transfert');
			$ObjetTrf->setDescription("Objet réservé au flux d'argent de type Transfert.");
			
			$Trf = ObjetDAL::insertOnDuplicate($ObjetTrf);
			echo "[DEBUG] L'objet Transfert a été correctement créée en base.</br>";
			$newTrfIn->setObjet($Trf);
			$newTrfOut->setObjet($Trf);
		}
	} else {
		echo "[ERROR] L'objet n'a pas le label 'Transfert' attendu !</br>";
	}
}

echo "[DEBUG] vérifie l'id du compte débité reçu</br>";
$validCompteDeb = filter_input(INPUT_POST, 'compte_deb_id', FILTER_SANITIZE_STRING);
if ($validCompteDeb != null) {
	echo "[DEBUG] Le champ compte_deb_id est ok et vaut :" . $validCompteDeb . "</br>";
	$newTrfOut->setCompte($validCompteDeb);
}
echo "[DEBUG] vérifie l'id du compte crédité reçu</br>";
$validCompteCred = filter_input(INPUT_POST, 'compte_cred_id', FILTER_SANITIZE_STRING);
if ($validCompteCred != null) {
	echo "[DEBUG] Le champ compte_cred_id est ok et vaut :" . $validCompteCred . "</br>";
	$newTrfIn->setCompte($validCompteCred);
}

echo "[DEBUG] vérifie l'id du moyen de payement de débit reçu</br>";
$validPayementDeb = filter_input(INPUT_POST, 'payement_deb_id', FILTER_SANITIZE_STRING);
if ($validPayementDeb != null) {
	echo "[DEBUG] Le champ payement_deb_id est ok et vaut :" . $validPayementDeb . "</br>";
	$newTrfOut->setPayement($validPayementDeb);
}
echo "[DEBUG] vérifie l'id du moyen de payement de crédit reçu</br>";
$validPayementCred = filter_input(INPUT_POST, 'payement_cred_id', FILTER_SANITIZE_STRING);
if ($validPayementCred != null) {
	echo "[DEBUG] Le champ payement_cred_id est ok et vaut :" . $validPayementCred . "</br>";
	$newTrfIn->setPayement($validPayementCred);
}

$compteCred = CompteDAL::findById($validCompteCred);
$compteDeb = CompteDAL::findById($validCompteDeb);
$desc = "Transfert d'argent depuis le compte " . $compteDeb->getLabel() . " vers le compte " . $compteCred->getLabel() . ".";
echo "[DEBUG] Ajout la description suivante aux ES: '" . $desc . "'.</br>";
$newTrfIn->setInformation($desc);
$newTrfOut->setInformation($desc);

// est-ce que la date est inférieur ou égale à now ?
$mois = $newTrfIn->getMois();
$annee = $newTrfIn->getAnnee();
echo "[DEBUG] Le transfert a eu lieu le " . $mois . "/" . $annee . ".</br>";
if ($annee < date('Y') || ($mois <= date('m') && $annee == date('Y'))) { // Si l'es est dans le présent ou passé
	
	if (SoldeDAL::isYounger($validCompteDeb, $validDate) == 1 && SoldeDAL::isYounger($validCompteCred, $validDate) == 1) { // Si la date est supérieur ou égale au plus vieux solde des comptes Deb et Cred
	                                                                                                                       
		// =====Insertion de l'ES dans la table entree_sortie=====//
		echo "[DEBUG] Création de l'entrée et la sortie relatives au Transfert.</br>";
		$validInsertIn = EntreeSortieDAL::insertOnDuplicate($newTrfIn);
		$validInsertOut = EntreeSortieDAL::insertOnDuplicate($newTrfOut);
		echo "[DEBUG] Entrée et Sortie lié au Transfert, correctement créées (id Entrée: " . $validInsertIn . "; id Sortie: " . $validInsertOut . ").</br>";
		
		$addedIn = EntreeSortieDAL::findById($validInsertIn);
		$addedOut = EntreeSortieDAL::findById($validInsertOut);
		if ($addedIn != null && $addedOut != null) {
			
			// =====Solde du compte débité=====//
			$soldeDeb = SoldeDAL::findByDate($mois, $annee, $validCompteDeb);
			if ($soldeDeb != null) {
				echo "[DEBUG] Il y a déjà un solde à la date indiquée pour ce compte.</br>";
				echo "[DEBUG] Mise à jour du solde d'id: " . $soldeDeb->getId() . "</br>";
			} else {
				echo "[DEBUG] Il n'y a pas de solde à la date indiquée pour ce compte.</br>";
				$soldeDeb = SoldeDAL::findOldLast($validDate, $validCompteDeb);
				$soldeDeb->setId(-1); // réinitialise l'id pour que l'on créer bien un nouveau solde
				echo "[DEBUG] Création d'un solde pour ce compte à la date indiquée.</br>";
			}
			$soldeDeb->setDate($addedOut->getDate());
			SoldeDAL::insertOnDuplicate($soldeDeb);
			
			// =====Solde du compte crédité=====//
			$soldeCred = SoldeDAL::findByDate($mois, $annee, $validCompteCred);
			if ($soldeCred != null) {
				echo "[DEBUG] Il y a déjà un solde à la date indiquée pour ce compte.</br>";
				echo "[DEBUG] Mise à jour du solde d'id: " . $soldeCred->getId() . ".</br>";
			} else {
				echo "[DEBUG] Il n'y a pas de solde à la date indiquée pour ce compte.</br>";
				$soldeCred = SoldeDAL::findOldLast($validDate, $validCompteCred);
				$soldeCred->setId(-1); // réinitialise l'id pour que l'on créer bien un nouveau solde
				echo "[DEBUG] Création d'un solde pour ce compte à la date indiquée.</br>";
			}
			$soldeCred->setDate($addedIn->getDate());
			SoldeDAL::insertOnDuplicate($soldeCred);
			
			// ====Met à jour les Soldes du compte débité, entre la date indiqué et maintenant=====//
			$soldesDeb = SoldeDAL::findByIntervalDate($validDate, $validCompteDeb);
			foreach ($soldesDeb as $solde) :
				echo "[DEBUG] Solde du " . $solde->getDate() . "</br>";
				echo "[DEBUG] Le solde était de " . $solde->getValeur() . "</br>";
				$solde->setValeur($solde->getValeur() + $addedOut->getValeur()); // calcul le nouveau solde
				echo "[DEBUG] Le nouveau solde est de " . $solde->getValeur() . "</br>";
				SoldeDAL::insertOnDuplicate($solde); // met à jour le solde
			endforeach;
			
			// ====Met à jour les Soldes du compte crédité, entre la date indiqué et maintenant=====//
			$soldesCred = SoldeDAL::findByIntervalDate($validDate, $validCompteCred);
			foreach ($soldesCred as $solde) :
				echo "[DEBUG] Solde du " . $solde->getDate() . "</br>";
				echo "[DEBUG] Le solde était de " . $solde->getValeur() . "</br>";
				$solde->setValeur($solde->getValeur() + $addedOut->getValeur()); // calcul le nouveau solde
				echo "[DEBUG] Le nouveau solde est de " . $solde->getValeur() . "</br>";
				SoldeDAL::insertOnDuplicate($solde); // met à jour le solde
			endforeach;
		} else {
			echo "[ERROR] L'entrée ou la sortie liée au Transfert n'a pas été ajouté en base.</br>";
		}
	} else { // sinon il n'y a pas de solde pour ce compte antérieur à la date indiquée pour cette ES
		echo "[ERROR] Il n'y a pas de solde pour l'un des comptes avant la date ou à la date indiquée...</br>";
	}
} else { // sinon elle est dans le futur... pas possible
	echo "[ERROR] La date de l'ES est dans le futur... Impossible de mettre à jour le solde.</br>";
}

?>