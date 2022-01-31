<?php

require_once "./../metiers/personne/personne.class.php";
require_once "./../metiers/personne/DAO/personne.dao.php";
// require_once "./../metiers/personne/DAOImpl/personne.REDBEAN.daoImpl.php";

/**
 *API permettant de récupérer, ajouter, modifier et supprimer des utilisateurs dans la table personne
 */

$request_method = $_SERVER["REQUEST_METHOD"];

$personne = new daoImplPersonneRedBean(); //On appelle une nouvelle instance de la classe daoImpPersonneRedBean que l'on mets dans la variable $personne, pour nous permettre d'utiliser les méthodes définit dans cette classe

switch ($request_method) {
    case 'GET': //Méthode GET permettant de récupérer une ou plusieurs personnes

        if(!empty($_GET["id"]))
        {
            //récupère une seule personne dans la BDD
            $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
            $personne->avoirPersonneParId($id); //Méthode définit dans la classe daoImpPersonneRedBean permettant de récupérer une personne par son identifiant
        
        } else {

           $personne->avoirPersonnes(); //Méthode définit dans la classe daoImpPersonneRedBean permettant de récupérer toutes les personnes présentes dans la BDD
        
        }
        break;

    case 'POST':

        //Méthode POST permettant d'ajouter une personne dans la table personne de la BDD
        $pers = new personne($_POST["nom"], $_POST["prenom"]); //On créé une nouvelle instance de la classe personne, dans laquelle on passe en argument le nom et le prenom de cette personne récupéré grâce aux variables globales $_POST["nom"] et $_POST["prenom"]
        $personne->ajoutPersonneBd($pers); //Méthode permettant d'ajouter une nouvelle personne en BDD, en prenant comme argument notre nouvelle personne
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Méthode PUT permettant de modifier une personne dans la table personne de la BDD
        $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
        $pers = new personne($_POST["nom"], $_POST["prenom"]); //On créé une nouvelle instance de la classe personne, dans laquelle on passe en argument le nom et le prenom permettant de mettre à jour une personne récupéré grâce aux variables globales $_POST["nom"] et $_POST["prenom"]
        $personne->modificationPersonneBD($pers,$id); //Méthode permettant de modifier une personne en BDD, en prenant comme argument les nouvelles données ($pers) et l'identifiant de la personne ciblé ($id)
        break;

    case 'DELETE':
        //Méthode DELETE permettant de supprimer une personne dans la table personne de la BDD
        $id = intval($_GET["id"]); //On stock l'identifiant récupéré dans la variable $id
        $personne->suppressionPersonneBD($id);//Méthode permettant de supprimer une personne en BDD, en prenant comme argument l'identifiant de la personne ciblé ($id)
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Méthode de demande non valide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>