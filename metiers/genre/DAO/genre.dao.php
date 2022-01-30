<?php

interface daoGenre {

    //Méthodes CRUD du DAO daoGenre
    public function avoirGenres(); //Retourne toutes les genres du tableau
    public function avoirGenreParId(int $idGenre); // Récupérer un genre via son identifiant
    public function ajoutGenreBd(Genre $genre); // Rajoute un genre dans la base de données
    public function suppressionGenreBD(int $idGenre); //Supprime un genre dans la base de données
    public function modificationGenreBD(Genre $genre, int $idGenre); //Modifie un genre dans la base de données
}