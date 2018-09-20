<?php

/**
 * Page affichant les ES lié à une catégorie d'objet sur une période donnée 
 * 
 * @author AlexisBattagli
 * @date 24 mai 2018
 * @version 0.1
 */

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

//require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/EntreeSortie.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/Objet.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/SousObjet.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/controller/page/rapport_obj_ctrl.php');

//======Vérification de ce qui est renvoyé par le lien du tableau des objet dans la page /view/phtml/rapport_defini.php====/
echo "[DEBUG] Vérifie la date de début reçue</br>";
$validDateDebut = filter_input(INPUT_GET, 'debut', FILTER_SANITIZE_STRING);
if (!is_null($validDateDebut))
{
	echo "[DEBUG] Le champ debut est ok et vaut :".$validDateDebut."</br>";
	$debut = $validDateDebut;
}
else {
	echo "[ERROR] Le champ debut est erroné... il vaut :".$validDateDebut."</br>";
}

echo "[DEBUG] Vérifie la date de fin reçue </br>";
$validDateFin = filter_input(INPUT_GET, 'fin', FILTER_SANITIZE_STRING);
if (!is_null($validDateFin))
{
	echo "[DEBUG] Le champ fin est ok et vaut :".$validDateFin."</br>";
	$fin = $validDateFin;
}
else {
	echo "[ERROR] Le champ fin est erroné... il vaut :".$validDateFin."</br>";
}

echo "[DEBUG] Vérifie l'id de l'objet reçue </br>";
$validIdObjet = filter_input(INPUT_GET, 'idObjet', FILTER_SANITIZE_STRING);
if (!is_null($validIdObjet))
{
	echo "[DEBUG] Le champ idObjet est ok et vaut :".$validIdObjet."</br>";
	$idObjet = $validIdObjet;
}
else {
	echo "[ERROR] Le champ idObjet est erroné... il vaut :".$validIdObjet."</br>";
}


$bilan = RapportObjCtrl::calcBilan($idObjet, $debut, $fin);

echo '<pre>';
var_dump($bilan );
echo '</pre>';


?>

<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Détail Objet <?php echo $idObjet; ?> du <?php echo $debut;?> au <?php echo $fin;?></title>

	<link rel="stylesheet" type="text/css" href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/css/bootstrap-theme.min.css">

	<script src=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/js/bootstrap.js"></script>
	<script src=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/js/dropdown.js"></script>
	<script src=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/js/jquery-1.11.3.js"></script>

	<style type="text/css">
table {
	border-radius: 6px;
	box-shadow: 1px 1px 2px grey;
}

td {
	color: #2e6da4;
	font-size: 12px;
	background: rgb(255, 255, 255); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(255, 255, 255, 1) 0%,
		rgba(243, 243, 243, 1) 50%, rgba(237, 237, 237, 1) 51%,
		rgba(255, 255, 255, 1) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top, rgba(255, 255, 255, 1) 0%,
		rgba(243, 243, 243, 1) 50%, rgba(237, 237, 237, 1) 51%,
		rgba(255, 255, 255, 1) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%,
		rgba(243, 243, 243, 1) 50%, rgba(237, 237, 237, 1) 51%,
		rgba(255, 255, 255, 1) 100%);
	/* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff',
		endColorstr='#ffffff', GradientType=0); /* IE6-9 */
}

th {
	font-size: 12px;
	background: rgb(255, 255, 255); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(255, 255, 255, 1) 0%,
		rgba(241, 241, 241, 1) 50%, rgba(225, 225, 225, 1) 51%,
		rgba(246, 246, 246, 1) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top, rgba(255, 255, 255, 1) 0%,
		rgba(241, 241, 241, 1) 50%, rgba(225, 225, 225, 1) 51%,
		rgba(246, 246, 246, 1) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%,
		rgba(241, 241, 241, 1) 50%, rgba(225, 225, 225, 1) 51%,
		rgba(246, 246, 246, 1) 100%);
	/* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff',
		endColorstr='#f6f6f6', GradientType=0); /* IE6-9 */
}

legend {
	color: #428BCA; /* Old browsers */
}

blockquote {
	background-color: #fffeee;
	border-radius: 12px;
	border: 2px #eee dotted;
}

body {
	font-family: initial;
}
</style>

	</head>

<body>
	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<nav class="navbar navbar-default navbar-static-top" role="navigation">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse"></button>
							<span class="navbar-brand">Gestionnaire de Compte 2.0</span>
						</div>
						<div class="collapse navbar-collapse" id="navbarCollapse">
							<ul class="nav navbar-nav">
								<li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?> "/view/phtml/home.php" class="btn btn-default btn-sm">Home</a></li>
								<li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?> "/view/phtml/info_gen.php" class="btn btn-default btn-sm" target="_blank">Informations Générales</a></li>
								<li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?> "/view/phtml/liens_utiles.php" class="btn btn-default btn-sm" target="_blank">Liens utiles</a></li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
		</div>

		<div class="row">
			<legend>Détail de l'Objet par Sous-Objet</legend>
			<div class="col-lg-12">
            	<table class="table table-bordered table-hover table-condensed">
                	<thead>
                    	<tr>
                        	<th class="text-center">Sous-Objet</th>
                           	<th class="text-center">Date</th>
                            <th class="text-center">Somme (€)</th>
                            <th class="text-center">Informations</th>
                            <th class="text-center">Total Sortie (€)</th>
                            <th class="text-center">Total Entrée (€)</th>
                        </tr>
                  	</thead>
				<?php if (count($bilan)>0){?>
                    <tbody>
                    <?php for ($i=0; $i < count($bilan); $i++){
                    		foreach ($bilan as $sousBilan){
                    			if($sousBilan[3]>0){
                    ?>
                    	<tr>
                        	<td class="text-center"><?php echo $sousBilan["label"][0]; ?></th>
                            <td class="text-center"><?php echo "test"; ?></th>
                            <td class="text-center"><?php echo "test"; ?></th>
                            <td class="text-center"><?php echo "test"; ?></th>
                            <td class="text-center"><?php echo "test"; ?></th>
                            <td class="text-center"><?php echo "test"; ?></th>
                      	</tr>
                    <?php 
                    			} //endif (nbES du sous bilan)
                    		} //endforeach
                    	} //endfor ?>
                    </tbody>
                <?php } else { ?>
                	ERREUR: Il n'y a aucunes ES pour cette Objet !
                <?php }?>
               	</table>
          	</div>
		</div>
		

	</div>
</body>




