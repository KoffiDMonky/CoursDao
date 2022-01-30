<?php

include_once "./../constantes.php";
require_once "./../rb.php";


class daoImplGenreRedBean implements daoGenre {

    /**
    * Retourne tous les genres de la liste
    * 
    */
    public function avoirGenres(){

        R::setup( Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        $mesGenres = R::findAll('genre');
        R::close();

        header('Content-Type: application/json');
        echo json_encode($mesGenres, JSON_PRETTY_PRINT);


    }

    /**
     * Récupérer un genre via son identifiant
     * @param int $idGenre
     */
    public function avoirGenreParId(int $idGenre){

        R::setup( Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        
        $genre = R::load('genre', $idGenre);
        R::close();

        header('Content-Type: application/json');
        echo json_encode($genre, JSON_PRETTY_PRINT);
    }

    /**
     * Rajoute un genre dans la base de données
     * @param Genre $genre
     */
    public function ajoutGenreBd(Genre $genre){

        R::setup( Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);

        $g = R::dispense('genre');
        $g->nomGenre = $genre->getNomGenre();
        $id = R::store($g);

        R::close();

        header('Content-Type: application/json');
        echo json_encode($id);

    }

    /**
     * Supprime un genre dans la base de données
     * @param int $idGenre
     */
    public function suppressionGenreBD(int $idGenre){

        R::setup( Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);

        $g = R::load('genre',$idGenre);
        R::trash($g);

        R::close();

        header('Content-Type: application/json');
        echo json_encode($g);

    }

    /**
     * Modifie un genre dans la base de données
     * @param Genre $genre
     * @param int $idGenre
     */

    function modificationGenreBD(Genre $genre, int $idGenre){
        
        R::setup( Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        
        $g = R::load('genre',$idGenre);
        $g->nomGenre = $genre->getNomGenre();
        $id = R::store($g);
        R::close();

        header('Content-Type: application/json');
        echo json_encode($id);


    }
}
