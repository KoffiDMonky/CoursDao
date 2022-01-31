<?php

include_once "./../db_connect.php";
require_once "./../rb.php";

class daoImplAuteurRedBean implements daoAuteur
{

    /**
     * Retourne tous les auteurs de la BDD
     * 
     */

    public function avoirAuteurs()
    {
        R::setup( Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        $mesAuteurs = R::findAll('auteur');
        R::close();

        header('Content-Type: application/json');
        echo json_encode($mesAuteurs, JSON_PRETTY_PRINT);

    }

    /**
     * Récupérer un auteur via son identifiant
     * @param int $idAuteur
     */

    public function avoirAuteurParId(int $idAuteur)
    {
        R::setup( Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        $auteur = R::load('auteur', $idAuteur);
        R::close();

        header('Content-Type: application/json');
        echo json_encode($auteur, JSON_PRETTY_PRINT);
    }

    /**
     * Rajoute un auteur dans la base de données
     * @param Auteur $auteur
     */
    public function ajoutAuteurBd(Auteur $auteur)
    {

        R::setup( Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);

        $a = R::dispense('auteur');
        $a->auteur = $auteur->getNomAuteur();
        $id = R::store($a);

        R::close();

        header('Content-Type: application/json');
        echo json_encode($id);


    }

    /**
     * Supprime un auteur dans la base de données
     * @param int $idAuteur
     */
    public function suppressionAuteurBD(int $idAuteur)
    {
        R::setup( Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        $a = R::load('auteur', $idAuteur);
        R::trash($a);

        R::close();

        header('Content-Type: application/json');
        echo json_encode($a);
    }

    /**
     * Modifie une personne dans la base de données
     * @param Auteur $auteur
     * @param int $idAuteur
     */

    function modificationAuteurBD(Auteur $auteur, int $idAuteur)
    {

        R::setup( Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        $a = R::load('auteur', $idAuteur);
        $a->auteur = $auteur->getNomAuteur();
        $id = R::store($a);
        R::close();

        header('Content-Type: application/json');
        echo json_encode($id);


    }
}
