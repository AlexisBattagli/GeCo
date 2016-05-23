<!DOCTYPE html>
<!--
- Page d'acceuil du site web Gestionnaire de Compte version 2.0 
- 
- @author Alexis BATTAGLI
- @version 0.1
- 
- Doit afficher,
- dans un tableau Etat des compte avec un comparatif de chacun sur les 2 dernier mois
- les 5 dernière entrée du mois en cours
- les 5 dernière sorties du mois en cours
- dans un tableau l'Etat d'avancemùent du Budget défini pour le mois en cours
- dans une  v0.2 il devra avoir un volet ouvrable sur le coté gauche afin d'afficher les tendances
- sur chaque compte (sous forme d'histogramme)  depuis 2 mois (un histo pour chaque compte
- 
-->
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
                //box-shadow: 3px 3px 6px #8c8c8c;
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
                                <span class="navbar-brand">Gestionnaire de Compte v 2.0</span>
                            </div>
                            <div class="collapse navbar-collapse" id="navbarCollapse">
                                <ul class="nav navbar-nav">
                                    <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/home.php" class="btn btn-default btn-sm">Home</a></li>
                                    <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/info_gen.php" class="btn btn-default btn-sm" target="_blank">Informations Générales</a></li>
                                    <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/liens_utiles.php" class="btn btn-default btn-sm" target="_blank">Liens utiles</a></li>
                                </ul>
                                <!-- Outil de gestion des donnée d'info placer dans la bar de nav et pas juste sur home (pres2)-->
                                <!--<div class="row">
                                    <div class="col-lg-12"> 
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse"></button>
                                        <span class="navbar-brand">Gestion des données d'informations</span>
                                        <ul class="nav navbar-nav">
                                            <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/gst_lieux.php" class="btn btn-default btn-sm" target="_blank">Lieux</a></li>
                                            <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/gst_compte.php" class="btn btn-default btn-sm" target="_blank">Comptes</a></li>
                                            <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/gst_objet.php" class="btn btn-default btn-sm" target="_blank">Objets</a></li>
                                            <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/gst_budget.php" class="btn btn-default btn-sm" target="_blank">Budget</a></li>
                                            <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/gst_payement.php" class="btn btn-default btn-sm" target="_blank">Moyen de payement</a></li>
                                            <li><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/gst_etiquette.php" class="btn btn-default btn-sm" target="_blank">Etiquette</a></li>
                                        </ul>
                                    </div>
                                </div>-->
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
                            <p class="list-group-item-text">Ajouter, modifier ou supprimer <b>un Compte</b> associables à un Flux d'argent.</p>
                        </a>
                    </div>     
                    <div class="col-lg-3">
                        <a href="./gst_objet.php" class="list-group-item">
                            <h4 class="list-group-item-heading">Objet</h4>
                            <p class="list-group-item-text">Ajouter, modifier ou supprimer <b>un Objet</b> et <b>ses Sous-Objets</b> associables à un Flux d'argent.</p>
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
                            <a href="#" class="list-group-item">
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
                            <a href="#" class="list-group-item">
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
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">Nom</th>
                                <th class="text-center">Actuellement</th>
                                <th class="text-center">Fin Octobre 2015</th>
                                <th class="text-center">Fin Septembre 2015</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="text-center"><a href="#" class="btn btn-primary btn-sm btn-block">ESPECE</a></td>
                                <td class="text-center">122,35 €</td>
                                <td class="text-center">133.25 € <a href="#" class="btn btn-danger btn-sm active">(-10.08)</a></td>
                                <td class="text-center">110.37 € <a href="#" class="btn btn-success btn-sm active">(+12.16)</a></td>
                            </tr>

                            <tr>
                                <td class="text-center"><a href="#" class="btn btn-primary btn-sm btn-block">LIVRET_A</a></td>
                                <td class="text-center">13 800.00 €</td>
                                <td class="text-center">14 000.00 € <a href="#" class="btn btn-danger btn-sm active">(-200.00)</a></td>
                                <td class="text-center">13 568.15 € <a href="#" class="btn btn-success btn-sm active">(+432.85)</a></td>
                            </tr>

                            <tr>
                                <td class="text-center"><a href="#" class="btn btn-primary btn-sm btn-block">CPT_DEPOT_PART</a></td>
                                <td class="text-center">230.86 €</td>
                                <td class="text-center">138.56 € <a href="#" class="btn btn-success btn-sm active">(+92.35)</a></td>
                                <td class="text-center">192.56 € <a href="#" class="btn btn-success btn-sm active">(+37.86)</a></td>
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
