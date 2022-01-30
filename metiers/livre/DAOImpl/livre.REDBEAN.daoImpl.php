<?php

include_once "./../constantes.php";
require_once "./../rb.php";


class daoImplLivreRedBean implements daoLivre
{

    /**
     * Charge toutes les livres contenu dans la BDD
     * 
     */
    public function avoirLivres()
    {
        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        $mesLivres = R::findAll('livre');
        R::close();

        header('Content-Type: application/json');
        echo json_encode($mesLivres, JSON_PRETTY_PRINT);
    }

    /**
     * Récupérer un livre via son identifiant
     * @param int $idLivre
     */
    public function avoirLivreParId(int $idLivre)
    {
        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        $livre = R::load('livre', $idLivre);
        R::close();

        header('Content-Type: application/json');
        echo json_encode($livre, JSON_PRETTY_PRINT);
    }

    /**
     * Rajoute une Livre dans la base de données
     * @param Livre $livre
     */
    public function ajoutLivreBd(Livre $livre)
    {
        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);

        
        $l = R::dispense('livre');
        $l->titre = $livre->getTitre();

        $g = R::dispense('genre');
        $g->nomGenre = $livre->getGenre()->getNomGenre();
        $l->sharedGenreList[] = $g;

        
        $a = R::dispense('auteur');
        $a->auteur =  $livre->getAuteur()->getNomAuteur();
        $l->ownAuteurList[] = $a;

        $id = R::store($l);
        R::close();

        header('Content-Type: application/json');
        echo json_encode($id);
    }

    /**
     * Supprime une Livre dans la base de données
     * @param int $idLivre
     */
    public function suppressionLivreBD(int $idLivre)
    {
        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        $l = R::load('livre', $idLivre);
        R::trash($l);

        R::close();

        header('Content-Type: application/json');
        echo json_encode($l);
    }


    /**
     * Modifie une Livre dans la base de données
     * @param Livre $livre
     * @param int $idLivre
     */
    public function modificationLivreBD(Livre $livre, int $idLivre)
    {
        R::setup( Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        $l = R::load('livre', $idLivre);
        $g = R::dispense('genre');
        $a = R::dispense('auteur');


        $l->titre = $livre->getTitre();
        $g->nom_genre = $livre->getGenre()->getNomGenre();
        $a->auteur = $livre->getAuteur()->getNomAuteur();
        $id = R::store($l, $g, $a);
        R::close();

        header('Content-Type: application/json');
        echo json_encode($id);
    }
}
