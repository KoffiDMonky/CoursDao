<?php

require_once "./../metiers/genre/genre.class.php";
require_once "./../metiers/genre/DAO/genre.dao.php";
require_once "./../metiers/genre/DAOImpl/genre.REDBEAN.daoImpl.php";

/**
 *API permettant de récupérer, ajouter, modifier et supprimer des genres dans la table genre
 */

$request_method = $_SERVER["REQUEST_METHOD"];

$genre = new daoImplGenreRedBean(); //On appelle une nouvelle instance de la classe daoImplGenreRedBean que l'on mets dans la variable $genre, pour nous permettre d'utiliser les méthodes définit dans cette classe

switch ($request_method) {
    case 'GET': //Méthode GET permettant de récupérer un ou plusieurs genres
        if(!empty($_GET["id"]))
        {
            //récupère un seul genre dans la BDD
            $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
            $genre->avoirGenreParId($id); //Méthode définit dans la classe daoImplGenreRedBean permettant de récupérer un genre par son identifiant
        } else {
            
            $genre->avoirGenres(); //Méthode définit dans la classe daoImplGenreRedBean permettant de récupérer tous les genres présents dans la BDD
        
        }
        break;

    case 'POST':

        //Méthode POST permettant d'ajouter un genre dans la table genre de la BDD
        $gen = new genre($_POST["genre"]); //On créé une nouvelle instance de la classe genre, dans laquelle on passe en argument le nom du genre récupéré grâce aux variables globales $_POST["genre"]
        $genre->ajoutGenreBd($gen); //Méthode permettant d'ajouter un nouveau genre en BDD, en prenant comme argument notre nouveau genre
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Méthode PUT permettant de modifier un genre dans la table genre de la BDD
        $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
        $gen = new genre($_POST["genre"]); //On créé une nouvelle instance de la classe genre, dans laquelle on passe en argument le nom du genre permettant de mettre à jour un genre récupéré grâce aux variables globales $_POST["genre"]
        $genre->modificationGenreBD($gen, $id); //Méthode permettant de modifier un genre en BDD, en prenant comme argument les nouvelles données ($gen) et l'identifiant du genre ciblé ($id)
        break;

    case 'DELETE':
        //Méthode DELETE permettant de supprimer un genre dans la table genre de la BDD
        $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
        $genre->suppressionGenreBD($id); //Méthode permettant de supprimer un genre en BDD, en prenant comme argument l'identifiant du genre ciblé ($id)
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Méthode de demande non valide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
