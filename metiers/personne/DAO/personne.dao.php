<?php

interface daoPersonne {

    //Méthodes CRUD du DAO daoPersonne
    public function ajoutPersonne(Personne $personne); // Ajoute une personne dans un tableau de personnes
    public function getPersonnes(); //Retourne toutes les personnes du tableau
    public function chargementPersonnes(); //Charge toutes les personnes contenu dans la base de donnée dans le tableau de personnes
    public function getPersonneById(Personne $idPersonne); // Récupère une personne via son identifiant
    public function ajoutPersonneBd(Personne $personne); // Rajoute une personne dans la base de données
    public function suppressionPersonneBD(Personne $idPersonne); //Supprime une personne dans la base de données
    public function modificationPersonneBD(Personne $personne, Personne $idPersonne); //Modifie une personne dans la base de données
}