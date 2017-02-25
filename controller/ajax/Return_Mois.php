<?php

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

// import
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/controller/page/RapportMenu.php');

// Définition du message renvoyé
$message = "error";

// Checker de où il vient
// =====Vérification de ce qui est renvoyé par le formulaire
$validAnnee = filter_input(INPUT_POST, 'annee', FILTER_SANITIZE_STRING);

// Récupération des sous-objets de l'objet.
$listMois = RapportMenu::listMois($validAnnee);
$listMoisJson = [ ];
foreach ($listMois as $mois) {
	$listMoisJson [$mois] ['num'] = $mois;
	$listMoisJson [$mois] ['nom'] = findNomMois($mois);
}

// Envoi des sous-objets récupérés
$json = json_encode($listMoisJson);
echo $json;


function findNomMois($num) {
	if (is_string($num)) {
		$num = (int)$num;
	}
	
	$nom = $num;
	
	if ($num == 1) {
		$nom = "Janvier";
	} else if ($num == 2) {
		$nom = "Février";
	} else if ($num == 3) {
		$nom = "Mars";
	} else if ($num == 4) {
		$nom = "Avril";
	} else if ($num == 5) {
		$nom = "Mai";
	} else if ($num == 6) {
		$nom = "Juin";
	} else if ($num == 7) {
		$nom = "Juillet";
	} else if ($num == 8) {
		$nom = "Aout";
	} else if ($num == 9) {
		$nom = "Septembre";
	} else if ($num == 10) {
		$nom = "Octobre";
	} else if ($num == 11) {
		$nom = "Novembre";
	} else if ($num == 12) {
		$nom = "Décembre";
	}
	
	return $nom;
}
?>