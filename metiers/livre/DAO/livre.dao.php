<?php

interface daoLivre {

    //Méthodes CRUD du DAO daoLivre
    public function ajoutLivre(Livre $livre); // Ajoute un livre dans un tableau de livres
    public function getLivres(); //Retourne tous les livres du tableau
    public function chargementLivres(); //Charge tous les livres contenu dans la base de donnée dans le tableau de livres
    public function getLivreById(Livre $idLivre); // Récupère un livre via son identifiant
    public function ajoutLivreBd(Livre $livre); // Rajoute un livre dans la base de données
    public function suppressionLivreBD(Livre $idLivre); //Supprime un livre dans la base de données
    public function modificationLivreBD(Livre $livre, Livre $idLivre); //Modifie un livre dans la base de données
}