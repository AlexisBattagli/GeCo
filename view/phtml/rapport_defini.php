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

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/CompteDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/EntreeSortie.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/class/RapportDefini.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/controller/page/rapport_def_ctrl.php');

//======Vérification de ce qui est renvoyé par le formulaire de /view/phtml/rapport_menu.php====/
//echo "[DEBUG] Vérifie la date de début reçue</br>";
$validDateDebut = filter_input(INPUT_POST, 'debut', FILTER_SANITIZE_STRING);
if ($validDateDebut != null)
{
	//echo "[DEBUG] Le champ debut est ok et vaut :".$validDateDebut."</br>";
	$debut = $validDateDebut;
}
else {
	echo "[ERROR] Le champ debut est vide... il vaut :".$validDateDebut."</br>";
}

//echo "[DEBUG] Vérifie la date de fin reçue </br>";
$validDateFin = filter_input(INPUT_POST, 'fin', FILTER_SANITIZE_STRING);
if ($validDateFin != null)
{
	//echo "[DEBUG] Le champ fin est ok et vaut :".$validDateFin."</br>";
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
			<legend>Etat des Comptes au <?php echo $fin;?></legend>
			<div class="col-lg-12">
            	<table class="table table-bordered table-hover table-condensed">
                	<thead>
                    	<tr>
                        	<th class="text-center">Banque</th>
                           	<th class="text-center">Nom</th>
                            <th class="text-center">Solde (€)</th>
                            <th class="text-center">Informations</th>
                            <th class="text-center">Numéro</th>
                        </tr>
                  	</thead>

                    <tbody>
                    <?php $comptes = CompteDAL::findAll();?>
                    <?php foreach ($comptes as $compte): ?>
                    	<tr>
                        	<td class="text-center"><?php echo $compte->getBanque(); ?></th>
                            <td class="text-center"><?php echo $compte->getLabel(); ?></th>
                            <td class="text-center"><?php echo round($compte->getSoldeTo($fin),2); ?></th>
                            <td class="text-center"><?php echo $compte->getInformation(); ?></th>
                            <td class="text-center"><?php echo $compte->getIdentifiant(); ?></th>
                      	</tr>
                    <?php endforeach; ?>
                    </tbody>
               	</table>
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
                      <!--  <th class="text-center">Modifier</th>  Fonctionalité non prioritaire-->
                            <th class="text-center">Supprimer</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($entreesSorties as $es): 
                    		$couleurES = 'red';
                    		if($es->isE()){
                    			$couleurES = 'green';
                    		}
                    ?>
                    	<tr>
                        	<td class="text-center" style="color:<?php echo $couleurES;?>"><?php echo $es->getDate(); ?></td>
                            <td class="text-center" style="color:<?php echo $couleurES;?>"><?php echo $es->getValeur(); ?></td>
                            <td class="text-center" style="color:<?php echo $couleurES;?>"><?php echo $es->getInformation(); ?></td>
                            <td class="text-center" style="color:<?php echo $couleurES;?>"><?php echo $es->getObjet()->getLabel(); ?></td>
                            <td class="text-center" style="color:<?php echo $couleurES;?>"><?php echo $es->getCompte()->getLabel(); ?></td>
                            <td class="text-center" style="color:<?php echo $couleurES;?>"><?php echo $es->getPayement()->getMoyen(); ?></td>
                            <td class="text-center" style="color:<?php echo $couleurES;?>"><?php echo $es->getLieu()->getVille()." (".$es->getLieu()->getPays().")"; ?></td>
                       <!-- <td class="text-center" style="color:<?php //echo $couleur;?>"> <a href=<?php // $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/mod_es.php?idES=<?php //echo $es->getId(); ?>" class="btn btn-primary btn-sm active">Mod</a></td>  --> <!-- Lien vers une page view qui affiche les détail (permet leur modif) -->
                            <th class="text-center" style="color:<?php echo $couleurES;?>"><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/controller/page/sup_es.php?idES=<?php echo $es->getId(); ?>&debut=<?php echo $debut; ?>&fin=<?php echo $fin; ?>" target="_blank" class="btn btn-danger btn-sm active">Sup</a></th>
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
							<th class="text-center">Gain (€)</th>
						</tr>
					</thead>
					
					<tbody>
					<?php 
						$couleurObj = 'red';
						$nbObj = count($listObjets['id']);
						for ($i = 0; $i < $nbObj; $i++): 
							if($listObjets['gain'][$i]>=0){
								$couleurObj = 'green';
							}else{
								$couleurObj = 'red';
							}
					?>
						<tr>
							<td class="text-center" ><a style="color:<?php echo $couleurObj;?>" target="_blank" href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/rapport_objet.php?idObjet=<?php echo $listObjets['id'][$i]; ?>&debut=<?php echo $debut; ?>&fin=<?php echo $fin; ?>"</a><?php echo $listObjets['label'][$i]; ?></td>
							<td class="text-center"><?php echo $listObjets['nbS'][$i]; ?></td>
							<td class="text-center"><?php echo $listObjets['nbE'][$i]; ?></td>
							<td class="text-center"><span style="font-weight:bold"><?php echo $listObjets['totS'][$i]; ?></span> (<?php echo $listObjets['%S'][$i]; ?> %)</td>
							<td class="text-center"><span style="font-weight:bold"><?php echo $listObjets['totE'][$i]; ?></span> (<?php echo $listObjets['%E'][$i]; ?> %)</td>
							<td class="text-center" style="color:<?php echo $couleurObj;?>"><?php echo $listObjets['gain'][$i]; ?></td>
						</tr>
					<?php  endfor; ?>
					</tbody>
					
					<tfoot>
						<tr>
							<th class="text-center">Total <?php echo $nbObj;?> Objet(s)</th>
							<th class="text-center"><?php echo $rapportDef->getNbSortie()?> sortie(s)</th>
							<th class="text-center"><?php echo $rapportDef->getNbEntree()?> entrée(s)</th>
							<th class="text-center" style="color:red"><?php echo $rapportDef->getTotSortie()?> €</th>
							<th class="text-center" style="color:green"><?php echo $rapportDef->getTotEntree()?> €</th>
							<th class="text-center"
								<?php 
									$couleurTotObj = 'red';
									if($rapportDef->getGain() >= 0){
										$couleurTotObj = 'green';
									}
								?>
								style="color:<?php echo $couleurTotObj;?>"><?php echo $rapportDef->getGain()?></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	
		<div class="row">
			<?php $listComptes = RapportDefCtrl::calBilanComptes($flux, $debut, $fin); ?>
			
			<legend>Gain par Compte sur la période du <?php echo $debut;?> au <?php echo $fin;?> (avec Transfert)</legend>
			<div class="col-lg-12">
				<table class="table table-bordered table-hover table-condensed">
					<thead>
						<tr>
							<th class="text-center">Compte</th>
							<th class="text-center">Solde au <?php echo $fin;?> (€)</th>
							<th class="text-center">Nombre de Sortie</th>
							<th class="text-center">Nombre d'Entrée</th>
							<th class="text-center">Sortie (€)</th>
							<th class="text-center">Entrée (€)</th>
							<th class="text-center">Gain (€)</th>
						</tr>
					</thead>
					
					<tbody>
					<?php 
						$couleurCpt = 'red';
						$nbCpt = count($listComptes['id']);
						for ($i = 0; $i < $nbCpt; $i++): 
							if($listComptes['gain'][$i]>=0){
								$couleurCpt = 'green';
							}else{
								$couleurCpt = 'red';
							}
					?>
						<tr>
							<td class="text-center"><?php echo $listComptes['label'][$i]; ?></td>
							<td class="text-center"><?php echo $listComptes['solde'][$i]; ?></td>
							<td class="text-center"><?php echo $listComptes['nbS'][$i]; ?></td>
							<td class="text-center"><?php echo $listComptes['nbE'][$i]; ?></td>
							<td class="text-center"><span style="font-weight:bold"><?php echo $listComptes['totS'][$i]; ?></span> (<?php echo $listComptes['%S'][$i]; ?> %)</td>
							<td class="text-center"><span style="font-weight:bold"><?php echo $listComptes['totE'][$i]; ?></span> (<?php echo $listComptes['%E'][$i]; ?> %)</td>
							<td class="text-center" style="color:<?php echo $couleurCpt;?>"><?php echo $listComptes['gain'][$i]; ?></td>
						</tr>
					<?php  endfor; ?>
					</tbody>
					
					<tfoot>
					</tfoot>
				</table>
			</div>
		</div>
	
	</div>
</body>

</html>
