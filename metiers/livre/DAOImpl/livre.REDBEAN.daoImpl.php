<?php

class daoImplLivreRedBean implements daoLivre
{

    private $db; //Instance de PDO
    private $livres; //tableau de livres

    function __construct($db, $livres)
    {
        $this->db = $db;
        $this->livres = $livres;
    }


    /**
     * Ajoute une Livre à la liste de livres
     * @param Livre $livre
     */
    public function ajoutLivre(Livre $livre): void
    {
        $this->livres[] = $livre;
    }

    /**
     * Retourne toutes les livres de la liste
     * 
     */
    public function getLivres()
    {
        return $this->livres;
    }

    /**
     * Charge toutes les livres contenu dans la BDD dans le tableau de livres
     * 
     */
    public function chargementLivres(): void
    {
        R::setup();
        $mesLivres = R::findAll('livre');
        R::close();

        //On créé les livres et on les ajoute dans le tableau "Livres"
        foreach ($mesLivres as $livre) {
            $p = new Livre($livre['idLivre'], $livre['titre'], $livre['genre'], $livre['auteur']);
            $this->ajoutLivre($p);
        }
    }


    /**
     * Rajoute une Livre dans la base de données
     * @param Livre $idLivre
     */
    public function getLivreById(Livre $idLivre)
    {
        for ($i = 0; $i < count($this->livres); $i++) {
            if ($this->livres[$i]->getId() === $idLivre) {
                return $this->livres[$i];
            }
        }
    }

    /**
     * Rajoute une Livre dans la base de données
     * @param Livre $livre
     */
    public function ajoutLivreBd(Livre $livre): void
    {
        R::setup();

        $l = R::dispense('livre');
        $l->titre = $livre->getTitre();

        $g = R::dispense('genre');
        $g->nomGenre = $livre->getGenre();
        $l->sharedGenreList[] = $g;

        $a = R::dispense('auteur');
        $a->nomAuteur = $livre->getAuteur();
        $l->ownAuteurList[] = $a;

        $id = R::store($l);
        R::close();

        // On vérifie que la requête a bien fonctionnée et on ajoute la nouvelle Livre dans la liste de Livre
        if ($l > 0) {
            $livre = new Livre($id, $l['titre'], $g['nomGenre'], $a['auteur']);
            $this->ajoutLivre($livre);
        }
    }

    /**
     * Supprime une Livre dans la base de données
     * @param Livre $idLivre
     */
    public function suppressionLivreBD(Livre $idLivre): void
    {
        R::setup();
        $l = R::load('livre', $idLivre);
        
        // On vérifie que la requête a bien fonctionnée et on supprime la nouvelle Livre dans la liste de livres
        if ($l > 0) {
            $livre = $this->getLivreById($idLivre);
            unset($livre);
        }

        R::trash($l);
        R::close();
    }


    /**
     * Modifie une Livre dans la base de données
     * @param Livre $idLivre
     */
    public function modificationLivreBD(Livre $livre, Livre $idLivre): void
    {
        R::setup();
        $l = R::load('livre',$idLivre);
        $g = R::dispense('genre');
        $a = R::dispense('auteur');
        

        $l->titre = $livre->getTitre();
        $g->nom_genre = $livre->getGenre();
        $a->auteur = $livre->getAuteur();
        $id = R::store($l, $g, $a);
        R::close();



        // On vérifie que la requête a bien fonctionnée et on met à jour le livre dans la liste de livres
        if ($l > 0) {
            $this->getLivreById($idLivre)->setTitre($livre->getTitre());
            $this->getLivreById($idLivre)->setGenre($livre->getGenre());
            $this->getLivreById($idLivre)->setAuteur($livre->getAuteur());
        }
    }
}
