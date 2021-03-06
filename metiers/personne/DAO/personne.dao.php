<?php

interface daoPersonne {

    //Méthodes CRUD du DAO daoPersonne
    public function avoirPersonnes();// Récupère toutes les personnes
    public function avoirPersonneParId(int $idPersonne); // Récupère une personne via son identifiant
    public function ajoutPersonneBd(Personne $personne); // Rajoute une personne dans la base de données
    public function suppressionPersonneBD(int $idPersonne); //Supprime une personne dans la base de données
    public function modificationPersonneBD(Personne $personne, int $idPersonne); //Modifie une personne dans la base de données
    public function afficherCollection(int $idPersonne);// Affiche la collection d'un utilisateur
    public function ajouterLivreCollection(int $idPersonne, int $idLivre); //Ajoute un livre dans la collection
    public function supprimerLivreCollection(int $idLivre, int $idPersonne); //Supprime un livre dans la collection
}