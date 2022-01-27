<?php

interface daoAuteur {

    //Méthodes CRUD du DAO daoAuteur
    public function ajoutAuteur(Auteur $Auteur); // Ajoute un auteur à un tableau d'auteurs
    public function getAuteurs(); //Retourne tous les auteurs du tableau
    public function chargementAuteurs(); //Charge tous les auteurs contenu dans la base de donnée dans un tableau d'auteurs
    public function getAuteurById(Auteur $idAuteur); // Récupère un auteur via son identifiant
    public function ajoutAuteurBd(Auteur $Auteur); // Rajoute un auteur dans la base de données
    public function suppressionAuteurBD(Auteur $idAuteur); //Supprime un auteur dans la base de données
    public function modificationAuteurBD(Auteur $auteur, Auteur $idAuteur); //Modifie un auteur dans la base de données
}