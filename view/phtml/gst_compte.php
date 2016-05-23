<!DOCTYPE html>
<!--
- Page d'ajout de Compte du site web Gestionnaire de Compte version 2.0 
- 
- @author Alexis BATTAGLI
- @version 0.1
- 
- Permet d'afficher un formulaire pour ajouter un compte
- Doit permettre de donnée un label, un nom de banque, et des informations relative à ce compte.
-->

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/CompteDAL.php');
?>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Gestion des Comptes</title>

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

            body {
                font-family:initial;
            }

            blockquote {
                background-color:#fffeee;
                border-radius: 12px;
                //box-shadow: 3px 3px 6px #8c8c8c;
                border: 2px #eee dotted; 
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
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <form action=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/controller/page/add_compte.php" method="POST">
                        <legend>Formulaire d'ajout d'un nouveau Compte</legend>

                        <!-- Label/Nom du compte-->
                        <div class="col-lg-2">
                            <label for="label" class="control-label">Label : </label>
                            <input type="text" name="label" class="form-control" id="label" placeholder="Ex: LIVRET_A" required="required">
                        </div>

                        <!-- Nom de la banque associé à ce compte-->
                        <div class="col-lg-2">
                            <label for="banque" class="control-label">Banque : </label>
                            <input type="text" name="banque" class="form-control" id="banque" placeholder="Ex: Caisse d'Epargne" required="required">
                        </div>

                        <!-- Informations relatives au compte-->
                        <div class="col-lg-4">
                            <label for="information" class="control-label">Informations : </label>
                            <input type="text" name="information" class="form-control" id="information" placeholder="Ex: Compte principale de la réserve d'argent" required="required">
                        </div>

                        <!-- Numéro de compte-->
                        <div class="col-lg-2">
                            <label for="identifiant" class="control-label">Numero de Compte : </label>
                            <input type="text" name="identifiant" class="form-control" id="identifiant" placeholder="Ex: 495128972350" required="required">
                        </div>

                        <!-- Solde de départ du compte au jour de l'ajout en base-->
                        <div class="col-lg-2">
                            <label for="solde" class="control-label">Solde (€) : </label>
                            <input type="number" value="0" name="solde" min="-1000.00" step="0.01" class="form-control" id="solde" required="required" title="Solde de départ du compte au jour de création (par défaut 0)">
                        </div>

                        <!-- Bouton de Validation-->
                        <div class="col-lg-2">
                            </br>
                            <input type="submit" value="Ajouter ce Compte" class="btn btn-success btn-block"/>
                        </div>
                    </form>

                    <div class="col-lg-1">
                        </br>
                        <a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/home.php" class="btn btn-danger btn-block">Annuler</a>
                    </div>
                </div>
            </div>

            </br>

            <?php $comptes = CompteDAL::findAll(); ?>
            <div class="row">
                <div class="col-lg-9">
                    <legend>Liste des Comptes précédemment ajoutés</legend>
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">Banque</th>
                                <th class="text-center">Nom</th>
                                <th class="text-center">Solde (€)</th>
                                <th class="text-center">Informations</th>
                                <th class="text-center">Numéro</th>
                                <th class="text-center">Modifier</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($comptes as $compte): ?>
                                <tr>
                                    <th class="text-center"><?php echo $compte->getBanque(); ?></th>
                                    <th class="text-center"><?php echo $compte->getLabel(); ?></th>
                                    <th class="text-center"><?php echo round($compte->getSolde(),2); ?></th>
                                    <th class="text-center"><?php echo $compte->getInformation(); ?></th>
                                    <th class="text-center"><?php echo $compte->getIdentifiant(); ?></th>
                                    <th class="text-center"><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/mod_unCompte.php?idCompte=<?php echo $compte->getId(); ?>" class="btn btn-primary btn-sm active">Mod</a></th>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                </br></br>

                <div class="panel panel-danger col-lg-3">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>ATTENTION: Suppression/Modification de Compte</b></h3>
                    </div>
                    <div class="panel-body text-justify text-danger">
                        Attention, la suppression d'un Compte n'est pas possible, cela entrainerais des résultats de Rapports illogique
                        et des Flux d'argent pourrais se retrouver sans Compte associé.</br>
                        De plus, la modification d'un solde n'est pas possible car cela produirait des Rapports illogique.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>