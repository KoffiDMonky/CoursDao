<?php

interface daoGenre {

    //Méthodes CRUD du DAO daoGenre
    public function ajoutGenre(Genre $genre); // Ajoute un genre au tableau de Genres
    public function getGenres(); //Retourne toutes les genres du tableau
    public function chargementGenres(); //Charge tous les genres contenu dans la base de donnée dans le tableau de genres
    public function getGenreById(Genre $idGenre); // Récupérer un genre via son identifiant
    public function ajoutGenreBd(Genre $genre); // Rajoute un genre dans la base de données
    public function suppressionGenreBD(Genre $idGenre); //Supprime un genre dans la base de données
    public function modificationGenreBD(Genre $genre, Genre $idGenre); //Modifie un genre dans la base de données
}