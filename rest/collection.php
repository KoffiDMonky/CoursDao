<?php

require_once "./../metiers/personne/personne.class.php";
require_once "./../metiers/personne/DAO/personne.dao.php";
require_once "./../metiers/personne/DAOImpl/personne.REDBEAN.daoImpl.php";

/**
 *API permettant de récupérer la collection d'un utilisateur et d'y ajouter et supprimer des livres
 */

$request_method = $_SERVER["REQUEST_METHOD"];

$personne = new daoImplPersonneRedBean(); //On appelle une nouvelle instance de la classe daoImpPersonneRedBean que l'on mets dans la variable $personne, pour nous permettre d'utiliser les méthodes définit dans cette classe

switch ($request_method) {
    case 'GET': //Méthode GET permettant de récupérer la collection d'un utilisateur

        if (!empty($_GET["id"])) {
            //récupère une seule personne dans la BDD
            $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
            $personne->afficherCollection($id); //Méthode définit dans la classe daoImpPersonneRedBean permettant de récupérer une personne par son identifiant

        }
        break;

    case 'POST':

        //Méthode POST permettant d'ajouter une personne dans la table personne de la BDD
        $idPers = intval($_GET["id"]); //On stock l'identifiant de la personne récupéré dans la variable $idPers
        $idLiv = $_POST['idLivre']; //On stock l'identifiant du livre récupéré dans la variable $idLiv
        $personne->ajouterLivreCollection($idPers,$idLiv); //Méthode permettant d'ajouter des livre dans la collection d'un utilisateur, en prenant comme argument l'id du livre et l'id de la personne
        header("HTTP/1.0 201 created");
        break;

    case 'DELETE':
        //Méthode DELETE permettant de supprimer un livre d'une collection
        $idPers = intval($_GET["id"]); //On stock l'identifiant de la personne récupéré dans la variable $idPers
        $idLiv = $_POST['idLivre']; //On stock l'identifiant du livre récupéré dans la variable $idLiv
        $personne->supprimerLivreCollection($idLiv,$idPers); //Méthode permettant de supprimer un livre d'une collection, en prenant comme argument l'identifiant du livre et l'identifiant de la personne
        header("HTTP/1.0 204 request processed");
        break;

    default:
        //Méthode de demande non valide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
