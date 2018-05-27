<!DOCTYPE html>
<!--
- Page de séléction du rapport à afficher.
- 
- @author Alexis BATTAGLI
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

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/controller/page/rapport_menu_ctrl.php');

?>

<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Séléction Rapport</title>

<link rel="stylesheet" type="text/css" href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/css/bootstrap-theme.min.css">

<script src=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/js/bootstrap.js"></script>
<script src=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/js/dropdown.js"></script>
<script src=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/js/jquery-1.11.3.js"></script>

<script src=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/javascript/rapport_menu.js"></script>

<style type="text/css">

input{
	color: DodgerBlue;
}

select{
	color: DodgerBlue;
}


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
			<div class="col-lg-12">
				<form action=<?php $_SERVER['DOCUMENT_ROOT'] ?> "/view/phtml/rapport_annuel.php" method="POST" target="_blank">
					<legend>Rapport Annuel</legend>

					<?php
					$annees = RapportMenuCtrl::listAnnees();
					if (is_null($annees)) {
						?>
					
					<div class="panel panel-danger col-lg-8">
						<div class="panel-heading">
							<h3 class="panel-title">
								<b>ATTENTION: Aucune entrée ou sortie d'argent présente !</b>
							</h3>
						</div>
						<div class="panel-body text-justify text-danger">Il n'y aucune entrée ou sortie d'argent en base permettant de réaliser un rapport annuel.</div>
					</div>
					
					<?php
					} else {
						?>
					<div class="col-lg-3">
						<label for="annee" class="control-label">Année : </label>
						<select name='annee' id='annee'>
							<?php foreach ($annees as $annee): ?>
        						<option value='<?php echo $annee;?>'><?php echo $annee;?></option>
        						<?php endforeach;?>
						</select>
					</div>

					<div class="col-lg-3">
						<input type="submit" value="Consulter le rapport annuel" class="btn btn-success btn-block" />
					</div>
					<?php
					}
					?>
				</form>
			</div>
		</div>

		</br>

		<div class="row">
			<div class="col-lg-12">
				<form action=<?php $_SERVER['DOCUMENT_ROOT'] ?> "/view/phtml/rapport_mensuel.php" method="POST" target="_blank">
					<legend>Rapport Mensuel</legend>

					<?php
					$annees = RapportMenuCtrl::listAnnees();
					if (is_null($annees)) {
						?>
					<div class="panel panel-danger col-lg-8">
						<div class="panel-heading">
							<h3 class="panel-title">
								<b>ATTENTION: Aucune entrée ou sortie d'argent présente !</b>
							</h3>
						</div>
						<div class="panel-body text-justify text-danger">Il n'y aucune entrée ou sortie d'argent en base permettant de réaliser un rapport mensuel.</div>
					</div>
					
					<?php
					} else {
						?>
					<div class="col-lg-3">
						<label for="annee_mens" class="control-label">Année : </label>
						<select name='annee_mens' id='annee_mens'>
							<?php foreach ($annees as $annee): ?>
        						<option value='<?php echo $annee;?>'><?php echo $annee;?></option>
        						<?php endforeach;?>
						</select>
					</div>

					<div class="col-lg-3">
						<label for="mois" class="control-label">Mois : </label>
						<select name="mois" id="mois"></select>
					</div>

					<div class="col-lg-3">
						<input type="submit" value="Consulter le rapport mensuel" class="btn btn-success btn-block" />
					</div>
					<?php
					}
					?>
				</form>
			</div>
		</div>

		</br>

		<div class="row">
			<div class="col-lg-12">
				<form action=<?php $_SERVER['DOCUMENT_ROOT'] ?> "/view/phtml/rapport_defini.php" method="POST" target="_blank">
					<legend>Rapport sur une période définie</legend>

					<div class="col-lg-4">
						<label for="debut" class="control-label">Date de début : </label>
						<input type="date" id="debut" name="debut" size=7 pattern="(20[0-9][0-9])\-(0[1-9]|1[0-2])\-(0[1-9]|[1-2][0-9]|3[0-1])" required></input>
					</div>

					<div class="col-lg-4">
						<label for="fin" class="control-label">Date de fin : </label>
						<input type="date" id="fin" name="fin" size=7 pattern="(20[0-9][0-9])\-(0[1-9]|1[0-2])\-(0[1-9]|[1-2][0-9]|3[0-1])" placeholder='<?php echo date('Y-m-d');?>' value='<?php echo date('Y-m-d');?>' required></input>
					</div>

					<div class="col-lg-4">
						<input type="submit" value="Consulter le rapport de cette période" class="btn btn-success btn-block" />
					</div>
				</form>
			</div>
		</div>

		</br>

		<div class="col-lg-2">
			</br> <a href=<?php $_SERVER['DOCUMENT_ROOT'] ?> "/view/phtml/home.php" class="btn btn-danger btn-block">Annuler</a>
		</div>

	</div>
</body>
</html>




