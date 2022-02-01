<?php

require_once "./../metiers/auteur/auteur.class.php";
require_once "./../metiers/auteur/DAO/auteur.dao.php";
require_once "./../metiers/auteur/DAOImpl/auteur.REDBEAN.daoImpl.php";

/**
 *API permettant de récupérer, ajouter, modifier et supprimer des auteurs dans la table auteur
 */

$request_method = $_SERVER["REQUEST_METHOD"];

$auteur = new daoImplAuteurRedBean(); //On appelle une nouvelle instance de la classe daoImplAuteurRedBean que l'on mets dans la variable $auteur, pour nous permettre d'utiliser les méthodes définit dans cette classe

switch ($request_method) {
    case 'GET': //Méthode GET permettant de récupérer un ou plusieurs auteurs
        if(!empty($_GET["id"]))
        {
            //récupère un seul auteur dans la BDD
            $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
            $auteur->avoirAuteurParId($id); //Méthode définit dans la classe daoImplAuteurRedBean permettant de récupérer un genre par son identifiant
        } else {
            //Récupère tous les auteurs
            $auteur->avoirAuteurs(); //Méthode définit dans la classe daoImplAuteurRedBean permettant de récupérer tous les auteurs présents dans la BDD
        }
        break;

    case 'POST':

        //Méthode POST permettant d'ajouter un auteur dans la table auteur de la BDD
        $aut = new auteur($_POST["auteur"]); //On créé une nouvelle instance de la classe auteur, dans laquelle on passe en argument le nom de l'auteur récupéré grâce aux variables globales $_POST["auteur"]
        $auteur->ajoutAuteurBd($aut); //Méthode permettant d'ajouter un nouvel auteur en BDD, en prenant comme argument notre nouvel auteur
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Méthode PUT permettant de modifier un auteur dans la table auteur de la BDD
        $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
        $aut = new auteur($_POST["auteur"]); //On créé une nouvelle instance de la classe auteur, dans laquelle on passe en argument le nom de l'auter permettant de mettre à jour un auteur récupéré grâce aux variables globales $_POST["auteur"]
        $auteur->modificationAuteurBD($aut, $id); //Méthode permettant de modifier un auteur en BDD, en prenant comme argument les nouvelles données ($aut) et l'identifiant de l'auteur ciblé ($id)
        break;

    case 'DELETE':
        //Méthode DELETE permettant de supprimer un auteur dans la table auteur de la BDD
        $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
        $auteur->suppressionAuteurBD($id); //Méthode permettant de supprimer un auteur en BDD, en prenant comme argument l'identifiant de l'auteur ciblé ($id)
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Méthode de demande non valide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
