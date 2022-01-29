<?php

require_once "./metiers/livre/livre.class.php";
require_once "./metiers/livre/DAO/livre.dao.php";

$request_method = $_SERVER["REQUEST_METHOD"];

$livre = new daoImplLivreRedBean();

switch ($request_method) {
    case 'GET':
        if(!empty($_GET["id"]))
        {
            //récupère un seul livre
            $id = intval($_GET["id"]);
            $livre->avoirLivreParId($id);
        } else {
            //Récupère tous les livres
            $livre->avoirLivres();
        }
        break;

    case 'POST':
        //Ajouter un livre
        $liv = new livre($_POST["titre"], $_POST["genre"], $_POST["auteur"]);
        $livre->ajoutLivreBd($liv);
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Modifier un livre
        $id = intval($_GET["id"]);
        $liv = new livre($_POST["titre"], $_POST["genre"], $_POST["auteur"]);
        $livre->modificationLivreBD($liv,$id);
        break;

    case 'DELETE':
        //supprimer un livre
        $id = intval($_GET["id"]);
        $livre->suppressionLivreBD($id);
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>