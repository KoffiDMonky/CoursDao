<?php

interface daoAuteur {

    //Méthodes CRUD du DAO daoAuteur
    public function avoirAuteurs(); //Retourne tous les auteurs du tableau
    public function avoirAuteurParId(int $idAuteur); // Récupère un auteur via son identifiant
    public function ajoutAuteurBd(Auteur $Auteur); // Rajoute un auteur dans la base de données
    public function suppressionAuteurBD(int $idAuteur); //Supprime un auteur dans la base de données
    public function modificationAuteurBD(Auteur $auteur, int $idAuteur); //Modifie un auteur dans la base de données
}