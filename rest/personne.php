<?php

require_once "./../metiers/personne/personne.class.php";
require_once "./../metiers/personne/DAO/personne.dao.php";
require_once "./../metiers/personne/DAOImpl/personne.REDBEAN.daoImpl.php";

$request_method = $_SERVER["REQUEST_METHOD"];

$personne = new daoImplPersonneRedBean();

switch ($request_method) {
    case 'GET':
        if(!empty($_GET["id"]))
        {
            //récupère une seule personne
            $id = intval($_GET["id"]);
            $personne->avoirPersonneParId($id);
        } else {
            //Récupère toutes les personnes
           $personne->avoirPersonnes();
        }
        break;

    case 'POST':
        //Ajouter une personne

        $pers = new personne($_POST["nom"], $_POST["prenom"]);
        $personne->ajoutPersonneBd($pers);
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Modifier une personne
        $id = intval($_GET["id"]);
        $pers = new personne($_POST["nom"], $_POST["prenom"]);
        $personne->modificationPersonneBD($pers,$id);
        break;

    case 'DELETE':
        //supprimer une personne
        $id = intval($_GET["id"]);
        $personne->suppressionPersonneBD($id);
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>