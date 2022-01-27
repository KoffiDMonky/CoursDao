<?php

class daoImplAuteurRedBean implements daoAuteur
{


    private $db; //Instance de PDO
    private $auteurs; //tableau de auteurs

    function __construct($db, $auteurs)
    {
        $this->db = $db;
        $this->auteurs = $auteurs;
    }

    /**
     * Ajoute une auteur à la liste d'auteurs
     * @param Auteur $Auteur
     */

    public function ajoutAuteur(Auteur $auteur)
    {
        $this->auteurs[] = $auteur;
    }

    /**
     * Retourne tous les auteurs de la liste
     * 
     */

    public function getAuteurs()
    {
        return $this->auteurs;
    }


    /**
     * Charge tous les auteurs contenu dans la BDD dans le tableau de auteur
     * 
     */

    public function chargementAuteurs()
    {

        R::setup();
        $mesAuteurs = R::findAll('auteur');
        R::close();

        //On créé les auteurs et on les ajoute dans le tableau "Auteurs"
        foreach ($mesAuteurs as $auteur) {
            $p = new Auteur($auteur['idAuteur'], $auteur['oeuvre']);
            $this->ajoutAuteur($p);
        }
    }

    /**
     * Récupérer un auteur via son identifiant
     * @param Auteur $idAuteur
     */

    public function getAuteurById(Auteur $idAuteur)
    {
        for ($i = 0; $i < count($this->auteurs); $i++) {
            if ($this->auteurs[$i]->getId() === $idAuteur) {
                return $this->livres[$i];
            }
        }
    }

    /**
     * Rajoute un auteur dans la base de données
     * @param Auteur $auteur
     */
    public function ajoutAuteurBd(Auteur $auteur)
    {

        R::setup();

        $a = R::dispense('auteur');
        $a->auteur = $auteur->getNomAuteur();
        $id = R::store($a);

        R::close();

        // On vérifie que la requête a bien fonctionnée et on ajoute la nouvelle auteur dans la liste de auteur
        if ($a > 0) {
            $auteur = new Auteur($id, $a['nomAuteur']);
            $this->ajoutAuteur($auteur);
        }
    }

    /**
     * Supprime un auteur dans la base de données
     * @param Auteur $idAuteur
     */
    public function suppressionAuteurBD(Auteur $idAuteur)
    {

        R::setup();
        $a = R::load('personne', $idAuteur);

        // Si on a un bean, on supprime l'auteur dans la liste de personnes
        if ($a > 0) {
            $a = $this->getAuteurById($idAuteur);
            unset($p);
        }

        R::trash($a);
        R::close();
    }

    /**
     * Modifie une personne dans la base de données
     * @param Auteur $auteur
     * @param Auteur $idAuteur
     */

    function modificationAuteurBD(Auteur $auteur, Auteur $idAuteur)
    {

        R::setup();
        $a = R::load('auteur', $idAuteur);
        $a->auteur = $auteur->getNomAuteur();
        $a->livre_id = $auteur->getId_livre();
        $id = R::store($a);
        R::close();

        if ($id > 0) {
            $this->getAuteurById($idAuteur)->setNomAuteur($auteur->getNomAuteur());
        }
    }
}
