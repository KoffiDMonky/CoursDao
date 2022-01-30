<?php

require_once "./../metiers/auteur/auteur.class.php";
require_once "./../metiers/auteur/DAO/auteur.dao.php";
require_once "./../metiers/auteur/DAOImpl/auteur.REDBEAN.daoImpl.php";

$request_method = $_SERVER["REQUEST_METHOD"];

$auteur = new daoImplAuteurRedBean();

switch ($request_method) {
    case 'GET':
        if(!empty($_GET["id"]))
        {
            //récupère un seul auteur
            $id = intval($_GET["id"]);
            $auteur->avoirAuteurParId($id);
        } else {
            //Récupère tous les auteurs
            $auteur->avoirAuteurs();
        }
        break;

    case 'POST':
        //Ajouter un auteur

        $aut = new auteur($_POST["auteur"]);
        $auteur->ajoutAuteurBd($aut);
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Modifier un auteur
        $id = intval($_GET["id"]);
        $aut = new auteur($_POST["auteur"]);
        $auteur->modificationAuteurBD($aut, $id);
        break;

    case 'DELETE':
        //supprimer un auteur
        $id = intval($_GET["id"]);
        $auteur->suppressionAuteurBD($id);
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
