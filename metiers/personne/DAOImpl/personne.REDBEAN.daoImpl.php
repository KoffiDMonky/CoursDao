<?php

include_once "./../db_connect.php";
require_once "./../rb.php";


class daoImplPersonneRedBean implements daoPersonne
{

    /**
     * Charge toutes les personnes contenu dans la BDD 
     * 
     */

    public function avoirPersonnes()
    {
        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        
        $mesPersonnes = R::findAll('personne');
        
        R::close();

        header('Content-Type: application/json');
        echo json_encode($mesPersonnes, JSON_PRETTY_PRINT);
    }


    /**
     * Récupérer une personne via son identifiant
     * @param int $idPersonne
     */

    public function avoirPersonneParId(int $idPersonne)
    {
        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);
        
        $personne = R::load('personne', $idPersonne);
       
        R::close();

        header('Content-Type: application/json');
        echo json_encode($personne, JSON_PRETTY_PRINT);
    }


    /**
     * Rajoute une personne dans la base de données
     * @param Personne $personne
     */

    public function ajoutPersonneBd(Personne $personne)
    {
        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);

        $p = R::dispense('personne');
        $p->nom = $personne->getNom();
        $p->prenom = $personne->getPrenom();
        $id = R::store($p);

        R::close();

        header('Content-Type: application/json');
        echo json_encode($id);
    }


    /**
     * Modifie une personne dans la base de données
     * @param Personne $personne
     * @param int $idPersonne
     */

    function modificationPersonneBD(Personne $personne, int $idPersonne)
    {

        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);

        $p = R::load('personne', $idPersonne);
        $p->nom = $personne->getNom();
        $p->prenom = $personne->getPrenom();
        $id = R::store($p);

        R::close();

        header('Content-Type: application/json');
        echo json_encode($id);
    }

    /**
     * Supprime une personne dans la base de données
     * @param int $idPersonne
     */

    public function suppressionPersonneBD($idPersonne)
    {

        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);

        $p = R::load('personne', $idPersonne);
        R::trash($p);

        R::close();

        header('Content-Type: application/json');
        echo json_encode($p);
    }

    /**
     * Affiche la collection de livre d'un utilisateur
     * @param int $idPersonne
     */

    public function afficherCollection(int $idPersonne)
    {
        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);

        $personne = R::load('personne', $idPersonne);
        $collection = $personne->sharedLivreList;

        R::close();



        header('Content-Type: application/json');
        echo json_encode($collection, JSON_PRETTY_PRINT);
    }

    /**
     * Ajoute un livre dans la collection d'un utilisateur
     * 
     */

    public function ajouterLivreCollection(int $idPersonne, int $idLivre)
    {
        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);

        $l = R::load('livre', $idLivre);
        $p = R::load('personne', $idPersonne);
        $p->sharedLivreList[] = $l;

        $id = R::store($p);

        R::close();
        echo json_encode($id, JSON_PRETTY_PRINT);
    }

    /**
     * Supprimer un livre dans la collection d'un utilisateur
     * 
     */

    public function supprimerLivreCollection(int $idLivre, int $idPersonne)
    {
        R::setup(Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE_REDBEAN, Constantes::USER, Constantes::PASSWORD);

        $l = R::load('livre', $idLivre);
        unset($l->sharedPersonneList[$idPersonne]);
        $id = R::store($l);

        R::close();

        echo json_encode($id, JSON_PRETTY_PRINT);

        
    }
}
