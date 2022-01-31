<?php

require_once "./../metiers/livre/livre.class.php";
require_once "./../metiers/livre/DAO/livre.dao.php";
// require_once "./../metiers/livre/DAOImpl/livre.REDBEAN.daoImpl.php";

/**
 *API permettant de récupérer, ajouter, modifier et supprimer des livres dans la table livre
 */



$request_method = $_SERVER["REQUEST_METHOD"];

$livre = new daoImplLivreRedBean(); //On appelle une nouvelle instance de la classe daoImpLivreRedBean que l'on mets dans la variable $livre, pour nous permettre d'utiliser les méthodes définit dans cette classe

switch ($request_method) {
    case 'GET': //Méthode GET permettant de récupérer une ou plusieurs livres
        if(!empty($_GET["id"]))
        {
            //récupère un seul livre dans la BDD
            $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
            $livre->avoirLivreParId($id); //Méthode définit dans la classe daoImpLivreRedBean permettant de récupérer un livre par son identifiant

        } else {

            $livre->avoirLivres(); //Méthode définit dans la classe daoImpLivreRedBean permettant de récupérer tous les livres présents dans la BDD
        }
        break;

    case 'POST':
        //Méthode POST permettant d'ajouter un livre dans la table livre de la BDD
        $gen = new genre($_POST["genre"]); //On créé une nouvelle instance de la classe genre, dans laquelle on passe en argument le genre du livre récupéré grâce à la variable globale $_POST["genre"]
        $aut = new auteur($_POST["auteur"]); //On créé une nouvelle instance de la classe auteur, dans laquelle on passe en argument l'auteur du livre récupéré grâce à la variable globale $_POST["auteur"]
        $liv = new livre($_POST["titre"], $gen, $aut); //Pour finir on créé une nouvelle instance de la classe livre, dans laquelle on passe en argument le genre et l'auteur du livre précédemment récupéré dans les variables $gen et $aut, et le titre du livre grâce à la variable globale $_POST["titre"]
        $livre->ajoutLivreBd($liv); //Méthode permettant d'ajouter un nouveau livre en BDD, en prenant comme argument notre nouveau livre
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Méthode PUT permettant de modifier un livre dans la table livre de la BDD
        $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
        $liv = new livre($_POST["titre"], $_POST["genre"], $_POST["auteur"]); //On créé une nouvelle instance de la classe livre, dans laquelle on passe en argument le titre, le genre et l'auteur permettant de mettre à jour un livre récupéré grâce aux variables globales $_POST["titre"],$_POST["genre"] et $_POST["auteur"]
        $livre->modificationLivreBD($liv,$id); //Méthode permettant de modifier un livre en BDD, en prenant comme argument les nouvelles données ($liv) et l'identifiant du livre ciblé ($id)
        break;

    case 'DELETE':
        //Méthode DELETE permettant de supprimer un livre dans la table livre de la BDD
        $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
        $livre->suppressionLivreBD($id); //Méthode permettant de supprimer un livre en BDD, en prenant comme argument l'identifiant du livre ciblé ($id)
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Méthode de demande non valide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>