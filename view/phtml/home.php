<!DOCTYPE html>
<!--
- Page d'acceuil du site web Gestionnaire de Compte version 2.0 
- 
- @author Alexis BATTAGLI
- @version 0.1
- @version 0.2
- 	@date 5 novembre 2021
-       Ajout de l'état des comptes (création du controller de la page home: /controller/page/home_ctrl)
- 
- @descritpion
-  Doit afficher,
-  dans un tableau Etat des compte avec un comparatif de chacun sur les 2 dernier mois
-  les 5 dernière entrée du mois en cours
-  les 5 dernière sorties du mois en cours
-  dans un tableau l'Etat d'avancemùent du Budget défini pour le mois en cours
-  dans une  v0.2 il devra avoir un volet ouvrable sur le coté gauche afin d'afficher les tendances
-  sur chaque compte (sous forme d'histogramme)  depuis 2 mois (un histo pour chaque compte
- 
-->

<?php
// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');

require_once($_SERVER['DOCUMENT_ROOT'] . '/controller/page/home_ctrl.php');

//Récupère l'état des comptes sous la forme d'un tableau (cf /controller/page/home_ctrl)
$etatComptes = HomeCtrl::getEtatComptes();
//Récupère les statistique d'ES du mois en cours (cf /controller/page/home_ctrl)
$statCurrentMonth = HomeCtrl::getStatCurrentMonth();
// Récupère les 5 dernières Sorties du mois en cours
$lastE = HomeCtrl::getLastEntreeSortie(5,'e');
// Récupère les 5 dernières Entrées du mois en cours
$lastS = HomeCtrl::getLastEntreeSortie(5,'s');

?>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Acceuil</title>

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
                background: rgb(255,255,255); /* Old browsers */
                background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(243,243,243,1) 50%, rgba(237,237,237,1) 51%, rgba(255,255,255,1) 100%); /* FF3.6-15 */
                background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(243,243,243,1) 50%,rgba(237,237,237,1) 51%,rgba(255,255,255,1) 100%); /* Chrome10-25,Safari5.1-6 */
                background: linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(243,243,243,1) 50%,rgba(237,237,237,1) 51%,rgba(255,255,255,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
            }

            th {
                background: rgb(255,255,255); /* Old browsers */
                background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(241,241,241,1) 50%, rgba(225,225,225,1) 51%, rgba(246,246,246,1) 100%); /* FF3.6-15 */
                background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%); /* Chrome10-25,Safari5.1-6 */
                background: linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f6f6f6',GradientType=0 ); /* IE6-9 */
            }

            legend {
                color:#428BCA; /* Old browsers */
            }

            blockquote {
                background-color:#fffeee;
                border-radius: 12px;
                border: 2px #eee dotted; 
            }

            body {
                font-family:initial;
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
                                    <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/home.php" class="btn btn-default btn-sm">Home</a></li>
                                    <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/info_gen.php" class="btn btn-default btn-sm" target="_blank">Informations Générales</a></li>
                                    <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/liens_utiles.php" class="btn btn-default btn-sm" target="_blank">Liens utiles</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    </br>
                    <legend>Gestion des données d'informations</legend>
                    <div class="col-lg-3">
                        <a href="./gst_lieux.php" class="list-group-item">
                            <h4 class="list-group-item-heading">Lieux</h4>
                            <p class="list-group-item-text">Ajouter, modifier ou supprimer <b>un Lieu</b> associables à un Flux d'argent.</p>
                        </a>
                    </div>
                    <div class="col-lg-3">
                        <a href="./gst_compte.php" class="list-group-item">
                            <h4 class="list-group-item-heading">Compte</h4>
                            <p class="list-group-item-text">Ajouter, modifier <b>un Compte</b> associables à un Flux d'argent.</p>
                        </a>
                    </div>     
                    <div class="col-lg-3">
                        <a href="./gst_objet.php" class="list-group-item">
                            <h4 class="list-group-item-heading">Objet</h4>
                            <p class="list-group-item-text">Ajouter, modifier <b>un Objet</b> associable à un Flux d'argent.</p>
                        </a>
                    </div>     
                    <div class="col-lg-3">
                        <a href="./gst_budget.php" class="list-group-item">
                            <h4 class="list-group-item-heading">Budget</h4>
                            <p class="list-group-item-text">Définir ou revoir <b>le Budget Annuel</b> d'un Objet.</p>
                        </a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="col-lg-3">
                        <a href="./gst_payement.php" class="list-group-item">
                            <h4 class="list-group-item-heading">Moyen de Payement</h4>
                            <p class="list-group-item-text">Ajouter, modifier ou supprimer <b>un moyen de payement</b> associables à un Flux d'argent.</p>
                        </a>
                    </div>
                    <div class="col-lg-3 ">
                        <a href="./gst_etiquette.php" class="list-group-item">
                            <h4 class="list-group-item-heading">Etiquette</h4>
                            <p class="list-group-item-text">Ajouter, modifier ou supprimer <b>une Etiquette</b> associables à un Flux d'argent.</p>
                        </a>
                    </div>
                    <div class="col-lg-3 ">
                        <a href="./gst_sousobjet.php" class="list-group-item">
                            <h4 class="list-group-item-heading">Sous-Objet</h4>
                            <p class="list-group-item-text">Ajouter, modifier ou supprimer <b>un Sous-Objet</b> associables à un <b>Objet</b>.</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    </br>
                    <legend>Gestion des Flux d'argent</legend>
                    <div class="list-group">       
                        <div class="col-lg-6">
                            <a href="./add_es.php" class="list-group-item">
                                <h4 class="list-group-item-heading">Entrée ou Sortie</h4>
                                <p class="list-group-item-text">Ajouter une nouvelle <b>Entrée/Sortie</b> d'argent.</br>
                                    Pensez à bien avoir ajouter toutes les données d'informations nécéssaire à cette ajout d'ES!
                                </p>
                            </a>
                        </div>     
                        <div class="col-lg-6">
                            <a href="./add_trf.php" class="list-group-item">
                                <h4 class="list-group-item-heading">Transfert</h4>
                                <p class="list-group-item-text">Ajouter un transfert d'argent réaliser entre deux comptes.</br>
                                    Pensez à bien avoir ajouter tous les comptes nécéssaire à l'ajout de ce transfert!
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    </br>
                    <legend>Statistique et Analyse</legend>
                    <div class="list-group">       
                        <div class="col-lg-4">
                            <a href="./rapport_menu.php" class="list-group-item">
                                <h4 class="list-group-item-heading">Rapport</h4>
                                <p class="list-group-item-text">Visualiser les rapport mensuel annuel ou sur une période donnée.</p>
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <a href="#" class="list-group-item">
                                <h4 class="list-group-item-heading">Bilan Budget</h4>
                                <p class="list-group-item-text">Consulter état des budgets alloués à chaque Objets,d'un mois ou une année donnée.</p>
                            </a>
                        </div>     
                        <div class="col-lg-4">
                            <a href="./recherche_form.php" class="list-group-item">
                                <h4 class="list-group-item-heading">Recherche</h4>
                                <p class="list-group-item-text">Lancer une recherche d'ES sur une période voulu.</br>
                                    La recherche est affinable via différents filtres.
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    </br>
		    <legend>Etat des Comptes:</legend>
			<?php $currentMonth = date('m'); $currentYear = date('Y'); ?>
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">Nom</th>
                                <th class="text-center">Actuellement</th>
				<th class="text-center"><?php echo "Fin ".date("M Y", mktime(0, 0, 0, $currentMonth, 0, $currentYear))." (1 mois)";?></th>
				<th class="text-center"><?php echo "Fin ".date("M Y", mktime(0, 0, 0, $currentMonth-1, 0, $currentYear))." (2 mois)";?></th>
				<th class="text-center"><?php echo "Fin ".date("M Y", mktime(0, 0, 0, $currentMonth-5, 0, $currentYear))." (6 mois)";?></th>
				<th class="text-center"><?php echo "Fin ".date("M Y", mktime(0, 0, 0, $currentMonth-11, 0, $currentYear))." (12 mois)";?></th>
                            </tr>
                        </thead>

			<tbody>
			<?php 	     
			  $nbCompte = count($etatComptes['id']);
			  $totalActuel=0; $totalM1=0; $totalM2=0; $totalM6=0; $totalM12=0;
			  $diffTotM1=0; $diffTotM2=0; $diffTotM6=0; $diffTotM12=0;
			  for ($i = 0; $i < $nbCompte; $i++):
				$signeM1="+"; if ($etatComptes['diffM1'][$i] > 0){ $classM1 = "btn-success";} elseif ($etatComptes['diffM1'][$i] == 0) { $classM1 = "btn-secondary"; } else { $classM1 = "btn-danger"; $signeM1="";}
				$signeM2="+"; if ($etatComptes['diffM2'][$i] > 0){ $classM2 = "btn-success";} elseif ($etatComptes['diffM2'][$i] == 0) { $classM2 = "btn-secondary"; } else { $classM2 = "btn-danger"; $signeM2="";}
				$signeM6="+"; if ($etatComptes['diffM6'][$i] > 0){ $classM6 = "btn-success";} elseif ($etatComptes['diffM6'][$i] == 0) { $classM6 = "btn-secondary"; } else { $classM6 = "btn-danger"; $signeM6="";}
				$signeM12="+"; if ($etatComptes['diffM12'][$i] > 0){ $classM12 = "btn-success";} elseif ($etatComptes['diffM12'][$i] == 0) { $classM12 = "btn-secondary"; } else { $classM12 = "btn-danger"; $signeM12="";}
				
			  	$totalActuel += $etatComptes['solde'][$i];
				$totalM1 += $etatComptes['soldeM1'][$i]; $diffTotM1 += $etatComptes['diffM1'][$i]; 
				$totalM2 += $etatComptes['soldeM2'][$i]; $diffTotM2 += $etatComptes['diffM2'][$i];
				$totalM6 += $etatComptes['soldeM6'][$i]; $diffTotM6 += $etatComptes['diffM6'][$i];
				$totalM12 += $etatComptes['soldeM12'][$i]; $diffTotM12 += $etatComptes['diffM12'][$i];
			?>
			    <tr>
			    <td class="text-center"><a href="#" class="btn btn-primary btn-sm btn-block"><?php echo $etatComptes['label'][$i]; ?></a></td>
                                <td class="text-center"><?php echo number_format($etatComptes['solde'][$i],2,',',' ')." € "; ?></td>
				<td class="text-center"><?php echo number_format($etatComptes['soldeM1'][$i],2,',',' ')." € "; ?><a href="#" class="btn <?php echo $classM1; ?> btn-sm active"><?php echo "(".$signeM1.number_format($etatComptes['diffM1'][$i],2,',',' ').")"; ?></a></td>
                                <td class="text-center"><?php echo number_format($etatComptes['soldeM2'][$i],2,',',' ')." € "; ?><a href="#" class="btn <?php echo $classM2; ?> btn-sm active"><?php echo "(".$signeM2.number_format($etatComptes['diffM2'][$i],2,',',' ').")"; ?></a></td>
                                <td class="text-center"><?php echo number_format($etatComptes['soldeM6'][$i],2,',',' ')." € "; ?><a href="#" class="btn <?php echo $classM6; ?> btn-sm active"><?php echo "(".$signeM6.number_format($etatComptes['diffM6'][$i],2,',',' ').")"; ?></a></td>
                                <td class="text-center"><?php echo number_format($etatComptes['soldeM12'][$i],2,',',' ')." € "; ?><a href="#" class="btn <?php echo $classM12; ?> btn-sm active"><?php echo "(".$signeM12.number_format($etatComptes['diffM12'][$i],2,',',' ').")"; ?></a></td>
			     </tr>
			<?php endfor;?>
			<?php
				$signeTotM1="+"; if ($diffTotM1 > 0){ $classTotM1 = "btn-success";} elseif ($diffTotM1 == 0){$classTotM1 = "btn-secondary";} else{$classTotM1 ="btn-danger"; $signeTotM1="";}
				$signeTotM2="+"; if ($diffTotM2 > 0){ $classTotM2 = "btn-success";} elseif ($diffTotM2 == 0){$classTotM2 = "btn-secondary";} else{$classTotM2 ="btn-danger"; $signeTotM2="";}
				$signeTotM6="+"; if ($diffTotM6 > 0){ $classTotM6 = "btn-success";} elseif ($diffTotM6 == 0){$classTotM6 = "btn-secondary";} else{$classTotM6 ="btn-danger"; $signeTotM6="";}
				$signeTotM12="+"; if ($diffTotM12 > 0){ $classTotM12 = "btn-success";} elseif ($diffTotM12 == 0){$classTotM12 = "btn-secondary";} else{$classTotM12 ="btn-danger"; $signeTotM12="";}
			?>
			     <tr>
				<td class="text-center btn btn-warning btn-sm btn-block">TOTAL</td>
				<td class="text-center"><?php echo number_format($totalActuel,2,',',' ')." € " ;?></td>
				<td class="text-center"><?php echo number_format($totalM1,2,',',' ')." € " ;?><div class="btn <?php echo $classTotM1; ?> btn-sm active"><?php echo "(".$signeTotM1.number_format($diffTotM1,2,',',' ').")";?></div></td>
				<td class="text-center"><?php echo number_format($totalM2,2,',',' ')." € " ;?><div class="btn <?php echo $classTotM2; ?> btn-sm active"><?php echo "(".$signeTotM2.number_format($diffTotM2,2,',',' ').")";?></div></td>
				<td class="text-center"><?php echo number_format($totalM6,2,',',' ')." € " ;?><div class="btn <?php echo $classTotM6; ?> btn-sm active"><?php echo "(".$signeTotM6.number_format($diffTotM6,2,',',' ').")";?></div></td>
				<td class="text-center"><?php echo number_format($totalM12,2,',',' ')." € " ;?><div class="btn <?php echo $classTotM12; ?> btn-sm active"><?php echo "(".$signeTotM12.number_format($diffTotM12,2,',',' ').")";?></div></td>
			     </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            </br>
            <fieldset>
                <div class="row">
                    <div class="col-lg-6">
                        <legend>Sorties du mois:</legend>
                    </div>
                    <div class="col-lg-6">
                        <legend>Entrées du mois:</legend>
                    </div>
                    <div class="col-lg-6">
                        <blockquote>
                            <footer>Nombre de Sorties du Mois: <b>3</b></br> </footer>
                            <footer>Argent dépensés du Mois: <b><span style="color:red">72.15 €</span></footer>
                        </blockquote>
                    </div>
                    <div class="col-lg-6">
                        <blockquote>
                            <footer>Nombre de d'Entrées du Mois: <b>3</b></br> </footer>
                            <footer>Argent gagné ce Mois-ci: <b><span style="color:green">152.15 €</span></footer>
                        </blockquote>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table table-bordered table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Somme</th>
                                    <th class="text-center">Objet</th>
                                    <th class="text-center">Information Supplémentaire</th>
                                    <th class="text-center">Lieux</th>
                                    <th class="text-center">Moyen</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="text-center">2015/11/02</a></td>
                                    <td class="text-center">7,50 €</td>
                                    <td class="text-center">Sortie (Bar)</td>
                                    <td class="text-center">Aller au Subway</td>
                                    <td class="text-center">Grenoble (France)</td>
                                    <td class="text-center">Espèce</td>

                                </tr>

                                <tr>
                                    <td class="text-center">2015/11/02</a></td>
                                    <td class="text-center">27,50 €</td>
                                    <td class="text-center">Nourriture</td>
                                    <td class="text-center">Fait les course pour Nîmes à Casino</td>
                                    <td class="text-center">Echirolles (France)</td>
                                    <td class="text-center">Carte</td>
                                </tr>

                                <tr>
                                    <td class="text-center">2015/11/07</a></td>
                                    <td class="text-center">19,54 €</td>
                                    <td class="text-center">Loisir (Jeux-Vidéo)</td>
                                    <td class="text-center">Achat de Tekken 6 sur Xbox360</td>
                                    <td class="text-center">Echirolles (France)</td>
                                    <td class="text-center">Carte sur Internet</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-6">
                        <table class="table table-bordered table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Somme</th>
                                    <th class="text-center">Objet</th>
                                    <th class="text-center">Information Supplémentaire</th>
                                    <th class="text-center">Lieux</th>
                                    <th class="text-center">Moyen</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="text-center">2015/11/02</a></td>
                                    <td class="text-center">7,50 €</td>
                                    <td class="text-center">Sortie (Bar)</td>
                                    <td class="text-center">Aller au Subway</td>
                                    <td class="text-center">Grenoble (France)</td>
                                    <td class="text-center">Espèce</td>
                                </tr>

                                <tr>
                                    <td class="text-center">2015/11/02</a></td>
                                    <td class="text-center">27,50 €</td>
                                    <td class="text-center">Nourriture</td>
                                    <td class="text-center">Fait les course pour Nîmes à Casino</td>
                                    <td class="text-center">Echirolles (France)</td>
                                    <td class="text-center">Carte</td>
                                </tr>

                                <tr>
                                    <td class="text-center">2015/11/07</a></td>
                                    <td class="text-center">19,54 €</td>
                                    <td class="text-center">Loisir (Jeux-Vidéo)</td>
                                    <td class="text-center">Achat de Tekken 6 sur Xbox360</td>
                                    <td class="text-center">Echirolles (France)</td>
                                    <td class="text-center">Carte sur Internet</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </fieldset>
        </div>
    </body>
</html>
