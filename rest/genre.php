<?php

require_once "./../metiers/genre/genre.class.php";
require_once "./../metiers/genre/DAO/genre.dao.php";
require_once "./../metiers/genre/DAOImpl/genre.REDBEAN.daoImpl.php";

$request_method = $_SERVER["REQUEST_METHOD"];

$genre = new daoImplGenreRedBean();

switch ($request_method) {
    case 'GET':
        if(!empty($_GET["id"]))
        {
            //récupère un seul genre
            $id = intval($_GET["id"]);
            $genre->avoirGenreParId($id);
        } else {
            //Récupère tous les genres
            $genre->avoirGenres();
        }
        break;

    case 'POST':
        //Ajouter un genre
        $gen = new genre($_POST["genre"]);
        $genre->ajoutGenreBd($gen);
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Modifier un genre
        $id = intval($_GET["id"]);
        $gen = new genre($_PUT["genre"]);
        $genre->modificationGenreBD($gen, $id);
        break;

    case 'DELETE':
        //supprimer un genre
        $id = intval($_GET["id"]);
        $genre->suppressionGenreBD($id);
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
