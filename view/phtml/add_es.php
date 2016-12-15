<!DOCTYPE html>
<!--
- Page d'ajout de Lieux du site web Gestionnaire de Compte version 2.0 
- 
- @author Alexis BATTAGLI
- @version 0.1
- 
- Permet d'afficher un formulaire pour ajouter un lieux
- Doit permettre de donnée un nom de ville, et un nom de pays.
-->

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/BudgetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/CompteDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/EtiquetteDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/LieuDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/ObjetDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/PayementDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/SoldeDAL.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/SousObjetDAL.php');
?>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Ajout d'ES</title>

        <link rel="stylesheet" type="text/css" href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/css/bootstrap-theme.min.css"> 

        <script src=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/js/bootstrap.js"></script>
        <script src=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/js/dropdown.js"></script>
        <script src=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/bootstrap/js/jquery-1.11.3.js"></script>
 
        <script src=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/javascript/add_es.js"></script>

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
        
        	<form action=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/controller/page/add_es.php" method="POST">
            <legend>Formulaire d'ajout d'une Entrée ou Sortie</legend>
        	
        		<div class="row">
           			<div class="col-lg-12">
                    	<h4>~ Objet et Sous-Objet:</h4>
                        	
                        <!-- Liste les Objets -->
                        <?php $objets = ObjetDAL::findAll(); ?>
                        <div class='col-lg-10'>
                        	<label for='objet_id' class='control-label'>Objet* : </label>
                        	<select name='objet_id' id='objet'>
                        		<?php foreach ($objets as $objet): ?>
                        	    <option value='<?php echo $objet->getId();?>'><?php echo $objet->getLabel()." (".$objet->getDescription().")";?></option>
                        	    <?php endforeach; ?>
                        	</select>
                       	</div>
                        
                        <!-- Renvoie à la gestion des Objets -->
                        <div class='col-lg-2'>
                    	   	<a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/gst_objet.php" class="btn btn-primary btn-sm active" target="_blank">Ajouter un Objet</a>
                	    </div>
        			</div>
        	    </div>
        	
        		</br>
             
        		<div class="row">
        			<div class="col-lg-12">
        		
        					<!-- Liste les Sous-Objets séléctionés -->
        					<div class='col-lg-10'>
        						<label for="sousobjet_id" class="control-label">Sous-Objet : </label>
        						<select name="sousobjet_id" id="sousobjet_linked" ></select>
        					</div>
        				
							<!-- Renvoie à la gestion des Sous-Objets -->        				
        					<div class='col-lg-2'>
                    	    	<a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/gst_sousobjet.php" class="btn btn-primary btn-sm active" target="_blank">Ajouter un Sous-Objet</a>
                	        </div>
        			</div>
            	</div>
        		
        		</br>
        	
        		<div class="row">
        			<div class="col-lg-12">
        				<h4>~ Payement:</h4>
        			</div>
        		</div>
        		
        		</br>
        		
        		<div class="row">
        			<div class="col-lg-12">
        				<h4>~ Informations:</h4>
        			</div>
        		</div>
        	
            </form>

			</br>
            
	        <div class="col-lg-2">
            	<a href=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/view/phtml/home.php" class="btn btn-danger btn-block">Annuler</a>
            </div>
        </div>
    </body>
</html>