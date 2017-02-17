<?php

/*
* Script d'ajout d'une ENtrée ou Sortie d'argent
* Appelé par le formulaire d'ajout d'Entrée et Sortie de la page /view/phtml/add_es.php
*
* Ajout une entrée ou sortie en base et renvoie sur la page /view/phtml/add_es.php.
*
* @author Alexis BATTAGLI
* @date 8 Février 2017
* @version 0.1
*/

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EntreeSortieDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/EntreeSortie.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/CompteDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Compte.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/SoldeDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Solde.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/SousObjet.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Etiquette.php');

//Création d'une ES par défaut
$newES = new EntreeSortie();

//======Vérification de ce qui est renvoyé par le formulaire de /view/phtml/add_es====/
echo "[DEBUG] Vérifie la date reçu</br>";
$validDate = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
if ($validDate != null)
{
	echo "[DEBUG] Le champ date est ok et vaut :".$validDate."</br>";
	$newES->setDate($validDate);
}

echo "[DEBUG] vérifie l'es reçu</br>";
$validES = filter_input(INPUT_POST, 'es', FILTER_SANITIZE_STRING);
if ($validES != null)
{
	echo "[DEBUG] Le champ es est ok et vaut :".$validES."</br>";
	$newES->setEs($validES);
}

echo "[DEBUG] vérifie la valeur reçu</br>";
$validValeur = filter_input(INPUT_POST, 'valeur', FILTER_SANITIZE_STRING);
if($validValeur != null)
{
	echo "[DEBUG] Le champ valeur est ok et vaut :".$validValeur."</br>";
	echo "[DEBUG] Cast la valeur en double.</br>";
	$validValeur = (double) $validValeur;
	$newES->setValeur($validValeur);
}

echo "[DEBUG] vérifie l'id du lieu reçu</br>";
$validLieu = filter_input(INPUT_POST, 'lieu_id', FILTER_SANITIZE_STRING);
if($validLieu != null)
{
	echo "[DEBUG] Le champ lieu_id est ok et vaut :".$validLieu."</br>";
	$newES->setLieu($validLieu);
}

echo "[DEBUG] vérifie l'id de l'objet reçu</br>";
$validObjet = filter_input(INPUT_POST, 'objet_id', FILTER_SANITIZE_STRING);
if($validObjet != null)
{
	echo "[DEBUG] Le champ objet_id est ok et vaut :".$validObjet."</br>";
	$newES->setObjet($validObjet);
}

echo "[DEBUG] vérifie l'id du sous-objet reçu</br>";
$validSousObjet = filter_input(INPUT_POST, 'sousobjet_id', FILTER_SANITIZE_STRING);
if($validSousObjet != null)
{
	echo "[DEBUG] Le champ sousobjet_id est ok et vaut :".$validSousObjet."</br>";
	if($validSousObjet != "0"){
		$newES->setSousObjet($validSousObjet);
	}else{
		$defaultSousObjet = new SousObjet();
		$defaultSousObjet->setId(0);
		$newES->setSousObjet($defaultSousObjet);
	}
}

echo "[DEBUG] vérifie l'id du compte reçu</br>";
$validCompte = filter_input(INPUT_POST, 'compte_id', FILTER_SANITIZE_STRING);
if($validCompte != null)
{
	echo "[DEBUG] Le champ compte_id est ok et vaut :".$validCompte."</br>";
	$newES->setCompte($validCompte);
}

echo "[DEBUG] vérifie l'id du moyen de payement reçu</br>";
$validPayement = filter_input(INPUT_POST, 'payement_id', FILTER_SANITIZE_STRING);
if($validPayement != null)
{
	echo "[DEBUG] Le champ payement_id est ok et vaut :".$validPayement."</br>";
	$newES->setPayement($validPayement);
}

echo "[DEBUG] vérifie la description reçu</br>";
$validInfo = filter_input(INPUT_POST, 'information', FILTER_SANITIZE_STRING);
if($validInfo != null)
{
	echo "[DEBUG] Le champ information est ok et vaut :".$validInfo."</br>";
	$newES->setInformation($validInfo);
}

echo "[DEBUG] vérifie l'id de l'etiquette reçu</br>";
$validEtiquette = filter_input(INPUT_POST, 'etiquette_id', FILTER_SANITIZE_STRING);
if($validEtiquette != null)
{
	echo "[DEBUG] Le champ etiquette_id est ok et vaut :".$validEtiquette."</br>";
	if($validEtiquette != "0"){
		$newES->setEtiquette($validEtiquette);
	}else {
		$defaultEtiquette = new Etiquette();
		$defaultEtiquette->setId(0);
		$newES->setEtiquette($defaultEtiquette);
	}
}

//est-ce que la date est inférieur ou égale à now ?
$mois = $newES->getMois();
$annee = $newES->getAnnee();
echo "[DEBUG] L'es a eu lieu au mois ".$mois." de l'année ".$annee.".</br>";
if($annee<date('Y') || ($mois<=date('m') && $annee==date('Y'))){ //Si l'es est dans le présent ou passé
	
	if(SoldeDAL::isYounger($validCompte, $validDate)==1){ // Si la date est supérieur ou égale au plus vieux solde de ce compte
	
		//=====Insertion de l'ES dans la table entree_sortie=====//
		$validInsertES = EntreeSortieDAL::insertOnDuplicate($newES);
		if ($validInsertES != null) //L'ES a bien été ajoutée en base 
		{
			echo "[DEBUG] Succés de l'insertion pour l'es d'id :".$validInsertES."</br>";
			//=====Change le(s) solde(s) du compte=====//
			$addedES = EntreeSortieDAL::findById($validInsertES); 
	
			if($addedES->getEs()=='S'){
				$validValeur = 0 - $validValeur;
			}
			echo "[DEBUG] Le flux d'argent est de ".$validValeur." €.</br>";
		
			if(date('m')==$mois && date('Y')==$annee){ //si l'ES à eu lieu ce mois-ci
				$soldeCurrent = SoldeDAL::findByDate($mois, $annee, $validCompte);
				if($soldeCurrent != null){ //S'il y a déjà un solde ce mois-ci
					echo "[DEBUG] Il y a un solde trouvé ce mois-ci pour le compte".$validCompte.".</br>";
					echo "[DEBUG] L'ancien solde de ce compte est ".$soldeCurrent->getValeur().".</br>";
					$soldeCurrent->setValeur($soldeCurrent->getValeur() + $validValeur); //met à jour la valeur du solde de ce mois-ci
					echo "[DEBUG] Le nouveau solde est ".$soldeCurrent->getValeur()."</br>";
					SoldeDAL::insertOnDuplicate($soldeCurrent); //met à jour le solde de ce mois-ci avec sa new value
					echo "[DEBUG] Mise à jour du solde de ce mois-ci ok !";
				}else{ //Si le solde n'existe pas pour ce mois, alors le créer
					echo "[DEBUG] Il n'y a pas de solde trouvé ce mois-ci pour le compte ".$validCompte."</br>";
					$newSolde = new Solde();
					echo "[DEBUG] Récupère le solde du compte ".$validCompte." le plus récent.</br>";
					$lastSolde = SoldeDAL::findLast($validCompte); //récupère le solde le plus récent (il y en aura toujours un au minimum)
					echo "[DEBUG] Le solde le plus récent enregistré pour ce compte est de ".$lastSolde->getValeur()."</br>";
					$newSolde->setCompte($validCompte);
					$newSolde->setValeur($lastSolde->getValeur() + $validValeur);
					echo "[DEBUG] Le nouveau solde pour se compte est ".$newSolde->getValeur()."</br>";
					SoldeDAL::insertOnDuplicate($newSolde); //crée un solde pour ce mois-ci
					echo "[DEBUG] Nouveau solde de ".$newSolde->getValeur()." pour le compte ".$newSolde->getCompte()." pour ce mois-ci créer avec succés !";
				}
			}else if(($mois<date('m') && date('Y')==$annee) || $annee<date('Y')){ //si l'es est antérieur au mois actuel
				//Vérifie s'il y a un solde pour ce mois/année là
				$soldeCurrent = SoldeDAL::findByDate($mois, $annee, $validCompte);
				if($soldeCurrent == null){ //s'il n'existe pas, le créer avec la valeur du solde le précédant, il ser amis à jour après.
					echo "[DEBUG] Il n'y a pas de solde trouvé en ".$mois."/".$annee." pour le compte ".$validCompte."</br>";
					$newSolde = new Solde();
					echo "[DEBUG] Récupère le solde du compte ".$validCompte." le plus récent.</br>";
					$oldSolde = SoldeDAL::findOldLast($validDate, $validCompte);
					echo "[DEBUG] Le solde le plus récent enregistré pour ce compte est de ".$oldSolde->getValeur()."</br>";
					$newSolde->setCompte($validCompte);
					$newSolde->setValeur($oldSolde->getValeur());
					echo "[DEBUG] Création d'un solde pour le compte ".$validCompte.", à la date du ".$mois."/".$annee.".</br>";
					$idNewSolde = SoldeDAL::insertOnDuplicate($newSolde);
					$solde = SoldeDAL::findById($idNewSolde);
					$solde->setDate($validDate);
					SoldeDAL::insertOnDuplicate($solde);
				}
				
				$soldes = SoldeDAL::findByIntervalDate($validDate, $validCompte); //récupèrer tous les solde compris entre le mois/annee de la date de l'es et maintenant.
				foreach ($soldes as $solde): //parcours les solde passé de ce compte, il y a toujours au moins 1, le tout premier !
					echo "[DEBUG] Solde du ".$solde->getDate()."</br>";
					echo "[DEBUG] Le solde était de ".$solde->getValeur()."</br>";
					$oldSoldValeur =$solde->getValeur();
					$solde->setValeur($oldSoldValeur + $validValeur); //calcul le nouveau solde
					echo "[DEBUG] Le nouveau solde est de ".$solde->getValeur()."</br>";
					SoldeDAL::insertOnDuplicate($solde); //met à jour le solde
				endforeach;
			}
		}else{ //L'insertion de l'ES de n'a pas été faite...
			echo "[ERROR] Echec de l'insertion de l'ES.</br>";
		}
	}else{ //sinon il n'y a pas de solde pour ce compte antérieur à la date indiquée pour cette ES
		echo "[ERROR] Il n'y a pas de solde pour se compte avant la date ou à la date indiquée...</br>";
	}
}else{ //sinon elle  est dans le  futur... pas possible
	echo "[ERROR] La date de l'ES est dans le futur... Impossible de mettre à jour le solde.</br>";
}

?>