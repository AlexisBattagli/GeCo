<!DOCTYPE html>

<!--
- Page d'ajout d'Objet du site web Gestionnaire de Compte version 2.0 
- 
- @author Alexis BATTAGLI
- @version 0.1
- 
- Permet d'afficher un formulaire pour ajouter un objet
- Doit permettre de donnée un label, et une description.
-->

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php'); ?>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Gestion des Objets</title>

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
                    <form action=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/controller/page/add_objet.php" method="POST">
                        <legend>Formulaire d'ajout d'un Objet</legend>
                        
                        <!-- Label de l'objet-->
                        <div class="col-lg-2">
                            <label for="label" class="control-label">Label* : </label>
                            <input type="text" maxlength="30" name="label" class="form-control" id="label" placeholder="Ex: Salaire" required="required">
                        </div>

                        <!-- Description de l'objet-->
                        <div class="col-lg-4">
                            <label for="description" class="control-label">Description : </label>
                            <input type="text" maxlength="150" name="description" class="form-control" id="description" placeholder="Ex: Permet d'identifier toutes les ES liées à un salaire">
                        </div>

                        <!-- Bouton de Validation-->
                        <div class="col-lg-2">
                            </br>
                            <input type="submit" value="Ajouter cet Objet" class="btn btn-success btn-block"/>
                        </div>
                    </form>

                    <div class="col-lg-2">
                        </br>
                        <a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/home.php" class="btn btn-danger btn-block">Annuler</a>
                    </div>
                </div>
            </div>
            
            <br>

            <?php $objets = ObjetDAL::findAllUsabled(); ?>
            <div class="row">
                <div class="col-lg-8">
                    <legend>Liste des Objets précédemment ajoutés</legend>
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">Label</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Modifier</th>
                                <th class="text-center">Supprimer</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($objets as $objet): ?>
                                <tr>
                                    <td class="text-center"><?php echo $objet->getLabel(); ?></td>
                                    <td class="text-center"><?php echo $objet->getDescription(); ?></td>
                                    <td class="text-center"><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/mod_unObjet.php?idObjet=<?php echo $objet->getId(); ?>" class="btn btn-primary btn-sm active">Mod</a></td> <!-- Lien vers une page view qui affiche les détail (permet leur modif) -->
                               		<?php if($objet->isDeletable()) {?>
                                    	<th class="text-center"><a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/controller/page/sup_objet.php?idObjet=<?php echo $objet->getId(); ?>" class="btn btn-danger btn-sm active">Sup</a></th>
                               		<?php } else {?>
                               			<th class="text-center"><a href="#" class="btn btn-danger btn-sm disabled">Sup</a></th>
                               		<?php }?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <br><br>

                <div class="panel panel-danger col-lg-4">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>ATTENTION: Suppression d'Objets</b></h3>
                    </div>
                    <div class="panel-body text-justify text-danger">
                        Attention, la suppression d'un Objet n'est réalisable uniquement si l'objet n'est rattaché à aucunes ES et aucun Budget.<br>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>