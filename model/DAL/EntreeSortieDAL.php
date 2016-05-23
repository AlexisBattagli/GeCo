<?php

/**
 * La class EntreeSortieDAL hérite de la class EntreeSortie.
 * Elle possède donc tous ces attributs et méthodes
 *
 * @author Alexis
 * @version 0.3
 *  Histo:
 *      0.2 - Ajout de sous_objet dans la table entre_sortie
 *      0.3 - Ajout de l'attribut externe Payement
 * 
 * Cette class permet de faire,
 * recherche, ajout, modification et suppression d'ES en base.
 */
require_once('BaseSingleton.php');

class EntreeSortieDAL {
    /*
     * Retourne l'ES correspondant à l'id donnée
     * 
     * @param int $id Identifiant de l'es à trouver
     * @return EntreeSortie
     */

    public static function findById($id)
    {
        $data = BaseSingleton::select('SELECT entree_sortie.id as id, '
                        . 'entree_sortie.valeur as valeur, '
                        . 'entree_sortie.es as es, '
                        . 'entree_sortie.information as information, '
                        . 'entree_sortie.date as date, '
                        . 'entree_sortie.lieu_id as lieu_id, '
                        . 'entree_sortie.objet_id as objet_id, '
                        . 'entree_sortie.compte_id as compte_id, '
                        . 'entree_sortie.etiquette_id as etiquette_id, '
                        . 'entree_sortie.sous_objet_id as sous_objet_id, '
                        . 'entree_sortie.payement_id as payement_id '
                        . ' FROM entree_sortie'
                        . ' WHERE entree_sortie.id = ?', array('i', &$id));
        $entreeSortie = new EntreeSortie();
        if (sizeof($data) > 0)
        {
            $entreeSortie->hydrate($data[0]);
        }
        else
        {
            $entreeSortie = null;
        }
        return $entreeSortie;
    }

    /*
     * Retourne l'ensemble des ES qui sont en base
     * 
     * @return array[EntreeSortie] Toutes les ES sont placées dans un Tableau
     */

    public static function findAll()
    {
        $mesES = array();

        $data = BaseSingleton::select('SELECT entree_sortie.id as id, '
                        . 'entree_sortie.valeur as valeur, '
                        . 'entree_sortie.es as es, '
                        . 'entree_sortie.information as information, '
                        . 'entree_sortie.date as date, '
                        . 'entree_sortie.lieu_id as lieu_id, '
                        . 'entree_sortie.objet_id as objet_id, '
                        . 'entree_sortie.compte_id as compte_id, '
                        . 'entree_sortie.etiquette_id as etiquette_id, '
                        . 'entree_sortie.sous_objet_id as sous_objet_id, '
                        . 'entree_sortie.payement_id as payement_id '
                        . ' FROM entree_sortie');

        foreach ($data as $row)
        {
            $entreeSortie = new EntreeSortie();
            $entreeSortie->hydrate($row);
            $mesES[] = $entreeSortie;
        }

        return $mesES;
    }

    /*
     * Insère ou met à jour l'ES donnée en paramètre.
     * 
     * @param EntreeSortie es
     * @return int id
     * L'id de l'objet inséré en base. False si ça a planté
     */

    public static function insertOnDuplicate($entreeSortie)
    {
        //Récupère les valeurs de l'objet entreeSortie passé en para.
        $id = $entreeSortie->getId();
        $valeur = $entreeSortie->getValeur(); //double
        $es = $entreeSortie->getEs(); //string
        $information = $entreeSortie->getInformation(); //string
        $date = $entreeSortie->getDate(); //string
        $lieuId = $entreeSortie->getLieu()->getId(); //int
        $objetId = $entreeSortie->getObjet()->getId(); //int
        $etiquetteId = $entreeSortie->getEtiquette()->getId(); //int
        $sousObjetId = $entreeSortie->getSousObjet()->getId(); //int
        $payementId = $entreeSortie->getPayement()->getId(); //int
        if ($id < 0)
        {
            //Prépare la requête Insertion/Mise à Jour
            $sql = 'INSERT INTO entree_sortie (valeur, es, information, date, lieu_id, '
                    . ' objet_id, compte_id, etiquette_id, sous_objet_id, payement_id '
                    . ' VALUES(?,?,?,DATE_FORMAT(?,"%Y/%m/%d"),?,?,?,?,?,?) ';
            $params = array('dsssiiiii',
                &$valeur,
                &$es,
                &$information,
                &$date,
                &$lieuId,
                &$objetId,
                &$etiquetteId,
                &$sousObjetId,
                &$payementId
            );
        }
        else
        {
            $sql = 'UPDATE entree_sortie '
                    . ' SET valeur = ?, '
                    . ' es = ?, '
                    . ' information = ?, '
                    . ' date = DATE_FORMAT(?,"%Y/%m/%d"), '
                    . ' lieu_id = ?, '
                    . ' objet_id = ?, '
                    . ' etiquette_id = ?, '
                    . ' sous_objet_id = ?, '
                    . ' payement_id = ? '
                    . ' WHERE id = ?';
            $params = array('dsssiiiiii',
                &$valeur,
                &$es,
                &$information,
                &$date,
                &$lieuId,
                &$objetId,
                &$etiquetteId,
                &$sousObjetId,
                &$payementId,
                &$id
            );
        }

        //Exec la requête
        $idInsert = BaseSingleton::insertOrEdit($sql, $params);

        return $idInsert;
    }

    /*
     * Supprime l'ES correspondant à l'id donné en paramètre
     * 
     * @param int $id
     * @return bool
     * True si la ligne a bien été supprimée, False sinon
     */

    public static function delete($id)
    {
        $deleted = BaseSingleton::delete('DELETE FROM entree_sortie WHERE id = ?', array('i', &$id));
        return $deleted;
    }

}
