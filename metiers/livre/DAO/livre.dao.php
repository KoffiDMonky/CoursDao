<?php

interface daoLivre {

    //Méthodes CRUD du DAO daoLivre
    public function avoirLivres(); //Retourne tous les livres du tableau
    public function avoirLivreParId(int $idLivre); // Récupère un livre via son identifiant
    public function ajoutLivreBd(Livre $livre); // Rajoute un livre dans la base de données
    public function suppressionLivreBD(int $idLivre); //Supprime un livre dans la base de données
    public function modificationLivreBD(Livre $livre, int $idLivre); //Modifie un livre dans la base de données
}