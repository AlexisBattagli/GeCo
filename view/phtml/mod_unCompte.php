<!DOCTYPE html>
<!--
- Page de Modification de Compte 
- 
- @author Alexis BATTAGLI
- @version 0.1
- 
- Permet d'afficher un formulaire pour modifier un Compte
-->

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/DAL/CompteDAL.php');
?>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Modification de Compte</title>

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

            <?php
            //=====Vérification de ce qui est renvoyé par l'URL en GET===/
            $validId = filter_input(INPUT_GET, 'idCompte', FILTER_SANITIZE_STRING);
            if ($validId != null)
            {
                //echo "[DEBUG]Validation de l'ID --> OK </br>";
                $validId = (int) $validId;
                if (is_int($validId))
                {
                    //echo "[DEBUG]Cast de l'ID en int --> OK </br>";
                    //echo "[INFO]valeur d'ID transmise: " . $validId . "</br>";
                    $compte = CompteDAL::findById($validId);
                    if (is_null($compte))
                    {
                        echo "[DEBUG]Aucun Compte trouver avec cette ID...</br>";
                    }
                    else
                    {
                        ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <form action=<?php $_SERVER['DOCUMENT_ROOT'] ?>"/controller/page/mod_compte.php" method="POST">
                                    <legend>Formulaire de modification d'un Compte</legend>

                                    <!-- Label/Nom du compte-->
                                    <div class="col-lg-2">
                                        <label for="label" class="control-label">Label : </label>
                                        <input type="text" name="label" class="form-control" id="label" value="<?php echo $compte->getLabel(); ?>" required="required">
                                    </div>

                                    <!-- Nom de la banque associé à ce compte-->
                                    <div class="col-lg-2">
                                        <label for="banque" class="control-label">Banque : </label>
                                        <input type="text" name="banque" class="form-control" id="banque" value="<?php echo $compte->getBanque(); ?>" required="required">
                                    </div>

                                    <!-- Informations relatives au compte-->
                                    <div class="col-lg-4">
                                        <label for="information" class="control-label">Informations : </label>
                                        <input type="text" name="information" class="form-control" id="information" value="<?php echo $compte->getInformation(); ?>" required="required">
                                    </div>

                                    <!-- Numéro de compte-->
                                    <div class="col-lg-2">
                                        <label for="identifiant" class="control-label">Numero de Compte : </label>
                                        <input type="text" name="identifiant" class="form-control" id="identifiant" value="<?php echo $compte->getIdentifiant(); ?>" required="required">
                                    </div>

                                    <!-- ID du Compte, caché-->
                                    <div class="col-lg-2" hidden>
                                        <label for="id" class="control-label">Id : </label>
                                        <input type="text" name="id" class="form-control" id="id" value="<?php echo $compte->getId(); ?>">
                                    </div>

                                    <!-- Bouton de Validation-->
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-lg-2">
                                                </br>
                                                <input type="submit" value="Modifier ce Compte" class="btn btn-success btn-block"/>
                                            </div>
                                            <div class="col-lg-1">
                                                </br>
                                                <a href="<?php echo $_SERVER["HTTP_REFERER"]; ?>" class="btn btn-danger btn-block">Annuler</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        else
        {
            echo "[DEBUG]L'ID n'a pas ete caste en int et est toujours en string... </br>";
            echo "[DEBUG](valeur transmise: " . $validId . " )";
        }
    }
    else
    {
        echo "[DEBUG]Aucun ID renseigner dans ce lien... </br>";
        echo "[DEBUG](valeur transmise: " . $validId . " )";
    }
    ?>
</div>
</body>
</html>