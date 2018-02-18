<!DOCTYPE html>
<!--
- Page affichant un rapport sur une période donnée définie.
- 
- @author Alexis BATTAGLI
- @date 27 décembre 2017
- @version 0.1
-
-->

<?php
// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/EntreeSortie.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/RapportDefini.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/controller/page/rapport_def_ctrl.php');

//======Vérification de ce qui est renvoyé par le formulaire de /view/phtml/rapport_menu.php====/
echo "[DEBUG] Vérifie la date de début reçue</br>";
$validDateDebut = filter_input(INPUT_POST, 'debut', FILTER_SANITIZE_STRING);
if ($validDateDebut != null)
{
	echo "[DEBUG] Le champ debut est ok et vaut :".$validDateDebut."</br>";
	$debut = $validDateDebut;
}
else {
	echo "[ERROR] Le champ debut est vide... il vaut :".$validDateDebut."</br>";
}

echo "[DEBUG] Vérifie la date de fin reçue </br>";
$validDateFin = filter_input(INPUT_POST, 'fin', FILTER_SANITIZE_STRING);
if ($validDateFin != null)
{
	echo "[DEBUG] Le champ fin est ok et vaut :".$validDateFin."</br>";
	$fin = $validDateFin;
}
else {
	echo "[ERROR] Le champ fin est vide... il vaut :".$validDateFin."</br>";
}

$flux = RapportDefCtrl::getFlux($debut, $fin);
$rapportDef = new RapportDefini($debut, $fin, $flux);

?>

<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Rapport du <?php echo $debut;?> au <?php echo $fin;?></title>

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
			<?php $entreesSorties = $rapportDef->getES();?>
			<legend>Liste des Entrées et Sorties sur la période du <?php echo $debut;?> au <?php echo $fin;?></legend>
			<div class="col-lg-12">
				<table class="table table-bordered table-hover table-condensed">
                	<thead>
                    	<tr>
                        	<th class="text-center">Date</th>
                            <th class="text-center">Somme</th>
                            <th class="text-center">Info</th>
                            <th class="text-center">Objet</th>
                            <th class="text-center">Compte</th>
                            <th class="text-center">Moyen de payement</th>
                            <th class="text-center">Lieux</th>
                            <th class="text-center">Modifier</th>
                            <th class="text-center">Supprimer</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($entreesSorties as $es): ?>
                    	<tr>
                        	<td class="text-center"><?php echo $es->getDate(); ?></td>
                            <td class="text-center"><?php echo $es->getValeur(); ?></td>
                            <td class="text-center"><?php echo $es->getInformation(); ?></td>
                            <td class="text-center"><?php echo $es->getObjet()->getLabel(); ?></td>
                            <td class="text-center"><?php echo $es->getCompte()->getLabel(); ?></td>
                            <td class="text-center"><?php echo $es->getPayement()->getMoyen(); ?></td>
                            <td class="text-center"><?php echo $es->getLieu()->getVille()." (".$es->getLieu()->getPays().")"; ?></td>
                            <td class="text-center"><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/mod_es.php?idES=<?php echo $es->getId(); ?>" class="btn btn-primary btn-sm active">Mod</a></td> <!-- Lien vers une page view qui affiche les détail (permet leur modif) -->
                            <th class="text-center"><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/controller/page/sup_es.php?idES=<?php echo $es->getId(); ?>" class="btn btn-danger btn-sm active">Sup</a></th>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
			</div>
		</div>
		
		<div class="row">
			<?php $listObjets = RapportDefCtrl::calBilanObjets($entreesSorties, $debut, $fin);?>
			<legend>Gain par Objet sur la période du <?php echo $debut;?> au <?php echo $fin;?></legend>
			<div class="col-lg-12">
				<table class="table table-bordered table-hover table-condensed">
					<thead>
						<tr>
							<th class="text-center">Objet</th>
							<th class="text-center">Nombre de Sortie</th>
							<th class="text-center">Nombre d'Entrée</th>
							<th class="text-center">Sortie (€)</th>
							<th class="text-center">Entrée (€)</th>
							<th class="text-center">Gain</th>
							<th class="text-center">Budget <?php echo date('Y');?></th>
						</tr>
					</thead>
					<!-- 
					<tbody>
					<?php //foreach ($listObjets as $objet): ?>
						<tr>
							<td class="text-center"><?php  //echo $objet['label']; ?></td>
							<td class="text-center"><?php //echo $objet['id']; ?></td>
							<td class="text-center"><?php //echo $objet['label']; ?></td>
							<td class="text-center"><?php //echo $objet['id']; ?></td>
							<td class="text-center"><?php //echo $objet['label']; ?></td>
							<td class="text-center"><?php //echo $objet['id']; ?></td>
							<td class="text-center"><?php //echo $objet['label']; ?></td>
						</tr>
					</tbody>
					 -->
				</table>
			</div>
		</div>
	 
	
	</div>
</body>

</html>
